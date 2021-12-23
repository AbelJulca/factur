<?php
class Transportista extends Controller
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
        $this->view->js = array("transportista/js/script-transportista.js");
    }

    public function index()
    {
        if (Session::get('rutas')[27]['estado'] == '1') {
            $this->view->render('transportista/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }
    
    function listarTabla()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variable = $this->model->listarTransportista(); 
            $data = array();
            foreach ($variable as $key => $value) {
                $datos = array(
                    'codigo' => $value['codigo'],
                    'iddocumento' => $value['iddocumento'],
                    'nrodoc' => $value['nrodoc'],
                    'razon_social' => $value['razon_social'],
                    'telefono' => $value['telefono'],
                    'correo' => $value['correo'],
                    'direccion' => $value['direccion'],
                    'placa' => $value['placa'],
                    'estado' => $value['estado'],
                    'boton' => "<div class='d-flex'><button type='button' data-dni = ".$value['nrodoc']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-codigo = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
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
            $this->view->render('transportista/combobox/selectDocumento', true);
        }
    }

    function listarTablaDocumentoEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarDocumento();
            $this->view->render('transportista/combobox/selectDocumentoEdit', true);
        }
    }

    function buscarTransportista()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dni = $_POST['nrodoc'];
            $mensaje = $this->model->buscarTranspor($dni);
            echo json_encode($mensaje); 
        }
    }

    public function insertarTransportista() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipodoc = $_POST['txtdocumento'];
            $nrodoc = $_POST['txtdni'];
            $tele = $_POST['txttelefono'];
            $correo = $_POST['txtcorreo'];
            $placa = strtoupper($_POST['txtplaca']);
            $direccion = strtoupper($_POST['txtdireccion']);
            $razonsocial = strtoupper($_POST['txtrazonsocial']);

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Transpor"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("tipodoc",$tipodoc);
                $xml->writeElement("nrodoc", $nrodoc); 
                $xml->writeElement("telefono", $tele); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("razonsocial", $razonsocial);
                $xml->writeElement("placa", $placa);              
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->insertTransportista($content);            
            echo json_encode($mensaje);
        }
    }

    public function actualizarTransportista() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['txtidtranspor'];
            $tipodoc = $_POST['txtdocumentoEdit'];
            $nrodoc = $_POST['txtdniEdit'];
            $tele = $_POST['txttelefonoEdit'];
            $correo = $_POST['txtcorreoEdit'];
            $placa = strtoupper($_POST['txtplacaEdit']);
            $direccion = strtoupper($_POST['txtdireccionEdit']);
            $razonsocial = strtoupper($_POST['txtrazonsocialEdit']);

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Transpor"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("codigo",$codigo);
                $xml->writeElement("tipodoc",$tipodoc);
                $xml->writeElement("nrodoc", $nrodoc); 
                $xml->writeElement("telefono", $tele); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("razonsocial", $razonsocial);
                $xml->writeElement("placa", $placa);              
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->updateTransportista($content);            
            echo json_encode($mensaje);
        }
    }

    function eliminarTransportista(){
        $codigo = $_POST['codigo'];
        $mensaje = $this->model->deleteTransportista($codigo);
        echo json_encode($mensaje);
    }

}
  