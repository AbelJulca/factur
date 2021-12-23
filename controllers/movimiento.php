<?php
class Movimiento extends Controller
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
        $this->view->js = array("movimiento/js/script-movimiento.js");
    }

    public function index()
    {
        if (Session::get('rutas')[15]['estado'] == '1') {
            $this->view->render('movimiento/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function buscarMovimientoCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['codigo'];
            $array = $this->model->buscarMovimientoId($codigo);
            echo json_encode($array);            
        }
    }
  
    function listarMovimiento() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $idperiodo = $_POST['periodo'];
            $idusuario = Session::get('codUser');
            $idalmacen = Session::get('idalmacen');

            $variable = $this->model->ListaMovimiento($idperiodo,$idalmacen,$idusuario);
            $data = array();
            foreach ($variable as $key => $value) {               
                $datos = array(
                    'codigo' => $value['codigo'],
                    'tipo' => $value['tipo'],                    
                    'usuario_participante' => $value['usuario_participante'], 
                    'monto' => $value['monto'],
                    'glosa' => $value['glosa'],                  
                    'boton' => "<div class='d-flex'><button type='button' data-id = ".$value['codigo']." class='editar btn btn-warning btn-xs ml-2'><i class='fas fa-pencil-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    public function insertarMovimiento() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idcaja = Session::get('idCaja');
            if ($idcaja !== '0') {
                $tipo = strtoupper($_POST['txttipo']);
                $glosa = strtoupper($_POST['txtglosa']);
                $monto = $_POST['txtmonto'];
                $participante = strtoupper($_POST['txtparticipante']);

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	'); 
                $xml->startDocument('1.0', 'UTF-8');     
                $xml->startElement("Movimiento"); 
                $xml->startElement("Cabecera");
                    $xml->writeElement("tipo",$tipo);
                    $xml->writeElement("glosa", $glosa); 
                    $xml->writeElement("monto", $monto); 
                    $xml->writeElement("participante",$participante); 
                    $xml->writeElement("idcaja",$idcaja);            
                    $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory(); 
                $mensaje = $this->model->insertMovimiento($content);            
                echo json_encode($mensaje);
            } else {
                echo json_encode('APERTURE UNA CAJA PRIMERO');
            }
        }
    }

    public function updateMovimiento() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idmovi = $_POST['idmovimiento'];
            
            $tipo = strtoupper($_POST['txttipoEdit']);
            $glosa = strtoupper($_POST['txtglosaEdit']);
            $monto = $_POST['txtmontoEdit'];
            $participante = strtoupper($_POST['txtparticipanteEdit']);

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Movimiento"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("tipo",$tipo);
                $xml->writeElement("glosa", $glosa); 
                $xml->writeElement("monto", $monto); 
                $xml->writeElement("participante",$participante); 
                $xml->writeElement("idmovi",$idmovi);            
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->actualizarMovimiento($content);            
            echo json_encode($mensaje);            
        }
    }

}
