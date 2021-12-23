<?php
class Reportebajacompras extends Controller
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
        $this->view->js = array("reportebajacompras/js/script-reportebajacompras.js");
    }
    public function index()
    {
        if (Session::get('rutas')[13]['estado'] == '1') {
            $this->view->render('reportebajacompras/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarComprasPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idperiodo = $_POST['periodo'];
            $idalmacen = Session::get('idalmacen');

            $variable = $this->model->comprasPeriodo($idperiodo,$idalmacen);
            $data = array();
            foreach ($variable as $key => $value) {               
                $datos = array(
                    'codigo' => $value['codigo'],
                    'serie' => $value['serie'],                    
                    'proveedor' => $value['proveedor'], 
                    'fecha_emision' => $value['fecha_emision'],
                    'fecha_vencimiento' => $value['fecha_vencimiento'],
                    'glosa' => $value['glosa'],
                    'op_gravadas' => $value['op_gravadas'],
                    'op_exoneradas' => $value['op_exoneradas'],
                    'op_inafectas' => $value['op_inafectas'],
                    'op_icbper' => $value['op_icbper'],
                    'igv' => $value['igv'],
                    'total' => $value['total'],                   
                    'boton' => "<div class='d-flex'><button type='button' data-compraid = ".$value['codigo']." class='ver btn btn-info btn-sm'><i class='fas fa-binoculars'></i></button></div>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function listarComprasProveedor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idperiodo = $_POST['periodo'];
            $idproveedor = $_POST['proveedor'];
            $idalmacen = Session::get('idalmacen');

            $variable = $this->model->comprasProveedor($idperiodo,$idalmacen,$idproveedor);
            $data = array();
            foreach ($variable as $key => $value) {               
                $datos = array(
                    'codigo' => $value['codigo'],
                    'serie' => $value['serie'],                    
                    'proveedor' => $value['proveedor'], 
                    'fecha_emision' => $value['fecha_emision'],
                    'fecha_vencimiento' => $value['fecha_vencimiento'],
                    'glosa' => $value['glosa'],
                    'op_gravadas' => $value['op_gravadas'],
                    'op_exoneradas' => $value['op_exoneradas'],
                    'op_inafectas' => $value['op_inafectas'],
                    'op_icbper' => $value['op_icbper'],
                    'igv' => $value['igv'],
                    'total' => $value['total'],                   
                    'boton' => "<div class='d-flex'><button type='button' data-compraid = ".$value['codigo']." class='ver btn btn-info btn-sm'><i class='fas fa-binoculars'></i></button></div>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

}
