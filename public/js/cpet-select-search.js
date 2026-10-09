/**
 * Activa búsqueda (Select2) en todos los <select> del sistema.
 */
(function (window, $) {
    'use strict';

    if (!$ || !$.fn || !$.fn.select2) {
        return;
    }

    var LANG = {
        errorLoading: function () {
            return 'No se pudieron cargar los resultados';
        },
        inputTooLong: function (args) {
            return 'Por favor, elimine ' + (args.input.length - args.maximum) + ' caracter(es)';
        },
        inputTooShort: function (args) {
            return 'Por favor, introduzca ' + (args.minimum - args.input.length) + ' o más caracteres';
        },
        loadingMore: function () {
            return 'Cargando más resultados…';
        },
        maximumSelected: function (args) {
            return 'Sólo puede seleccionar ' + args.maximum + ' elemento(s)';
        },
        noResults: function () {
            return 'No se encontraron resultados';
        },
        searching: function () {
            return 'Buscando…';
        },
        removeAllItems: function () {
            return 'Eliminar todos los elementos';
        },
    };

    var refreshTimers = new WeakMap();
    var suppressingObserver = false;

    function shouldSkip($select) {
        if (!$select || !$select.length) {
            return true;
        }

        var el = $select.get(0);
        if (!el || el.tagName !== 'SELECT') {
            return true;
        }

        if ($select.is('[data-no-select2], .no-select2, .no-search, .js-select2-skip')) {
            return true;
        }

        if ($select.closest('.dataTables_length, .dataTables_filter, .swal2-container, .select2').length) {
            return true;
        }

        if ($select.attr('size') && parseInt($select.attr('size'), 10) > 1) {
            return true;
        }

        return false;
    }

    function dropdownParentFor($select) {
        var $modal = $select.closest('.modal');
        if ($modal.length) {
            return $modal;
        }

        var $dropdown = $select.closest('.dropdown-menu');
        if ($dropdown.length) {
            return $dropdown;
        }

        return $(document.body);
    }

    function destroy($select) {
        if ($select.hasClass('select2-hidden-accessible')) {
            try {
                $select.select2('destroy');
            } catch (e) {
                // ignore
            }
        }
    }

    function initOne(select, force) {
        var $select = $(select);
        if (shouldSkip($select)) {
            return;
        }

        var wasInit = $select.hasClass('select2-hidden-accessible');
        var current = $select.val();

        // Evita reinits innecesarios del observer salvo cuando cambian opciones (force/refresh).
        if (wasInit && !force) {
            return;
        }

        suppressingObserver = true;
        try {
            if (wasInit) {
                destroy($select);
            }

            $select.select2({
                theme: 'default',
                width: '100%',
                language: LANG,
                placeholder: $select.find('option[value=""]').text() || 'Seleccione…',
                allowClear: !$select.prop('required') && $select.find('option[value=""]').length > 0,
                minimumResultsForSearch: 0,
                dropdownParent: dropdownParentFor($select),
            });

            if (current != null) {
                $select.val(current).trigger('change.select2');
            }
        } finally {
            setTimeout(function () {
                suppressingObserver = false;
            }, 0);
        }
    }

    function init(scope) {
        var $root = scope ? $(scope) : $(document);
        $root.find('select').addBack('select').each(function () {
            initOne(this);
        });
    }

    function refresh($select) {
        if (!$select || !$select.length) {
            return;
        }

        $select.each(function () {
            var el = this;
            if (refreshTimers.has(el)) {
                clearTimeout(refreshTimers.get(el));
            }
            refreshTimers.set(
                el,
                setTimeout(function () {
                    refreshTimers.delete(el);
                    initOne(el, true);
                }, 40)
            );
        });
    }

    function observeDom() {
        if (!window.MutationObserver) {
            return;
        }

        var observer = new MutationObserver(function (mutations) {
            if (suppressingObserver) {
                return;
            }

            mutations.forEach(function (mutation) {
                if (mutation.type === 'childList') {
                    if (mutation.target && mutation.target.tagName === 'SELECT') {
                        refresh($(mutation.target));
                        return;
                    }

                    mutation.addedNodes.forEach(function (node) {
                        if (!node || node.nodeType !== 1) {
                            return;
                        }
                        // Ignora nodos internos de Select2.
                        if (node.classList && (node.classList.contains('select2') || node.classList.contains('select2-container'))) {
                            return;
                        }
                        if (node.tagName === 'SELECT') {
                            initOne(node);
                        } else if (node.querySelectorAll) {
                            node.querySelectorAll('select').forEach(function (el) {
                                initOne(el);
                            });
                        }
                    });
                }

                if (mutation.type === 'attributes' && mutation.target.tagName === 'SELECT') {
                    if (mutation.attributeName === 'disabled' || mutation.attributeName === 'required') {
                        refresh($(mutation.target));
                    }
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['disabled', 'required'],
        });
    }

    function bindEvents() {
        $(document).on('shown.bs.modal', '.modal', function () {
            init(this);
        });

        $(document).on('shown.bs.tab', 'a[data-toggle="tab"], button[data-toggle="tab"]', function (e) {
            var target = $(e.target).attr('href') || $(e.target).data('target');
            if (target) {
                init(target);
            }
        });

        // DataTables redraws length selects; skip those via shouldSkip, re-init others in table wrappers if needed.
        $(document).on('draw.dt', function (e) {
            var $wrap = $(e.target).closest('.dataTables_wrapper');
            if ($wrap.length) {
                // No tocar length; solo selects de filtro custom dentro del wrapper.
                $wrap.find('select').each(function () {
                    if (!$(this).closest('.dataTables_length').length) {
                        initOne(this);
                    }
                });
            }
        });
    }

    function boot() {
        init(document);
        bindEvents();
        observeDom();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    // Por si el script se carga tras jQuery ready en el layout.
    $(function () {
        init(document);
    });

    window.CpetSelectSearch = {
        init: init,
        refresh: refresh,
        destroy: destroy,
    };

    // Integra con catálogos dinámicos.
    if (window.CpetCatalog) {
        var originalLoad = window.CpetCatalog.loadSelect;
        var originalAppend = window.CpetCatalog.appendOption;

        if (typeof originalLoad === 'function') {
            window.CpetCatalog.loadSelect = function ($select, url, selectedId, emptyLabel) {
                return originalLoad($select, url, selectedId, emptyLabel).then(function (result) {
                    refresh($select);
                    return result;
                });
            };
        }

        if (typeof originalAppend === 'function') {
            window.CpetCatalog.appendOption = function ($select, item, selected) {
                originalAppend($select, item, selected);
                refresh($select);
            };
        }
    }
})(window, window.jQuery);
