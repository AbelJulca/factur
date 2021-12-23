<?php
class Reporteguia extends Controller
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
        $this->view->js = array("reporteguia/js/script-reporteguia.js");
    }

    public function index()
    {
        if (Session::get('rutas')[28]['estado'] == '1') {
            $this->view->render('reporteguia/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarVentaPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idperiodo = $_POST['periodo'];
           
            $comprobante = '09';
            $idalmacen = Session::get('idalmacen');
            $idusuario = Session::get('codUser');

            $variable = $this->model->consultarGuia($idperiodo,$comprobante,$idalmacen,$idusuario);
            $data = array();
            foreach ($variable as $key => $value) {
                $correx = strlen($value['correlativo']);
                $correlativo ='';
                $condicion = "<kbd class='bg-danger' > Error</kbd>";
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
                
                if ($value['codsunat'] == '') {
                    $condicion = "<kbd class='bg-secondary' >Sin Codigo</kbd>";
                    $boton = "<div class='d-flex'><button type='button' data-guiaid = ".$value['codigo']." class='ver btn btn-xs'><kbd class='bg-danger'>pdf</kbd></button></div>";
                }

                if ($value['codsunat'] == '0') {
                    $condicion = "<kbd class='bg-success' >Enviado</kbd>";
                    $boton = "<div class='d-flex'><button type='button' data-guiaid = ".$value['codigo']." class='ver btn btn-xs'><kbd class='bg-danger'>pdf</kbd></button><button type='button' data-xml = ".$value['xml']." class='xml btn btn-xs'><kbd class='bg-primary'>xml</kbd></button><button type='button' data-cdr = ".$value['cdr']." class='cdr btn btn-xs'><kbd class='bg-warning'>cdr</kbd></button></div>";
                }

                if ($value['codsunat'] == '109') {
                    $condicion = "<kbd class='bg-warning' >No Enviado</kbd>";
                    $boton = "<div class='d-flex'><button type='button' data-sunat= ".$value['codigo']." class='sunat btn btn-xs'><kbd class='bg-success'>sunat</kbd></button><button type='button' data-guiaid = ".$value['codigo']." class='ver btn btn-xs'><kbd class='bg-danger'>pdf</kbd></button><button type='button' data-xml = ".$value['xml']." class='xml btn btn-xs'><kbd class='bg-primary'>xml</kbd></button><button type='button' data-cdr = ".$value['cdr']." class='cdr btn btn-xs'><kbd class='bg-warning'>cdr</kbd></button></div>";
                }

                $datos = array(                    
                    'serie' => $value['serie'].'-'.$correlativo,                    
                    'razon_social' => $value['razon_social'], 
                    'fecha_emision' => $value['fecha_emision'],
                    'fecha_envio' => $value['fecha_envio'],
                    'hora' => $value['hora'],
                    'observacion' => $value['observacion'],
                    'peso' => $value['peso'],
                    'cant_peso' => $value['cant_peso'],
                    'idtransporte' => $value['idtransporte'],
                    'condicion' => $condicion,
                    'mensajesunat' => $value['status_sunat'],                    
                    'boton' => $boton
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idguia',$_POST['codigo']);           
        }else {
            $id = Session::get('idguia');            
            $idalmacen = Session::get('idalmacen');
            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen);
            $this->view->guia = $this->model->obtenerGuiaTwo($id);
            $this->view->detalle = $this->model->obtenerDetalleGuia($id);        
            $this->view->render('pdf/guia', true);
        }       
    }

    function rutaCdr()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('rutacdr',$_POST['ruta']);           
        }else {
            $ruta = Session::get('rutacdr');
            $enlace = './facturacion/cdr_guia/'.$ruta;
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
            $enlace = './facturacion/xml_firmar_guia/'.$ruta;
            header ("Content-Disposition: attachment; filename=".$ruta." ");
            header ("Content-Type: application/octet-stream");
            header ("Content-Length: ".filesize($enlace));
            readfile($enlace);
        }       
    }
}
 