$(function () {
    var table, tablex;

    window.soloNumeros = function (e) 
    {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };
    
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

    function ListarComboPerfil() {
        $.post('usuario/listarTablaPerfil', function (e) {
            $('#cmbperfil').html(e);
        });
    }

    function ListarComboAlmacen() {
        $.post('usuario/listarTablaAlmacen', function (e) {
            $('#cmbalmacen').html(e);
        });
    }

    function ListarComboPerfilEdit() {
        $.post('usuario/listarTablaPerfilEdit', function (e) {
            $('#cmbperfilEdit').html(e);
        });
    }

    function ListarComboAlmacenEdit() {
        $.post('usuario/listarTablaAlmacenEdit', function (e) {
            $('#cmbalmacenEdit').html(e);
        });
    }

    $('#btnBuscarDni').on('click', function (e) {
        document.getElementById('btnBuscarDni').disabled = true;
        $('.loadDni').removeClass('d-none');
        var documento = $('#txtdni').val();
        $.post('usuario/buscarUsuario', {
            'nrodoc': documento
        }, function (e) {
            document.getElementById('btnBuscarDni').disabled = false;
            
            console.log(e);
            if (e !== false) {
                $('.loadDni').addClass('d-none');
                $("#usuarioModal").modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Ya existe un Usuario con el mismo documento',
                }).then(function () {

                });
            } else {
                if(documento.length === 8){
                    apiDni(documento);
                }else{
                    $('.loadDni').addClass('d-none');
                    $("#usuarioModal").modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Dni incorrecto',
                    }).then(function () {

                    }); 
                }                
            }
        }, 'JSON');        
    });

    function apiDni(iden) {
        var documento = 'DNI';
        var usuario = '10447915125';
        var password = '985511933';
        var nro_documento = iden;
        $.ajax({
            type: 'GET',
            dataType: "json",
            url: 'https://www.facturacionelectronica.us/facturacion/controller/ws_consulta_rucdni_v2.php',
            data: {
                documento: documento,
                usuario: usuario,
                password: password,
                nro_documento: nro_documento
            },
            success: function (data) {
                //console.log(msg);                        
                //console.log(data.result);
                if (data.result.DNI === null || data.result.DNI === '') {                   
                    $('#txtnombre').val('DNI NO EXISTE');
                    $('.loadDni').addClass('d-none');
                    document.getElementById('btnBuscarDni').disabled = false;
                } else {
                    var nombre = htmlEntities(data.result.Nombre);
                    var apep = htmlEntities(data.result.Paterno);
                    var apem = htmlEntities(data.result.Materno);
                    $('#txtnombre').val(nombre);
                    $('#txtapep').val(apep);
                    $('#txtapem').val(apem);
                    $('.loadDni').addClass('d-none');                    
                    document.getElementById('btnBuscarDni').disabled = false;
                }
            }
        });
    }

    function htmlEntities(str) {
        return String(str).replace('&ntilde;', 'ñ')
            .replace('&Ntilde;', 'Ñ')
            .replace('&amp;', '&')
            .replace('&Ntilde;', 'Ñ')
            .replace('&ntilde;', 'ñ')
            .replace('&Ntilde;', 'Ñ')
            .replace('&Agrave;', 'À')
            .replace('&Aacute;', 'Á')
            .replace('&Acirc;', 'Â')
            .replace('&Atilde;', 'Ã')
            .replace('&Auml;', 'Ä')
            .replace('&Aring;', 'Å')
            .replace('&AElig;', 'Æ')
            .replace('&Ccedil;', 'Ç')
            .replace('&Egrave;', 'È')
            .replace('&Eacute;', 'É')
            .replace('&Ecirc;', 'Ê')
            .replace('&Euml;', 'Ë')
            .replace('&Igrave;', 'Ì')
            .replace('&Iacute;', 'Í')
            .replace('&Icirc;', 'Î')
            .replace('&Iuml;', 'Ï')
            .replace('&ETH;', 'Ð')
            .replace('&Ntilde;', 'Ñ')
            .replace('&Ograve;', 'Ò')
            .replace('&Oacute;', 'Ó')
            .replace('&Ocirc;', 'Ô')
            .replace('&Otilde;', 'Õ')
            .replace('&Ouml;', 'Ö')
            .replace('&Oslash;', 'Ø')
            .replace('&Ugrave;', 'Ù')
            .replace('&Uacute;', 'Ú')
            .replace('&Ucirc;', 'Û')
            .replace('&Uuml;', 'Ü')
            .replace('&Yacute;', 'Ý')
            .replace('&THORN;', 'Þ')
            .replace('&szlig;', 'ß')
            .replace('&agrave;', 'à')
            .replace('&aacute;', 'á')
            .replace('&acirc;', 'â')
            .replace('&atilde;', 'ã')
            .replace('&auml;', 'ä')
            .replace('&aring;', 'å')
            .replace('&aelig;', 'æ')
            .replace('&ccedil;', 'ç')
            .replace('&egrave;', 'è')
            .replace('&eacute;', 'é')
            .replace('&ecirc;', 'ê')
            .replace('&euml;', 'ë')
            .replace('&igrave;', 'ì')
            .replace('&iacute;', 'í')
            .replace('&icirc;', 'î')
            .replace('&iuml;', 'ï')
            .replace('&eth;', 'ð')
            .replace('&ntilde;', 'ñ')
            .replace('&ograve;', 'ò')
            .replace('&oacute;', 'ó')
            .replace('&ocirc;', 'ô')
            .replace('&otilde;', 'õ')
            .replace('&ouml;', 'ö')
            .replace('&oslash;', 'ø')
            .replace('&ugrave;', 'ù')
            .replace('&uacute;', 'ú')
            .replace('&ucirc;', 'û')
            .replace('&uuml;', 'ü')
            .replace('&yacute;', 'ý')
            .replace('&thorn;', 'þ')
            .replace('&yuml;', 'ÿ');
    }

    $("#frmUsuario").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'usuario/insertarUsuario/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("USUARIO REGISTRADO")) {
                    $('#usuarioModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmUsuario")[0].reset();
                        table.ajax.reload(null, false);
                    });
                    //$("#frmProveedor")[0].reset();
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#usuarioModal').modal('hide');
                    if(data.includes("ERORR DEL SISTEMA SQLSTATE[45000]")){
                        Swal.fire({
                            icon: 'error',
                            title: 'Ya existe un usuario con el mismo DNI',
                        }).then(function () {
    
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: data,
                        }).then(function () {
    
                        });
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });
    });

    $("#frmEditUsuario").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'usuario/actualizarUsuario/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("USUARIO MODIFICADO")) {
                    $('#usuarioEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmEditUsuario")[0].reset();
                        table.ajax.reload(null, false);
                    });
                    //$("#frmProveedor")[0].reset();
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#usuarioEditModal').modal('hide');
                    if(data.includes("ERORR DEL SISTEMA SQLSTATE[45000]")){
                        Swal.fire({
                            icon: 'error',
                            title: 'Ya existe un usuario con el mismo DNI',
                        }).then(function () {
    
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: data,
                        }).then(function () {
    
                        });
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });
    });

    $("#frmAccesoAlmacen").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'usuario/insertarAccesso/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("ACCESSO LISTO")) {                
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmAccesoAlmacen")[0].reset();
                        tablex.ajax.reload(null, false);
                    });
                } else {
                    if(data.includes("ERORR DEL SISTEMA SQLSTATE[45000]")){
                        Swal.fire({
                            icon: 'error',
                            title: 'Ya un acceso a este Almacen',
                        }).then(function () {
    
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: data,
                        }).then(function () {
    
                        });
                    }
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

    function ListarALmacenAccess() {
        /*$.post('usuario/listarAccesoAlmacen', function (e) {            
            console.log(e);
        });*/
        tablex = $('#datosAccesosAlmacen').DataTable({
            "destroy": true,
            "responsive": true,
            "lengthChange": false,
            "searching": false,
            "info": false,
            "ajax": {
                'method': 'POST',
                'url': 'usuario/listarAccesoAlmacen'
            },            
            "columns": [
                {
                    "data": "sucursal"
                },
                {
                    "data": "descripcion"
                },
                {
                    "data": "condicion"
                },
                {
                    "data": "estado"
                },
                {
                    "data": "boton"
                }
            ]
        });

        estadoAccesos('#datosAccesosAlmacen tbody');
        eliminarAccesos('#datosAccesosAlmacen tbody');
    }

    function estadoAccesos(tbody) {
        $(tbody).on('click', 'button.estado', function () {
            var cod =$(this).data('estadoid');
            console.log(cod);
            Swal.fire({
                title: 'Aplicar Cambios',
                showDenyButton: true,
                showCancelButton: false,
                denyButtonColor: '#d33',
                confirmButtonText: `Aceptar`,
                denyButtonText: `Cancelar`,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    cambiarEstado(cod);                    
                  //Swal.fire('Saved!', '', 'success')
                } else if (result.isDenied) {
                  //Swal.fire('Changes are not saved', '', 'info')
                }
              })
        });
    }

    function eliminarAccesos(tbody) {
        $(tbody).on('click', 'button.eliminar', function () {
            var cod =$(this).data('accesoid');
            //console.log(cod);
            Swal.fire({
                title: '¿Seguro que desea Eliminar',
                showDenyButton: true,
                showCancelButton: false,
                denyButtonColor: '#d33',
                confirmButtonText: `Aceptar`,
                denyButtonText: `Cancelar`,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.post('usuario/eliminarAcceso', {
                        'id': cod
                    }, function (e) {
                       if(e === 'ACCESO ELIMINADO'){
                        tablex.ajax.reload();
                       }
                    }, 'JSON');                   
                  //Swal.fire('Saved!', '', 'success')
                } else if (result.isDenied) {
                  //Swal.fire('Changes are not saved', '', 'info')
                }
              })
        });
    }

    function cambiarEstado(cod){
        var datos = new FormData();
        datos.append('id',cod);

        $.ajax({
            type: 'POST',
            url: 'usuario/estadoAcceso/',
            data: datos,
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                let data = JSON.parse(msg);
                console.log(data);
                //tablex.destroy();
                tablex.ajax.reload();
                //ListarALmacenAccess();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });
    }

    function ListarUsuarios() {
      
        table = $('#datosUsuario').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'usuario/listarTablaUsuario'
            },            
            "columns": [{
                    "data": "codigo"
                },
                {
                    "data": "nombres"
                },
                {
                    "data": "telefono"
                },
                {
                    "data": "direccion"
                },
                {
                    "data": "usuario"
                },
                {
                    "data": "perfil"
                },
                {
                    "data": "almacen"
                },
                {
                    "data": "estado"
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
                    text: '<i class="fas fa-user-plus"></i>',
                    attr: {
                        'title': 'Agregar Cliente',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-primary'
                    },
                    action:function () {
                        $("#usuarioModal").modal('show');
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_USUARIO' + '_' + datetime,
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
                    title: 'REPORTE_USUARIO' + '_' + datetime,
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
        odtenerDatosUsuario('#datosUsuario tbody', table);
        eliminarDatosUsuario('#datosUsuario tbody', table);
        accesosUsuario('#datosUsuario tbody');
    }

    function accesosUsuario(tbody) {
        $(tbody).on('click', 'button.permiso', function () {
            var data =$(this).data('usuarioid');
            //console.log(data);
            $('#txtidusuarioacces').val(data);
            $.post('usuario/vs_usuario',{'id':data}, function (e) {            
                console.log(e);
                if(e === 'LISTO'){                    
                    ListarALmacenAccess();
                    $('#acccesosModal').modal('show');
                }
            },'JSON');
            
                        
            
        });
    }

    function odtenerDatosUsuario(tbody, table) {
        $(tbody).on('click', 'button.editar', function () {
            var data =$(this).data('usuarioid');
            console.log(data);
            $.post('usuario/buscarUsuarioId',{'id':data}, function (e) {   
                $('#txtidusuario').val(e.codigo);
                $('#txtdniEdit').val(e.dni);
                $('#txtnombreEdit').val(e.nombre);
                $('#txtapepEdit').val(e.apep); 
                $('#txtapemEdit').val(e.apem); 
                $('#txttelefonoEdit').val(e.telefono); 
                $('#txtperfilEdit').val(e.idperfil); 
                $('#txtalmacenEdit').val(e.almacen_actual);  
                $('#txtdireccionEdit').val(e.direccion);
                $('#txtusuarioEdit').val(e.usuario);
                $('#txtpassEdit').val(e.clave);

                if(e.estado == '1'){
                    $('#customSwitches').attr("checked",true);
                }else{
                    $('#customSwitches').attr("checked",false);
                }                      
                console.log(e);
            },'JSON'); 
            $('#usuarioEditModal').modal('show');         
        });
    }

    function eliminarDatosUsuario(tbody, table) {
        $(tbody).on('click', 'button.eliminar', function () {
            var data =$(this).data('usuarioid');
            //console.log(data);
            
            Swal.fire({
                title: 'Seguro que desea eliminar?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `Aceptar`,
                denyButtonText: `Cancelar`,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.post('usuario/eliminarUsuario', {
                        'id': data
                    }, function (e) {
                        console.log(e)
                        if (e === 'USUARIO ELIMINADO') { 
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
                  //Swal.fire('Saved!', '', 'success')
                } else if (result.isDenied) {
                  //Swal.fire('Changes are not saved', '', 'info')
                }
              })

            //$('#txtcodigo').val(data);  
           // $('#txteliminar').text('¿SEGURO QUE DESEA ELIMINAR?');
            //$('#ModalEliminar').modal('show');
        });
    }    

    $('#btn-cinfirm-elimina').on('click', function (e) {
        var codigo = $('#txtcodigo').val();
        e.preventDefault();
        $('#ModalEliminar').modal('hide');
        $.post('usuario/eliminarUsuario', {
            'id': codigo
        }, function (e) {
            console.log(e)
            if (e === 'USUARIO ELIMINADO') { 
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

    function ListarComboSucursal() {
        $.post('usuario/listarTablaSucursal', function (e) {
            $('#cmbsucursal').html(e);
        });
    }

    function ListarComboAlmacenSucursal() {
        $.post('usuario/listarSelectnuevo', function (e) {
            $('#cmbalmacenSucursal').html(e);
            
            setTimeout(function(){ obtenerAlmacen(); }, 3000);
        });
    }

    window.obtenerAlmacen = function (e) {
        var sucursal = $('#txtsucursal').val();
        $.post('usuario/listarAlamacenSucursal',{'id':sucursal}, function (e) {
            $('#cmbalmacenSucursal').html(e);
        });
    };

    ListarUsuarios();
    ListarComboPerfil();
    ListarComboAlmacen();
    ListarComboPerfilEdit();
    ListarComboAlmacenEdit();
    ListarComboSucursal();
    ListarComboAlmacenSucursal();
});