$(function () {

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

    $("#AbrirCaja").on('click', function (e) {
        $("#cajaModal").modal('show');
    });

    $("#formCaja").on('submit', function (e)
    {
        e.preventDefault();
        $.ajax(
                {
                    type: 'POST',
                    url: 'caja/insertCaja/',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (msg)
                    {
                        console.log(msg);
                        let data = JSON.parse(msg);
                        if (data.includes('CAJA REGISTRADA'))
                        {
                            $('#cajaModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: data,
                            }).then(function () {
                                validarCaja();
                                listarPeriodo();
                            });

                        } else {
                            $('#cajaModal').modal('hide');
                            Swal.fire({
                                icon: 'error',
                                title: 'NO TIENE PERMISO PARA ESTE ALMACEN',
                            }).then(function () {
        
                            });
                        }
                    }
                });
    });

    function validarCaja() {
        $.post('caja/validarCaja', function (e) {
            console.log(e)
            if (e[0] !== 'SIN NOMBRE') {
                $('#txtnamecaja').text(e[0]);
                $('#txtmontocaja').val(e[1]);
                $('#txtestado').text('ABIERTO');
                $('#txtestado').removeClass('bg-danger');
                $('#txtestado').addClass('bg-success');
                $('#AbrirCaja').attr('disabled', true);                
            } else {
                $('#txtnamecaja').text(e[0]);
                $('#txtmontocaja').val(e[1]);
                $('#AbrirCaja').attr('disabled', false);
                $('#txtestado').text('CERRADO');
                $('#txtestado').addClass('bg-danger');
            }
        }, 'JSON');
        llenarTotales();
    }

    function llenarTotales() {
        $.post('caja/listarCajaTotales', function (e) {
            console.log(e);
            if (e == false) {
                $('#txtmontototal').val('0.0');
                $('#txtmontoticket').val('0.0');
                $('#txtmontoboleta').val('0.0');
                $('#txtmontofactura').val('0.0');
            } else {
                $('#txtmontototal').val(e.monto_cierre);
                $('#txtmontoticket').val(e.ticket);
                $('#txtmontoboleta').val(e.boleta);
                $('#txtmontofactura').val(e.factura);  
            }
                        
        }, 'JSON');
    }

    $("#CerrarCaja").on('click', function () {        
        $.post('caja/cerrarCaja', function (e) {
            //console.log(e[0])
            if (e === 'CAJA FINALIZADA') {
                Swal.fire({
                    icon: 'success',
                    title: e,
                }).then(function () {
                    //validarCaja();
                    validarCaja();
                    location.reload();
                });
               
            } else {
                Swal.fire({
                    icon: 'error',
                    title: e,
                }).then(function () {

                });
            }
        }, 'JSON');
    });

    validarCaja(); 

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

    window.listarPeriodo = function (){
        var idperiodo = $('#txtperiodo').val();
        ListarTablaPeriodo(idperiodo);
        Toggle();
    }

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
                'url': 'caja/listarCajaPeriodo',
                'data' : { 'periodo' : periodo },
            },
            "columns": [{
                "data": "descripcion"
            },
            {
                "data": "fecha"
            },
            {
                "data": "monto_apertura"
            },
            {
                "data": "factura"
            },
            {
                "data": "boleta"
            },
            {
                "data": "ticket"
            },
            {
                "data": "monto_cierre"
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
                    title: 'REPORTE_CAJA' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: ':visible'
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_CAJA' + '_' + datetime,
                    orientation: 'portrait',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });  
    }

    ListarComboPeriodo();

});