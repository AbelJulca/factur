<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Reportekardex extends Controller
{
    function __construct()
    {
        parent::__construct();

        Session::init();
        $slogged = Session::get('loggedIn');

        if ($slogged == false) {
            Session::destroy();
            header('location: ../index');
            exit;
        }
        $this->view->js = array("reportekardex/js/script-reportekardex.js");
    }
    public function index()
    {
        if (Session::get('rutas')[18]['estado'] == '1') {
            $this->view->render('reportekardex/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function ListarProductosNombre() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtro = $_POST['nombre'];
            $nombre = '%' . $filtro . '%';            
            $this->view->Listar = $this->model->obtenerProductoNombre($nombre);
            $this->view->render('reportekardex/tabla/tablaProducto', true);
        }
    }

    function excelKardexInd()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idProductoK',$_POST['codigo']);
            Session::set('fechaini',$_POST['fechaini']); 
            Session::set('fechafin',$_POST['fechafin']);  
            Session::set('nombrePrducto',$_POST['nombre']);            
        }else {                        
            $idalmacen = Session::get('idalmacen');
            $idarticulo = Session::get('idProductoK');
            $fechainicio = Session::get('fechaini');
            $fechafin = Session::get('fechafin');
            $nombreproducto = Session::get('nombrePrducto');
            $nombrealmacen=Session::get('almacen');

            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen); 
            $producto =  $this->model->obtenerProductoExcel($idalmacen,$idarticulo,$fechainicio,$fechafin);
            $excel = new Spreadsheet();
            $hojaActiva = $excel->getActiveSheet();            
            $hojaActiva->setTitle('REPORTE KARDEX');

            
            $styleArray = [                
                'fill' => [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FFA0A0A0',
                    ],
                    'endColor' => [
                        'argb' => 'FFFFFFFF',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $hojaActiva->mergeCells('H1:I1');
            $hojaActiva->getStyle('A3')->applyFromArray($styleArray);   
            $hojaActiva->getStyle('A3')->getFont()->setBold(true)->setName('Arial')->setSize(10);        
            $hojaActiva->setCellValue('A3','FECHA INI: ');
           //$hojaActiva->mergeCells('J1:K1');
            $hojaActiva->setCellValue('B3',$fechainicio);

            //$hojaActiva->mergeCells('L1:M1');
            $hojaActiva->getStyle('C3')->applyFromArray($styleArray);
            $hojaActiva->getStyle('C3')->getFont()->setBold(true)->setName('Arial')->setSize(10);           
            $hojaActiva->setCellValue('C3','FECHA FIN: ');
            //$hojaActiva->mergeCells('N1:O1');
            $hojaActiva->setCellValue('D3',$fechafin);


            $hojaActiva->mergeCells('B1:F1');
            $hojaActiva->getStyle('A1')->applyFromArray($styleArray);
            $hojaActiva->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->setCellValue('A1','ALMACEN: ');
            $hojaActiva->setCellValue('B1',$nombrealmacen);
            $hojaActiva->mergeCells('B2:F2');
            $hojaActiva->getStyle('A2')->applyFromArray($styleArray);
            $hojaActiva->getStyle('A2')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->setCellValue('A2','ARTICULO: ');
            $hojaActiva->setCellValue('B2',$nombreproducto);
            $hojaActiva->getStyle('A4:I4')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->getStyle('A4:I4')->applyFromArray($styleArray);
            $hojaActiva->getColumnDimension('A')->setWidth(19);
            //$hojaActiva->mergeCells('A3:A4');
            $hojaActiva->setCellValue('A4','FECHA');
            $hojaActiva->getColumnDimension('B')->setWidth(12);
            //$hojaActiva->mergeCells('B3:B4');
            $hojaActiva->setCellValue('B4','TIPO');
            $hojaActiva->getColumnDimension('C')->setWidth(18);
            //$hojaActiva->mergeCells('C3:C4');
            $hojaActiva->setCellValue('C4','RUC_PROVEEDOR');
            $hojaActiva->getColumnDimension('D')->setWidth(15);
            //$hojaActiva->mergeCells('D3:D4');
            $hojaActiva->setCellValue('D4','DOCUMENTO');
            $hojaActiva->getColumnDimension('E')->setWidth(12);
            //$hojaActiva->mergeCells('E3:E4');
            $hojaActiva->setCellValue('E4','NUMERO');
            $hojaActiva->getColumnDimension('F')->setWidth(35);
            //$hojaActiva->mergeCells('F3:F4');
            $hojaActiva->setCellValue('F4','OBSERVACION');
            $hojaActiva->getColumnDimension('G')->setWidth(11);
            
            $hojaActiva->getColumnDimension('H')->setWidth(11);
            $hojaActiva->getColumnDimension('J')->setWidth(11);
            $hojaActiva->getColumnDimension('I')->setWidth(11);
            $hojaActiva->getColumnDimension('K')->setWidth(11);
            $hojaActiva->getColumnDimension('L')->setWidth(11);
            $hojaActiva->getColumnDimension('M')->setWidth(11);
            $hojaActiva->getColumnDimension('N')->setWidth(11);
            $hojaActiva->getColumnDimension('O')->setWidth(11);
            //$hojaActiva->mergeCells('G3:I3');
            //$hojaActiva->setCellValue('G3','ENTRADA');
            $hojaActiva->setCellValue('G4','ENTRADA');
            //$hojaActiva->setCellValue('H4','COSTO UNI');
            //$hojaActiva->setCellValue('I4','TOTAL');

            $hojaActiva->mergeCells('J3:L3');
            
            //$hojaActiva->setCellValue('J3','SALIDA');
            
            $hojaActiva->setCellValue('H4','SALIDA');
            //$hojaActiva->setCellValue('K4','COSTO UNI');
           // $hojaActiva->setCellValue('L4','TOTAL');
            
            $hojaActiva->mergeCells('M3:O3');
            //$hojaActiva->setCellValue('M3','SALDO');
            $hojaActiva->setCellValue('I4','SALDO');
            //$hojaActiva->setCellValue('N4','COSTO UNI');
            //$hojaActiva->setCellValue('O4','TOTAL');

            $hojaActiva->mergeCells('G2:H2');
            $hojaActiva->getStyle('G2:H2')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->getStyle('G2:H2')->applyFromArray($styleArray);
            $hojaActiva->setCellValue('G2','STOCK INICIAL: ');
            $hojaActiva->getStyle('G3')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->getStyle('G3')->applyFromArray($styleArray);
            $hojaActiva->setCellValue('G3','UNIDAD: ');

            $valorencabezado='SI';

            $fila = 5;

            foreach ($producto as $key => $value) {
                //$fecha=array(date('d/m/Y', strtotime($value['fecha_registro'])));
                if ($valorencabezado=='SI') {
                    $ultimo=$value['saldo'];
                    $saldoinicial=($ultimo-$value['entrada'])+$value['salida'];
                    $hojaActiva->setCellValue('I2',$saldoinicial);
                    $hojaActiva->setCellValue('H3',$value['idunidad']);
                    $hojaActiva->setCellValue('A'.$fila,$value['fecha_registro']);
                    $hojaActiva->setCellValue('B'.$fila,$value['tipo']);
                    $hojaActiva->setCellValue('C'.$fila,$value['proveedor']);
                    $hojaActiva->setCellValue('D'.$fila,$value['serie_ref']);
                    $hojaActiva->setCellValue('E'.$fila,$value['correlativo_ref']);
                    $hojaActiva->setCellValue('F'.$fila,$value['observacion']);
                    $hojaActiva->setCellValue('G'.$fila,$value['entrada']);
                    //$hojaActiva->setCellValue('H'.$fila,$value['costoentrada']);
                    //$hojaActiva->setCellValue('I'.$fila,number_format($value['costoentrada'] * $value['entrada'], 2, '.', ''));
                    $hojaActiva->setCellValue('H'.$fila,$value['salida']);
                   // $hojaActiva->setCellValue('K'.$fila,$value['costosalida']);
                   // $hojaActiva->setCellValue('L'.$fila,number_format($value['costosalida'] * $value['salida'], 2, '.', ''));
                    $hojaActiva->setCellValue('I'.$fila,$value['saldo']);   
                    
                    $fila ++;
                    $valorencabezado='NO';
                }else{
                    $hojaActiva->setCellValue('A'.$fila,$value['fecha_registro']);
                    $hojaActiva->setCellValue('B'.$fila,$value['tipo']);
                    $hojaActiva->setCellValue('C'.$fila,$value['proveedor']);
                    $hojaActiva->setCellValue('D'.$fila,$value['serie_ref']);
                    $hojaActiva->setCellValue('E'.$fila,$value['correlativo_ref']);
                    $hojaActiva->setCellValue('F'.$fila,$value['observacion']);
                    $hojaActiva->setCellValue('G'.$fila,$value['entrada']);
                    //$hojaActiva->setCellValue('H'.$fila,$value['costoentrada']);
                    //$hojaActiva->setCellValue('I'.$fila,number_format($value['costoentrada'] * $value['entrada'], 2, '.', ''));
                    $hojaActiva->setCellValue('H'.$fila,$value['salida']);
                    //$hojaActiva->setCellValue('K'.$fila,$value['costosalida']);
                    //$hojaActiva->setCellValue('L'.$fila,number_format($value['costosalida'] * $value['salida'], 2, '.', ''));
                    $hojaActiva->setCellValue('I'.$fila,$value['saldo']);

                   /* if($value['salida'] == 0){
                        $hojaActiva->setCellValue('N'.$fila,'=(I'.($fila).'+ O'.($fila-1).')/'.$value['saldo']);
                        $hojaActiva->setCellValue('O'.$fila,'='.'I'.($fila).'+ O'.($fila-1));                                               
                    }else{
                        $hojaActiva->setCellValue('N'.$fila,'=(O'.($fila-1).'- L'.($fila).')/'.$value['saldo']);
                        $hojaActiva->setCellValue('O'.$fila,'='.'O'.($fila-1).'- L'.($fila)); 
                    }*/
                    $fila ++;
                }
            }

            $title = 'REPORTE KARDEX'.'_'.date('Ymd').'_'.date('H:i:m').'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename='.$title);
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($excel, 'Xlsx');
            $writer->save('php://output');
            exit;
        }       
    }

    function excelKardexIndPrueba()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idProductoK',$_POST['codigo']);
            Session::set('fechaini',$_POST['fechaini']); 
            Session::set('fechafin',$_POST['fechafin']);  
            Session::set('nombrePrducto',$_POST['nombre']);            
        }else {                        
            $idalmacen = Session::get('idalmacen');
            $idarticulo = Session::get('idProductoK');
            $fechainicio = Session::get('fechaini');
            $fechafin = Session::get('fechafin');
            $nombreproducto = Session::get('nombrePrducto');
            $nombrealmacen=Session::get('almacen');

            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen); 
            $producto =  $this->model->obtenerProductoExcel($idalmacen,$idarticulo,$fechainicio,$fechafin);
            $excel = new Spreadsheet();
            $hojaActiva = $excel->getActiveSheet();            
            $hojaActiva->setTitle('REPORTE KARDEX');

            
            $styleArray = [                
                'fill' => [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FFA0A0A0',
                    ],
                    'endColor' => [
                        'argb' => 'FFFFFFFF',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $hojaActiva->mergeCells('H1:I1');
            $hojaActiva->getStyle('H1')->applyFromArray($styleArray);   
            $hojaActiva->getStyle('H1')->getFont()->setBold(true)->setName('Arial')->setSize(10);        
            $hojaActiva->setCellValue('H1','FECHA INI: ');
            $hojaActiva->mergeCells('J1:K1');
            $hojaActiva->setCellValue('J1',$fechainicio);

            $hojaActiva->mergeCells('L1:M1');
            $hojaActiva->getStyle('L1')->applyFromArray($styleArray);
            $hojaActiva->getStyle('L1')->getFont()->setBold(true)->setName('Arial')->setSize(10);           
            $hojaActiva->setCellValue('L1','FECHA FIN: ');
            $hojaActiva->mergeCells('N1:O1');
            $hojaActiva->setCellValue('N1',$fechafin);


            $hojaActiva->mergeCells('B1:F1');
            $hojaActiva->getStyle('A1')->applyFromArray($styleArray);
            $hojaActiva->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->setCellValue('A1','ALMACEN: ');
            $hojaActiva->setCellValue('B1',$nombrealmacen);
            $hojaActiva->mergeCells('B2:F2');
            $hojaActiva->getStyle('A2')->applyFromArray($styleArray);
            $hojaActiva->getStyle('A2')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->setCellValue('A2','ARTICULO: ');
            $hojaActiva->setCellValue('B2',$nombreproducto);
            $hojaActiva->getStyle('A3:O4')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->getStyle('A3:O4')->applyFromArray($styleArray);
            $hojaActiva->getColumnDimension('A')->setWidth(19);
            $hojaActiva->mergeCells('A3:A4');
            $hojaActiva->setCellValue('A3','FECHA');
            $hojaActiva->getColumnDimension('B')->setWidth(10);
            $hojaActiva->mergeCells('B3:B4');
            $hojaActiva->setCellValue('B3','TIPO');
            $hojaActiva->getColumnDimension('C')->setWidth(18);
            $hojaActiva->mergeCells('C3:C4');
            $hojaActiva->setCellValue('C3','RUC_PROVEEDOR');
            $hojaActiva->getColumnDimension('D')->setWidth(15);
            $hojaActiva->mergeCells('D3:D4');
            $hojaActiva->setCellValue('D3','DOCUMENTO');
            $hojaActiva->getColumnDimension('E')->setWidth(12);
            $hojaActiva->mergeCells('E3:E4');
            $hojaActiva->setCellValue('E3','NUMERO');
            $hojaActiva->getColumnDimension('F')->setWidth(35);
            $hojaActiva->mergeCells('F3:F4');
            $hojaActiva->setCellValue('F3','OBSERVACION');
            $hojaActiva->getColumnDimension('G')->setWidth(11);
            
            $hojaActiva->getColumnDimension('H')->setWidth(11);
            $hojaActiva->getColumnDimension('J')->setWidth(11);
            $hojaActiva->getColumnDimension('I')->setWidth(11);
            $hojaActiva->getColumnDimension('K')->setWidth(11);
            $hojaActiva->getColumnDimension('L')->setWidth(11);
            $hojaActiva->getColumnDimension('M')->setWidth(11);
            $hojaActiva->getColumnDimension('N')->setWidth(11);
            $hojaActiva->getColumnDimension('O')->setWidth(11);
            $hojaActiva->mergeCells('G3:I3');
            $hojaActiva->setCellValue('G3','ENTRADA');
            $hojaActiva->setCellValue('G4','CANTIDAD');
            $hojaActiva->setCellValue('H4','COSTO UNI');
            $hojaActiva->setCellValue('I4','TOTAL');

            $hojaActiva->mergeCells('J3:L3');
            
            $hojaActiva->setCellValue('J3','SALIDA');
            
            $hojaActiva->setCellValue('J4','CANTIDAD');
            $hojaActiva->setCellValue('K4','COSTO UNI');
            $hojaActiva->setCellValue('L4','TOTAL');
            
            $hojaActiva->mergeCells('M3:O3');
            $hojaActiva->setCellValue('M3','SALDO');
            $hojaActiva->setCellValue('M4','CANTIDAD');
            $hojaActiva->setCellValue('N4','COSTO UNI');
            $hojaActiva->setCellValue('O4','TOTAL');

            $hojaActiva->mergeCells('G2:H2');
            $hojaActiva->getStyle('G2:H2')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->getStyle('G2:H2')->applyFromArray($styleArray);
            $hojaActiva->setCellValue('G2','STOCK INICIAL: ');
            $hojaActiva->getStyle('K2')->getFont()->setBold(true)->setName('Arial')->setSize(10);
            $hojaActiva->getStyle('K2')->applyFromArray($styleArray);
            $hojaActiva->setCellValue('K2','UNIDAD: ');

            $valorencabezado='SI';

            $fila = 5;

            foreach ($producto as $key => $value) {
                //$fecha=array(date('d/m/Y', strtotime($value['fecha_registro'])));
                if ($valorencabezado=='SI') {
                    $ultimo=$value['saldo'];
                    $saldoinicial=($ultimo-$value['entrada'])+$value['salida'];
                    $hojaActiva->setCellValue('I2',$saldoinicial);
                    $hojaActiva->setCellValue('L2',$value['idunidad']);
                    $hojaActiva->setCellValue('A'.$fila,$value['fecha_registro']);
                    $hojaActiva->setCellValue('B'.$fila,$value['tipo']);
                    $hojaActiva->setCellValue('C'.$fila,$value['proveedor']);
                    $hojaActiva->setCellValue('D'.$fila,$value['serie_ref']);
                    $hojaActiva->setCellValue('E'.$fila,$value['correlativo_ref']);
                    $hojaActiva->setCellValue('F'.$fila,$value['observacion']);
                    $hojaActiva->setCellValue('G'.$fila,$value['entrada']);
                    //$hojaActiva->setCellValue('H'.$fila,$value['costoentrada']);
                    //$hojaActiva->setCellValue('I'.$fila,number_format($value['costoentrada'] * $value['entrada'], 2, '.', ''));
                    $hojaActiva->setCellValue('J'.$fila,$value['salida']);
                   // $hojaActiva->setCellValue('K'.$fila,$value['costosalida']);
                   // $hojaActiva->setCellValue('L'.$fila,number_format($value['costosalida'] * $value['salida'], 2, '.', ''));
                    $hojaActiva->setCellValue('M'.$fila,$value['saldo']);
                    
                    if($value['salida'] == 0){
                        $hojaActiva->setCellValue('N'.$fila,$value['costoentrada']);
                        $hojaActiva->setCellValue('O'.$fila,number_format($value['saldo'] * $value['costoentrada'], 2, '.', ''));
                    }else{
                        $hojaActiva->setCellValue('N'.$fila,$value['costosalida']);
                        $hojaActiva->setCellValue('O'.$fila,number_format($value['saldo'] * $value['costosalida'], 2, '.', ''));
                    }
                    
                    $fila ++;
                    $valorencabezado='NO';
                }else{
                    $hojaActiva->setCellValue('A'.$fila,$value['fecha_registro']);
                    $hojaActiva->setCellValue('B'.$fila,$value['tipo']);
                    $hojaActiva->setCellValue('C'.$fila,$value['proveedor']);
                    $hojaActiva->setCellValue('D'.$fila,$value['serie_ref']);
                    $hojaActiva->setCellValue('E'.$fila,$value['correlativo_ref']);
                    $hojaActiva->setCellValue('F'.$fila,$value['observacion']);
                    $hojaActiva->setCellValue('G'.$fila,$value['entrada']);
                    //$hojaActiva->setCellValue('H'.$fila,$value['costoentrada']);
                    //$hojaActiva->setCellValue('I'.$fila,number_format($value['costoentrada'] * $value['entrada'], 2, '.', ''));
                    $hojaActiva->setCellValue('J'.$fila,$value['salida']);
                    //$hojaActiva->setCellValue('K'.$fila,$value['costosalida']);
                    //$hojaActiva->setCellValue('L'.$fila,number_format($value['costosalida'] * $value['salida'], 2, '.', ''));
                    $hojaActiva->setCellValue('M'.$fila,$value['saldo']);

                   /* if($value['salida'] == 0){
                        $hojaActiva->setCellValue('N'.$fila,'=(I'.($fila).'+ O'.($fila-1).')/'.$value['saldo']);
                        $hojaActiva->setCellValue('O'.$fila,'='.'I'.($fila).'+ O'.($fila-1));                                               
                    }else{
                        $hojaActiva->setCellValue('N'.$fila,'=(O'.($fila-1).'- L'.($fila).')/'.$value['saldo']);
                        $hojaActiva->setCellValue('O'.$fila,'='.'O'.($fila-1).'- L'.($fila)); 
                    }*/
                    $fila ++;
                }
            }

            $title = 'REPORTE KARDEX'.'_'.date('Ymd').'_'.date('H:i:m').'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename='.$title);
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($excel, 'Xlsx');
            $writer->save('php://output');
            exit;
        }       
    }

    function pdfKardexInd()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idProductoK',$_POST['codigo']);
            Session::set('fechaini',$_POST['fechaini']); 
            Session::set('fechafin',$_POST['fechafin']);            
        }else {                        
            $idalmacen = Session::get('idalmacen');
            $idarticulo = Session::get('idProductoK');
            $fechainicio = Session::get('fechaini');
            $fechafin = Session::get('fechafin');

            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen); 
            $this->view->producto =  $this->model->obtenerProducto($idalmacen,$idarticulo,$fechainicio,$fechafin);       
            $this->view->render('pdf/kardexind', true);
        }       
    }

    function pdfKardexGnd()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            Session::set('fechaini',$_POST['fechaini']); 
            Session::set('fechafin',$_POST['fechafin']);            
        }else {            
            $idalmacen = Session::get('idalmacen');
            $fechainicio = Session::get('fechaini');
            $fechafin = Session::get('fechafin');

            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen); 
            $this->view->producto =  $this->model->obtenerProductoGnd($idalmacen,$fechainicio,$fechafin);
            $this->view->idproducto =  $this->model->obtenerIdProductoGnd($idalmacen,$fechainicio,$fechafin);         
            $this->view->render('pdf/kardexgnd', true);
        }       
    }
}
 