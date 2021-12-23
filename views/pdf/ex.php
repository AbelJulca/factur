<?php
// (c) Xavier Nicolay
// Exemple de devis/facture PDF
use Luecano\NumeroALetras\NumeroALetras;

$formatter = new NumeroALetras();
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();


$fecha_emi = '';
$fecha_reg = '';

if($this->venta['idtipocomp'] == '03')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev('BOLETA ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc'] );
    $pdf->addRazonSocial(" CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"DNI CLIENTE");
    $pdf->addCondicionPago($this->venta['formapago']);
    $fecha_venc = $this->venta['fecha_vencimiento'];
    $fecha_reg = $this->venta['fecha_emision'];
    $pdf->addHora( $this->venta['hora']);
    $pdf->addDireccion($this->venta['direccion']);
}

if($this->venta['idtipocomp'] == '01')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev('FACTURA ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc'] );
    $pdf->addRazonSocial(" CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"RUC CLIENTE");
    $pdf->addCondicionPago($this->venta['formapago']);   
    $fecha_venc = $this->venta['fecha_vencimiento'];
    $fecha_reg = $this->venta['fecha_emision'];
    $pdf->addHora( $this->venta['hora']);
    $pdf->addDireccion($this->venta['direccion']);
}

if($this->venta['idtipocomp'] == '04')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev('TICKET ELECTRÓNICO', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc'] );
    $pdf->addRazonSocial(" CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"DNI CLIENTE");
    $pdf->addCondicionPago($this->venta['formapago']);
    $fecha_venc = $this->venta['fecha_vencimiento'];
    $fecha_reg = $this->venta['fecha_emision'];
    $pdf->addHora( $this->venta['hora']);
    $pdf->addDireccion($this->venta['direccion']);
}

if($this->venta['idtipocomp'] == '05')
{
    $pdf->addSociete(utf8_decode($this->venta['empresa']),utf8_decode($this->venta['direccion_empresa']));
    $pdf->fact_dev( 'ORDEN COMPRA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->venta['ruc'] );
    $pdf->addRazonSocial(" PROVEEDOR:",$this->venta['proveedor']);
    $pdf->addRucCliente($this->venta['nrodoc'],"RUC PROVEEDOR");
    $pdf->addCondicionPago("Proceso");
    $porciones = explode(" ", $this->venta['fecha']);
    $fecha_reg = $porciones[0]; // porción1
    $fecha_venc = $porciones[0]; // porción1
    $hora = $porciones[1].' '; // porción2

    $pdf->addHora($hora);
    $pdf->addDireccion($this->venta['direccion_proveedor']);
}

if($this->venta['idtipocomp'] == '10')
{
    $pdf->addSociete(utf8_decode($this->venta['empresa']),utf8_decode($this->venta['direccion_empresa']));
    $pdf->fact_dev( 'COMPRA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->venta['ruc'] );
    $pdf->addRazonSocial(" PROVEEDOR:",$this->venta['proveedor']);
    $pdf->addRucCliente($this->venta['nrodoc'],"RUC PROVEEDOR");
    $pdf->addCondicionPago($this->venta['formapago']);

    $porciones = explode(" ", $this->venta['fecha_registro']);
    $fecha_venc = $this->venta['fecha_vencimiento']; // porción1
    
    $hora = $porciones[1].' '; // porción2

    $porc = explode(" ", $this->venta['fecha_registro']);
    $fecha_reg = $porc[0]; // porción1

    $pdf->addHora($hora); 
    $pdf->addglosa($this->venta['glosa']);
    $pdf->addDireccion($this->venta['direccion_proveedor']);    
}

if($this->venta['idtipocomp'] == '07')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev( 'NOTA CREDITO ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc']);
    $pdf->addRazonSocial(" CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"RUC CLIENTE");
    $pdf->addCondicionPago($this->venta['formapago']);   
    $fecha_venc = $this->venta['fecha_vencimiento'];
    $fecha_reg = $this->venta['fecha_emision'];

    $pdf->addHora($this->venta['hora']); 
    $pdf->addglosa(utf8_decode($this->movito['descripcion']));
    $pdf->addDireccion($this->venta['direccion']);    
}

if($this->venta['idtipocomp'] == '08')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev( 'NOTA DEBITO ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc']);
    $pdf->addRazonSocial(" CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"RUC CLIENTE");
    $pdf->addCondicionPago($this->venta['formapago']);   
    $fecha_venc = $this->venta['fecha_vencimiento'];
    $fecha_reg = $this->venta['fecha_emision'];

    $pdf->addHora($this->venta['hora']); 
    $pdf->addglosa(utf8_decode($this->movito['descripcion']));
    $pdf->addDireccion($this->venta['direccion']);    
}

$pdf->addfecha($fecha_reg);
$pdf->addfechaVencimiento($fecha_venc);
$pdf->addMoneda($this->venta['idmoneda']);
$pdf->SetFont( "Arial", "B", 9);
$cols=array( "CODIGO"    => 29,
             "UND"  => 12,
             "CANT"     => 15,
             "PRODUCTO"      => 85,
             "PRECIO" => 30,
             "SUBTOTAL"          => 19 );
$pdf->addCols($cols);
$cols=array( "CODIGO"    => "L",
             "UND"  => "C",
             "CANT" => "C",
             "PRODUCTO" => "L",
             "PRECIO" => "R",
             "SUBTOTAL" => "C" );
$pdf->addLineFormat($cols);
$pdf->SetFont( "Arial", "", 9);

$y    = 95;
//********************COLOCAR PRODUCTOS CON UN FOREACH */

foreach ($this->detalle as $key => $value) {
    $line = array( 
        "CODIGO"    => $value['sku'],
        "UND"       => $value['idunidad'],
        "CANT"      => $value['cantidad'],
        "PRODUCTO"  => $value['nombre_comercial'],
        "PRECIO"    => $value['precio_unitario'],
        "SUBTOTAL"  => $value['importe_total']
    );
    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;
}

/*$line = array( "CODIGO"    => "REF1",
               "UND"  => "NIU",
               "CANT"     => "1",
               "PRODUCTO"      => "600.00",
               "PRECIO" => "600.00",
               "SUBTOTAL"          => "1" );
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

$line = array( "CODIGO"    => "REF2",
               "UND"  => "NIU",
               "CANT"     => "1",
               "PRODUCTO"      => "10.00",
               "PRECIO" => "60.00",
               "SUBTOTAL"          => "1" );
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;*/

//****************** TERMINA EL FOREACH */
$pdf->addCadreTVAs();

$op_gravada = $this->venta['op_gravadas'];
$op_exonerada = $this->venta['op_exoneradas'];
$op_inafecta  = $this->venta['op_inafectas'];
$icbper  = $this->venta['op_icbper'];
$op_igv  = $this->venta['igv'];
$total  = $this->venta['total'];
$total = number_format($total, 2, '.', '') ;
$total_letras = utf8_decode($formatter->toInvoice($total, 2, 'soles'));

$pdf->addTVAs($op_gravada, $op_exonerada, $op_inafecta, $icbper, $op_igv, $total,$total_letras);
$pdf->addCadreEurosFrancs();

if($this->venta['idtipocomp'] == '01'){
    $ruc = $this->empresa['ruc'];
    $tipo_documento = $this->venta['idtipocomp'];
    $serie = $this->venta['serie'];
    $correlativo = $this->venta['correlativo'];
    $igv = $this->venta['igv'];
    $total = $this->venta['total'];
    $fecha = $this->venta['fecha_emision'];
    $tipo_doc_cliente = $this->venta['iddocumento'];
    $nro_doc_cliente = $this->venta['nrodoc'];

    $nombrexml = $ruc . '-' . $tipo_documento . '-' . $serie . '-' . $correlativo;
    $texto_qr = $ruc . '|' . $tipo_documento . '|' . $serie . '|' . $correlativo . '|' . $igv . '|' . $total . '|' . $fecha . '|' . $tipo_doc_cliente . '| ' . $nro_doc_cliente . '|';

    $ruta_qr = 'qr/factura/' . $nombrexml . '.png';

    QRcode::png($texto_qr, $ruta_qr, 'Q', 15, 0); //crear la imagen del codigo QR
    $pdf->qrView($ruta_qr);
}

if($this->venta['idtipocomp'] == '03'){
    $ruc = $this->empresa['ruc'];
    $tipo_documento = $this->venta['idtipocomp'];
    $serie = $this->venta['serie'];
    $correlativo = $this->venta['correlativo'];
    $igv = $this->venta['igv'];
    $total = $this->venta['total'];
    $fecha = $this->venta['fecha_emision'];
    $tipo_doc_cliente = $this->venta['iddocumento'];
    $nro_doc_cliente = $this->venta['nrodoc'];

    $nombrexml = $ruc . '-' . $tipo_documento . '-' . $serie . '-' . $correlativo;
    $texto_qr = $ruc . '|' . $tipo_documento . '|' . $serie . '|' . $correlativo . '|' . $igv . '|' . $total . '|' . $fecha . '|' . $tipo_doc_cliente . '| ' . $nro_doc_cliente . '|';

    $ruta_qr = 'qr/boleta/' . $nombrexml . '.png';

    QRcode::png($texto_qr, $ruta_qr, 'Q', 15, 0); //crear la imagen del codigo QR
    $pdf->qrView($ruta_qr);
}

if($this->venta['idtipocomp'] == '07'){
    $ruc = $this->empresa['ruc'];
    $tipo_documento = $this->venta['idtipocomp'];
    $serie = $this->venta['serie'];
    $correlativo = $this->venta['correlativo'];
    $igv = $this->venta['igv'];
    $total = $this->venta['total'];
    $fecha = $this->venta['fecha_emision'];
    $tipo_doc_cliente = $this->venta['iddocumento'];
    $nro_doc_cliente = $this->venta['nrodoc'];

    $nombrexml = $ruc . '-' . $tipo_documento . '-' . $serie . '-' . $correlativo;
    $texto_qr = $ruc . '|' . $tipo_documento . '|' . $serie . '|' . $correlativo . '|' . $igv . '|' . $total . '|' . $fecha . '|' . $tipo_doc_cliente . '| ' . $nro_doc_cliente . '|';

    $ruta_qr = 'qr/nc/' . $nombrexml . '.png';

    QRcode::png($texto_qr, $ruta_qr, 'Q', 15, 0); //crear la imagen del codigo QR
    $pdf->qrView($ruta_qr);
}

if($this->venta['idtipocomp'] == '08'){
    $ruc = $this->empresa['ruc'];
    $tipo_documento = $this->venta['idtipocomp'];
    $serie = $this->venta['serie'];
    $correlativo = $this->venta['correlativo'];
    $igv = $this->venta['igv'];
    $total = $this->venta['total'];
    $fecha = $this->venta['fecha_emision'];
    $tipo_doc_cliente = $this->venta['iddocumento'];
    $nro_doc_cliente = $this->venta['nrodoc'];

    $nombrexml = $ruc . '-' . $tipo_documento . '-' . $serie . '-' . $correlativo;
    $texto_qr = $ruc . '|' . $tipo_documento . '|' . $serie . '|' . $correlativo . '|' . $igv . '|' . $total . '|' . $fecha . '|' . $tipo_doc_cliente . '| ' . $nro_doc_cliente . '|';

    $ruta_qr = 'qr/nd/' . $nombrexml . '.png';

    QRcode::png($texto_qr, $ruta_qr, 'Q', 15, 0); //crear la imagen del codigo QR
    $pdf->qrView($ruta_qr);
}

$pdf->Output();
?>
