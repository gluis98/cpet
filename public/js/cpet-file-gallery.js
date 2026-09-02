/**
 * Galería de archivos con vista previa en grid y lightbox.
 */
(function (window, $) {
    'use strict';

    if (!$) {
        return;
    }

    var IMAGE_EXT = /\.(jpe?g|png|gif|webp|bmp|svg)$/i;
    var PDF_EXT = /\.pdf$/i;

    function fileUrl(storageBase, path) {
        var base = String(storageBase || '').replace(/\/$/, '');
        var rel = String(path || '').replace(/^\//, '');
        return base + '/' + rel;
    }

    function isImage(path) {
        return IMAGE_EXT.test(String(path || ''));
    }

    function isPdf(path) {
        return PDF_EXT.test(String(path || ''));
    }

    function fileName(path) {
        var parts = String(path || '').split('/');
        return parts[parts.length - 1] || 'archivo';
    }

    function ensureLightbox() {
        if ($('#cpet-file-lightbox').length) {
            return;
        }

        $('body').append(
            '<div class="modal fade" id="cpet-file-lightbox" tabindex="-1" role="dialog" aria-hidden="true">' +
                '<div class="modal-dialog modal-xl modal-dialog-centered" role="document">' +
                    '<div class="modal-content cpet-file-lightbox__content">' +
                        '<div class="modal-header py-2">' +
                            '<h5 class="modal-title cpet-file-lightbox__title text-truncate">Archivo</h5>' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">' +
                                '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                        '</div>' +
                        '<div class="modal-body cpet-file-lightbox__body text-center p-2">' +
                            '<div class="cpet-file-lightbox__preview"></div>' +
                        '</div>' +
                        '<div class="modal-footer py-2 justify-content-between">' +
                            '<div>' +
                                '<button type="button" class="btn btn-outline-secondary btn-sm cpet-file-lightbox__prev">' +
                                    '<i class="fas fa-chevron-left"></i> Anterior' +
                                '</button>' +
                                '<button type="button" class="btn btn-outline-secondary btn-sm cpet-file-lightbox__next ml-1">' +
                                    'Siguiente <i class="fas fa-chevron-right"></i>' +
                                '</button>' +
                            '</div>' +
                            '<div>' +
                                '<a href="#" class="btn btn-success btn-sm cpet-file-lightbox__download" download>' +
                                    '<i class="fas fa-download"></i> Descargar' +
                                '</a>' +
                                '<button type="button" class="btn btn-danger btn-sm cpet-file-lightbox__delete ml-1">' +
                                    '<i class="fas fa-trash-alt"></i> Eliminar' +
                                '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'
        );
    }

    function thumbHtml(url, path) {
        if (isImage(path)) {
            return '<img src="' + url + '" alt="" class="cpet-file-gallery__thumb-img" loading="lazy">';
        }
        if (isPdf(path)) {
            return '<div class="cpet-file-gallery__thumb-icon"><i class="fas fa-file-pdf fa-3x text-danger"></i></div>';
        }
        return '<div class="cpet-file-gallery__thumb-icon"><i class="fas fa-file fa-3x text-secondary"></i></div>';
    }

    var state = {
        files: [],
        index: 0,
        storageBase: '',
        deleteUrl: null,
        onDeleted: null,
        contextId: null,
    };

    function currentFile() {
        return state.files[state.index] || null;
    }

    function filePath(file) {
        return file.archivo_url || file.archivo || '';
    }

    function renderLightbox() {
        var file = currentFile();
        if (!file) {
            return;
        }

        var path = filePath(file);
        var url = fileUrl(state.storageBase, path);
        var $preview = $('#cpet-file-lightbox .cpet-file-lightbox__preview');
        var $title = $('#cpet-file-lightbox .cpet-file-lightbox__title');
        var $download = $('#cpet-file-lightbox .cpet-file-lightbox__download');

        $title.text(fileName(path));
        $download.attr('href', url).attr('download', fileName(path));

        if (isImage(path)) {
            $preview.html('<img src="' + url + '" class="cpet-file-lightbox__image" alt="">');
        } else if (isPdf(path)) {
            $preview.html('<iframe src="' + url + '" class="cpet-file-lightbox__iframe" title="PDF"></iframe>');
        } else {
            $preview.html(
                '<div class="py-5">' +
                    '<i class="fas fa-file fa-4x text-muted mb-3"></i>' +
                    '<p class="mb-0">' + fileName(path) + '</p>' +
                '</div>'
            );
        }

        var hasPrev = state.index > 0;
        var hasNext = state.index < state.files.length - 1;
        $('#cpet-file-lightbox .cpet-file-lightbox__prev').prop('disabled', !hasPrev);
        $('#cpet-file-lightbox .cpet-file-lightbox__next').prop('disabled', !hasNext);
    }

    function bindLightboxEvents() {
        if ($('body').data('cpet-file-lightbox-bound')) {
            return;
        }
        $('body').data('cpet-file-lightbox-bound', true);

        $(document).on('click', '.cpet-file-lightbox__prev', function () {
            if (state.index > 0) {
                state.index--;
                renderLightbox();
            }
        });

        $(document).on('click', '.cpet-file-lightbox__next', function () {
            if (state.index < state.files.length - 1) {
                state.index++;
                renderLightbox();
            }
        });

        $(document).on('click', '.cpet-file-lightbox__delete', function () {
            var file = currentFile();
            if (!file || !state.deleteUrl) {
                return;
            }

            var doDelete = function () {
                var formData = new FormData();
                formData.append('_method', 'DELETE');

                fetch(state.deleteUrl(file.id), { method: 'POST', body: formData })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (window.Swal) {
                            Swal.fire({ icon: 'success', title: data.msj || 'Eliminado' });
                        }
                        $('#cpet-file-lightbox').modal('hide');
                        if (typeof state.onDeleted === 'function') {
                            state.onDeleted(state.contextId);
                        }
                    })
                    .catch(function () {
                        if (window.Swal) {
                            Swal.fire({ icon: 'error', title: 'No se pudo eliminar el archivo' });
                        }
                    });
            };

            if (window.Swal) {
                Swal.fire({
                    title: '¿Eliminar archivo?',
                    text: 'Se borrará del servidor.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        doDelete();
                    }
                });
            } else if (window.confirm('¿Eliminar archivo?')) {
                doDelete();
            }
        });
    }

    window.CpetFileGallery = {
        render: function (container, files, options) {
            options = options || {};
            ensureLightbox();
            bindLightboxEvents();

            state.files = files || [];
            state.storageBase = options.storageBase || '';
            state.deleteUrl = options.deleteUrl || null;
            state.onDeleted = options.onDeleted || null;
            state.contextId = options.contextId || null;

            var $container = $(container);
            if (!state.files.length) {
                $container.html('<div class="col-12 text-muted text-center py-3">Sin archivos</div>');
                return;
            }

            var html = '';
            state.files.forEach(function (file, idx) {
                var path = filePath(file);
                var url = fileUrl(state.storageBase, path);
                html +=
                    '<div class="col-6 col-md-3 col-lg-2 mb-3">' +
                        '<div class="cpet-file-gallery__item" data-index="' + idx + '" role="button" tabindex="0">' +
                            thumbHtml(url, path) +
                            '<p class="cpet-file-gallery__caption text-truncate small mb-0 mt-1" title="' + fileName(path) + '">' +
                                fileName(path) +
                            '</p>' +
                        '</div>' +
                    '</div>';
            });

            $container.html(html);

            $container.find('.cpet-file-gallery__item').on('click keypress', function (e) {
                if (e.type === 'keypress' && e.which !== 13 && e.which !== 32) {
                    return;
                }
                state.index = parseInt($(this).data('index'), 10) || 0;
                renderLightbox();
                $('#cpet-file-lightbox').modal('show');
            });
        },
    };
})(window, window.jQuery);
