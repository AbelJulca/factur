(function ($) {
    var table, tablex, tabley;

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


    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();


    function ListarSucursal() 
    {
        table = $('#datosSucursal').DataTable({
            "destroy":true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'almacen/listarTablaSucursal'
            },
            "columns": [
                {
                    "data": "descripcion"
                },
                {
                    "data": "ubigeo"
                },
                {
                    "data": "departamento"
                },
                {
                    "data": "provincia"
                },
                {
                    "data": "distrito"
                },
                {
                    "data": "direccion"
                },                 
                {
                    "data": "estado"
                },               
                {
                    "data": "boton"
                }
            ],
            "language":idioma,
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
                        'title': 'Agregar Almacen',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-primary'
                    },
                    action:function () {
                        $("#sucursalModal").modal('show');
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_SUCURSAL' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_SUCURSAL' + '_' + datetime,
                    orientation: 'portrait',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    }
                }
            ]
        });
        odtenerDatosSucursal('#datosSucursal tbody', table);
        eliminarDatosSucursal('#datosSucursal tbody', table);
    }

    function  odtenerDatosSucursal(tbody, table) 
    {
        $(tbody).on('click', 'button.editar', function () {
            var codigo =$(this).data('sucursalid'); 
            $.post('almacen/obtenerSucursalCodigo', {'id': codigo}, function (e) {
                console.log(e);
                let cadena = e.ubigeo;            
                $('#txtidsuc').val(e.codigo);            
                $('#txtdesccripcionEdit').val(e.descripcion);
                $('#txtdireccionEdit').val(e.direccion);
                $('#txtempresaEdit').val(e.idempresa);
                $('#txtdepartamentoEdit').val(cadena.slice(0, 2));
                ListProvincia (cadena.slice(0, 2),cadena.slice(2, 4));
                ListDistrito(cadena.slice(0, 2),cadena.slice(2, 4),cadena.slice(4, 6))
                $('#txtubigeoEdit').val(e.ubigeo);            
            if(e.estado == '1'){
                $('#customSwitchesEdit').attr("checked",true);
            }else{
                $('#customSwitchesEdit').attr("checked",false);
            }
                $('#sucursalEditModal').modal('show');           
            }, 'JSON');
        });
    }

    function eliminarDatosSucursal(tbody, table) 
    {
        $(tbody).on('click', 'button.eliminar', function () {
            var codigo =$(this).data('sucursalid');               
            Swal.fire({
                title: '¿Esta Seguro?',
                text: "Deseas eliminar la Sucursal!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('almacen/eliminarSucursal', {'id': codigo}, function (e) {
                        console.log(e)
                        if (e === 'SUCURSAL ELIMINADA EXITOSAMENTE') { 
                            Swal.fire({
                                icon: 'success',
                                title: e,
                            }).then(function () {
                                //table.ajax.reload(null, false);
                                location.reload();
                            });
                            // ListarBajas();
                        } else {
                            if(e.includes("ERORR DEL SISTEMASQLSTATE[23000]")){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Sucursal tiene registros. No se puede eliminar',
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

    function SelectDistritoEdit() 
    {
        $.post('empresa/listarSelect', function (e) {            
            $('#cmbdistritoEdit').html(e);
        });
    }

    function ListarComboSelectEdit() 
    {
        $.post('empresa/listarSelect', function (e) {
            $('#cmbprovinciaEdit').html(e);
            $('#cmbdistritoEdit').html(e);
        });
    }

    function SelectDistritoEdit() 
    {
        $.post('empresa/listarSelect', function (e) {            
            $('#cmbdistritoEdit').html(e);
        });
    }

    window.ListarProvinciaEdit = function() 
    {
        var codigo = $('#txtdepartamentoEdit').val();
        $('#txtubigeoEdit').val('');
        $('#txtubigeoEdit').val(codigo+'01');
        $.post('empresa/listarTablaProvinciaEdit', {'codigo':codigo},function (e) {            
            $('#cmbprovinciaEdit').html(e);
            SelectDistritoEdit();
        });
    }

    window.ListarDistritoEdit = function() 
    {
        var codigo = $('#txtprovinciaEdit').val();
        var depar = $('#txtdepartamentoEdit').val();
        var ubi =  depar+codigo+'01';
        $('#txtubigeoEdit').val(ubi);
        $.post('empresa/listarTablaDistritoEdit', {'provin':codigo,'depar':depar},function (e) {            
            $('#cmbdistritoEdit').html(e);
        });
    }

    function ListProvincia (dep,pro) 
    {
        var codigo = dep;        
        $.post('empresa/listarTablaProvinciaEdit', {'codigo':codigo},function (e) {            
            $('#cmbprovinciaEdit').html(e);
            $('#txtprovinciaEdit').val(pro);           
        });
    }

    function ListDistrito(dep,pro,dis) 
    {
        var codigo = pro;
        var depar = dep;        
        $.post('empresa/listarTablaDistritoEdit', {'provin':codigo,'depar':depar},function (e) {            
            $('#cmbdistritoEdit').html(e);
            $('#txtdistritoEdit').val(dis); 
        });
    }

    function ListarComboEmpresa() 
    {
        $.post('almacen/listarTablaEmpresa', function (e) {
            $('#cmbempresa').html(e);
        });
    }

    function ListarComboEmpresaEdit() 
    {
        $.post('almacen/listarTablaEmpresaEdit', function (e) {
            $('#cmbempresaEdit').html(e);
        });
    }

    function ListarComboDepartamento() 
    {
        $.post('empresa/listarTablaDepartamento', function (e) {
            $('#cmbdepartamento').html(e);
        });
    }

    function ListarComboDepartamentoEdit() 
    {
        $.post('empresa/listarTablaDepartamentoEdit', function (e) {
            $('#cmbdepartamentoEdit').html(e);
        });
    }

    function ListarComboSelect() 
    {
        $.post('empresa/listarSelect', function (e) {
            $('#cmbprovincia').html(e);
            $('#cmbdistrito').html(e);
        });
    }

    window.ListarProvincia = function() 
    {
        var codigo = $('#txtdepartamento').val();
        $('#txtubigeo').val('');
        $('#txtubigeo').val(codigo+'01');
        $.post('empresa/listarTablaProvincia', {'codigo':codigo},function (e) {            
            $('#cmbprovincia').html(e);
            SelectDistrito();
        });
    }

    window.ListarDistrito = function() 
    {
        var codigo = $('#txtprovincia').val();
        var depar = $('#txtdepartamento').val();
        var ubi =  depar+codigo+'01';
        $('#txtubigeo').val(ubi);
        $.post('empresa/listarTablaDistrito', {'provin':codigo,'depar':depar},function (e) {            
            $('#cmbdistrito').html(e);
        });
    }

    window.llenarubigeo = function() 
    {
        var depar = $('#txtdepartamento').val();
        var prov = $('#txtprovincia').val();
        var dist = $('#txtdistrito').val();
        var ubi = depar+prov+dist;
        $('#txtubigeo').val('');
        $('#txtubigeo').val(ubi);       
    }

    window.llenarubigeoEdit = function()
    {
        var depar = $('#txtdepartamentoEdit').val();
        var prov = $('#txtprovinciaEdit').val();
        var dist = $('#txtdistritoEdit').val();
        var ubi = depar+prov+dist;
        $('#txtubigeoEdit').val('');
        $('#txtubigeoEdit').val(ubi);       
    }

    function SelectDistrito() 
    {
        $.post('empresa/listarSelect', function (e) {            
            $('#cmbdistrito').html(e);
        });
    }

    $("#frmSucursal").on('submit', function (e) 
    {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'almacen/insertarSucursal/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("SUCURSAL REGISTRADA")) {
                    $('#sucursalModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmSucursal")[0].reset();
                        //table.ajax.reload(null, false);
                        location.reload();
                    });
                } else {
                    $('#sucursalModal').modal('hide');
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

    $("#frmEditSucursal").on('submit', function (e) 
    {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'almacen/actualizarSucursal/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("SUCURSAL MODIFICADA")) {
                    $('#sucursalEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        //$("#frmEditSucursal")[0].reset();
                        //table.ajax.reload(null, false);
                        location.reload();
                    });
                } else {
                    $('#sucursalEditModal').modal('hide');
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
  
  ListarSucursal();
  ListarComboDepartamento();
  ListarComboSelect();
  ListarComboEmpresa();
  ListarComboEmpresaEdit();
  ListarComboDepartamentoEdit();

  //**************************** ALMACEN****************** */

function ListarAlmacen() {
    
    tablex = $('#datosAlmacen').DataTable({
        "destroy":true,
        "responsive": true,
        "ajax": {
            'method': 'POST',
            'url': 'almacen/listarTablaAlmacen'
        },
        "columns": [
            {
                "data": "descripcion"
            },
            {
                "data": "condicion"
            },
            {
                "data": "sucursal"
            },                
            {
                "data": "estado"
            },               
            {
                "data": "boton"
            }
        ],
        "language":idioma,
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
                    'title': 'Agregar Almacen',
                    'data-toggle': 'tooltip',
                    'data-placement': 'bottom',
                    'class': 'btn btn-primary'
                },
                action:function () {
                    $("#almacenModal").modal('show');
                }
            },
            {
                extend: 'excelHtml5',
                title: 'REPORTE_ALMACEN' + '_' + datetime,
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
                title: 'REPORTE_ALMACEN' + '_' + datetime,
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
    odtenerDatosAlmacen('#datosAlmacen tbody', tablex);
    eliminarDatosAlmacen('#datosAlmacen tbody', tablex);
}

function eliminarDatosAlmacen(tbody, table) {
    $(tbody).on('click', 'button.eliminar', function () {
        var codigo =$(this).data('almacenid');         
        Swal.fire({
            title: '¿Esta Seguro?',
            text: "Deseas eliminar el ALmacen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('almacen/eliminarAlmacen', {
                    'id': codigo
                }, function (e) {
                    console.log(e)
                    if (e === 'ALMACEN ELIMINADO EXITOSAMENTE') { 
                        Swal.fire({
                            icon: 'success',
                            title: e,
                        }).then(function () {
                            tablex.ajax.reload(null, false);
                        });
                        // ListarBajas();
                    } else {
                        if(e.includes("ERORR DEL SISTEMASQLSTATE[23000]")){
                            Swal.fire({
                                icon: 'error',
                                title: 'Almacen tiene registros. No se puede eliminar',
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

$('#btn-cinfirm-elimina-almacen').on('click', function (e) {
    var codigo = $('#txtcodigoAlmacen').val();
    e.preventDefault();
    $('#ModalEliminarAlmacen').modal('hide');
    $.post('almacen/eliminarAlmacen', {
        'id': codigo
    }, function (e) {
        console.log(e)
        if (e === 'ALMACEN ELIMINADO EXITOSAMENTE') { 
            Swal.fire({
                icon: 'success',
                title: e,
            }).then(function () {
                tablex.ajax.reload(null, false);
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

function  odtenerDatosAlmacen(tbody, table) {
    $(tbody).on('click', 'button.editar', function () { 
        var codigo =$(this).data('almacenid'); 
            $.post('almacen/obtenerAlmacenCodigo', {'id': codigo}, function (e) {
                console.log(e)
                $('#txtidalm').val(e.codigo);            
                $('#txtdescalmacenEdit').val(e.descripcion);
                $('#txtsucursalEdit').val(e.idsucursal);
                $('#txtcondicionEdit').val(e.condicion);            
                if(e.estado == '1'){
                    $('#chkalmacenEdit').attr("checked",true);
                }else{
                    $('#chkalmacenEdit').attr("checked",false);
                }
                $('#almacenEditModal').modal('show');         
            }, 'JSON');
    });
}


function ListarComboSucursal() {
    $.post('almacen/listarComboSucursal', function (e) {
        $('#cmbsucursal').html(e);
    });
}

function ListarComboSucursalEdit() {
    $.post('almacen/listarComboSucursalEdit', function (e) {
        $('#cmbsucursalEdit').html(e);
    });
}

$("#frmAlmacen").on('submit', function (e) {
    e.preventDefault();        
    $.ajax({
        type: 'POST',
        url: 'almacen/insertarAlmacen/',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (msg) {
            console.log(msg);
            let data = JSON.parse(msg);
            console.log(data);
            if (data.includes("ALMACEN REGISTRADO")) {
                $('#almacenModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: data,
                }).then(function () {
                    $("#frmAlmacen")[0].reset();
                    tablex.ajax.reload(null, false);
                   // location.reload();
                });
            } else {
                $('#almacenModal').modal('hide');
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

$("#frmEditAlmacen").on('submit', function (e) {
    e.preventDefault();        
    $.ajax({
        type: 'POST',
        url: 'almacen/actualizarAlmacen/',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (msg) {
            console.log(msg);
            let data = JSON.parse(msg);
            console.log(data);
            if (data.includes("ALMACEN MODIFICADO")) {
                $('#almacenEditModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: data,
                }).then(function () {
                    $("#frmAlmacen")[0].reset();
                    tablex.ajax.reload(null, false);
                    //location.reload();
                });
            } else {
                $('#almacenEditModal').modal('hide');
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

ListarComboSucursal();
ListarComboSucursalEdit();
ListarAlmacen();

//************************** SERIE ****************/

function ListarSerie() {
    /* $.post('almacen/listarTablaSucursal', function (e) {            
         console.log(e);
     });*/
     tabley = $('#datosSerie').DataTable({
         "destroy":true,
         "responsive": true,
         "ajax": {
             'method': 'POST',
             'url': 'almacen/listarTablaSucursal'
         },
         "columns": [
             {
                 "data": "descripcion"
             },             
             {
                 "data": "direccion"
             },              
             {
                 "defaultContent": "<div class='d-flex'><button type='button' class='add btn btn-info btn-xs'><i class='fas fa-hand-pointer'></i></button><button type='button' class='ver ml-2  btn btn-danger btn-xs'><i class='fas fa-binoculars'></i></button></div>"
             }
         ],
         "language":idioma
     });
     odtenerDatosSerie('#datosSerie tbody', tabley);
     viewDatosSucursal('#datosSerie tbody', tabley);
}

function odtenerDatosSerie(tbody, table) {
    $(tbody).on('click', 'button.add', function () {
        var data = table.row($(this).parents('tr')).data();           
        $('#txtidsucurser').val(data.codigo);            
        $('#txttitulo').text(data.descripcion);       
    });
}

function viewDatosSucursal(tbody, table) {
    $(tbody).on('click', 'button.ver', function () {
        var data = table.row($(this).parents('tr')).data();           
        var cd = data.codigo;
        $('#txttituloserie').text(data.descripcion);
        $.post('almacen/listarTablaSeries',{'codigo':cd}, function (e) {            
           $('#tablaSeries').html(e);
        },);           
        $('#seriesModal').modal('show');       
    });
}

function ListarComboComprobante() {
    $.post('almacen/listarComboComprobante', function (e) {
        $('#cmbtipocomprobante').html(e);
    });
}

$("#formSerie").on('submit', function (e) {
    e.preventDefault();        
    $.ajax({
        type: 'POST',
        url: 'almacen/insertarSerie/',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (msg) {
            console.log(msg);
            let data = JSON.parse(msg);
            console.log(data);
            if (data.includes("SERIE REGISTRADA")) {               
                Swal.fire({
                    icon: 'success',
                    title: data,
                }).then(function () {
                    $('.nc-one').addClass('d-none');
                    $("#formSerie")[0].reset();
                    tabley.ajax.reload(null, false);
                   // location.reload();
                });
            } else {               
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

window.notacd = function (e) {
    let tipo =  $('#txttipocomprobante').val();
    if (tipo === '07' || tipo === '08') {
        $('.nc-one').removeClass('d-none');
    }else{
        if (tipo === 'RC' || tipo === 'RA') {
            $('#txtserie').attr('maxlength','8');
        }else{
            $('#txtserie').attr('maxlength','4');
            $('.nc-one').addClass('d-none');
        }        
    } 
};

 ListarSerie();
 ListarComboComprobante();

 window.eliminarSerieCodido = function(cod_detalle,cod_serie){
    $.post('almacen/eliminarSerieCodido',{'codigo_d':cod_detalle,'codigo_s':cod_serie}, function (e) {
        $('#seriesModal').modal('hide'); 
        if (e.includes("SERIE ELIMINADA")) {               
            Swal.fire({
                icon: 'success',
                title: e,
            }).then(function () {                
                tabley.ajax.reload(null, false);
               // location.reload();
            });
        } else { 
            if(e.includes("ERORR DEL SISTEMASQLSTATE[45000]")){
                Swal.fire({
                    icon: 'error',
                    title: 'Serie Tiene Ventas Registradas, No se puede eliminar',
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
    },'JSON');
 }
})(jQuery);
  