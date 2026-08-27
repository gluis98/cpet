/**
 * Helper para selects con catálogo agregable vía SweetAlert (+).
 */
(function (window, $) {
    'use strict';

    if (!$ || !window.Swal) {
        return;
    }

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    function escapeAttr(value) {
        return String(value).replace(/"/g, '\\"');
    }

    function appendOption($select, item, selected) {
        if (!$select || !$select.length || !item || item.id == null) {
            return;
        }

        var id = String(item.id);
        var label = item.nombre != null ? String(item.nombre) : String(item.label || '');

        if (!$select.find('option[value="' + escapeAttr(id) + '"]').length) {
            $select.append($('<option>', { value: id, text: label }));
        }

        if (selected !== false) {
            $select.val(id).trigger('change');
        }
    }

    function loadSelect($select, url, selectedId, emptyLabel) {
        emptyLabel = emptyLabel || '--- SELECCIONE ---';

        return fetch(url, {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            cache: 'no-store',
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('No se pudo cargar el catálogo');
                }
                return response.json();
            })
            .then(function (list) {
                var previous = $select.val();
                $select.html($('<option>', { value: '', text: emptyLabel }));

                (list || []).forEach(function (item) {
                    $select.append($('<option>', { value: item.id, text: item.nombre }));
                });

                var pick = selectedId != null && selectedId !== '' ? String(selectedId) : previous;
                if (pick) {
                    $select.val(pick);
                }

                $select.trigger('change');
            });
    }

    function extractItem(data) {
        return data?.item || data?.discapacidad || data?.curso || data?.cargo || null;
    }

    function promptAdd(options) {
        var settings = $.extend(
            {
                title: 'Agregar',
                placeholder: '',
                postUrl: '',
                $select: null,
                fieldName: 'nombre',
                onAdded: null,
                successMessage: 'Registro agregado',
            },
            options || {}
        );

        if (!settings.$select || !settings.$select.length || !settings.postUrl) {
            return;
        }

        Swal.fire({
            title: settings.title,
            input: 'text',
            inputPlaceholder: settings.placeholder,
            showCancelButton: true,
            confirmButtonText: 'Agregar',
            cancelButtonText: 'Cancelar',
            inputValidator: function (value) {
                if (!value || !String(value).trim()) {
                    return 'Escribe un valor';
                }
            },
        }).then(function (result) {
            if (!result.isConfirmed) {
                return;
            }

            var form = new FormData();
            form.append(settings.fieldName, String(result.value).trim());

            fetch(settings.postUrl, {
                method: 'POST',
                body: form,
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken(),
                },
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) {
                            throw data;
                        }
                        return data;
                    });
                })
                .then(function (data) {
                    var item = extractItem(data);

                    if (!item || item.id == null) {
                        throw new Error('Respuesta inválida del servidor');
                    }

                    appendOption(settings.$select, item, true);

                    if (typeof settings.onAdded === 'function') {
                        settings.onAdded(item, data);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: data.msj || settings.successMessage,
                        timer: 1600,
                        showConfirmButton: false,
                    });
                })
                .catch(function (err) {
                    var msg =
                        err?.message ||
                        (err?.errors ? Object.values(err.errors).flat().join('\n') : 'Intenta de nuevo');

                    Swal.fire({
                        icon: 'error',
                        title: 'No se pudo guardar',
                        text: msg,
                    });
                });
        });
    }

    window.CpetCatalog = {
        appendOption: appendOption,
        loadSelect: loadSelect,
        promptAdd: promptAdd,
    };
})(window, window.jQuery);
