<?php

// Xavier Nicolay 2004
// Version 1.02

//////////////////////////////////////
// Public functions                 //
//////////////////////////////////////
//  function sizeOfText( $texte, $larg )
//  function addSociete( $nom, $adresse )
//  function fact_dev( $libelle, $num )
//  function addDevis( $numdev )
//  function addFacture( $numfact )
//  function addDate( $date )
//  function addClient( $ref )
//  function addPageNumber( $page )
//  function addClientAdresse( $adresse )
//  function addReglement( $mode )
//  function addEcheance( $date )
//  function addNumTVA($tva)
//  function addReference($ref)
//  function addCols( $tab )
//  function addLineFormat( $tab )
//  function lineVert( $tab )
//  function addLine( $ligne, $tab )
//  function addRemarque($remarque)
//  function addCadreTVAs()
//  function addCadreEurosFrancs()
//  function addTVAs( $params, $tab_tva, $invoice )
//  function temporaire( $texte )


class PDF_Invoice extends FPDF
{
// private variables
var $colonnes;
var $format;
var $angle=0;
private $formatter;



// private functions
function RoundedRect($x, $y, $w, $h, $r, $style = '')
{
	$k = $this->k;
	$hp = $this->h;
	if($style=='F')
		$op='f';
	elseif($style=='FD' || $style=='DF')
		$op='B';
	else
		$op='S';
	$MyArc = 4/3 * (sqrt(2) - 1);
	$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
	$xc = $x+$w-$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

	$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
	$xc = $x+$w-$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
	$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
	$xc = $x+$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
	$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
	$xc = $x+$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
	$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
	$this->_out($op);
}

function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
	$h = $this->h;
	$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
						$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}

function Rotate($angle, $x=-1, $y=-1)
{
	if($x==-1)
		$x=$this->x;
	if($y==-1)
		$y=$this->y;
	if($this->angle!=0)
		$this->_out('Q');
	$this->angle=$angle;
	if($angle!=0)
	{
		$angle*=M_PI/180;
		$c=cos($angle);
		$s=sin($angle);
		$cx=$x*$this->k;
		$cy=($this->h-$y)*$this->k;
		$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	}
}

function _endpage()
{
	if($this->angle!=0)
	{
		$this->angle=0;
		$this->_out('Q');
	}
	parent::_endpage();
}

// public functions
function sizeOfText( $texte, $largeur )
{
	$index    = 0;
	$nb_lines = 0;
	$loop     = TRUE;
	while ( $loop )
	{
		$pos = strpos($texte, "\n");
		if (!$pos)
		{
			$loop  = FALSE;
			$ligne = $texte;
		}
		else
		{
			$ligne  = substr( $texte, $index, $pos);
			$texte = substr( $texte, $pos+1 );
		}
		$length = floor( $this->GetStringWidth( $ligne ) );
		$res = 1 + floor( $length / $largeur) ;
		$nb_lines += $res;
	}
	return $nb_lines;
}

// Company
function addSociete( $nom, $adresse )
{
	$x1 = 42;
	$y1 = 8;
	//Positionnement en bas
	$this->SetXY( $x1, $y1 );
	$this->SetFont('Arial','B',12);
	$length = $this->GetStringWidth( $nom );
	$this->Image(URL . 'public/images/logo_datacix.png', 10, 6, 30, 25);
	$this->Cell( $length, 2, $nom);
	$this->SetXY( $x1, $y1 + 5 );
	$this->SetFont('Arial','',8);
	$length = $this->GetStringWidth( $adresse );
	//Coordonn�es de la soci�t�
	$lignes = $this->sizeOfText( $adresse, $length) ;
	$this->MultiCell(($length+3/1.5)+$y1, 4, $adresse);
}

