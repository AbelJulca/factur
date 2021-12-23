$(function () {
    $('#txtBuscarProducto').keyup(function (e) {
        e.preventDefault();
        var nombre = $('#txtBuscarProducto').val();
        if(nombre.length < 5){
            $('#tablaProducto').html('');
        }else{
        $.post('reportekardex/ListarProductosNombre', {'nombre': nombre}, function (e) {
            $('#tablaProducto').html(e);
        });  
        }        
    });

    window.AgregarCarrito = function (cod,nombre) {
        $('#idproduc').val(cod);
        $('#txtnombreproducto').val(nombre);
        $('#tablaProducto').html('');               
    };

    $("#btn-pdf-one").on('click', function (e)
    {        
        let codigo = $('#idproduc').val();
        let fechaini = $('#txtfechainicio').val();
        let fechafin = $('#txtfechafin').val();
        if(codigo !== '' && fechaini !== '' && fechafin !== ''){
            $("#btn-pdf-one").attr('disabled','true');
            $.post('reportekardex/pdfKardexInd',{'codigo':codigo,'fechaini':fechaini,'fechafin':fechafin},function (e) {
                $("#btn-pdf-one").removeAttr('disabled');           
                window.open('reportekardex/pdfKardexInd', '_blank');
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'INGRESE DATOS',
            }).then(function () {
                $("#txtfechainicio").focus();
            });
            $("#txtfechainicio").focus();
        }                
    });

    $("#btn-excel-one").on('click', function (e)
    {        
        let codigo = $('#idproduc').val();
        let nombre = $('#txtnombreproducto').val();
        let fechaini = $('#txtfechainicio').val();
        let fechafin = $('#txtfechafin').val();
        if(codigo !== '' && fechaini !== '' && fechafin !== ''){
            $("#btn-excel-one").attr('disabled','true');
            $.post('reportekardex/excelKardexInd',{'codigo':codigo,'fechaini':fechaini,'fechafin':fechafin,'nombre':nombre},function (e) { 
                $("#btn-excel-one").removeAttr('disabled');           
                window.open('reportekardex/excelKardexInd', '_blank');
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'INGRESE DATOS',
            }).then(function () {
                $("#txtfechainicio").focus();
            });
            $("#txtfechainicio").focus();
        }                
    });


    $("#btn-pdf-gnr").on('click', function (e)
    {   
        let fechaini = $('#txtfechainiciognd').val();
        let fechafin = $('#txtfechafingnd').val();
        if(fechaini !== '' && fechafin !== ''){
            $.post('reportekardex/pdfKardexGnd',{'fechaini':fechaini,'fechafin':fechafin},function (e) {           
                window.open('reportekardex/pdfKardexGnd', '_blank');
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'INGRESE DATOS',
            }).then(function () {
                
            });
        }                
    });

    function imprimirPDF (codigo) {
        $.post('comprobante/pdf',{'codigo':codigo},function (e) {           
           window.open('comprobante/pdf', '_blank');
        });               
    };

});