<?php
class Reportebajafac extends Controller {

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
        $this->view->js = array("reportebajafac/js/script-reportebajafac.js");
    }
    
    public function index()
    {
        if (Session::get('rutas')[24]['estado'] == '1') {
            $this->view->render('reportebajafac/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarVentaPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idperiodo = $_POST['periodo'];
            
            $comprobante = '01';
            $idalmacen = Session::get('idalmacen');

            $variable = $this->model->consultarVentasBajas($idperiodo,$comprobante,$idalmacen);
            $data = array();
            foreach ($variable as $key => $value) {
                $correx = strlen($value['correlativo']);
                $correlativo ='';
                $condicion = "<kbd class='bg-danger'>Error</kbd>";
                if ($correx == '1') {
                    $correlativo = '0000000'.$value['correlativo'];
                }
                if ($correx == '2') {
                    $correlativo = '000000'.$value['correlativo'];
                }
                if ($correx == '3') {
                    $correlativo = '00000'.$value['correlativo'];
                }
                if ($correx == '4') {
                    $correlativo = '0000'.$value['correlativo'];
                }
                if ($correx == '5') {
                    $correlativo = '000'.$value['correlativo'];
                }
                if ($correx == '6') {
                    $correlativo = '00'.$value['correlativo'];
                }
                if ($correx == '7') {
                    $correlativo = '0'.$value['correlativo'];
                }
                if ($correx == '8') {
                    $correlativo = $value['correlativo'];
                }

                $boton = "<div class='d-flex'><button type='button' data-ventaid = ".$value['codigo']." class='ver btn btn-xs'><kbd class='bg-danger'>pdf</kbd></button></div>";

                if ($value['codsunat_baja'] == '0') {
                    $condicion = "<kbd class='bg-success' >Enviado</kbd>";
                    $boton = "<div class='d-flex'><button type='button' data-ventaid = ".$value['codigo']." class='ver btn btn-xs'><kbd class='bg-danger'>pdf</kbd></button><button type='button' data-xml = ".$value['rutaxml_baja']." class='xml btn btn-xs'><kbd class='bg-primary'>xml</kbd></button><button type='button' data-cdr = ".$value['rutacdr_baja']." class='cdr btn btn-xs'><kbd class='bg-warning'>cdr</kbd></button></div>";
                }

                if ($value['codsunat_baja'] == '109') {
                    $condicion = "<kbd class='bg-success' >No Enviado</kbd>";
                    $boton = "<div class='d-flex'><button type='button' data-sunat= ".$value['codigo']." class='sunat btn btn-xs'><kbd class='bg-success'>sunat</kbd></button><button type='button' data-ventaid = ".$value['codigo']." class='ver btn btn-xs'><kbd class='bg-danger'>pdf</kbd></button><button type='button' data-xml = ".$value['rutaxml_baja']." class='xml btn btn-xs'><kbd class='bg-primary'>xml</kbd></button><button type='button' data-cdr = ".$value['rutacdr_baja']." class='cdr btn btn-xs'><kbd class='bg-warning'>cdr</kbd></button></div>";
                }

                $datos = array(                    
                    'serie' => $value['serie'].'-'.$correlativo,                    
                    'cliente' => $value['razon_social'], 
                    'fecha_emision' => $value['fecha_emision'],
                    'fecha_baja' => $value['fecha_baja'],
                    'op_gravadas' => $value['op_gravadas'],
                    'op_exoneradas' => $value['op_exoneradas'],
                    'op_inafectas' => $value['op_inafectas'],
                    'op_icbper' => $value['op_icbper'],
                    'igv' => $value['igv'],
                    'total' => $value['total'],
                    'condicion' => $condicion,
                    'mensajesunat' => $value['statussunat_baja'],
                    'ticket' => $value['ticket_resumen_baja'],                     
                    'boton' => $boton
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function rutaCdr()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('rutacdr',$_POST['ruta']);           
        }else {
            $ruta = Session::get('rutacdr');
            $enlace = './facturacion/cdr_ra/'.$ruta;
            header ("Content-Disposition: attachment; filename=".$ruta." ");
            header ("Content-Type: application/octet-stream");
            header ("Content-Length: ".filesize($enlace));
            readfile($enlace);
        }       
    }

    function rutaXml()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('rutaxml',$_POST['ruta']);           
        }else {
            $ruta = Session::get('rutaxml');
            $enlace = './facturacion/xml_firmar_ra/'.$ruta;
            header ("Content-Disposition: attachment; filename=".$ruta." ");
            header ("Content-Type: application/octet-stream");
            header ("Content-Length: ".filesize($enlace));
            readfile($enlace);
        }       
    }
}