(function ($) {
    var table,idioma;
    idioma = {
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

    window.soloNumeros = function (e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };

    $("#btnAddempresa").on('click', function (e) {
        $("#empresaModal").modal('show');
    });
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
                    if (e === 'YA EXISTE UN PROVEEDOR CON EL MISMO DNI') {
                        $('#proveedorModal').modal('hide');
                        $('#mensajeModal').modal('show');
                        $('#txtmensaje').val(e);
                        document.getElementById('btnBuscarDni').disabled = false;
                        $('.loadDni').addClass('d-none');
                    } else {
                        apiDni(dni);
                    }
                }, 'JSON');
            } else {
                document.getElementById('btnBuscarDni').disabled = false;
                $('#proveedorModal').modal('hide');
                $('#mensajeModal').modal('show'); // abrir
                $('#txtmensaje').val('DNI INCORRECTO');
            }
        }
        if (tipo === '6') {
            var ruc = $('#dniP').val();
            if (ruc.length === 11) {
                $.post('proveedor/buscarProveedor', {
                    'nrodoc': ruc
                }, function (e) {
                    if (e === 'YA EXISTE UN PROVEEDOR CON EL MISMO DNI') {
                        $('#proveedorModal').modal('hide');
                        $('#mensajeModal').modal('show');
                        $('#txtmensaje').val('YA EXISTE UN PROVEEDOR CON EL MISMO RUC');
                        document.getElementById('btnBuscarDni').disabled = false;
                        $('.loadDni').addClass('d-none');
                    } else {
                        apiRuc(ruc);
                    }
                }, 'JSON');
            } else {
                document.getElementById('btnBuscarDni').disabled = false;
                $('#proveedorModal').modal('hide');
                $('#mensajeModal').modal('show'); // abrir
                $('#txtmensaje').val('RUC INCORRECTO');
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
                    $('#proveedorModal').modal('hide');
                    $('#mensajeModal').modal('show');
                    $('#txtmensaje').val('DNI NO EXISTE');
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
                console.log(data.result);
                if (data.result.RazonSocial !== null) {
                    var nombre = htmlEntities(data.result.RazonSocial);
                    document.getElementById('razonsocialP').value = nombre;
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

    function ListarComboPais() {
        $.post('empresa/listarTablaPais', function (e) {
            $('#cmbpais').html(e);
        });
    }
    function ListarComboPaisEdit() {
        $.post('empresa/listarTablaPaisEdit', function (e) {
            $('#cmbpaisEdit').html(e);
        });
    }

    function ListarComboDepartamento() {
        $.post('empresa/listarTablaDepartamento', function (e) {
            $('#cmbdepartamento').html(e);
        });
    }

    function ListarComboDepartamentoEdit() {
        $.post('empresa/listarTablaDepartamentoEdit', function (e) {
            $('#cmbdepartamentoEdit').html(e);
        });
    }

    window.ListarProvincia = function() {
        var codigo = $('#txtdepartamento').val();
        $('#txtubigeo').val('');
        $('#txtubigeo').val(codigo+'01');
        $.post('empresa/listarTablaProvincia', {'codigo':codigo},function (e) {            
            $('#cmbprovincia').html(e);
            SelectDistrito();
        });
    }

    window.ListarProvinciaEdit = function() {
        var codigo = $('#txtdepartamentoEdit').val();
        $('#txtubigeoEdit').val('');
        $('#txtubigeoEdit').val(codigo+'01');
        $.post('empresa/listarTablaProvinciaEdit', {'codigo':codigo},function (e) {            
            $('#cmbprovinciaEdit').html(e);
            SelectDistritoEdit();
        });
    }

    window.ListarDistritoEdit = function() {
        var codigo = $('#txtprovinciaEdit').val();
        var depar = $('#txtdepartamentoEdit').val();
        var ubi =  depar+codigo+'01';
        $('#txtubigeoEdit').val(ubi);
        $.post('empresa/listarTablaDistritoEdit', {'provin':codigo,'depar':depar},function (e) {            
            $('#cmbdistritoEdit').html(e);
        });
    }

    window.ListarDistrito = function() {
        var codigo = $('#txtprovincia').val();
        var depar = $('#txtdepartamento').val();
        var ubi =  depar+codigo+'01';
        $('#txtubigeo').val(ubi);
        $.post('empresa/listarTablaDistrito', {'provin':codigo,'depar':depar},function (e) {            
            $('#cmbdistrito').html(e);
        });
    }

    window.llenarubigeoEdit = function() {
        var depar = $('#txtdepartamentoEdit').val();
        var prov = $('#txtprovinciaEdit').val();
        var dist = $('#txtdistritoEdit').val();
        var ubi = depar+prov+dist;
        $('#txtubigeoEdit').val('');
        $('#txtubigeoEdit').val(ubi);       
    }

    window.llenarubigeo = function() {
        var depar = $('#txtdepartamento').val();
        var prov = $('#txtprovincia').val();
        var dist = $('#txtdistrito').val();
        var ubi = depar+prov+dist;
        $('#txtubigeo').val('');
        $('#txtubigeo').val(ubi);       
    }

    function ListarComboSelect() {
        $.post('empresa/listarSelect', function (e) {
            $('#cmbprovincia').html(e);
            $('#cmbdistrito').html(e);
        });
    }

    function ListarComboSelectEdit() {
        $.post('empresa/listarSelect', function (e) {
            $('#cmbprovinciaEdit').html(e);
            $('#cmbdistritoEdit').html(e);
        });
    }

    function SelectDistrito() {
        $.post('empresa/listarSelect', function (e) {            
            $('#cmbdistrito').html(e);
        });
    }

    function SelectDistritoEdit() {
        $.post('empresa/listarSelect', function (e) {            
            $('#cmbdistritoEdit').html(e);
        });
    }

    $("#frmEmpresa").on('submit', function (e) {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'empresa/insertarEmpresa/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("EMPRESA REGISTRADA")) {
                    $('#empresaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmEmpresa")[0].reset();
                        table.ajax.reload(null, false);
                    });
                    
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#empresaModal').modal('hide');
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

    $("#frmEmpresaEditar").on('submit', function (e) {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'empresa/actualizarEmpresa/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("DATOS DE EMPRESA")) {
                    $('#empresaEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        table.ajax.reload(null, false);
                    });
                    //$("#frmProveedor")[0].reset();
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#empresaEditModal').modal('hide');
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

       
    
    function ListarEmpresas() {
        /*$.post('empresa/listarTablaEmpresa', function (e) {            
            console.log(e);
        });*/
        table = $('#datosEmpresa').DataTable({
            "destroy":true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'empresa/listarTablaEmpresa'
            },
            "columns": [
                {
                    "data": "ruc"
                },
                {
                    "data": "razon_social"
                },
                {
                    "data": "modo_ft_notas"
                },
                {
                    "data": "modo_guias"
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
                    extend: 'excelHtml5',
                    title: 'REPORTE_EMPRESAS' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_EMPRESAS' + '_' + datetime,
                    orientation: 'portrait',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ]
        });
        odtenerDatosEmpresa('#datosEmpresa tbody', table);
        eliminarDatosEmpresa('#datosEmpresa tbody', table);
    }

    function eliminarDatosEmpresa(tbody, table) {
        $(tbody).on('click', 'button.eliminar', function () {
            var data =$(this).data('dellid');
            console.log(data);
            Swal.fire({
                title: '¿ESTA SEGURO?',
                text: "NO HAY VUELTA ATRAS!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
              }).then((result) => {
                if (result.isConfirmed) {
                    deleteEmpresa(data);
                }
              })
        });
    }    

    function deleteEmpresa(codigo) {
        $.post('empresa/eliminarEmpresa', {
            'id': codigo
        }, function (e) {
            console.log(e)
            if (e === 'EMPRESA ELIMINADA EXITOSAMENTE') { 
                Swal.fire({
                    icon: 'success',
                    title: e,
                }).then(function () {
                    Swal.fire(
                        'ELIMINADO!',
                        'EMPRESA ELIMINADA EXITOSAMENTE',
                        'success'
                    )
                    table.ajax.reload(null, false);
                });
                // ListarBajas();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'LA EMPRESA TIENE REGISTROS NO SE PUEDE ELIMINAR',
                }).then(function () {
                    
                });
            }
        }, 'JSON');
    }

    function  odtenerDatosEmpresa(tbody, table) {
        $(tbody).on('click', 'button.editar', function () {
           // var data = table.row($(this).parents('tr')).data();
           
            var codigo =$(this).data('empresaid');
            //console.log(codigo)
                $.post('empresa/listarEmpresaCodigo', {'id':codigo},function (data) {   
                    let cadena = data.ubigeo;  
                    console.log(data);       
                    $('#txtcodigo').val(data.codigo);            
                    $('#dniPEdit').val(data.ruc);
                    $('#razonsocialPEdit').val(data.razon_social);
                    $('#nombrecomercialPEdit').val(data.nombre_comercial);
                    $('#direccionPEdit').val(data.direccion);
                    $('#txtpaisEdit').val(data.idpais);
                    $('#txtdepartamentoEdit').val(cadena.slice(0, 2));
                    ListProvincia (cadena.slice(0, 2),cadena.slice(2, 4));
                    ListDistrito(cadena.slice(0, 2),cadena.slice(2, 4),cadena.slice(4, 6))
                    $('#txtubigeoEdit').val(data.ubigeo);
                    $('#txtusuariosolEdit').val(data.usuario_sol_sec);
                    $('#txtclavesolEdit').val(data.clave_sol_sec);
                    $('#txtmodonotaEdit').val(data.modo_ft_notas);
                    $('#txtmodoguiaEdit').val(data.modo_guias);
                    if(data.estado == '1'){
                        $('#chkestadoEdit').prop("checked", true); 
                    }else{
                        $('#chkestadoEdit').prop("checked", false); 
                    } 
                    $('#empresaEditModal').modal('show');         
                },'JSON');         
            
        });
    }

    function ListProvincia (dep,pro) {
        var codigo = dep;        
        $.post('empresa/listarTablaProvinciaEdit', {'codigo':codigo},function (e) {            
            $('#cmbprovinciaEdit').html(e);
            $('#txtprovinciaEdit').val(pro);           
        });
    }

    function ListDistrito(dep,pro,dis) {
        var codigo = pro;
        var depar = dep;        
        $.post('empresa/listarTablaDistritoEdit', {'provin':codigo,'depar':depar},function (e) {            
            $('#cmbdistritoEdit').html(e);
            $('#txtdistritoEdit').val(dis); 
        });
    }

    ListarEmpresas();
    ListarComboPais();
    ListarComboDepartamento();
    ListarComboSelect();

    ListarComboPaisEdit();
    ListarComboDepartamentoEdit();
    ListarComboSelectEdit();

    //setTimeout(function(){ ListarEmpresas(); }, 2000);
})(jQuery);