$(function () {

    window.soloNumeros = function (e) {

        var key = window.Event ? e.which : e.keyCode;

        return (key >= 48 && key <= 57);

    };

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

    function ListarCompr() {
        $.post('guiaremision/ListarCompro', function (e) {
            $('#cmbComproNota').html(e);
        });
    }

    function odtenerSerie() {
        var tipocomp = '09';
        var Datos = new FormData();        
        Datos.append('comp',tipocomp);
        $.ajax({
            type: 'POST',
            url: 'bajaboletas/odtenerSerie/',
            data: Datos,
            contentType: false,
            cache: false,
            dataType: 'json',
            processData: false,
            success: function (msg) {
                console.log(msg)
                $('#txtidserie').val(msg.codigo);
                $('#txtserie').val(msg.serie);
                var a = parseInt('1');
                var b = parseInt(msg.correlativo);
                $('#txtcorrelativo').val(a+b);
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
                    $('#txtdireccion').val(e.direccion);
                    $('#txtrazonsocial').val(e.razon_social);
                    $('#txtnrodocu').val(e.nrodocu);
                  
                    llenarDetalleVenta(e.codigo);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'COMPROBANTE NO HA SIDO ENVIADO A SUNAT O HA SIDO DADO DE BAJA',
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

    function llenarDetalleVenta(idventa) {
        $.post('guiaremision/llenaDetalle', {'idventa': idventa}, function (e) {
            $('#tabla-ncdetalle').html(e);
        });
    }

    function ListarComboMotivo() {
        $.post('guiaremision/listarMotivo', function (e) {
            $('#cmbMotivo').html(e);
        });
    }

    function ListarComboModo() {
        $.post('guiaremision/listarModo', function (e) {
            $('#cmbModoTraslado').html(e);
        });
    }

    function ListarComboUnid() {
        $.post('guiaremision/ListarComboUnid', function (e) {
            $('#cmbUnidad').html(e);
        });
    }

    function ListarDocumento() {
        $.post('guiaremision/listarTablaDocumento', function (e) {
            $('#cmbTipoDocu').html(e);
        });
    }

    function ListarTablaNueva() {
        $.post('guiaremision/listarTablaNueva', function (e) {
            $('#tabla-ncdetalle').html(e);
        });
    }

    function ListarComboDepartamento() {
        $.post('empresa/listarTablaDepartamento', function (e) {
            $('#cmbdepartamento').html(e);
        });
    }


    $("#btnBuscarUbigeo").on('click', function (e) {
        // $('.cargarUb').removeClass('d-none');
        $('#btnAceptarPP').removeClass('d-none');
        $('#btnAceptarLL').addClass('d-none');
        $('#ModalUbigeo').modal('show');
    });
    $("#btnBuscarUbigeoLL").on('click', function (e) {
        $('#btnAceptarPP').addClass('d-none');
        $('#btnAceptarLL').removeClass('d-none');
        $('#ModalUbigeo').modal('show');
    });

    $("#btnAceptarPP").on('click', function (e) {
        let ubigeo = $('#txtUbigeox').val();
        $('#txtubigeo').val(ubigeo);
        $('#ModalUbigeo').modal('hide');
    });

    $("#btnAceptarLL").on('click', function (e) {
        let ubigeo = $('#txtUbigeox').val();
        $('#txtubigeoLL').val(ubigeo);
        $('#ModalUbigeo').modal('hide');
    });

    window.ListarProvincia = function() {
        var codigo = $('#txtdepartamento').val();        
        $('#txtubigeo').val('');
        $('#txtUbigeox').val(codigo+'01');
        $('#txtubigeo').val(codigo+'01');
        $.post('empresa/listarTablaProvincia', {'codigo':codigo},function (e) {            
            $('#cmbprovincia').html(e);
            SelectDistrito();
        });
    }

    window.ListarDistrito = function() {
        var codigo = $('#txtprovincia').val();
        var depar = $('#txtdepartamento').val();
        var ubi =  depar+codigo+'01';
        $('#txtUbigeox').val(ubi);
        $('#txtubigeo').val(ubi);
        $.post('empresa/listarTablaDistrito', {'provin':codigo,'depar':depar},function (e) {            
            $('#cmbdistrito').html(e);
        });
    }

    window.llenarubigeo = function() {
        var depar = $('#txtdepartamento').val();
        var prov = $('#txtprovincia').val();
        var dist = $('#txtdistrito').val();
        var ubi = depar+prov+dist;
        $('#txtUbigeox').val(ubi);
        $('#txtubigeo').val('');
        $('#txtubigeo').val(ubi);       
    }

    window.modoprivado = function() {
        let modo = $('#txtmodotraslado').val();
        if (modo == '02') {
            $('.privado').removeClass('d-none');
        } else {
            $('.privado').addClass('d-none');
        }      
    }
    
    function SelectDistrito() {
        $.post('empresa/listarSelect', function (e) {            
            $('#cmbdistrito').html(e);
        });
    }

    $('#btnBuscarDni').on('click', function (e) {
        document.getElementById('btnBuscarDni').disabled = true;
        $('.loadDni').removeClass('d-none');
        var documento = $('#txtdocum').val();
        if(documento.length === 8 || documento.length === 11 ){
            $.post('transportista/buscarTransportista', {
                'nrodoc': documento
            }, function (e) {
                document.getElementById('btnBuscarDni').disabled = false;  
                if (e !== false) { 
                    console.log(e);   
                    $('.loadDni').addClass('d-none')                
                    $("#txtplaca").val(e.placa);
                    $("#txtidtrans").val(e.codigo);
                    $("#txtnombre").val(e.razon_social);              
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registre un transportista primero',
                    }).then(function () {
                        $('.loadDni').addClass('d-none')
                        window.location = 'transportista';
                    }); 
                }
            }, 'JSON');  
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Introdusca un Documento valido',
            }).then(function () {

            });      
        }        
    });

    function validarPeriodo() {
        $.post('compras/validarPeriodo', function (e) { 
            $('#txtidperiodo').val(e.codigo);       
        },'JSON');
    }

    $("#frmGuiaRemision").on('submit', function (e)    
    {
        e.preventDefault();
        let idcliente = $('#txtidcliente').val();
        if (idcliente !== '') {
            $.ajax(
                {
                    type: 'POST',
                    url: 'guiaremision/registrarGuia/',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (msg)
                    {
                        //console.log(msg);
                        let e = JSON.parse(msg);
                        if (e.includes("GUIA REMISION"))
                        {
                            $('#cargaEspera').modal('show');
                            var venta = e.split("-");                                
                            SendToSunat(venta[1]);                            
                            //table.ajax.reload(null, false);
                            $("#frmGuiaRemision")[0].reset();                           
                            ListarTablaNueva();
                            odtenerSerie();
                            //location.reload();

                         /*   Swal.fire({
                                icon: 'success',
                                title: e,
                            }).then(function () {
        
                            }); */
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
        $.post('guiaremision/pdf',{'codigo':codigo},function (e) {           
           window.open('guiaremision/pdf', '_blank');
        });               
    };

    function SendToSunat (codigo) {
        //console.log(codigo);
        $.post('guiaremision/sendToSunat',{'idventa':codigo},function (e) {
            console.log(e);
            $('#cargaEspera').modal('hide');
            Swal.fire({
                icon: 'success',
                title: e,
            }).then(function () {
                imprimirPDF(codigo);
            });           
           //window.open('comprobante/pdf', '_blank');
        },'JSON');   
    };

    

    validarPeriodo();
    ListarCompr();
    odtenerSerie();
    ListarComboMotivo();
    ListarComboModo();
    ListarComboUnid();
    ListarDocumento();
    ListarTablaNueva();
    ListarComboDepartamento();
});   