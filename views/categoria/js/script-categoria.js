(function ($) {
    var table,tablex;
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

    $("#btnAddcategoria").on('click', function (e) {
        $("#categoriaModal").modal('show');
    });  

    $("#frmCategoria").on('submit', function (e) 
    {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'categoria/insertarCategoria/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("DATOS REGISTRADOS")) {
                    $('#categoriaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        table.ajax.reload(null, false);
                        $("#frmCategoria")[0].reset();
                    });
                    //$("#frmProveedor")[0].reset();
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#categoriaModal').modal('hide');
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

    $("#frmEditCategoria").on('submit', function (e) 
    {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'categoria/actualizarCategoria/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("DATOS MODIFICADOS")) {
                    $('#categoriaEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        table.ajax.reload(null, false);
                        $("#frmEditCategoria")[0].reset();
                    });
                    //$("#frmProveedor")[0].reset();
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#categoriaEditModal').modal('hide');
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

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();
    
        function ListarCategoria() 
    {

        table = $('#datosCategoria').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'categoria/tablaCategoria'
            },
            "columns": [{
                    "data": "codigo"
                },
                {
                    "data": "descripcion"
                },                
                {
                    "data": "boton"
                }
            ],
            "language": idioma,
            "dom": 'Bfrtip',            
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_CATEGORIA' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_CATEGORIA' + '_' + datetime,
                    orientation: 'portrait',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1]
                    }
                }
            ]
        });
        odtenerDatosCategoria('#datosCategoria tbody', table);
        eliminarDatosCategoria('#datosCategoria tbody');
    }

    function odtenerDatosCategoria(tbody, table) 
    {
        $(tbody).on('click', 'button.editar', function () {
            var codigo =$(this).data('categoriaid');
            var nombre =$(this).data('categorianom');
            console.log(codigo);        
            $('#txtidcategoria').val(codigo);
            $('#txtdescripcionCEdit').val(nombre);
            $('#categoriaEditModal').modal('show');            
        });
    }

    function eliminarDatosCategoria(tbody) 
    {
        $(tbody).on('click', 'button.eliminar', function () {
            var codigo =$(this).data('categoriaid'); 
            
            Swal.fire({
                title: '¿Esta Seguro?',
                text: "Deseas eliminar la Categoria!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('categoria/eliminarCategoria',{'id':codigo}, function (e) {
                        console.log(e)               
                        if (e.includes("DATOS ELIMINADOS")) {                   
                            Swal.fire({
                                icon: 'success',
                                title: e,
                            }).then(function () {
                                table.ajax.reload(null, false);                        
                            });
                        } else { 
                            if (e.includes("ERORR DEL SISTEMA SQLSTATE[23000]")) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'La categoria tiene registros, no se puede eliminar!',
                                }).then(function () {
            
                                }); 
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: e,
                                }).then(function () {
            
                                }); 
                            }
                        }
                    },'JSON');                
                }
            })
        });
    }  

    ListarCategoria();

})(jQuery);