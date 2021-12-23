$(function () {
    var table,tablex;

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

    $("#btnAddejercicio").on('click', function (e) {
        $("#ejercicioModal").modal('show');
    });

    window.soloNumeros = function (e) {
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

    function ListarPeriodo() 
    {

        table = $('#datosPeriodos').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'periodo/listarTablaPeriodo'
            },
            "columns": [
                {
                    "data": "descripcion"
                },
                {
                    "data": "f_inicio"
                },
                {
                    "data": "f_fin"
                },
                {
                    "data": "estado"
                }
            ],
            "language": idioma,
            "dom": 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1],
                ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
            ],
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
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange',
                    exportOptions: {
                        columns: ':visible'
                    }

                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_PERIODO' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_PERIODO' + '_' + datetime,
                    orientation: 'portrait',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    }
                }
            ]
        });
        //odtenerDatosProveedor('#datosProveedor tbody', table);
        //eliminarDatosProveedor('#datosProveedor tbody', table);
    }

    function ListarEjercicio() 
    {
        $.post('periodo/listarTablaEjercicio', function (e) {            
            console.log(e);
        });
        tablex = $('#datosEjercicios').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'periodo/listarTablaEjercicio'
            },
            "columns": [
                {
                    "data": "descripcion"
                },
                {
                    "data": "actual"
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
            lengthMenu: [
                [ 10, 25, 50, -1],
                ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
            ],
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
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: 'REPORTE_EJERCICIO' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_EJERCICIO' + '_' + datetime,
                    orientation: 'portrait',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }
            ]
        });
        odtenerDatosEjercicio('#datosEjercicios tbody', tablex);
        //eliminarDatosProveedor('#datosProveedor tbody', table);
    }

    function  odtenerDatosEjercicio(tbody, table) {
        $(tbody).on('click', 'button.editar', function () {
            //var data = table.row($(this).parents('tr')).data();

            var codigo =$(this).data('periodoid');   
            $.post('periodo/listarEjercicioCodigo',{'id':codigo},function (e) {           
                $('#txtidejercicio').val(e.codigo);            
                $('#txtdesccripcionEdit').val(e.descripcion);
                $('#txtyearEdit').val(e.actual);
                if(e.check == '1'){
                    $('#customSwitchesEdit').attr("checked",true);
                }else{
                    $('#customSwitchesEdit').attr("checked",false);
                }
                $('#ejercicioEditModal').modal('show');
             },'JSON'); 
        });
    }

    $("#frmEjercicio").on('submit', function (e) {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'periodo/insertarEjercicio/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("EJERCICIO REGISTRADO")) {
                    $('#ejercicioModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmEjercicio")[0].reset();
                        tablex.ajax.reload(null, false);
                        table.ajax.reload(null, false);
                    });
                    
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#ejercicioModal').modal('hide');
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
    $("#frmEjercicioEdit").on('submit', function (e) {
        e.preventDefault();        
        $.ajax({
            type: 'POST',
            url: 'periodo/actualizarEjercicio/',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (msg) {
                console.log(msg);
                let data = JSON.parse(msg);
                console.log(data);
                if (data.includes("EJERCICIO MODIFICADO")) {
                    $('#ejercicioEditModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data,
                    }).then(function () {
                        $("#frmEjercicioEdit")[0].reset();
                        tablex.ajax.reload(null, false);
                    });
                    
                    //LimpiarEmpresa();
                    // table.ajax.reload(null, false);
                } else {
                    $('#ejercicioEditModal').modal('hide');
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

    ListarPeriodo();
    ListarEjercicio();
    
    //setTimeout(function(){ ListarEjercicio(); }, 1000);
});