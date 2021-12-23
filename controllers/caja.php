<?php

class Caja extends Controller
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
        $this->view->js = array("caja/js/script-caja.js");
    }
    public function index()
    {
        if (Session::get('rutas')[14]['estado'] == '1') {
            $this->view->render('caja/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    public function insertCaja() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = strtoupper($_POST['txtnombrecaja']);
            $fecha = $_POST['txtfecha'];
            $year = $_POST['txtyear'];
            $monto = $_POST['txtmonto'];
            $idusuario = Session::get('codUser');
            $idalmacen = Session::get('idalmacen');           

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Caja"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("idusuario",$idusuario);
                $xml->writeElement("idalmacen", $idalmacen); 
                $xml->writeElement("descripcion", $nombre); 
                $xml->writeElement("fecha",  $fecha); 
                $xml->writeElement("monto_apertura", $monto);           
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->agregarCaja($content);
            
            $porciones = explode("-", $mensaje);            
            Session::set('idCaja', $porciones[1]);
            Session::set('nombreCaja', $porciones[2]);
            echo json_encode($mensaje);
        }
    }

    public function validarCaja() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idusuario = Session::get('codUser');
            $idalmacen = Session::get('idalmacen');
            $idcaja = Session::get('idCaja');
            $fecha = date('Y-m-d');
            $mensaje = $this->model->verificarCaja($idusuario, $idalmacen, $fecha, $idcaja);
            Session::set('idCaja', $mensaje[2]);
            Session::set('nombreCaja', $mensaje[0]);
            echo json_encode($mensaje);            
        }
    }

    public function cerrarCaja() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $idcaja = Session::get('idCaja');
            $fecha = date('Y-m-d');
            $mensaje = $this->model->finalizarCaja($idcaja);
            Session::set('idCaja', '0');
            Session::set('nombreCaja', 'SIN NOMBRE');
            echo json_encode($mensaje);
        }
    }

    function listarCajaPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idperiodo = $_POST['periodo'];
            $idalmacen = Session::get('idalmacen');
            $idusuario = Session::get('codUser');

            $data = $this->model->cajaPeriodo($idperiodo,$idalmacen,$idusuario);            

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function listarCajaTotales() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idcaja = Session::get('idCaja');
            $mensaje = $this->model->cajaTotales($idcaja);
            echo json_encode($mensaje);
        }
    }
}
