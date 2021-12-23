$(function () {      
    
    function tooltip() {
        $('[data-toggle="tooltip"]').tooltip();
    }

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
            ListarTabla(e.codigo)
        },'JSON');
    }

    window.listarPeriodo = function(){
        let periodo =  $('#txtperiodo').val();     
        ListarTabla(periodo);
    }

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

    function ListarTabla(periodo) {
        table = $('#datosConsulta').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'movimiento/listarMovimiento',
                'data' : {'periodo' : periodo },
            },
            "columns": [{
                "data": "usuario_participante"
            },
            {
                "data": "monto"
            },
            {
                "data": "glosa"
            },
            {
                "data": "tipo"
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
                    title: 'REPORTE_MOVIMIENTO' + '_' + datetime,
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
                    title: 'REPORTE_MOVIMIENTO' + '_' + datetime,
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
        $(tbody).on('click', 'button.editar', function () {
            var codigo =$(this).data('id');
            $.post('movimiento/buscarMovimientoCodigo',{'codigo':codigo}, function (data) {
                $('#idmovimiento').val(data.codigo);
                $('#txttipoEdit').val(data.tipo);
                $('#txtglosaEdit').val(data.glosa);
                $('#txtmontoEdit').val(data.monto);
                $('#txtparticipanteEdit').val(data.usuario_participante);
                $('#movimientoEditModal').modal('show');
            },'JSON');
        });
    }

    window.filterFloat = function (evt, input) {
        // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempValue = input.value + chark;
        if (key >= 48 && key <= 57) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            if (key == 8 || key == 13 || key == 0) {
                return true;
            } else if (key == 46) {
                if (filter(tempValue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    };

    function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        if (preg.test(__val__) === true) {
            return true;
        } else {
            return false;
        }

    }
    
    $("#btnAdd").on('click', function (e) {
        $("#movimientoModal").modal('show');
    });

    $("#frmMovimiento").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'movimiento/insertarMovimiento/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("MOVIMIENTO REGISTRADO")) {
                    $('#movimientoModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    $('#movimientoModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: data,
                    }).then(function () {

                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });
    });

    $("#frmEditMovimiento").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'movimiento/updateMovimiento/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("MOVIMIENTO MODIFICADO")) {
                    $('#movimientoEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    $('#movimientoEditModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: data,
                    }).then(function () {

                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });
    });

    tooltip();
    ListarComboPeriodo();

});