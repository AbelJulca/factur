(function ($) {

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    

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

    function ListarComboProveedor() {
        $.post('orden/listarTablaProveedor', function (e) {
            $('#cmbproveedor').html(e);
            $('.select2').select2();
        });
    }

    function ListarComboAlmacen() {
        $.post('orden/listarTablaAlmacen', function (e) {
            $('#cmbalmacen').html(e);
            $('.select2').select2();
            //validarAlmacen();          
        });
    }

    function validarPeriodo() {
        $.post('compras/validarPeriodo', function (e) {            
            $('#txtperiodo').val(e.codigo);         
        },'JSON');
    }

    function validarAlmacen() {
        $.post('orden/validarAlmacenUsuario', function (e) {
            //console.log(e);
            //$('#txtalmacen').val(e);
            $('#txtidalmacen').val(e);
            //var tex = document.getElementById('txtalmacen');            
            //var long =tex.options[tex.selectedIndex].text;
            //$('#select2-txtalmacen-container').text(long);
            //$('#select2-txtalmacen-container').attr("title",long);
            odtenerSerieCorrelativo(e);
            odtenerSerieOrden(e);
            //console.log(long);
            //$('.select2').select2();
        },'JSON');
    }

    function odtenerSerieCorrelativo(almacen) {
        var tipocomp = '10';
        $('#txttipocompro').val(tipocomp);
    }

    function odtenerSerieOrden(almacen) {
        var tipocomp = '05';
        var Datos = new FormData(); 
        Datos.append('almacen', almacen);       
        Datos.append('comp', tipocomp);
        $.ajax({
            type: 'POST',
            url: 'orden/odtenerSerieCorrelativo/',
            data: Datos,
            contentType: false,
            cache: false,
            dataType: 'json',
            processData: false,
            success: function (msg) {
                //console.log(msg)
                $('#inputGroup-sizing-sm').text(msg.serie);
                $('#txtserieordencompra').val(msg.serie);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown.toString())
            }
            });    
    }
    
    window.renovarDatos = function(){
        var idalmacen = $('#txtalmacen').val();
        $('#txtidalmacen').val(idalmacen);
        odtenerSerieCorrelativo(idalmacen)
    }

    function ListarComboMoneda() {
        $.post('orden/ListarComboMoneda', function (e) {
            $('#cmbmoneda').html(e);
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

    function consultarTipoCambio() {
        $.post('orden/consultarTipoCambio', function (e) {  
            console.log(e);         
            $('#txttipocambio').val(e.venta);
        },'JSON');
    }

    function ListarComboTipoDocumento() {
        $.post('compras/ListarComboDocumento', function (e) {
            $('#cmbtipodocumento').html(e);
        });
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

    function ListarTablaProductos() 
    {
        $.post('orden/ListarProductosNew', function (e) {
            $('#tablaProducto').html(e);
        });
    }

    function ListarVentaNew() {
        $.post('compras/ListarVentaNew', function (e) {
            $('#tablaVenta').html(e);
        });
    }

    $('#txtBuscarProducto').keyup(function (e) {
        e.preventDefault();
        var nombre = $('#txtBuscarProducto').val();
        if(nombre.length < 3){
          ListarTablaProductos();
        }else{
          $.post('compras/ListarProductosNombre', {'nombre': nombre}, function (e) {
            $('#tablaProducto').html(e);
        });  
        }        
    });

    window.AgregarCarrito = function (cod) {
        var codi = cod;
        var cant = $("#txtCantidad" + codi).val();
        var fecha = $("#txtfechaven" + codi).val();     
        var igv = '0';
        if($("#ckbincluirigv").is(':checked')){
            var igv = '1';
        } 
        var preciocompra = $("#txtprecio" + codi).val();
        if(cant == '0' || preciocompra ==='' || fecha === ''){
            Swal.fire({
                icon: 'error',
                title: 'INGRESE PRECIO DE COMPRA O UNA CANTIDAD MAYOR A CERO O FECHA DE VENCIMIENTO',
            }).then(function () {
                
            });
        }else{
            $.post('compras/agregarCarrito', {'codigo': codi, 'cantidad': cant, 'precio': preciocompra, 'igv': igv, 'fecha': fecha}, function (e) {            
                //console.log(e)
               $('#tablaVenta').html(e);
            }); 
        }               
    };

    window.dellItemCarrito = function (cod) {
        $.post('compras/ItemDellCarrito', {'codigo': cod}, function (e) {
            $('#tablaVenta').html(e);
        });
    };

    window.editFechaCarrito = function (cod) {
        var fecha = $('#txtfechavenaux'+cod).val();
        $.post('compras/editFechaCarrito', {'codigo': cod,'fecha': fecha}, function (e) {
            $('#tablaVenta').html(e);
        });
    };

    $('#btnCancelarCompra').on('click', function (e) {
        $.post('compras/cancelarCompra', function (e) {
            if (e === 'LISTO') {
                location.reload();
            }
        },'JSON');
    });

    $('#btnBuscarOrden').on('click', function (e) {
        var serie = $('#inputGroup-sizing-sm').text();
        var correlativo = $('#txtordencompra').val();
        //alert(serie+' - '+correlativo);

        if(correlativo !== ''){
            $('.loadOrden').removeClass('d-none');
            $.post('compras/buscarOrdenCompra',{'serie':serie,'correlativo':correlativo}, function (e) {            
                console.log(e)
                $('.loadOrden').addClass('d-none');
                if(e !== false){
                    $('#txtidordencompra').val(e.codigo);                

                   // $('#txtalmacen').val(e.idalmacen);
                    $('#txtidalmacen').val(e.idalmacen);
                    //var tex = document.getElementById('txtalmacen');            
                   // var long =tex.options[tex.selectedIndex].text;
                    //$('#select2-txtalmacen-container').text(long);
                    //$('#select2-txtalmacen-container').attr("title",long);

                    $('#txtproveedor').val(e.idproveedor);
                    var tex = document.getElementById('txtproveedor');            
                    var long =tex.options[tex.selectedIndex].text;
                    $('#select2-txtproveedor-container').text(long);
                    $('#select2-txtproveedor-container').attr("title",long);

                    llenarDetalleOrden(e.codigo);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'ORDEN DE COMPRA NO EXISTE',
                    }).then(function () {
                        
                    });
                }

            },'JSON');
        }else{
            Swal.fire({
                icon: 'error',
                title: 'INGRESE NÚMERO DE ORDEN',
            }).then(function () {
                
            });
        }
        
    });

    function llenarDetalleOrden(codigo) {
        $.post('compras/ListarDetalleOrden',{'codigo':codigo}, function (e) {
            $('#tablaVenta').html(e);
        });
    }

    $("#frmCompra").on('submit', function (e) {
        e.preventDefault();
        var proveedor = $("#txtproveedor").val();
        var serie = $("#txtserie").val();
        if(proveedor === '0'){
            Swal.fire({
                icon: 'error',
                title: 'ESCOJA UN PROVEEDOR',
            }).then(function () {
                $("#txtproveedor").focus()
            });
            $("#select2-txtproveedor-container").focus()
        }else{
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
                    url: 'compras/insertarCompras/',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (msg) {
                        console.log(msg);
                        let data = JSON.parse(msg);
                        console.log(data);
                        if (data.includes("COMPRA REGISTRADA")) {                    
                            Swal.fire({
                                icon: 'success',
                                title: data,
                            }).then(function () {
                                var venta = data.split("-");
                                console.log(venta[1]);
                                imprimirPDF(venta[1]);
                                $("#frmCompra")[0].reset();
                                
                                ListarComboProveedor()
                                validarAlmacen(); 
                                ListarVentaNew();
                                consultarTipoCambio();
                                renovarDatos();
                                validarPeriodo();
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
                                    consultarTipoCambio();
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
        }
    });

    window.imprimirPDF = function (codigo) {
        $.post('compras/pdf',{'codigo':codigo},function (e) {           
           window.open('compras/pdf', '_blank');
        });               
    };

    ListarVentaNew();

    ListarComboProveedor();
    //ListarComboAlmacen();
    validarAlmacen(); 
    ListarComboMoneda();
    consultarTipoCambio();
    ListarComboTipoDocumento();
    ListarComboYearContable();
    ListarComboPeriodo();

    ListarComboFormaPago();
    ListarTablaProductos();
    

})(jQuery);