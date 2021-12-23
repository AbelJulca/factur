<?php
class Dashboard extends Controller
{
    function __construct() {
        parent::__construct();      
        Session::init();
        $slogged = Session::get('loggedIn');

        if ($slogged == false) {
            Session::destroy();
            header('location: ../index');
            exit;
        }
        $this->view->js = array("dashboard/js/script-dashboard.js");
    } 

    public function index() {
        $this->view->render('dashboard/index');
    }
    
    public function logout() {
        Session::destroy();
        header('location: ../index');
        exit;
    }

    public function cantidadCliente() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mensaje = $this->model->consultarCantCliente();
            echo json_encode($mensaje);
        }
    }

    public function cantidadVentas() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idperiodo = $_POST['idperiodo'];
            $mensaje = $this->model->consultarCantVenta($idperiodo);
            echo json_encode($mensaje);
        }
    }

    public function cantidadCompras() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idperiodo = $_POST['idperiodo'];
            $mensaje = $this->model->consultarCantCompras($idperiodo);
            echo json_encode($mensaje);
        }
    }

    public function cantidadProveedor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $mensaje = $this->model->consultarCantProveedor();
            echo json_encode($mensaje);
        }
    }

    public function meses() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $year = date('Y');           
            $mensaje = $this->model->obtenerMeses($year);
            $data = array();
            foreach ($mensaje as $key => $value) {
               $por = explode(" ", $value['descripcion']);
                $por[1];
                    $datos = array(                    
                        'mes' => $por[1],                    
                        'total' => $value['total']
                    );
                array_push($data, $datos);
            }
            echo json_encode($data);
        }
    }

    public function pruebacebo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $data= $_SESSION['rutas'];
            echo json_encode($data);
        }
    }

    public function pruebapadre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $data= $_SESSION['menu'];
            echo json_encode($data);
        }
    }
    
}
