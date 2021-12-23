$(function () {

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

    $("#btnAddtrans").on('click', function (e) {
        $("#transportistaModal").modal('show');
    });

    window.soloNumeros = function (e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57);
    };

    window.cambiardoc = function () {
    };

    function Toggle() {
        $('[data-toggle="tooltip"]').tooltip();
    }


    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

    function ListarTransportista() {
        /*$.post('cliente/listarTablaCliente', function (e) {            
             console.log(e);
        },'JSON');*/
         table = $('#datosConsulta').DataTable({
             "destroy":true,
             "responsive": true,
             "ajax": {
                 'method': 'POST',
                 'url': 'transportista/listarTabla'
             },
             "columns": [
                 {
                     "data": "nrodoc"
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
                     "data": "placa"
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
                        'title': 'Agregar Transportista',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-primary'
                    },
                    action:function () {
                        $("#transportistaModal").modal('show');
                    }
                },
                 {
                     extend: 'excelHtml5',
                     title: 'REPORTE_TRANSPORTISTA' + '_' + datetime,
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
                     title: 'REPORTE_TRANSPORTISTA' + '_' + datetime,
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
         odtenerDatosCliente('#datosConsulta tbody');
         eliminarDatosCliente('#datosConsulta tbody');
    }

    function odtenerDatosCliente(tbody) {
        $(tbody).on('click', 'button.editar', function () {
            var codigo =$(this).data('dni');
            $.post('transportista/buscarTransportista', {
                'nrodoc': codigo
            }, function (data) {
                $('#txtidtranspor').val(data.codigo);
                $('#txtdniEdit').val(data.nrodoc);
                $('#txtdocumentoEdit').val(data.iddocumento);
                $('#txtrazonsocialEdit').val(data.razon_social);
                $('#txttelefonoEdit').val(data.telefono);
                $('#txtcorreoEdit').val(data.correo);
                $('#txtdireccionEdit').val(data.direccion);
                $('#txtplacaEdit').val(data.placa);
                $('#transportistaEditModal').modal('show');
                Toggle();
            }, 'JSON');
        });
    }

    function eliminarDatosCliente(tbody) {
        $(tbody).on('click', 'button.eliminar', function () {
            var codigo =$(this).data('codigo');
            Swal.fire({
                title: '¿ESTAS SEGURO?',
                text: "YA NO HAY REVERCION UNA VEZ ACEPTADO!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarTransporte(codigo);
                }
            })
        });
    }

    function eliminarTransporte(codigo) {
        $.post('transportista/eliminarTransportista',{'codigo':codigo}, function (e) {  
            if (e.includes('TRANSPORTISTA')) {
                Swal.fire(
                    'Eliminado!',
                    e,
                    'success'
                )
                table.ajax.reload(null, false);
            } else {
                Swal.fire(
                    'PROBLEMA!',
                    e,
                    'error'
                ) 
            }       
        },'JSON');
    }

    function ListarComboDocumento() {
        $.post('transportista/listarTablaDocumento', function (e) {            
            $('#cmbdocumento').html(e);
        });
    }

    function ListarComboDocumentoEdit() {
        $.post('transportista/listarTablaDocumentoEdit', function (e) {            
            $('#cmbdocumentoEdit').html(e);
        });
    }

    Toggle();

    $('#btnBuscarDni').on('click', function (e) {
        document.getElementById('btnBuscarDni').disabled = true;
        $('.loadDni').removeClass('d-none');
        var documento = $('#txtdni').val();
        if(documento.length === 8 || documento.length === 11){
            $.post('transportista/buscarTransportista', {
                'nrodoc': documento
            }, function (e) {
                document.getElementById('btnBuscarDni').disabled = false;  
                if (e !== false) {
                    $('.loadDni').addClass('d-none');
                    $("#transportistaModal").modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Ya existe un Transportista con el mismo documento',
                    }).then(function () {
    
                    });
                } else {
                    if (documento.length === 11) {
                        apiRuc(documento);
                    } else {
                        apiDni(documento);  
                    }                     
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
                    $('#txtdocumento').val('6');
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
                if (data.result.DNI === null || data.result.DNI === '') {                   
                    $('#txtrazonsocial').val('DNI NO EXISTE');
                    $('.loadDni').addClass('d-none');
                    document.getElementById('btnBuscarDni').disabled = false;
                } else {
                    //console.log(data);
                    var nombre = htmlEntities(data.result.Nombre);
                    var apep = htmlEntities(data.result.Paterno);
                    var apem = htmlEntities(data.result.Materno);
                    $('#txtrazonsocial').val(nombre + ' ' + apep + ' ' + apem);
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

    $("#frmTransportista").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'transportista/insertarTransportista/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("TRANSPORTISTA REGISTRADO")) {
                    $('#transportistaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        //location.reload();
                        table.ajax.reload(null, false);
                        $("#frmTransportista")[0].reset();
                    });
                } else {
                    $('#transportistaModal').modal('hide');
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
    
    $("#frmEditTransportista").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'transportista/actualizarTransportista/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {

                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("TRANSPORTISTA MODIFICADO")) {
                    $('#transportistaEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        //location.reload();
                        table.ajax.reload(null, false);
                        //$("#frmTransportista")[0].reset();
                    });
                } else {
                    $('#transportistaEditModal').modal('hide');
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
    ListarTransportista();
    ListarComboDocumento();
    ListarComboDocumentoEdit();
});