// Label and number of invoice/estimate
function fact_dev( $libelle, $num,$ruc)
{
    $r1  = $this->w - 77;
    $r2  = $r1 + 68;
    $y1  = 6;
    $y2  = $y1 + 20;
    $mid = ($r1 + $r2 ) / 2;
    
    $texte  = utf8_decode($libelle);    
    $szfont = 12;
    $loop   = 0;
    
    while ( $loop == 0 )
    {
       $this->SetFont( "Arial", "B", $szfont );
       $sz = $this->GetStringWidth( $texte );
       if ( ($r1+$sz) > $r2 )
          $szfont --;
       else
          $loop ++;
    }

    $this->SetLineWidth(0.1);
    $this->SetFillColor(192);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
	$this->SetXY( $r1+1, $y1+2);
    $this->Cell($r2-$r1 -1,5,$ruc, 0, 1, "C" );	
    $this->SetXY( $r1, $y1+9 );
    $this->Cell($r2-$r1 -1,5,$texte, 0, 0, "C" );
	$this->SetXY( $r1, $y1+18);
    $this->Cell($r2-$r1 -1,5, $num, 0, 0, "C" );
}

// Estimate
function addDevis( $numdev )
{
	$string = sprintf("DEV%04d",$numdev);
	$this->fact_dev( "Devis", $string );
}

// Invoice
function addFacture( $numfact )
{
	$string = sprintf("FA%04d",$numfact);
	$this->fact_dev( "Facture", $string );
}

function addDate( $date )
{
	$r1  = $this->w - 61;
	$r2  = $r1 + 30;
	$y1  = 17;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "Arial", "B", 10);
	$this->Cell(10,5, "DATE", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5,$date, 0,0, "C");
}

function addClient( $ref )
{
	$r1  = $this->w - 31;
	$r2  = $r1 + 19;
	$y1  = 17;
	$y2  = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "Arial", "B", 10);
	$this->Cell(10,5, "CLIENT", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5,$ref, 0,0, "C");
}

function addPageNumber( $page )
{
	$r1  = $this->w - 80;
	$r2  = $r1 + 19;
	$y1  = 17;
	$y2  = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "Arial", "B", 10);
	$this->Cell(10,5, "PAGE", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(10,5,$page, 0,0, "C");
}

// Client address
function addRazonSocial($documento, $adresse )
{
	$r1     = 10;
	$r2     = $r1 + 133;
	$y1     = 35;
	$y2     = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), 15, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),5,$documento, 0, 0, "");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 7);
	$this->MultiCell(($r2 - $r1), 4, $adresse);
}

function addDireccion( $adresse )
{
	$r1     = 10;
	$r2     = $r1 + 133;
	$y1     = 52;
	$y2     = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), 15, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),5, " DIRECCION:", 0, 0, "");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 7);
	$this->MultiCell(($r2 - $r1), 4, $adresse);
}

function addglosa( $adresse )
{
	$r1     = 10;
	$r2     = $r1 + 133;
	$y1     = 69;
	$y2     = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), 15, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),5, " GLOSA:", 0, 0, "");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 7);
	$this->MultiCell(($r2 - $r1), 4, $adresse);
}

// Client address
function addRucCliente( $ruc,$title)
{
	$r1     = $this->w - 63;
	$r2     = $r1 + 25;
	$y1     = 35;
	$y2     = $y1;
	$y3     = 10;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y3, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),6, $title, 0, 0, "C");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 9);
	$this->MultiCell( ($r2 - $r1), ($y3-6), $ruc,0,"C");
}

function addHora( $condicion)
{
	$r1     = $this->w - 63;
	$r2     = $r1 + 25;
	$y1     = 48;
	$y2     = $y1;
	$y3     = 10;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y3, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),6, "HORA", 0, 0, "C");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 9);
	$this->MultiCell( ($r2 - $r1), ($y3-6), $condicion,0,"C");
}

function addCondicionPago( $condicion)
{
	$r1     = $this->w - 63;
	$r2     = $r1 + 25;
	$y1     = 61;
	$y2     = $y1;
	$y3     = 10;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y3, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),6, "CONDICION PAGO", 0, 0, "C");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 9);
	$this->MultiCell( ($r2 - $r1), ($y3-6), $condicion,0,"C");
}

