<?php
class Laboratorio extends Controller
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
        $this->view->js = array("laboratorio/js/script-laboratorio.js"); 
    }
    
    public function index() { 
        if (Session::get('rutas')[5]['estado'] == '1') {
            $this->view->render('laboratorio/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }       
    }

    function listarTablaLaboratorio()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $array = $this->model->listarLaboratorio();            
            $data = array();
            foreach ($array as $key => $value) {
                $datos = array(
                    'nombre' => $value['nombre'],
                    'descripcion' => $value['descripcion'],
                    'telefono' => $value['telefono'],
                    'correo' => $value['correo'],
                    'personal_contacto' => $value['personal_contacto'],
                    'telefono_contacto' => $value['telefono_contacto'],
                    'boton' => "<div class='d-flex'><button type='button' data-id = ".$value['codigo']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-deleteid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }          
            $mensaje['data'] = $data;
            echo json_encode($mensaje);            
        }
    }

    public function insertarLaboratorio() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = strtoupper($_POST['txtnombre']);
            $descripcion = strtoupper($_POST['txtdescripcion']);
            $telefono = $_POST['txttelefono'];
            $correo = $_POST['txtcorreo'];
            $personacontacto = strtoupper($_POST['txtpersona_contac']);
            $telefonocontacto = $_POST['txttelefono_contac'];

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Laboratorio"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("nombre",$nombre);
                $xml->writeElement("descripcion", $descripcion); 
                $xml->writeElement("telefono", $telefono); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("personacontacto", $personacontacto);  
                $xml->writeElement("telefonocontacto", $telefonocontacto);
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->insertLaboratorio($content);            
            echo json_encode($mensaje);
        }
    }

    public function actualizarLaboratorio() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['txtidlaboratorio'];
            $nombre = strtoupper($_POST['txtnombreEdit']);
            $descripcion = strtoupper($_POST['txtdescripcionEdit']);
            $telefono = $_POST['txttelefonoEdit'];
            $correo = $_POST['txtcorreoEdit'];
            $personacontacto = strtoupper($_POST['txtpersona_contacEdit']);
            $telefonocontacto = $_POST['txttelefono_contacEdit'];

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Laboratorio"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("codigo",$id);
                $xml->writeElement("nombre",$nombre);
                $xml->writeElement("descripcion", $descripcion); 
                $xml->writeElement("telefono", $telefono); 
                $xml->writeElement("correo",  $correo); 
                $xml->writeElement("personacontacto", $personacontacto);  
                $xml->writeElement("telefonocontacto", $telefonocontacto);
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->updateLaboratorio($content);            
            echo json_encode($mensaje);
        }
    }

    function eliminarLaboratorio() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteLaboratorio($id);
            echo json_encode($mensaje);
        }
    }

    function buscarLaboratorio() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->obtenerLaboratorio($id);
            echo json_encode($mensaje);
        }
    }


    
}
