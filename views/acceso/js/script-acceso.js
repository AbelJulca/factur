$(function () {
    var table;

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

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

    function ListarComboMenu() {
        $.post('acceso/listarTablaMenu', function (e) {
            $('#cmbmenu').html(e);
        });
    }

    ListarComboMenu();

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

        
        //*************** PERFIL ************************* */

        $("#formPerfil").on('submit', function (e) {
            e.preventDefault();        
            $.ajax({
                type: 'POST',
                url: 'acceso/insertarPerfil/',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (msg) {
                    console.log(msg);
                    let data = JSON.parse(msg);
                    console.log(data);
                    if (data.includes("PERFIL REGISTRADO")) {                       
                        Swal.fire({
                            icon: 'success',
                            title: data,
                        }).then(function () {
                            $("#formPerfil")[0].reset();
                            tablex.ajax.reload(null, false);
                        });
                        
                        //LimpiarEmpresa();
                        // table.ajax.reload(null, false);
                    } else {                        
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

        $("#formEditPerfil").on('submit', function (e) {
            e.preventDefault();        
            $.ajax({
                type: 'POST',
                url: 'acceso/actualizarPerfil/',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (msg) {                    
                    let data = JSON.parse(msg);                    
                    if (data.includes("PERFIL MODIFICADO")) {
                        $('#perfilEditModal').modal('hide');                       
                        Swal.fire({
                            icon: 'success',
                            title: data,
                        }).then(function () {
                            $("#formEditPerfil")[0].reset();
                            tablex.ajax.reload(null, false);
                        });
                        
                        //LimpiarEmpresa();
                        // table.ajax.reload(null, false);
                    } else {     
                        $('#perfilEditModal').modal('hide');                   
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

        function ListarPerfil() {
            /*$.post('usuario/listarTablaUsuario', function (e) {            
                console.log(e);
            });*/
    
            tablex = $('#datosPerfil').DataTable({
                "destroy": true,
                "responsive": true,
                "ajax": {
                    'method': 'POST',
                    'url': 'acceso/listarTablaPerfil'
                },            
                "columns": [
                    {
                        "data": "codigo"
                    },                    
                    {
                        "data": "nombres"
                    },
                    {
                        "data": "boton"
                    }
                ],
                "language": idioma
            });
            verDatosPerfil('#datosPerfil tbody');
            odtenerDatosPerfil('#datosPerfil tbody');
            eliminarDatosPerfil('#datosPerfil tbody');
        }

        function verDatosPerfil(tbody) {
            $(tbody).on('click', 'button.ver', function () {
                var codigo =$(this).data('perfilid');
                var nombre =$(this).data('nombreid');
                //console.log(data);
                $('#txttitulo').text(nombre);
                $('#txtcodigoperfil').val(codigo);                                              
            });
        }

        function odtenerDatosPerfil(tbody) {
            $(tbody).on('click', 'button.editar', function () {
                var codigo =$(this).data('perfilid');
                var nombre =$(this).data('nombreid');
                //console.log(data);
                $('#txtidperfil').val(codigo);
                $('#txtperfilEdit').val(nombre); 
                $('#perfilEditModal').modal('show');            
            });
        } 

        function eliminarDatosPerfil(tbody) {
            $(tbody).on('click', 'button.eliminar', function () {
                var data =$(this).data('perfilid');
                console.log(data);
                $('#txtcodigo').val(data);  
                $('#txteliminar').text('¿SEGURO QUE DESEA ELIMINAR?');
                $('#ModalEliminar').modal('show');
            });
        } 

        $('#btnpermiso').on('click', function (e) {
            var codigo = $('#txtcodigoperfil').val();
            var encabezado = $('#txtmenu').val();
            if(codigo === ''){
                Swal.fire({
                    icon: 'error',
                    title: 'Seleccione un Perfil',
                }).then(function () {
                    
                });
            }else{

                $('#txtnombrepadre').val(encabezado);
                $.post('acceso/encabezado', {
                    'idperfil': codigo, 'padre':encabezado
                }, function (e) {                    
                    $('#listaHijos').html(e)
                    $('#permisosModal').modal('show');
                });

                
            }
        });

        $("#frmPermisos").on('submit', function (e)
        {
        e.preventDefault();
        $.ajax(
                {
                    type: 'POST',
                    url: 'acceso/permisos/',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (msg)
                    {
                        console.log(msg);
                        let e = JSON.parse(msg);
                        if (e === 'CAMBIOS REALIZADOS') { 
                            $('#permisosModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: e,
                            }).then(function () {
                                //location.reload();
                                
                            });
                            // ListarBajas();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: e,
                            }).then(function () {
                                
                            });
                        }

                    }
                });
        });

        $('#btn-cinfirm-elimina').on('click', function (e) {
            var codigo = $('#txtcodigo').val();
            e.preventDefault();
            $('#ModalEliminar').modal('hide');
            $.post('acceso/eliminarPerfil', {
                'id': codigo
            }, function (e) {
                console.log(e)
                if (e === 'PERFIL ELIMINADO') { 
                    Swal.fire({
                        icon: 'success',
                        title: e,
                    }).then(function () {
                        tablex.ajax.reload(null, false);
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

        ListarPerfil();
});