$(function () {

    var tabla;   

    var idioma = {
        "decimal": ",",
        "thousands": ".",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoPostFix": "",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "lengthMenu": "Mostrar _MENU_ registros",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "processing": "Procesando...",
        "search": "Buscar:",
        "searchPlaceholder": "Término de búsqueda",
        "zeroRecords": "No se encontraron resultados",
        "emptyTable": "Ningún dato disponible en esta tabla",
        "aria": {
            "sortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        //only works for built-in buttons, not for custom buttons
        "buttons": {
            "create": "Nuevo",
            "edit": "Cambiar",
            "remove": "Borrar",
            "copy": "Copiar",
            "csv": "fichero CSV",
            "excel": "tabla Excel",
            "pdf": "documento PDF",
            "print": "Imprimir",
            "colvis": "columnas",
            "collection": "Colección",
            "upload": "Seleccione fichero...."
        },
        "select": {
            "rows": {
                _: '%d filas seleccionadas',
                0: 'clic fila para seleccionar',
                1: 'una fila seleccionada'
            }
        }
    };

    function ListarComboPeriodo() {
        $.post('consultacompras/ListarComboPeriodo', function (e) {
            $('#cmbperiodo').html(e);
            validarPeriodo();
        });
    }

    function validarPeriodo() {
        $.post('compras/validarPeriodo', function (e) {            
            $('#txtperiodo').val(e.codigo);
            ListarTablaPeriodo(e.codigo)
            Toggle();         
        },'JSON');
    }

    window.listarPeriodo = function () {
        var idperiodo = $('#txtperiodo').val(); 
        ListarTablaPeriodo(idperiodo);
        Toggle(); 
    }

    ListarComboPeriodo();
        

    function Toggle() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

    function ListarTablaPeriodo(periodo) {
        table = $('#datosConsulta').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'reportenotacredito/listarVentaPeriodo',
                'data' : {'periodo' : periodo },
            },
            "columns": [{
                "data": "serie"
            },
            {
                "data": "fecha_emision"
            },
            {
                "data": "op_gravadas"
            },
            {
                "data": "op_exoneradas"
            },
            {
                "data": "op_inafectas"
            },
            {
                "data": "op_icbper"
            },
            {
                "data": "igv"
            },
            {
                "data": "total"
            },
            {
                "data": "condicion"
            },
            {
                "data": "mensajesunat"
            },
            {
                "data": "boton"
            }
        ],
        "language": idioma,
        "dom": 'Bfrtip',
            columnDefs: [{
                targets: 1,
                className: 'noVis'
            }],
            buttons: [{
                    extend: 'colvis',
                    columns: ':not(.noVis)',
                    className: 'btn btn-warning colvisAt',
                    titleAttr: 'Ocultar Columnas',
                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_NOTA_CREDITO_SUNAT' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_NOTA_CREDITO_SUNAT' + '_' + datetime,
                    orientation: 'landscape',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                }
            ]
        }); 
        
        odtenerDatosProducto('#datosConsulta tbody');
        enviarSunat('#datosConsulta tbody');
        xmlSunat('#datosConsulta tbody');
        cdrSunat('#datosConsulta tbody');
    }

    function xmlSunat(tbody) {
        $(tbody).on('click', 'button.xml', function () {
            var ruta =$(this).data('xml');            
            Swal.fire({
                title: '¿Esta Seguro?',
                text: "Deseas descargar el XML!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Descargar!'
            }).then((result) => {
                if (result.isConfirmed) { 
                    $.post('reportenotacredito/rutaXml',{'ruta':ruta},function (e) {           
                        window.open('reportenotacredito/rutaXml', '_blank');
                     });                  
                }
            })            
        });
    }

    function cdrSunat(tbody) {
        $(tbody).on('click', 'button.cdr', function () {
            var ruta =$(this).data('cdr');            
            Swal.fire({
                title: '¿Esta Seguro?',
                text: "Deseas descargar el CDR!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Descargar!'
            }).then((result) => {
                if (result.isConfirmed) { 
                    $.post('reportenotacredito/rutaCdr',{'ruta':ruta},function (e) {           
                        window.open('reportenotacredito/rutaCdr', '_blank');
                     });                  
                }
            })            
        });
    }

    function odtenerDatosProducto(tbody) {
        $(tbody).on('click', 'button.ver', function () {
            var codigo =$(this).data('ventaid');            
            Swal.fire({
                icon: 'success',
                title: '¿DESEA IMPRIMIR?',
            }).then(function () {
                imprimirPDF(codigo);
            });            
        });
    }

    function enviarSunat(tbody) {
        $(tbody).on('click', 'button.sunat', function () {
            var codigo =$(this).data('sunat');
            
            Swal.fire({
                title: '¿Esta Seguro?',
                text: "Deseas Enviar el comprobante!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Enviar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#cargaEspera').modal('show');
                    $.post('notacredito/sendToSunat',{'idventa':codigo},function (e) {
                        $('#cargaEspera').modal('hide');
                        listarPeriodo();
                        Swal.fire(
                            'Enviado!',
                            e,
                            'success'
                        )                        
                    },'JSON');                  
                }
            })
            
        });
    }

    function imprimirPDF (codigo) {
        $.post('comprobante/pdf',{'codigo':codigo},function (e) {           
           window.open('comprobante/pdf', '_blank');
        });               
    };

});