function addfecha( $fecha)
{
	$r1     = $this->w - 34;
	$r2     = $r1 + 25;
	$y1     = 35;
	$y2     = $y1;
	$y3     = 10;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y3, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),6, "FECHA EMISION", 0, 0, "C");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 9);
	$this->MultiCell( ($r2 - $r1), ($y3-6), $fecha,0,"C");
}

function addfechaVencimiento( $fecha)
{
	$r1     = $this->w - 34;
	$r2     = $r1 + 25;
	$y1     = 48;
	$y2     = $y1;
	$y3     = 10;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y3, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),6, "FECHA VENCIMI", 0, 0, "C");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 9);
	$this->MultiCell( ($r2 - $r1), ($y3-6), $fecha,0,"C");
}

function addMoneda($moneda)
{
	$r1     = $this->w - 34;
	$r2     = $r1 + 25;
	$y1     = 61;
	$y2     = $y1;
	$y3     = 10;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y3, 2.25);
	$this->Line( $r1, ($y1+5), $r2, ($y1+5));
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 7);
	$this->Cell(($r2 - $r1),6, "MONEDA", 0, 0, "C");
	$this->SetXY( $r1, $y1+6);
	$this->SetFont( "Arial", "", 9);
	$this->MultiCell( ($r2 - $r1), ($y3-6), $moneda,0,"C");
}

function addCols( $tab )
{
	global $colonnes;
	
	$r1  = 10;
	$r2  = $this->w - ($r1 * 2) ;
	$y1  = 86;
	$y2  = $this->h - 65 - $y1;
	$this->SetXY( $r1, $y1 );
	$this->Rect( $r1, $y1, $r2, $y2, "D");
	$this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
	$colX = $r1;
	$colonnes = $tab;
	
	foreach ($tab as $key => $value) {
    	$this->SetXY( $colX, $y1+2 );
    	$this->Cell( $value, 1, $key, 0, 0, "C");
    	$colX += $value;
    	$this->Line( $colX, $y1, $colX, $y1+$y2);
    }
}

function addLineFormat( $tab )
{
	global $format, $colonnes;

	foreach ($colonnes as $key => $value) {
    	if ( isset( $tab["$key"] ) )
			$format[ $key ] = $tab["$key"];
    }
}

function lineVert( $tab )
{
	global $colonnes;

	reset( $colonnes );
	$maxSize=0;
	while ( list( $lib, $pos ) = each ($colonnes) )
	{
		$texte = $tab[ $lib ];
		$longCell  = $pos -2;
		$size = $this->sizeOfText( $texte, $longCell );
		if ($size > $maxSize)
			$maxSize = $size;
	}
	return $maxSize;
}

// add a line to the invoice/estimate
/*    $ligne = array( "REFERENCE"    => $prod["ref"],
                      "DESIGNATION"  => $libelle,
                      "QUANTITE"     => sprintf( "%.2F", $prod["qte"]) ,
                      "P.U. HT"      => sprintf( "%.2F", $prod["px_unit"]),
                      "MONTANT H.T." => sprintf ( "%.2F", $prod["qte"] * $prod["px_unit"]) ,
                      "TVA"          => $prod["tva"] );
*/
function addLine( $ligne, $tab )
{
	global $colonnes, $format;

	$ordonnee     = 10;
	$maxSize      = $ligne;

	reset( $colonnes );
	foreach ($colonnes as $key => $value) {
    	$longCell  = $value -2;
		$texte     = $tab[ $key ];
		$length    = $this->GetStringWidth( $texte );
		$tailleTexte = $this->sizeOfText( $texte, $length );
		$formText  = $format[ $key ];
		$this->SetXY( $ordonnee, $ligne-1);
		$this->MultiCell( $longCell, 4 , $texte, 0, $formText);
		if ( $maxSize < ($this->GetY()  ) )
			$maxSize = $this->GetY() ;
		$ordonnee += $value;
    }
	
	return ( $maxSize - $ligne );
}

