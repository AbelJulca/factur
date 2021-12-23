<?php
class Cliente extends Controller
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
        $this->view->js = array("cliente/js/script-cliente.js");
    }

    public function index()
    {
        if (Session::get('rutas')[3]['estado'] == '1') {
            $this->view->render('cliente/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarTablaCliente()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $array = $this->model->listarCliente();  
            $data = array();
            foreach ($array as $key => $value) {
                $datos = array(
                    'codigo' => $value['codigo'],
                    'nrodocu' => $value['nrodocu'],
                    'razon_social' => $value['razon_social'],
                    'telefono' => $value['telefono'],
                    'correo' => $value['correo'],
                    'direccion' => $value['direccion'],
                    'boton' => "<div class='d-flex'><button type='button' data-dni = ".$value['nrodocu']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-deleteid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }          
            $mensaje['data'] = $data;
            echo json_encode($mensaje);            
        }
    }

    function listarTablaDocumento()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarDocumento();
            $this->view->render('cliente/combobox/selectDocumento', true);
        }
    }

    function listarTablaEditDocumento()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarDocumento();
            $this->view->render('cliente/combobox/selectDocumentoEdit', true);
        }
    }

    function buscarCliente()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nrodoc = $_POST['nrodoc'];
            $array = $this->model->buscarClientenrodoc($nrodoc);
            echo json_encode($array);            
        }
    }

    public function insertarCliente() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipodoc = $_POST['txtdocumento'];
            $nrodoc = $_POST['txtdni'];
            $tele = $_POST['txttelefono'];
            $correo = $_POST['txtcorreo'];
            $direccion = strtoupper($_POST['txtdireccion']);
            $razonsocial = strtoupper($_POST['txtrazonsocial']);

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Cliente"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("tipodoc",$tipodoc);
                $xml->writeElement("nrodoc", $nrodoc); 
                $xml->writeElement("telefono", $tele); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("razonsocial", $razonsocial);            
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->insertCliente($content);            
            echo json_encode($mensaje);
        }
    }

    public function actualizarCliente() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['txtidcliente'];
            $tipodoc = $_POST['txtdocumentoEdit'];
            $nrodoc = $_POST['txtdniEdit'];
            $tele = $_POST['txttelefonoEdit'];
            $correo = $_POST['txtcorreoEdit'];
            $direccion = strtoupper($_POST['txtdireccionEdit']);
            $razonsocial = strtoupper($_POST['txtrazonsocialEdit']);

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Cliente"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("codigo",$id);
                $xml->writeElement("tipodoc",$tipodoc);
                $xml->writeElement("nrodoc", $nrodoc); 
                $xml->writeElement("telefono", $tele); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("razonsocial", $razonsocial);            
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->updateCliente($content);            
            echo json_encode($mensaje);
        }
    }

    function eliminarCliente() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteCliente($id);
            echo json_encode($mensaje);
        }
    }
}
