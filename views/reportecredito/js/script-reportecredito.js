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
            Toggle();         
        },'JSON');
    }

    function ListarComboTipoDocumento() {
        $.post('comprobante/ListarComboDocumento', function (e) {
            $('#cmbtipodocumento').html(e);
            let periodo = '00';
            let comprobante = $('#txttipodocumento').val();
            console.log(periodo);            
            ListarTabla(periodo,comprobante);
        });
    }

    window.renovarDatos = function(){
        let periodo = $('#txtperiodo').val();
        let comprobante = $('#txttipodocumento').val();
        console.log(periodo);
        console.log(comprobante);
        ListarTabla(periodo,comprobante);
    }

    window.listarPeriodo = function(){
        let periodo =  $('#txtperiodo').val();
        let comprobante = $('#txttipodocumento').val();
        console.log(periodo);
        console.log(comprobante);
        ListarTabla(periodo,comprobante);
    }
    

    ListarComboPeriodo();
    ListarComboTipoDocumento();

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

    function ListarTabla(periodo,comprobante) {
        table = $('#datosConsulta').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'reportecredito/listarVentaPeriodo',
                'data' : {'periodo' : periodo, 'comprobante' : comprobante },
            },
            "columns": [{
                "data": "serie"
            },
            {
                "data": "cliente"
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
                    title: 'REPORTE_COMPRA' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_COMPRA' + '_' + datetime,
                    orientation: 'landscape',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        }); 
        
        odtenerDatosProducto('#datosConsulta tbody');
    }

    function odtenerDatosProducto(tbody) {
        $(tbody).on('click', 'button.ver', function () {
            var codigo =$(this).data('ventaid');

            Swal.fire({
                title: '¿DESEA IMPRIMIR?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'PDF',
                denyButtonText: `TICKET`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    imprimirPDF(codigo);
                } else if (result.isDenied) {
                    imprimirTicket(codigo);
                }
            })             
        });
    }

    function imprimirPDF (codigo) {
        $.post('comprobante/pdf',{'codigo':codigo},function (e) {           
            window.open('comprobante/pdf', '_blank');
        });               
    };
    
    function imprimirTicket (codigo) {
        $.post('comprobante/ticket',{'codigo':codigo},function (e) {           
           window.open('comprobante/ticket', '_blank');
        });               
    };
});