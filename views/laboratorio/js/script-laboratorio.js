$(function () {
    var table;
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

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $("#btnAddlaboratorio").on('click', function (e) {
        $("#laboratorioModal").modal('show');
    });

    window.soloNumeros = function (e) {

        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };

    $("#frmLaboratorio").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'laboratorio/insertarLaboratorio/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("LABORATORIO REGISTRADO")) {
                    $('#laboratorioModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        location.reload();
                    });
                    //$("#frmProveedor")[0].reset();
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#laboratorioModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: data,
                    }).then(function () {

                    });
                    //$('#mensajeModal').modal('show'); // abrir
                    //$('#txtmensaje').val(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });
    });

    $("#frmEditLaboratorio").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'laboratorio/actualizarLaboratorio/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("LABORATORIO MODIFICADO")) {
                    $('#laboratorioEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    $('#laboratorioEditModal').modal('hide');
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
    
    //*****************LISTAS**********************
    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

        function ListarLaboratorios() {

            table = $('#datosLaboratorio').DataTable({
                "destroy": true,
                "responsive": true,
                "ajax": {
                    'method': 'POST',
                    'url': 'laboratorio/listarTablaLaboratorio'
                },
                "columns": [
                    {
                        "data": "nombre"
                    },
                    {
                        "data": "descripcion"
                    },
                    {
                        "data": "telefono"
                    },
                    {
                        "data": "correo"
                    },
                    {
                        "data": "personal_contacto"
                    },
                    {
                        "data": "telefono_contacto"
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
                        title: 'REPORTE_LABORATORIO' + '_' + datetime,
                        text: '<i class="far fa-file-excel"></i>',
                        attr: {
                            'title': 'Exportar a Excel',
                            'data-toggle': 'tooltip',
                            'data-placement': 'bottom',
                            'class': 'btn btn-success'
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        excelStyles: { // Add an excelStyles definition
                            template: "blue_medium" // Apply the 'blue_medium' template
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'REPORTE_LABORATORIO' + '_' + datetime,
                        orientation: 'landscape',
                        text: '<i class="far fa-file-pdf"></i>',
                        attr: {
                            'title': 'Exportar a PDF',
                            'data-toggle': 'tooltip',
                            'data-placement': 'bottom',
                            'class': 'btn btn-danger'
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }
                ]
            });
            odtenerDatosLaboratorio('#datosLaboratorio tbody', table);
            eliminarDatosLaboratorio('#datosLaboratorio tbody', table);
        }

        function odtenerDatosLaboratorio(tbody, table) {
            $(tbody).on('click', 'button.editar', function () {
                var codigo =$(this).data('id'); 
                $.post('laboratorio/buscarLaboratorio', {
                    'id': codigo
                }, function (data) {
                    $('#txtidlaboratorio').val(data.codigo);
                    $('#txtnombreEdit').val(data.nombre);
                    $('#txtdescripcionEdit').val(data.descripcion);
                    $('#txttelefonoEdit').val(data.telefono);
                    $('#txtcorreoEdit').val(data.correo);
                    $('#txtpersona_contacEdit').val(data.personal_contacto);
                    $('#txttelefono_contacEdit').val(data.telefono_contacto);
                    $('#laboratorioEditModal').modal('show');
                }, 'JSON');               
            });
        }

        function eliminarDatosLaboratorio(tbody, table) {
            $(tbody).on('click', 'button.eliminar', function () {
                var codigo =$(this).data('deleteid');  
                Swal.fire({
                    title: '¿Esta Seguro?',
                    text: "Deseas eliminar Laboratorio!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('laboratorio/eliminarLaboratorio', {
                            'id': codigo
                        }, function (e) {
                            console.log(e)
                            if (e === 'LABORATORIO ELIMINADO') { 
                                Swal.fire({
                                    icon: 'success',
                                    title: e,
                                }).then(function () {
                                    table.ajax.reload(null, false);
                                });
                                // ListarBajas();
                            } else {
                                if(e.includes("ERORR DEL SISTEMA SQLSTATE[23000]")){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Laboratorio tiene registros. No se puede eliminar',
                                    }).then(function () {
                                        
                                    });
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: e,
                                    }).then(function () {
                                        
                                    });
                                } 
                            }
                        }, 'JSON');    
                    }
                })
            });
        }

        ListarLaboratorios();

});