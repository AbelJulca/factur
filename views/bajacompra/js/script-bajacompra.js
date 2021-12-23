$(function () {

    var tabla;   

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

    function ListarComboProveedor() {
        $.post('consultacompras/listarTablaProveedor', function (e) {
            $('#cmbproveedor').html(e);
            $('.select2').select2();
        });
    }

    function ListarComboPeriodo() {
        $.post('consultacompras/ListarComboPeriodo', function (e) {
            $('#cmbperiodo').html(e);
            validarPeriodo();
        });
    }

    function validarPeriodo() {
        $.post('compras/validarPeriodo', function (e) {            
            $('#txtperiodo').val(e.codigo);
            ListarTablaPeriodo(e.codigo)
            Toggle();         
        },'JSON');
    }

    window.listarPeriodo = function () {
        var idperiodo = $('#txtperiodo').val();
        $('#txtproveedor').val('0');

        var tex = document.getElementById('txtproveedor');            
        var long =tex.options[tex.selectedIndex].text;
        $('#select2-txtproveedor-container').text(long);
        $('#select2-txtproveedor-container').attr("title",long); 
        ListarTablaPeriodo(idperiodo);
        Toggle(); 
    }

    window.listarProveedor = function () {
        var idperiodo = $('#txtperiodo').val();
        var idproveedor = $('#txtproveedor').val();
        if(idproveedor !== '0'){
            ListarTablaProveedor(idperiodo,idproveedor);
            Toggle();
        }else{
            listarPeriodo();
        } 
    }

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/" +
        (currentdate.getMonth() + 1) + "/" +
        currentdate.getFullYear() + "_H" + "_" +
        currentdate.getHours() + ":" +
        currentdate.getMinutes() + ":" +
        currentdate.getSeconds();

    function ListarTablaPeriodo(periodo) {
        table = $('#datosConsulta').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'bajacompra/listarComprasPeriodo',
                'data' : { 'periodo' : periodo },
            },
            "columns": [{
                "data": "serie"
            },
            {
                "data": "proveedor"
            },
            {
                "data": "fecha_emision"
            },
            {
                "data": "fecha_vencimiento"
            },
            {
                "data": "glosa"
            },
            {
                "data": "total"
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
                    title: 'REPORTE_COMPRA' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_COMPRA' + '_' + datetime,
                    orientation: 'landscape',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        }); 
        
        odtenerDatosProducto('#datosConsulta tbody');
    }

    function odtenerDatosProducto(tbody) {
        $(tbody).on('click', 'button.ver', function () {
            var codigo =$(this).data('compraid');
            //console.log(codigo);
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
                    eliminarCompra(codigo);
                }
            })
        });
    }

    function eliminarCompra(codigo) {
        $.post('bajacompra/eliminarCompra',{'codigo':codigo}, function (e) {  
            if (e.includes('COMPRA DADA')) {
                Swal.fire(
                    'Eliminado!',
                    e,
                    'success'
                )
                listarProveedor();
            } else {
                Swal.fire(
                    'PROBLEMA!',
                    e,
                    'error'
                ) 
            }       
        },'JSON');
    }

    function ListarTablaProveedor(idperiodo,idproveedor) {
        table = $('#datosConsulta').DataTable({
            "destroy": true,
            "responsive": true,
            "ajax": {
                'method': 'POST',
                'url': 'bajacompra/listarComprasProveedor',
                'data' : { 'periodo' : idperiodo,'proveedor' : idproveedor },
            },
            "columns": [{
                "data": "serie"
            },
            {
                "data": "proveedor"
            },
            {
                "data": "fecha_emision"
            },
            {
                "data": "fecha_vencimiento"
            },
            {
                "data": "glosa"
            },
            {
                "data": "total"
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
                    title: 'REPORTE_COMPRA' + '_' + datetime,
                    text: '<i class="far fa-file-excel"></i>',
                    attr: {
                        'title': 'Exportar a Excel',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-success'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                    excelStyles: { // Add an excelStyles definition
                        template: "blue_medium" // Apply the 'blue_medium' template
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'REPORTE_COMPRA' + '_' + datetime,
                    orientation: 'landscape',
                    text: '<i class="far fa-file-pdf"></i>',
                    attr: {
                        'title': 'Exportar a PDF',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'class': 'btn btn-danger'
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        }); 
        
        odtenerDatosProducto('#datosConsulta tbody');
    }

    window.imprimirPDF = function (codigo) {
        $.post('compras/pdf',{'codigo':codigo},function (e) {           
           window.open('compras/pdf', '_blank');
        });               
    };

    ListarComboProveedor();
    ListarComboPeriodo();
 

    function Toggle() {
        $('[data-toggle="tooltip"]').tooltip();
    }
    
});