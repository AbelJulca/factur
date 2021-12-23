<?php
class Acceso extends Controller
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
        $this->view->js = array("acceso/js/script-acceso.js");
    }
    public function index()
    {
        if (Session::get('rutas')[30]['estado'] == '1') {
            $this->view->render('acceso/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarTablaPerfil() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variable = $this->model->listarPerfil();  
           
            $data = array();
            foreach ($variable as $key => $value) {                
                $datos = array(
                    'codigo' => $value['codigo'],
                    'nombres' => $value['descripcion'],
                    'boton' => "<div class='d-flex'><button type='button' data-perfilid = ".$value['codigo']." data-nombreid = ".$value['descripcion']." class='ver btn btn-warning btn-sm'><i class='far fa-hand-pointer'></i></button>
                    <button type='button' data-perfilid = ".$value['codigo']." data-nombreid = ".$value['descripcion']." class='editar ml-2 btn btn-info btn-sm'><i class='fas fa-pencil-alt'></i></button>
                    <button type='button' data-perfilid = ".$value['codigo']." class='eliminar ml-2 btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    public function insertarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
                if($_POST['txtperfil'] !== '') {
                    $nombre = strtoupper($_POST['txtperfil']);                
                    $mensaje = $this->model->insertPerfil($nombre);
                    echo json_encode($mensaje);
                }else{
                    $mensaje = 'INGRESE UN NOMBRE';
                    echo json_encode($mensaje);
                }                                          
        }
    }

    public function actualizarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
                $id = $_POST['txtidperfil'];             
                $nombre = strtoupper($_POST['txtperfilEdit']);                
                $mensaje = $this->model->updatePerfil($id,$nombre);
                echo json_encode($mensaje);                                           
        }
    }

    function eliminarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deletePerfil($id);
            echo json_encode($mensaje);
        }
    }

    function listarTablaMenu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarMenu();
            $this->view->render('acceso/combobox/selectMenu', true);
        }
    }

    function encabezado()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idperfil = $_POST['idperfil'];
            $padre = $_POST['padre'];
            $this->view->Listar = $this->model->listarHijos($idperfil,$padre);
            $this->view->render('acceso/combobox/hijos', true);
        }
    }

    function permisos()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['permisos'])){
                $id = $_POST['permisos'];
                $idperfil = $_POST['txtcodigoperfil'];
                $nombre = $_POST['txtnombrepadre'];
                $this->model->updatePermisoCero($idperfil,$nombre);
                foreach ($id as $value) {
                    $mensaje = $this->model->updatePermiso($value);
                }                
                $estado = '0';
                $hijos = $this->model->listarHijos($idperfil,$nombre);
                foreach ($hijos as $key => $value) {
                    if($value['estado'] == '1'){
                        $estado = '1';
                        $padre = $value['padre'];
                    }else {
                        $padre = $value['padre'];
                    }
                }
                $est = $this->model->updatePadre($idperfil,$padre,$estado);
                echo json_encode($mensaje);
            }else{
                $idperfil = $_POST['txtcodigoperfil'];
                $nombre = $_POST['txtnombrepadre'];
                $this->model->updatePermisoCero($idperfil,$nombre);
                $estado = '0';
                $hijos = $this->model->listarHijos($idperfil,$nombre);
                foreach ($hijos as $key => $value) {
                    if($value['estado'] == '1'){                        
                        $padre = $value['padre'];
                    }else {
                        $padre = $value['padre'];
                    }
                }
                $est = $this->model->updatePadre($idperfil,$padre,$estado);
                echo json_encode('CAMBIOS REALIZADOS');
            }            
        }
    }
}
