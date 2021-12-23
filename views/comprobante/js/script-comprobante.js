$(function () {

    $('#btnBuscarDocum').on('click', function () {
        document.getElementById('btnBuscarDocum').disabled = true;        
        var num = $('#nrdocu').val();      
        var dni = $('#nrdocu').val();
        if (num === '') {
            let dnix = '00000000';
            $('.loadDni').removeClass('d-none');
            $.post('comprobante/buscarCliente', {'nrodoc': dnix}, function (e) {
                if (e !== false) {
                    $('#nrdocu').val(dnix);
                    $('#razonSocial').val(e.razon_social);
                    $('#txtidcliente').val(e.codigo);
                    $('#direccion').val(e.direccion);
                    $('#txttipodocumento').val('03');
                    renovarDatos();
                    document.getElementById('btnBuscarDocum').disabled = false;
                    $('.loadDni').addClass('d-none');
                }
            }, 'JSON');
        }

        if (dni !== '') {
            if (dni.length === 8) {
                $('.loadDni').removeClass('d-none');
                $.post('comprobante/buscarCliente', {'nrodoc': dni}, function (e) {
                    if (e !== false) {
                        console.log(e);
                        $('#razonSocial').val(e.razon_social);
                        $('#txtidcliente').val(e.codigo);
                        $('#direccion').val(e.direccion);
                        $('#txttiponrodoc').val(e.iddocumento);
                        $('#txttipodocumento').val('03');
                        renovarDatos();
                        document.getElementById('btnBuscarDocum').disabled = false;
                        $('.loadDni').addClass('d-none');
                    } else {
                        apiDni(dni);
                        $('#txttipodocumento').val('03');
                        $('#txttiponrodoc').val('1');
                        renovarDatos();
                    }
                }, 'JSON');
            } else {

                if (dni.length === 11) {
                    $('.loadDni').removeClass('d-none');
                    $.post('comprobante/buscarCliente', {'nrodoc': dni}, function (e) {
                        if (e !== false) {
                            $('#razonSocial').val(e.razon_social);
                            $('#txtidcliente').val(e.codigo);
                            $('#direccion').val(e.direccion);
                            $('#txttiponrodoc').val(e.iddocumento);
                            $('#txttipodocumento').val('01');
                            renovarDatos();
                            document.getElementById('btnBuscarDocum').disabled = false;
                            $('.loadDni').addClass('d-none');
                        } else {
                            apiRuc(dni);
                            $('#txttiponrodoc').val('6');
                            $('#txttipodocumento').val('01');
                            renovarDatos();
                        }
                    }, 'JSON');
                } else {
                    if (dni.length > 3) {
                        $('.loadDni').removeClass('d-none');
                        $.post('comprobante/buscarCliente', {'nrodoc': dni}, function (e) {
                            if (e !== false) {
                                $('#razonSocial').val(e.razon_social);
                                $('#txtidcliente').val(e.codigo);
                                $('#direccion').val(e.direccion);
                                $('#documento').val(e.iddocumento);
                                $('#comprobante').val('03');
                                ConsultarSerie();
                                document.getElementById('btnBuscarDocum').disabled = false;
                                $('.loadDni').addClass('d-none');
                            } else {
                                document.getElementById('btnBuscarDocum').disabled = false;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'DOCUMENTO NO EXISTE!',
                                }).then(function () {
            
                                });
                                $('.loadDni').addClass('d-none');
                            }
                        }, 'JSON');
                    }else{
                        let dnix = '00000000';
                        $('.loadDni').removeClass('d-none');
                        $.post('comprobante/buscarCliente', {'nrodoc': dnix}, function (e) {
                            if (e !== false) {
                                $('#nrdocu').val(dnix);
                                $('#razonSocial').val(e.razon_social);
                                $('#txtidcliente').val(e.codigo);
                                $('#direccion').val(e.direccion);
                                $('#txttipodocumento').val('03');
                                renovarDatos();
                                document.getElementById('btnBuscarDocum').disabled = false;
                                $('.loadDni').addClass('d-none');
                            }
                        }, 'JSON');
                    }
                }

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
                    $('.loadDni').addClass('d-none');
                    Swal.fire({
                        icon: 'error',
                        title: 'DOCUMENTO NO EXISTE!',
                    }).then(function () {

                    });
                    $('.loadDni').addClass('d-none');
                    document.getElementById('btnBuscarDocum').disabled = false;
                } else {
                    var nombre = htmlEntities(data.result.Nombre);
                    var apep = htmlEntities(data.result.Paterno);
                    var apem = htmlEntities(data.result.Materno);
                    $('#txtrazonsocial').val(nombre + ' ' + apep + ' ' + apem);
                    $('#txtdni').val(iden);
                    $('.loadDni').addClass('d-none');
                    $('#txttipodoc').val('1');
                    $('#clienteModal').modal('show');
                    document.getElementById('btnBuscarDocum').disabled = false;
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
                    $('#clienteModal').modal('show');
                    $('#txtdni').val(ruc);
                    document.getElementById('txtrazonsocial').value = data.result.RazonSocial;
                    document.getElementById('txtdireccion').value = data.result.Direccion;
                    document.getElementById('btnBuscarDocum').disabled = false;
                    $('#txttipodoc').val('6');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'DOCUMENTO NO EXISTE!',
                    }).then(function () {

                    });
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

    $("#frmCliente").on('submit', function (e)
    {
        e.preventDefault();
        $.ajax(
                {
                    type: 'POST',
                    url: 'comprobante/insertarCliente/',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (msg)
                    {
                        console.log(msg);
                        let e = JSON.parse(msg);
                        if (e !== false)
                        {
                            $("#frmCliente")[0].reset();
                            $('#clienteModal').modal('hide');                            
                            $('#txtidcliente').val(e.codigo);
                            $('#razonSocial').val(e.razon_social);
                            $('#direccion').val(e.direccion);
                            document.getElementById('btnBuscarDocum').disabled = false;
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: e,
                            }).then(function () {
        
                            }); 
                        }
                    }
                });
    });

    window.soloNumeros = function (e) 
    {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };

    window.filterFloat = function (evt, input)
    {
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

    function filter(__val__) 
    {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        if (preg.test(__val__) === true) {
            return true;
        } else {
            return false;
        }

    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });    

    function ListarComboTipoDocumento() 
    {
        $.post('comprobante/ListarComboDocumento', function (e) {
            $('#cmbtipodocumento').html(e);
        });
    }
    
    function consultarTipoCambio() 
    {
        $.post('orden/consultarTipoCambio', function (e) {  
            console.log(e);         
            $('#txttipocambio').val(e.venta);
        },'JSON');
    }  

    function ListarComboFormaPago() 
    {
        $.ajax({
            type: 'POST',
            url: 'compras/ListarComboFormaPago/',            
            success: function (msg) {
                $('#cmbformapago').html(msg); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
            });
    }

    function validarPeriodo() 
    {
        $.post('compras/validarPeriodo', function (e) { 
            $('#txtidperiodo').val(e.codigo);       
        },'JSON');
    }

    function ListarComboMoneda() {
        $.post('orden/ListarComboMoneda', function (e) {
            $('#cmbmoneda').html(e);
        });
    }
    
    function ListarComboTipoNrodoc() {
        $.post('comprobante/ListarComboTipoNrodoc', function (e) {
            $('#cmbtiponrodoc').html(e);
        });
    } 

    function validarAlmacen() {
        $.post('orden/validarAlmacenUsuario', function (e) {           
            odtenerSerieCorrelativo(e);
            console.log(e);         
        },'JSON');
    }

    function odtenerSerieCorrelativo(almacen) {
        var tipocomp = '01';
        $.post('orden/odtenerSerieCorrelativo',{'almacen':almacen,'comp':tipocomp}, function (e) {
            console.log(e.correlativo);
            var core = parseInt(e.correlativo);
            var num = parseInt('1');
            $('#txtcorrelativo').val(core+num);
            $('#txtserie').val(e.serie);
            $('#txtidserie').val(e.codigo);
        },'JSON');
    }

    window.renovarDatos = function () {
        var tipocomp = $('#txttipodocumento').val(); 
        $.post('orden/validarAlmacenUsuario', function (e) {                      
            serieCorrelativo(e,tipocomp)         
        },'JSON'); 
    }

    function serieCorrelativo(almacen,tipocomp) {        
        $.post('orden/odtenerSerieCorrelativo',{'almacen':almacen,'comp':tipocomp}, function (e) {
            console.log(e.correlativo);
            var core = parseInt(e.correlativo);
            var num = parseInt('1');
            $('#txtcorrelativo').val(core+num);
            $('#txtserie').val(e.serie);
            $('#txtidserie').val(e.codigo);
        },'JSON');
    }
    ListarComboTipoDocumento();
    consultarTipoCambio();
    ListarComboFormaPago();
    validarPeriodo();
    ListarComboMoneda();
    validarAlmacen();
    ListarComboTipoNrodoc();

    function ListarTablaProductosNew() {
        $.post('comprobante/ListarProductoNew', function (e) {
            $('#tablaProducto').html(e);
        });
    }

    $('#txtBuscarProducto').keyup(function (e) {
        e.preventDefault();
        var nombre = $('#txtBuscarProducto').val();
        if(nombre.length < 3){
            ListarTablaProductosNew();
        }else{
          $.post('comprobante/ListarProductosNombre', {'nombre': nombre}, function (e) {
            $('#tablaProducto').html(e);
        });  
        }        
    });

    $('#txtpagocon').keyup(function (e) {
        e.preventDefault();
        let a = $('#txtmontoventa').val();
        let b = $('#txtpagocon').val();
        let r;
        if (b !== '') {
            a = parseFloat(a);
            b = parseFloat(b);
            r = (b-a);
            $('#txtvuelto').val(r.toFixed(2));
        } else {
            $('#txtvuelto').val('0.00');
        }        
    });

    window.AgregarCarrito = function (cod) {
        console.log(cod)
        var codi = cod;
        var cant = $("#txtCantidad" + codi).val();    
        var igv = '0';
        if($("#ckbincluirigv").is(':checked')){
            var igv = '1';
        } 
        var preciocompra = $("#txtprecio" + codi).val();
        if(cant == '0' || preciocompra ===''){
            Swal.fire({
                icon: 'error',
                title: 'INGRESE PRECIO DE COMPRA O UNA CANTIDAD MAYOR A CERO',
            }).then(function () {
                
            });
        }else{
            $.post('comprobante/agregarCarrito', {'codigo': codi, 'cantidad': cant, 'precio': preciocompra, 'igv': igv}, function (e) {            
                //console.log(e)
               $('#tablaVenta').html(e);
            }); 
        }               
    };

    window.dellItemCarrito = function (cod) {
        $.post('comprobante/ItemDellCarrito', {'codigo': cod}, function (e) {
            $('#tablaVenta').html(e);
        });
    };

    function ListarVentaNew() {
        $.post('comprobante/ListarVentaNew', function (e) {
            $('#tablaVenta').html(e);
        });
    }

    ListarTablaProductosNew();
    ListarVentaNew();

    $("#frmVenta").on('submit', function (e)    
    {
        e.preventDefault();
        let idcliente = $('#txtidcliente').val();
        if (idcliente !== '') {
            $.ajax(
                {
                    type: 'POST',
                    url: 'comprobante/registrarVenta/',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (msg)
                    {
                        //console.log(msg);
                        let e = JSON.parse(msg);
                        if (e.includes("VENTA REGISTRADA"))
                        {
                            $('#cargaEspera').modal('show');
                            var venta = e.split("-");                                
                            SendToSunat(venta[1]);                            
                            $('#txtidcliente').val('');
                            $('#razonSocial').val('');
                            $('#direccion').val('');
                            $('#nrdocu').val('');
                            $('#txtpagocon').val('');
                            $('#txtvuelto').val('0.00');
                            ListarTablaProductosNew();
                            ListarVentaNew();
                            //location.reload();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: e,
                            }).then(function () {
        
                            }); 
                        }
                    }
                });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'INGRESE UN CLIENTE',
            }).then(function () {

            }); 
        }       
    });

    function imprimirPDF (codigo) {
        $.post('comprobante/pdf',{'codigo':codigo},function (e) {           
           window.open('comprobante/pdf', '_blank');
        });               
    };

    function imprimirTicket (codigo) {
        $.post('comprobante/ticket',{'codigo':codigo},function (e) {           
           window.open('comprobante/ticket', '_blank');
        });               
    };

    function SendToSunat (codigo) {
        //console.log(codigo);
        $.post('comprobante/sendToSunat',{'idventa':codigo},function (e) {
            //console.log(e);
            //$('#cargaEspera').modal('hide');
            Swal.fire({
                title: e,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'PDF',
                denyButtonText: `TICKET`,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#cargaEspera').modal('hide');
                    imprimirPDF(codigo);
                } else if (result.isDenied) {
                    $('#cargaEspera').modal('hide');
                    imprimirTicket(codigo);
                }
              })
        },'JSON');   
    };

    function validarCaja() {
        $.post('caja/validarCaja', function (e) {
            console.log(e)
            if (e[0] === 'SIN NOMBRE') { 
                Swal.fire({
                    icon: 'error',
                    title: 'INICIE CAJA PRIMERO',
                }).then(function () {
                    window.location = 'caja';
                }); 
            }
        }, 'JSON');
    }
    validarCaja();
});   