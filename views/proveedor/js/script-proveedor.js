(function ($) {
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

    $(function () 
    {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#cmbdocumP').on('change', function () 
    {
        let tipo = $('#cmbdocumP').val();
        if (tipo === '1') {
            $('#dniP').attr('maxlength', '8');
        } else {
            $('#dniP').attr('maxlength', '11');
        }
    });

    window.soloNumeros = function (e) 
    {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };

    $('#btnBuscarDni').on('click', function (e) {
        document.getElementById('btnBuscarDni').disabled = true;
        $('.loadDni').removeClass('d-none');
        var tipo = $('#cmbdocumP').val();
        if (tipo === '1') {
            var dni = $('#dniP').val();
            if (dni.length === 8) {
                $.post('proveedor/buscarProveedor', {
                    'nrodoc': dni
                }, function (e) {
                    if (e !== false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'YA EXISTE PROVEEDOR IGUAL',
                        }).then(function () {
                            
                        });
                        document.getElementById('btnBuscarDni').disabled = false;
                        $('.loadDni').addClass('d-none');
                    } else {
                        apiDni(dni);
                    }
                }, 'JSON');
            } else {
                document.getElementById('btnBuscarDni').disabled = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Documento Incorrecto',
                }).then(function () {
                    
                });
            }
        }
        if (tipo === '6') {
            var ruc = $('#dniP').val();
            if (ruc.length === 11) {
                $.post('proveedor/buscarProveedor', {
                    'nrodoc': ruc
                }, function (e) {
                    if (e !== false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'YA EXISTE PROVEEDOR IGUAL',
                        }).then(function () {
                            
                        });
                        document.getElementById('btnBuscarDni').disabled = false;
                        $('.loadDni').addClass('d-none');
                    } else {
                        apiRuc(ruc);
                    }
                }, 'JSON');
            } else {
                document.getElementById('btnBuscarDni').disabled = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Documento Incorrecto',
                }).then(function () {
                    
                });
            }
        }
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
                    $('#razonsocialP').val('DNI NO EXISTE');
                    $('.loadDni').addClass('d-none');
                    document.getElementById('btnBuscarDni').disabled = false;
                } else {
                    var nombre = htmlEntities(data.result.Nombre);
                    var apep = htmlEntities(data.result.Paterno);
                    var apem = htmlEntities(data.result.Materno);
                    $('#razonsocialP').val(nombre + ' ' + apep + ' ' + apem);
                    $('.loadDni').addClass('d-none');
                    document.getElementById('btnBuscarDni').disabled = false;
                }
            }
        });
    }

    function apiRuc(ruc) {
        var documento = 'RUC';
        var usuario = '10447915125';
        var password = '985511933';
        var nro_documento = ruc;
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
                $('.loadDni').addClass('d-none');
                //console.log(data.result);
                if (data.result.RazonSocial !== null) {
                    document.getElementById('razonsocialP').value = data.result.RazonSocial;
                    document.getElementById('direccionP').value = data.result.Direccion;
                    document.getElementById('btnBuscarDni').disabled = false;
                } else {
                    document.getElementById('razonsocialP').value = 'NO EXISTE';
                    document.getElementById('direccionP').value = 'NO EXISTE';
                    document.getElementById('btnBuscarDni').disabled = false;
                }
            }
        });
    }

    function htmlEntities(str) 
    {
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

    //***********************FORMULARIO************************
    $("#frmProveedor").on('submit', function (e) 
    {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'proveedor/insertarProveedor/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("PROVEEDOR REGISTRADO")) {
                    $('#proveedorModal').modal('hide');
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
                    $('#proveedorModal').modal('hide');
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

    $("#frmProveedorEditar").on('submit', function (e) 
    {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'proveedor/editarProveedor/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                if (data.includes('PROVEEDOR MODIFICADO')) {
                    $('#proveedorEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        location.reload();
                    });
                    //$("#frmProveedorEditar")[0].reset();
                    //LimpiarEmpresa();
                    //table.ajax.reload(null, false);
                } else {
                    $('#proveedorEditModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: data,
                    }).then(function () {

                    });
                   // $('#mensajeModal').modal('show'); // abrir
                    //$('#txtmensaje').val(data);
                }
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

    function ListarProveedores() 
    {

        table = $('#datosProveedor').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'proveedor/listarTabla'
            },
            "columns": [{
                    "data": "nrodoc"
                },
                {
                    "data": "razon_social"
                },
                {
                    "data": "direccion"
                },
                {
                    "data": "telefono"
                },
                {
                    "data": "correo"
                },
                {
                    "data": "personacontacto"
                },
                {
                    "data": "telefonocontacto"
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
                        'title': 'Agregar Sucursal',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-primary'
                    },
                    action:function () {
                        $("#proveedorModal").modal('show');
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_PROVEEDOR' + '_' + datetime,
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
                    title: 'REPORTE_PROVEEDOR' + '_' + datetime,
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
        odtenerDatosProveedor('#datosProveedor tbody', table);
        eliminarDatosProveedor('#datosProveedor tbody', table);
    }

    function odtenerDatosProveedor(tbody, table) {
        $(tbody).on('click', 'button.editar', function () {
            var dni =$(this).data('dni'); 
            $.post('proveedor/buscarProveedor', {
                'nrodoc': dni
            }, function (data) {
                $('#codigoPM').val(data.codigo);
                $('#cmbdocumPM').val(data.idtipodoc);
                $('#dniPM').val(data.nrodoc);
                $('#razonsocialPM').val(data.razon_social);
                $('#direccionPM').val(data.direccion);
                $('#telefonoPM').val(data.telefono);
                $('#correoPM').val(data.correo);
                $('#personacontactoPM').val(data.personacontacto);
                $('#telefonocontactoPM').val(data.telefonocontacto);
                $('#proveedorEditModal').modal('show');
            }, 'JSON');
        });
    }

    function eliminarDatosProveedor(tbody, table) {
        $(tbody).on('click', 'button.eliminar', function () {
            var codigo =$(this).data('deleteid');  
            Swal.fire({
                title: '¿Esta Seguro?',
                text: "Deseas eliminar al Proveedor!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('proveedor/eliminarProveedor', {
                        'id': codigo
                    }, function (e) {
                        console.log(e)
                        if (e === 'PROVEEDOR ELIMINADO') { 
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
                                    title: 'Proveedor tiene registros. No se puede eliminar',
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
    
    ListarProveedores();
})(jQuery);