(function ($) {

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    

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

    function validarAlmacen() {
        $.post('orden/validarAlmacenUsuario', function (e) {
            //console.log(e);
            //$('#txtalmacen').val(e);
            $('#txtidalmacen').val(e);
            //var tex = document.getElementById('txtalmacen');            
            //var long =tex.options[tex.selectedIndex].text;
           // $('#select2-txtalmacen-container').text(long);
            //$('#select2-txtalmacen-container').attr("title",long);
            odtenerSerieCorrelativo(e);

            //console.log(long);
            //$('.select2').select2();
        },'JSON');
    }

    function odtenerSerieCorrelativo(almacen) {
        var tipocomp = '05';
        $.post('orden/odtenerSerieCorrelativo',{'almacen':almacen,'comp':tipocomp}, function (e) {
            console.log(e.correlativo);
            var core = parseInt(e.correlativo);
            var num = parseInt('1');
            $('#txtcorrelativo').val(core+num);
            $('#txtserie').val(e.serie);
            $('#txtidserie').val(e.codigo);
        },'JSON');
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

    function consultarTipoCambio() {
        $.post('orden/consultarTipoCambio', function (e) {
            //console.log(e.venta)
            $('#txttipocambio').val(e.venta);
        },'JSON');
    }

    ListarComboProveedor();
    //ListarComboAlmacen();
    ListarComboMoneda();
    consultarTipoCambio();
    validarAlmacen();

    function ListarTablaProductos() {
        $.post('orden/ListarProductosNew', function (e) {
            $('#tablaProducto').html(e);
        });
    }

    $('#txtBuscarProducto').keyup(function (e) {
        e.preventDefault();
        var nombre = $('#txtBuscarProducto').val();
        if(nombre === ''){
          ListarTablaProductos();
        }else{
          $.post('orden/ListarProductosNombre', {'nombre': nombre}, function (e) {
            $('#tablaProducto').html(e);
        });  
        }        
    });

    window.AgregarCarrito = function (cod) {
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
            $.post('orden/agregarCarrito', {'codigo': codi, 'cantidad': cant, 'precio': preciocompra, 'igv': igv}, function (e) {            
                //console.log(e)
               $('#tablaVenta').html(e);
            }); 
        }               
    };

    window.dellItemCarrito = function (cod) {
        $.post('orden/ItemDellCarrito', {'codigo': cod}, function (e) {
            $('#tablaVenta').html(e);
        });
    };


    function ListarVentaNew() {
        $.post('orden/ListarVentaNew', function (e) {
            $('#tablaVenta').html(e);
        });
    }

    $("#frmOrdenCompra").on('submit', function (e) {
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
                    url: 'orden/insertarOrden/',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (msg) {
                        console.log(msg);
                        let data = JSON.parse(msg);
                        console.log(data);
                        if (data.includes("ORDEN REGISTRADA")) {                    
                            Swal.fire({
                                icon: 'success',
                                title: data,
                            }).then(function () {
                                var venta = data.split("-");
                                console.log(venta[1]);
                                imprimirPDF(venta[1]);
                                $("#frmOrdenCompra")[0].reset();
                                ListarComboProveedor();
                                validarAlmacen();
                                ListarVentaNew();
                                consultarTipoCambio();
                                renovarDatos();
                            });
                            
                        } else {                   
                            if(data.includes("ERORR DEL SISTEMA SQLSTATE[45000]")){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'No hay items disponibles para guardar la Orden Compra',
                                }).then(function () {
                                    consultarTipoCambio();
                                });
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: data,
                                }).then(function () {
                                    consultarTipoCambio();
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

    $('#btnCancelarVenta').on('click', function (e) {
        consultarTipoCambio();
        ListarTablaProductos()
        $.post('orden/cancelarVenta', function (e) {            
            $('#tablaVenta').html(e);
        });
    });
    window.imprimirPDF = function (codigo) {
        $.post('orden/pdf',{'codigo':codigo},function (e) {           
           window.open('orden/pdf', '_blank');
        });               
    };

    window.imprimirTCK = function () {
        codigo = '4';
        $.post('orden/tck',{'codigo':codigo},function (e) {           
           window.open('orden/tck', '_blank');
        });               
    };
    ListarTablaProductos();
    ListarVentaNew();
    
    
})(jQuery);