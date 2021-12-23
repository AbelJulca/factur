<?php
$ini=Session::get('fechaini');
$fin=Session::get('fechafin');
$codalmacen=Session::get('idalmacen');
$nombalmacen=Session::get('almacen');
$GLOBALS['ruc']=$this->empresa['ruc'];
$codempresa=$this->empresa['codigo'];
$GLOBALS['nombre_emp']= utf8_decode($this->empresa['descripcion']);
$GLOBALS['fecha']=date("Y/m/d h:i:s a");
$GLOBALS['usuario']="USUARIO:".Session::get('nombreUser');
$GLOBALS['titulorep']='REPORTE DE MOVIMIENTOS KARDEX DEL:'.date('d/m/Y', strtotime($ini)).' AL:'.date('d/m/Y', strtotime($fin));
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',7);
        $this->Text(10,10, $GLOBALS['ruc'].' '.$GLOBALS['nombre_emp'],0,'C', 0);
        $this->Text(255,10, $GLOBALS['fecha'],0,'C', 0);
        $this->Text(255,14, $GLOBALS['usuario'],0,'C', 0);
        $this->Cell(0,10,$GLOBALS['titulorep'],0,1,'C');
    }

    function Footer()
    {
        $this->SetXY(280,-14);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,10,''.$this->PageNo(),0,0,'C');
    }
    var $widths;
    var $aligns;
    
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }
    
    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }
    
    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    
    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
    
    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}
$pdf = new PDF();
$pdf->AliasNbPages();

$pdf=new PDF('L','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial','B',6);
$pdf->Cell(0, 4, 'ALMACEN:'.$nombalmacen, 1,1);
$pdf->Ln(1);

$pdf->SetWidths(array(15,55,32,35,20,60,20,20,20));

    $html = "";$filas=""; $entra=0;$salid=0;$ultimo=0;
    $saldoinicial=0;
    
           foreach ($this->idproducto as $key => $value) {
                $valorencabezado='SI';
                $codigo = '';
                $codigo = $value['idarticulos'];               
                $html = "";$filas=""; $entra=0;$salid=0;$ultimo=0;
                $saldoinicial=0;

                $produc = array();

                foreach ($this->producto as $key => $v) {
                    if($v['idarticulo'] == $codigo){
                        $datos = array(
                            'fecha_registro' => $v['fecha_registro'],
                            'descripcion' => $v['descripcion'],
                            'tipo' => $v['tipo'],
                            'almacen' => $v['almacen'],
                            'serie_ref' => $v['serie_ref'],
                            'correlativo_ref' => $v['correlativo_ref'],
                            'observacion' => $v['observacion'],
                            'entrada' => $v['entrada'],
                            'salida' => $v['salida'],
                            'saldo' => $v['saldo']
                        );
                        array_push($produc, $datos);
                    }
                }
                foreach ($produc as $key => $value) {                  

                    if ($valorencabezado =='SI') {
                        $nombre = $value['descripcion'];
                        $ultimo=$value['saldo'];
                        $saldoinicial=($ultimo-$value['entrada'])+$value['salida'];                            
                        $pdf->Cell(217, 4,$nombre, 1,0,'L');    
                        $pdf->Cell(40, 4, 'STOCK INICIAL:', 1,0,'R'); 
                        $pdf->Cell(20, 4, $saldoinicial, 1,1,'C');            
                        $pdf->Cell(15, 4, 'FECHA', 1,0);
                        $pdf->Cell(55, 4, 'TIPO', 1,0);
                        $pdf->Cell(32, 4, 'ALMACEN REF.', 1,0);
                        $pdf->Cell(35, 4, 'DOCUMENTO', 1,0);
                        $pdf->Cell(20, 4, 'NUMERO', 1,0);
                        $pdf->Cell(60, 4, 'OBSERVACION', 1,0);
                        $pdf->Cell(20, 4, 'ENTRADA', 1,0);
                        $pdf->Cell(20, 4, 'SALIDA', 1,0);
                        $pdf->Cell(20, 4, 'SALDO', 1,1);
                        $pdf->SetFont('Arial','',6);
                        $pdf->Row(array(date('d/m/Y', strtotime($value['fecha_registro'])),$value['tipo'],$value['almacen'],$value['serie_ref'],
                        $value['correlativo_ref'],$value['observacion'],$value['entrada'],$value['salida'],$value['saldo']));        
                        $valorencabezado='NO';
                    }
                    else {                        
                        $pdf->SetFont('Arial','',6);
                        $pdf->Row(array(date('d/m/Y', strtotime($value['fecha_registro'])),$value['tipo'],$value['almacen'],$value['serie_ref'],
                        $value['correlativo_ref'],$value['observacion'],$value['entrada'],$value['salida'],$value['saldo']));
                        $ultimo=$value['saldo'];
                        $entra=($entra+$value['entrada']);
                        $salid=($salid+$value['salida']);    
                    } 
                } 
                $pdf->SetFont('Arial','B',6);
                $pdf->Cell(257, 4, 'STOCK ACTUAL:', 1,0,'R'); 
                $pdf->Cell(20, 4, $ultimo, 1,1,'C');
                $pdf->Ln(2);
                $produc = ''; 
           }       

$pdf->Output();
?>