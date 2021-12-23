$(function () {
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

    function tooltip() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    function validarPeriodo() {
        $.post('compras/validarPeriodo', function (e) {            
            $('#txtperiodo').val(e.codigo);         
        },'JSON');
    }

    function ListarComboYearContable() {
        $.post('compras/ListarComboYearContable', function (e) {
            $('#cmbyearcontable').html(e);
        });
    }

    function ListarComboPeriodo() {
        $.post('compras/ListarComboPeriodo', function (e) {
            $('#cmbperiodo').html(e);
            validarPeriodo();
        });
    }

    function ListarComboTipoDocumento() {
        $.post('compras/ListarComboDocumento', function (e) {
            $('#cmbtipodocumento').html(e);
        });
    }

    function ListarComboMoneda() {
        $.post('orden/ListarComboMoneda', function (e) {
            $('#cmbmoneda').html(e);
        });
    }

    function ListarComboMotivo() {
        $.post('notadebito/listarTablaMotivo', function (e) {
            $('#cmbmotivo').html(e);            
        });
    }

    function ListarComboFormaPago() {
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

    $('#btnBuscar').on('click', function (e) {
        var serie = $('#txtserieref').val();
        var correlativo = $('#txtcorrelativoref').val();
        if(correlativo !== ''){
            $('.loadOrden').removeClass('d-none');
            $.post('notacredito/buscarComprobante',{'serie':serie,'correlativo':correlativo}, function (e) { 
                $('.loadOrden').addClass('d-none');
                if(e !== false){
                    console.log(e);
                    $('#txtidventa').val(e.codigo);
                    $('#txttipodocumento').val(e.idtipocomp);
                    $('#txtidcliente').val(e.idcliente);
                    $('#direccion').val(e.direccion);
                    $('#txtdireccion').val(e.direccion);
                    odtenerSerieND(e.idtipocomp);
                    buscarCliente(e.idcliente);
                    //llenarDetalleVenta(e.codigo);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'COMPROBANTE NO HA SIDO ENVIADO A SUNAT',
                    }).then(function () {
                        
                    });
                }
            },'JSON');
        }else{
            Swal.fire({
                icon: 'error',
                title: 'INGRESE SERIE Y NÚMERO DE COMPROBANTE',
            }).then(function () {
                
            });
        }        
    });

    function buscarCliente(codigo) {
        $.post('notadebito/buscarClienteCod',{'codigo':codigo}, function (e) {
            $('#txtrazonsocial').val(e.razon_social);
        },'JSON');
    }

    window.dellItemCarrito = function (cod) {
        $.post('notacredito/ItemDellCarrito', {'codigo': cod}, function (e) {
            $('#tablaVenta').html(e);
        });
    };

    function ListarVentaNew() {
        $.post('notacredito/ListarVentaNew', function (e) {
            $('#tablaVenta').html(e);
        });
    }

    function odtenerSerieND(ref) {
        var tipocomp = '08';
        var Datos = new FormData(); 
        Datos.append('referencia',ref);       
        Datos.append('comp',tipocomp);
        $.ajax({
            type: 'POST',
            url: 'notacredito/odtenerSerieCorrelativo/',
            data: Datos,
            contentType: false,
            cache: false,
            dataType: 'json',
            processData: false,
            success: function (msg) {
                console.log(msg)
                $('#txtidserie').val(msg.codigo);
                $('#txtserie').val(msg.serie);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
        });    
    }

    $("#frmNotadebito").on('submit', function (e) {
        e.preventDefault();        
        var serie = $("#txtserie").val();        
        if(serie === ''){
            Swal.fire({
                icon: 'error',
                title: 'ASIGNE UNA SERIE A LA SUCURSAL EN EL MODULO REGISTRAR / ALMACEN',
            }).then(function () {
                $("#txtserie").focus()
            });
        }else{
            $.ajax({
                type: 'POST',
                url: 'notadebito/insertarNotaDebito/',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (msg) {
                    console.log(msg);
                    let data = JSON.parse(msg);
                    console.log(data);
                    if (data.includes("NOTA DEBITO REGISTRADA")) {                    
                        Swal.fire({
                            icon: 'success',
                            title: data,
                        }).then(function () {
                            var venta = data.split("-");                          
                            $('#cargaEspera').modal('show');
                            SendToSunat(venta[1]);                             
                            ListarVentaNew();                           
                        });
                        
                    } else {                   
                        if(data.includes("ERORR DEL SISTEMA SQLSTATE[45000]")){
                            Swal.fire({
                                icon: 'error',
                                title: 'No hay items disponibles para guardar la Compra',
                            }).then(function () {
                                consultarTipoCambio();
                                validarPeriodo();
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: data,
                            }).then(function () {
                                validarPeriodo();
                            });
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown.toString())
                }
                });
        }        
    });

    function validarPeriodo() {
        $.post('compras/validarPeriodo', function (e) {            
            $('#txtidperiodo').val(e.codigo);         
        },'JSON');
    }

    function SendToSunat (codigo) {
        //console.log(codigo);        
        $.post('notadebito/sendToSunat',{'idventa':codigo},function (e) {  
            Swal.fire({
                icon: 'success',
                title: e,
            }).then(function () {
                $('#cargaEspera').modal('hide');
                imprimirPDF(codigo);
            });           
           //window.open('comprobante/pdf', '_blank');
        },'JSON'); 
        
        //imprimirPDF(codigo);
    };

    $('#txtBuscarProducto').keyup(function (e) {
        e.preventDefault();
        var nombre = $('#txtBuscarProducto').val();
        if(nombre.length < 3){
            ListarTablaProductosNew();
        }else{
          $.post('notadebito/ListarProductosNombre', {'nombre': nombre}, function (e) {
            $('#tablaProducto').html(e);
        });  
        }        
    });

    function ListarTablaProductosNew() {
        $.post('comprobante/ListarProductoNew', function (e) {
            $('#tablaProducto').html(e);
        });
    }

    window.AgregarCarrito = function (cod) {
        var codi = cod;
        var cant = $("#txtCantidad" + codi).val(); 
        var preciocompra = $("#txtprecio" + codi).val();
        if(cant == '0' || preciocompra ===''){
            Swal.fire({
                icon: 'error',
                title: 'INGRESE PRECIO DE COMPRA O UNA CANTIDAD MAYOR A CERO',
            }).then(function () {
                
            });
        }else{
            $.post('notadebito/agregarCarrito', {'codigo': codi, 'cantidad': cant, 'precio': preciocompra}, function (e) {            
                //console.log(e)
               $('#tablaVenta').html(e);
            }); 
        }               
    };

    window.dellItemCarrito = function (cod) {
        $.post('notadebito/ItemDellCarrito', {'codigo': cod}, function (e) {
            $('#tablaVenta').html(e);
        });
    };

    function imprimirPDF (codigo) {
        $.post('comprobante/pdf',{'codigo':codigo},function (e) {           
           window.open('comprobante/pdf', '_blank');
        });               
    };

    tooltip();
    ListarComboPeriodo();
    ListarComboYearContable();
    ListarComboTipoDocumento();
    ListarComboMoneda();
    ListarComboMotivo();
    ListarComboFormaPago();
    ListarTablaProductosNew();
    ListarVentaNew();
});