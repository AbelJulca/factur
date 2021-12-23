$(function () {
    var table;

    window.soloNumeros = function (e) 
    {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };
    
    var idioma = 
    {
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

    function ListarComboUnidad() 
    {
        $.post('producto/listarTablaUnidad', function (e) {
            $('#cmbunidad').html(e);
        });
    }

    function ListarComboCategoria() 
    {
        $.post('producto/listarTablaCategoria', function (e) {
            $('#cmbcategoria').html(e);
        });
    }

    function ListarComboTipo() 
    {
        $.post('producto/listarTablaTipo', function (e) {
            $('#cmbtipo').html(e);
        });
    }

    function ListarComboLaboratorio() 
    {
        $.post('producto/listarTablaLaboratorio', function (e) {
            $('#cmblaboratorio').html(e);
        });
    }

    function ListarComboAfectacion() 
    {
        $.post('producto/listarTablaAfectacion', function (e) {
            $('#cmbafectacion').html(e);
        });
    }
    //******************* MODIFICAR ********************************/
    function ListarComboUnidadEdit() 
    {
        $.post('producto/listarTablaUnidadEdit', function (e) {
            $('#cmbunidadEdit').html(e);
        });
    }

    function ListarComboCategoriaEdit() 
    {
        $.post('producto/listarTablaCategoriaEdit', function (e) {
            $('#cmbcategoriaEdit').html(e);
        });
    }

    function ListarComboTipoEdit() 
    {
        $.post('producto/listarTablaTipoEdit', function (e) {
            $('#cmbtipoEdit').html(e);
        });
    }

    function ListarComboLaboratorioEdit() 
    {
        $.post('producto/listarTablaLaboratorioEdit', function (e) {
            $('#cmblaboratorioEdit').html(e);
        });
    }

    function ListarComboAfectacionEdit() 
    {
        $.post('producto/listarTablaAfectacionEdit', function (e) {
            $('#cmbafectacionEdit').html(e);
        });
    }

    //************************************************************* */

    $("#frmProducto").on('submit', function (e) 
    {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'producto/insertarProducto/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("PRODUCTO REGISTRADO")) {
                    $('#productoModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmProducto")[0].reset();
                        table.ajax.reload(null, false);
                    });
                    
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#productoModal').modal('hide');
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

    $("#frmEditProducto").on('submit', function (e) 
    {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'producto/actualizarProducto/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("PRODUCTO MODIFICADO")) {
                    $('#productoEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmEditProducto")[0].reset();
                        table.ajax.reload(null, false);
                    });
                    
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#productoEditModal').modal('hide');
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

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

    function ListarProductos() {
        /*$.post('producto/listarTablaArticulo', function (e) {            
            console.log(e);
        });*/

        table = $('#datosAticulo').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'producto/listarTablaArticulo'
            },            
            "columns": [
                {
                    "data": "nombre_comercial"
                },
                {
                    "data": "categoria"
                },
                {
                    "data": "sku"
                },
                {
                    "data": "afectacion"
                },
                {
                    "data": "porcentaje_ganancia"
                },
                {
                    "data": "idunidad"
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
                    text: '<i class="fas fa-folder-plus"></i>',
                    attr: {
                        'title': 'Agregar Producto',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-primary'
                    },
                    action:function () {
                        $("#productoModal").modal('show');
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_PRODUCTO' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_PRODUCTO' + '_' + datetime,
                    orientation: 'landscape',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ]
        });
        odtenerDatosProducto('#datosAticulo tbody', table);
        eliminarDatosProducto('#datosAticulo tbody', table);
    }

    function odtenerDatosProducto(tbody, table) {
        $(tbody).on('click', 'button.editar', function () {
            var codigo =$(this).data('productoid');
            console.log(codigo);

            $.post('producto/buscarProductoCodigo',{'codigo':codigo}, function (data) {
                $('#txtidproducto').val(data.codigo);
                $('#txtskuEdit').val(data.sku);
                $('#txtunidadEdit').val(data.idunidad);
                $('#txtnombre_comercialEdit').val(data.nombre_comercial);
                $('#txtcategoriaEdit').val(data.idcategoria);
                $('#txtafectacionEdit').val(data.idafectacion);
                $('#txtporcentajeEdit').val(data.porcentaje_ganancia);
                $('#productoEditModal').modal('show');
            },'JSON');
        });
    }

    function eliminarDatosProducto(tbody, table) 
    {
        $(tbody).on('click', 'button.eliminar', function () {
            var data =$(this).data('productoid');
            console.log(data);
            $('#txtcodigo').val(data);  
            $('#txteliminar').text('¿SEGURO QUE DESEA ELIMINAR?');
            $('#ModalEliminar').modal('show');
        });
    }    

    $('#btn-cinfirm-elimina').on('click', function (e) 
    {
        var codigo = $('#txtcodigo').val();
        e.preventDefault();
        $('#ModalEliminar').modal('hide');
        $.post('producto/eliminarProducto', {
            'id': codigo
        }, function (e) {
            console.log(e)
            if (e === 'PRODUCTO ELIMINADO') { 
                Swal.fire({
                    icon: 'success',
                    title: e,
                }).then(function () {
                    table.ajax.reload(null, false);
                });
                // ListarBajas();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: e,
                }).then(function () {
                    
                });
            }
        }, 'JSON');
    });

    ListarProductos();
    ListarComboUnidad();
    ListarComboCategoria();
    ListarComboTipo();
    ListarComboLaboratorio();
    ListarComboAfectacion();
    ListarComboUnidadEdit();
    ListarComboCategoriaEdit();
    ListarComboTipoEdit();
    ListarComboLaboratorioEdit();
    ListarComboAfectacionEdit();
});