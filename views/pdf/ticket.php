<?php
// (c) Xavier Nicolay
// Exemple de devis/facture PDF
use Luecano\NumeroALetras\NumeroALetras;

$formatter = new NumeroALetras();
$pdf = new PDF_Invo( 'P', 'mm', array(80, 350) );
$pdf->AddPage();

if($this->venta['idtipocomp'] == '05')
{
    $pdf->addSociete(utf8_decode($this->venta['empresa']),utf8_decode($this->venta['direccion_empresa']));
    $pdf->fact_dev( 'ORDEN COMPRA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->venta['ruc'] );
    $pdf->addRazonSocial("PROVEEDOR:",$this->venta['proveedor']);
    $pdf->addRucCliente($this->venta['nrodoc'],"RUC:");
    $pdf->addDireccion($this->venta['direccion_proveedor']);
    $porciones = explode(" ", $this->venta['fecha']);
    $fechaventa = $porciones[0]; // porción1
    $hora = $porciones[1].' '; // porción2
    $pdf->addHora($hora);
}

if($this->venta['idtipocomp'] == '03')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev('BOLETA ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc'] );
    $pdf->addRazonSocial("CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"DNI:");
    $pdf->addCondicionPago($this->venta['formapago']);
    $fechaventa = $this->venta['fecha_emision'];
    $pdf->addHora( $this->venta['hora']);
    $pdf->addDireccion($this->venta['direccion']);
}

if($this->venta['idtipocomp'] == '01')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev('FACTURA ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc'] );
    $pdf->addRazonSocial("CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"RUC:");
    $pdf->addCondicionPago($this->venta['formapago']);
    $fechaventa = $this->venta['fecha_emision'];
    $pdf->addHora( $this->venta['hora']);
    $pdf->addDireccion($this->venta['direccion']);
}

if($this->venta['idtipocomp'] == '04')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev('TICKET ELECTRÓNICO', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc'] );
    $pdf->addRazonSocial("CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"DNI:");
    $pdf->addCondicionPago($this->venta['formapago']);
    $fechaventa = $this->venta['fecha_emision'];
    $pdf->addHora( $this->venta['hora']);
    $pdf->addDireccion($this->venta['direccion']);
}

if($this->venta['idtipocomp'] == '07')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev( 'NOTA CREDITO ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc']);
    $pdf->addRazonSocial(" CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"NRO:");
    $pdf->addCondicionPago($this->venta['formapago']); 
    $fechaventa = $this->venta['fecha_emision'];
    $pdf->addHora($this->venta['hora']); 
    $pdf->addDireccion($this->venta['direccion']);    
}

if($this->venta['idtipocomp'] == '08')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev( 'NOTA DEBITO ELECTRÓNICA', $this->venta['serie'].' - '.$this->venta['correlativo'],$this->empresa['ruc']);
    $pdf->addRazonSocial(" CLIENTE:",$this->venta['razon_social']);
    $pdf->addRucCliente($this->venta['nrodoc'],"NRO:");
    $pdf->addCondicionPago($this->venta['formapago']);
    $fechaventa = $this->venta['fecha_emision'];
    $pdf->addHora($this->venta['hora']); 
    $pdf->addDireccion($this->venta['direccion']);    
}

$pdf->addfecha($fechaventa);
$pdf->SetFont( "Arial", "B", 6);
$cols=array( "PRODUCTO"    => 35,
             "UND"  => 9,
             "CANT"     => 9,
             "P.U" => 9,
             "SUBTOT"          => 16 );
$pdf->addCols($cols);
$cols=array( "PRODUCTO"    => "L",
             "UND"  => "C",
             "CANT" => "C",
             "P.U" => "R",
             "SUBTOT" => "C" );
$pdf->addLineFormat($cols);
$pdf->SetFont( "Arial", "", 6);
$y    = 93;

foreach ($this->detalle as $key => $value) {
    $line = array( 
        "PRODUCTO"  => $value['nombre_comercial'],
        "UND"       => $value['idunidad'],
        "CANT"      => $value['cantidad'],        
        "P.U"    => $value['precio_unitario'],
        "SUBTOT"  => $value['importe_total']
    );
    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;
}

$pos = $pdf->GetY();

$pdf->addCadreTVAs($pos+10);

$op_gravada = $this->venta['op_gravadas'];
$op_exonerada = $this->venta['op_exoneradas'];
$op_inafecta  = $this->venta['op_inafectas'];
$icbper  = $this->venta['op_icbper'];
$op_igv  = $this->venta['igv'];
$total  = $this->venta['total'];
$total = number_format($total, 2, '.', '') ;
$total_letras = $formatter->toInvoice($total, 2, 'soles');

$pdf->addTVAs($op_gravada, $op_exonerada, $op_inafecta, $icbper, $op_igv, $total,$total_letras,$pos+10);
//$pdf->addCadreEurosFrancs();


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