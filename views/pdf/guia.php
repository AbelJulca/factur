<?php
// (c) Xavier Nicolay
// Exemple de devis/facture PDF
use Luecano\NumeroALetras\NumeroALetras;

$formatter = new NumeroALetras();
$pdf = new PDF_Invoice_guia( 'P', 'mm', 'A4' );
$pdf->AddPage();


if($this->guia['idtipocomp'] == '09')
{
    $pdf->addSociete(utf8_decode($this->empresa['descripcion']),utf8_decode($this->empresa['direccion']));
    $pdf->fact_dev( 'GUIA REMISIÓN','ELECTRÓNICA - REMITENTE',$this->guia['serie'].' - '.$this->guia['correlativo'],$this->empresa['ruc']);
    $pdf->addRazonSocial(" CLIENTE DESTINO:",$this->guia['razon_social']);
    $pdf->addRucCliente($this->guia['documento'],"RUC CLIENTE");
    $pdf->addpeso($this->guia['peso']);
    $pdf->addvehiculo('Nro Placa: '.$this->guia['placa']);
    $pdf->addconductor('Nro Dni: '.$this->guia['dni_chofer']);       
    $fecha_venc = $this->guia['fecha_envio'];
    $fecha_reg = $this->guia['fecha_emision'];

    $pdf->addHora($this->guia['hora']); 
    $pdf->addglosa(utf8_decode($this->guia['motivo']));
    $pdf->addmodotransporte(utf8_decode($this->guia['transporte']));
    $pdf->adddireccionpartida($this->guia['ubigeo_partida'].' - '.$this->guia['direccion_partida']);
    $pdf->adddireccionllegada($this->guia['ubigeo_llegada'].' - '.$this->guia['direccion_llegada']);    
}

$y = 113;

if ($this->guia['idtransporte'] == '02') {
    $pdf->addrucempresatrans($this->guia['ruc_empresa_trans']);
    $pdf->addrzempresatrans($this->guia['rz_empresa_trans']);
    $y = 133;
} 


$pdf->addfecha($fecha_reg);
$pdf->addfechaEnvio($fecha_venc);
$pdf->addpaquetes($this->guia['cant_peso']);
$pdf->SetFont( "Arial", "B", 9);
$cols=array( "ITEM"    => 16,
             "CODIGO"  => 30,
             "DESCRIPCION"     => 110,
             "UND"      => 12,
             "CANTIDAD" => 22);
$pdf->addCols($cols,$y-9);
$cols=array( "ITEM"    => "L",
             "CODIGO"  => "C",
             "DESCRIPCION" => "L",
             "UND" => "L",
             "CANTIDAD" => "C" );
$pdf->addLineFormat($cols);
$pdf->SetFont( "Arial", "", 9);




//********************COLOCAR PRODUCTOS CON UN FOREACH */

foreach ($this->detalle as $key => $value) {
    $line = array( 
        "ITEM"    => $key + 1,
        "CODIGO"       => $value['sku'],
        "DESCRIPCION"      => $value['nombre_comercial'],
        "UND"  => $value['idunidad'],
        "CANTIDAD"    => $value['cantidad']
    );
    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;
}

//****************** TERMINA EL FOREACH */
$pdf->addCadreTVAs($this->guia['hash']);

//$pdf->addTVAs($op_gravada, $op_exonerada, $op_inafecta, $icbper, $op_igv, $total,$total_letras);
//$pdf->addCadreEurosFrancs();

$pdf->Output();
?>
