<?php

class Proveedor extends Controller {

    function __construct() {
        parent::__construct();

        Session::init();
        $slogged = Session::get('loggedIn');

        if ($slogged == false) {
            Session::destroy();
            header('location: ../index');
            exit;
        }
        $this->view->js = array("proveedor/js/script-proveedor.js"); 
    }
    public function index() { 
        if (Session::get('rutas')[4]['estado'] == '1') {
            $this->view->render('proveedor/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }       
    }
    
    //************* INSERTAR *********************
    public function insertarProveedor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipodoc = $_POST['cmbdocumP'];
            $nrodoc = $_POST['dniP'];
            $tele = $_POST['telefonoP'];
            $correo = $_POST['correoP'];
            $direccion = strtoupper($_POST['direccionP']);
            $razonsocial = strtoupper($_POST['razonsocialP']);
            $personacontacto = strtoupper($_POST['personacontactoP']);
            $telefonocontacto = $_POST['telefonocontactoP'];

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Proveedor"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("tipodoc",$tipodoc);
                $xml->writeElement("nrodoc", $nrodoc); 
                $xml->writeElement("telefono", $tele); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("razonsocial", $razonsocial); 
                $xml->writeElement("personacontacto", $personacontacto);  
                $xml->writeElement("telefonocontacto", $telefonocontacto);  
            
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->insertProveedor($content);            
            echo json_encode($mensaje);
        }
    }
    
    function editarProveedor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['codigoPM'];
            $tipodoc = $_POST['cmbdocumPM'];
            $nrodoc = $_POST['dniPM'];
            $tele = $_POST['telefonoPM'];
            $correo = $_POST['correoPM'];
            $direccion = strtoupper($_POST['direccionPM']);
            $razonsocial = strtoupper($_POST['razonsocialPM']);
            $personacontacto = strtoupper($_POST['personacontactoPM']);
            $telefonocontacto = $_POST['telefonocontactoPM'];

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Proveedor"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("codigo",$codigo);
                $xml->writeElement("tipodoc",$tipodoc);
                $xml->writeElement("nrodoc", $nrodoc); 
                $xml->writeElement("telefono", $tele); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("razonsocial", $razonsocial); 
                $xml->writeElement("personacontacto", $personacontacto);  
                $xml->writeElement("telefonocontacto", $telefonocontacto);
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory();                        
            $mensaje = $this->model->updateProveedor($content);            
            echo json_encode($mensaje);
        }
    }
    
    function eliminarProveedor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteProveedor($id);
            echo json_encode($mensaje);
        }
    }
    
    function activarCliente() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->activarCli($id);
            echo json_encode($mensaje);
        }
    }
    
    function buscarProveedor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nrodoc = $_POST['nrodoc'];
            $mensaje = $this->model->buscarProvee($nrodoc);
            echo json_encode($mensaje);
        }
    }  
    
    // ****************** LISTAS ***********************
    
    function listarTabla() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $array = $this->model->listarProveedor();
            $data = array();
            foreach ($array as $key => $value) {
                $datos = array(
                    'codigo' => $value['codigo'],
                    'nrodoc' => $value['nrodoc'],
                    'razon_social' => $value['razon_social'],
                    'telefono' => $value['telefono'],
                    'correo' => $value['correo'],
                    'direccion' => $value['direccion'],
                    'personacontacto' => $value['personacontacto'],
                    'telefonocontacto' => $value['telefonocontacto'],
                    'boton' => "<div class='d-flex'><button type='button' data-dni = ".$value['nrodoc']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-deleteid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }          
            $mensaje['data'] = $data;
            echo json_encode($mensaje);
            //$this->view->Listar = $this->model->listarProveedor();
            //$this->view->render('proveedor/tabla/tablaProveedor', true);
        }
    }
    
    function listarBajas() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarBajasCliente();
            $this->view->render('cliente/tabla/tablaClientesBajas', true);
        }
    }
}

