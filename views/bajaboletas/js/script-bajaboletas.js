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

    function odtenerSerie() {
        var tipocomp = 'RC';
        var Datos = new FormData();        
        Datos.append('comp',tipocomp);
        $.ajax({
            type: 'POST',
            url: 'bajaboletas/odtenerSerie/',
            data: Datos,
            contentType: false,
            cache: false,
            dataType: 'json',
            processData: false,
            success: function (msg) {
                console.log(msg)
                $('#txtidserie').val(msg.codigo);
                $('#txtserie').val(msg.serie);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });    
    }

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

        function ListarTablaProveedor() {
            table = $('#datosConsulta').DataTable({
                "destroy": true,
                "responsive": true,
                "ajax": {
                    'method': 'POST',
                    'url': 'bajaboletas/listarBoletas'                    
                },
                "columns": [{
                    "data": "serie"
                },
                {
                    "data": "razon_social"
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
                    "data": "igv"
                },
                {
                    "data": "total"
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
            $(tbody).on('click', 'button.delete', function () {
                var codigo =$(this).data('boletaid');
                console.log(codigo);
                Swal.fire({
                    title: '¿ESTAS SEGURO?',
                    text: "YA NO HAY REVERCION UNA VEZ ACEPTADO!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#cargaEspera').modal('show');
                        SendToSunat(codigo);
                    }
                })
            });
        }

        function SendToSunat (codigo) {
            //console.log(codigo);
            let idserie = $('#txtidserie').val();
            let serie = $('#txtserie').val();      
            $.post('bajaboletas/sendToSunat',{'idventa':codigo, 'idserie':idserie, 'serie':serie},function (e) {  
                Swal.fire({
                    icon: 'success',
                    title: e,
                }).then(function () {
                    $('#cargaEspera').modal('hide');
                    table.ajax.reload(null, false);
                });           
               //window.open('comprobante/pdf', '_blank');
            },'JSON'); 
            
            //imprimirPDF(codigo);
        };

        ListarTablaProveedor();
        odtenerSerie();
});