function addRemarque($remarque)
{
	$this->SetFont( "Arial", "", 10);
	$length = $this->GetStringWidth( "Remarque : " . $remarque );
	$r1  = 10;
	$r2  = $r1 + $length;
	$y1  = $this->h - 45.5;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, "Remarque : " . $remarque);
}

function addCadreTVAs()
{
	$this->SetFont( "Arial", "B", 8);
	$r1  = $this->w - 70;
	$r2  = $r1 + 60;
	$y1  = $this->h - 60;
	$y2  = $y1+40;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.22, 'D');	
	$this->SetXY($r1+3, $y1+5);
	$this->Cell(30,5, "OP.GRAVADAS:",0, '','R');
	$this->SetXY($r1+3, $y1+10);
	$this->Cell(30,5, "OP.EXONERADAS:",0, '','R');
	$this->SetXY($r1+3,$y1+15);
	$this->Cell(30,5, "OP.INAFECTAS:",0, '','R');
	$this->SetXY( $r1+3,$y1+20);
	$this->Cell(30,5, "I.C.B.P.E.R:",0, '','R');
	$this->SetXY($r1+3,$y1+25);
	$this->Cell(30,5, "IGV:",0, '','R');
	$this->SetXY($r1+3,$y1+30);
	$this->Cell(30,5, "IMPORTE TOTAL:",0, '','R');
}

function addCadreEurosFrancs()
{
	$r1  = 10;
	$r2  = $r1 + 50;
	$y1  = $this->h - 60;
	$y2  = $y1+33;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
		
}

function addTVAs( $op_gravada, $op_exonerada, $op_inafecta, $icbper, $op_igv, $total, $total_letras)
{
	$this->SetFont('Arial','',8);	
	$r1  = 120;
	$totalHT  = 0;
	$totalTTC = 0;
	$totalTVA = 0;
	$y = $this->h - 60;	

	$this->SetXY($r1+52, $y+5.5);
	$this->Cell(27,4,sprintf("%0.2F",$op_gravada),0, '','R'); //OP GRAVABA
	$this->SetXY($r1+52, $y+10.5 );
	$this->Cell(27,4,sprintf("%0.2F",$op_exonerada),0, '', 'R');//OP EXONERADA	
	$this->SetXY($r1+52, $y+15.5);
	$this->Cell(27,4,sprintf("%0.2F",$op_inafecta),0, '' ,'R');//OP INAFECTA
	$this->SetXY($r1+52, $y+20.5);
	$this->Cell(27,4,sprintf("%0.2F",$icbper),0, '', 'R');//OP ICBPER
	$this->SetXY($r1+52, $y+25.5 );
	$this->Cell(27,4,sprintf("%0.2F",$op_igv), 0, '', 'R');//OP IGV
	$this->SetXY($r1+52,$y+30.5);
	$this->Cell(27,4,sprintf("%0.2F",$total), 0, '', 'R');//IMPORTE TOTAL
	$this->SetFont( "Arial", "B", 9);
	$this->SetXY(10,$y+35);
	$this->Cell(120,4, 'SON: '.$total_letras, 0, '', 'L');//IMPORTE LETRAS
}

function qrView($ruta_qr)
{
	$re  = 10;
	$y1  = $this->h - 56;
	//$this->SetFont( "Arial", "", 8);
	//$this->SetXY( $re, $y1 );
	$this->Image(URL.$ruta_qr,($re+12),$y1, 25, 25);
	//$this->Cell(120,4 ,URL.$ruta_qr, 1, '', 'R');//OP IGV
	//$this->Image(URL . 'public/images/logo_codilans.png', 10, 7, 25, 25);
}

// add a watermark (temporary estimate, DUPLICATA...)
// call this method first
function temporaire( $texte )
{
	$this->SetFont('Arial','B',50);
	$this->SetTextColor(203,203,203);
	$this->Rotate(45,55,190);
	$this->Text(55,190,$texte);
	$this->Rotate(0);
	$this->SetTextColor(0,0,0);
}

}
?>
