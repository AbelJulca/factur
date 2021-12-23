<?php
class Reportecredito extends Controller
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
        $this->view->js = array("reportecredito/js/script-reportecredito.js");
    }

    public function index()
    {
        if (Session::get('rutas')[9]['estado'] == '1') {
            $this->view->render('reportecredito/index');# code...
        } else {
            $this->view->render('error/error');# code...
        } 
    }

    function listarVentaPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idperiodo = $_POST['periodo'];
            if ( $idperiodo == '00') {
                $fecha = date('Y-m-d');
                $periodo = $this->model->listarvalidarPeriodo($fecha);
                $idperiodo = $periodo['codigo'];
            }
            $comprobante = $_POST['comprobante'];
            $idalmacen = Session::get('idalmacen');

            $variable = $this->model->consultarVentas($idperiodo,$comprobante,$idalmacen);
            $data = array();
            foreach ($variable as $key => $value) {
                $correx = strlen($value['correlativo']);
                $correlativo ='';
                $condicion = "<kbd class='bg-warning' > No Enviado</kbd>";
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

                if ($value['feestado'] == '0') {
                    $condicion = "<kbd class='bg-success' >Enviado</kbd>";
                }

                $datos = array(
                    'codigo' => $value['codigo'],
                    'serie' => $value['serie'].'-'.$correlativo,                    
                    'cliente' => $value['razon_social'], 
                    'fecha_emision' => $value['fecha_emision'],
                    'op_gravadas' => $value['op_gravadas'],
                    'op_exoneradas' => $value['op_exoneradas'],
                    'op_inafectas' => $value['op_inafectas'],
                    'op_icbper' => $value['op_icbper'],
                    'igv' => $value['igv'],
                    'total' => $value['total'],
                    'condicion' => $condicion,                   
                    'boton' => "<div class='d-flex'><button type='button' data-ventaid = ".$value['codigo']." class='ver btn btn-info btn-sm'><i class='fas fa-binoculars'></i></button></div>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }
}
