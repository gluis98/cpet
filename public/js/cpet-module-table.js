/**
 * Utilidades compartidas: refresco seguro de tablas y feedback post-CRUD.
 */
(function (window, $) {
    'use strict';

    var dtEs = {
        decimal: ',',
        thousands: '.',
        processing: 'Procesando...',
        search: 'Buscar:',
        lengthMenu: 'Mostrar _MENU_ registros',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ registros totales)',
        loadingRecords: 'Cargando...',
        zeroRecords: 'No se encontraron resultados',
        emptyTable: 'No hay registros',
        paginate: {
            first: 'Primero',
            previous: 'Anterior',
            next: 'Siguiente',
            last: 'Último'
        }
    };

    function destroyTable(selector) {
        if (!$.fn.DataTable) {
            return;
        }
        $(selector).each(function () {
            if ($.fn.DataTable.isDataTable(this)) {
                $(this).DataTable().destroy();
            }
        });
    }

    window.CpetModule = {
        dtEs: dtEs,

        destroyTable: destroyTable,

        refreshDataTable: function (selector, html, options) {
            destroyTable(selector);
            var $table = $(selector).first();
            if (!$table.length) {
                return null;
            }
            $table.find('tbody').html(html);
            return $table.DataTable($.extend({
                language: dtEs,
                pageLength: 10
            }, options || {}));
        },

        /**
         * Cierra modal, refresca listado y muestra toast (sin bloquear la vista).
         */
        afterSave: function (opts) {
            opts = opts || {};

            if (opts.modal) {
                $(opts.modal).modal('hide');
            } else if (opts.hideModal !== false) {
                $('#add').modal('hide');
            }

            if (typeof opts.onReset === 'function') {
                opts.onReset();
            }

            if (typeof opts.refresh === 'function') {
                opts.refresh();
            }

            if (opts.message && window.Swal) {
                Swal.fire({
                    icon: opts.icon || 'success',
                    title: opts.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: opts.timer || 2200,
                    timerProgressBar: true
                });
            }
        }
    };
})(window, jQuery);
