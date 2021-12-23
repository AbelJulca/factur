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

    window.soloNumeros = function (e) 
    {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };

    window.cambiardoc = function () 
    {       
       let tipo = $('#txtdocumento').val();
       console.log(tipo)
       if (tipo === '6') {
            $('#txtdni').attr('maxlength', '11');
            $('#txtdni').val('');
        } else {
            $('#txtdni').attr('maxlength', '8');
            //$('#txtdni').val('');
        }
    };

    $('#btnBuscarDni').on('click', function (e) 
    {
        document.getElementById('btnBuscarDni').disabled = true;
        $('.loadDni').removeClass('d-none');
        var documento = $('#txtdni').val();
        $.post('cliente/buscarCliente', {
            'nrodoc': documento
        }, function (e) {
            document.getElementById('btnBuscarDni').disabled = false;
            
            console.log(e);
            if (e !== false) {
                $('.loadDni').addClass('d-none');
                $("#clienteModal").modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Ya existe un cliente con el mismo documento',
                }).then(function () {

                });
            } else {
                if(documento.length === 8){
                    apiDni(documento);
                }
                if(documento.length === 11){
                    apiRuc(documento);
                }
            }
        }, 'JSON');        
    });

    function apiDni(iden)
    {
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
                console.log(data.result);
                if (data.result.DNI === null || data.result.DNI === '') {                   
                    $('#txtrazonsocial').val('DNI NO EXISTE');
                    $('.loadDni').addClass('d-none');
                    document.getElementById('btnBuscarDni').disabled = false;
                } else {
                    var nombre = htmlEntities(data.result.Nombre);
                    var apep = htmlEntities(data.result.Paterno);
                    var apem = htmlEntities(data.result.Materno);
                    $('#txtrazonsocial').val(nombre + ' ' + apep + ' ' + apem);
                    $('.loadDni').addClass('d-none');
                    $('#txtdocumento').val('1');
                    document.getElementById('btnBuscarDni').disabled = false;
                }
            }
        });
    }

    function apiRuc(ruc) 
    {
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
                    document.getElementById('txtrazonsocial').value = data.result.RazonSocial;
                    document.getElementById('txtdireccion').value = data.result.Direccion;
                    document.getElementById('btnBuscarDni').disabled = false;
                    $('#txtdocumento').val('6');
                } else {
                    document.getElementById('txtrazonsocial').value = 'NO EXISTE';
                    document.getElementById('txtdireccion').value = 'NO EXISTE';
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

    $("#frmCliente").on('submit', function (e) 
    {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'cliente/insertarCliente/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("CLIENTE REGISTRADO")) {
                    $('#clienteModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    $('#clienteModal').modal('hide');
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

    $("#frmEditCliente").on('submit', function (e) 
    {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'cliente/actualizarCliente/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
               // console.log(data);
                if (data.includes("CLIENTE MODIFICADO")) {
                    $('#clienteEditModal').modal('hide');
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
                    $('#clienteEditModal').modal('hide');
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

    function ListarComboDocumento() 
    {
        $.post('cliente/listarTablaDocumento', function (e) {            
            $('#cmbdocumento').html(e);
        });
    }

    function ListarComboEditDocumento() 
    {
        $.post('cliente/listarTablaEditDocumento', function (e) {            
            $('#cmbdocumentoEdit').html(e);
        });
    }


    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

   function ListarCliente() 
   {            
        table = $('#datosCliente').DataTable({
            "destroy":true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'cliente/listarTablaCliente'
            },
            "columns": [{
                    "data": "nrodocu"
                },
                {
                    "data": "razon_social"
                },
                {
                    "data": "telefono"
                },
                {
                    "data": "correo"
                },
                {
                    "data": "direccion"
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
                        $("#clienteModal").modal('show');
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_CLIENTES' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_CLIENTES' + '_' + datetime,
                    orientation: 'portrait',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ]
        });
        odtenerDatosCliente('#datosCliente tbody', table);
        eliminarDatosCliente('#datosCliente tbody', table);
   }

    function odtenerDatosCliente(tbody, table) {
        $(tbody).on('click', 'button.editar', function () {
            var dnix =$(this).data('dni'); 
            $.post('comprobante/buscarCliente', {'nrodoc': dnix}, function (e) {
                if (e !== false) {
                    $('#txtidcliente').val(e.codigo);
                    $('#txtdniEdit').val(e.nrodocu);
                    $('#txtdocumentoEdit').val(e.iddocumento);
                    $('#txtrazonsocialEdit').val(e.razon_social);
                    $('#txttelefonoEdit').val(e.telefono);
                    $('#txtcorreoEdit').val(e.correo);
                    $('#txtdireccionEdit').val(e.direccion);
                    $('#clienteEditModal').modal('show');
                }
            }, 'JSON');
        });
    }

    function eliminarDatosCliente(tbody, table) {
        $(tbody).on('click', 'button.eliminar', function () {
            var codigo =$(this).data('deleteid');         
        Swal.fire({
            title: '¿Esta Seguro?',
            text: "Deseas eliminar al Cliente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('cliente/eliminarCliente', {
                    'id': codigo
                }, function (e) {
                    //console.log(e)
                    if (e.includes('CLIENTE ELIMINADO')) { 
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
                                title: 'Cliente tiene registros. No se puede eliminar',
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

   ListarCliente();
   ListarComboDocumento();
   ListarComboEditDocumento();

});