<?php
class Periodo extends Controller
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
        $this->view->js = array("periodo/js/script-periodo.js");
    }
    public function index()
    {
        if (Session::get('rutas')[1]['estado'] == '1') {
            $this->view->render('periodo/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarTablaPeriodo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mensaje['data'] = $this->model->listarPeriodo();
            echo json_encode($mensaje);
        }
    }

    function listarEjercicioCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->listarEjercicioId($id);
            echo json_encode($mensaje);
        }
    }

    function listarTablaEjercicio()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $array = $this->model->listarEjercicio();
            if (count($array) > 0) {
                $data = array();
                foreach ($array as $key => $value) {
                    $estado = '';
                    if ($value['estado'] == '1') {
                        $estado = "<kbd class='bg-success'>Activado</kbd>";
                    } else {
                        $estado = "<kbd class='bg-danger'>No Activado</kbd>";
                    }
                    $datos = array(
                        'codigo' => $value['codigo'],
                        'descripcion' => $value['descripcion'],
                        'actual' => $value['actual'],
                        'estado' => $estado,
                        'check' => $value['estado'],
                        'boton' => "<div class='d-flex'><button type='button' data-periodoid = ".$value['codigo']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button data-dellid = ".$value['codigo']." type='button' class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                    );

                    array_push($data, $datos);
                }
                $mensaje['data'] = $data;
                echo json_encode($mensaje);
            } else {
                $mensaje['data'] = $array;
                echo json_encode($mensaje);
            }
        }
    }

    public function insertarEjercicio()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $descripcion = $_POST['txtdesccripcion'];
            $year = $_POST['txtyear'];
            $estado = '0';

            if (isset($_POST['chkestado'])) {
                $estado = '1';
            }

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	');
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement("Ejercicio");
            $xml->startElement("Cabecera");
            $xml->writeElement("descripcion", $descripcion);
            $xml->writeElement("year", $year);
            $xml->writeElement("estado", $estado);
            $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory();
            $mensaje = $this->model->insertEjercicio($content);
            echo json_encode($mensaje);
        }
    }

    public function actualizarEjercicio()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['txtidejercicio'];
            $descripcion = $_POST['txtdesccripcionEdit'];
            $year = $_POST['txtyearEdit'];
            $estado = '0';

            if (isset($_POST['chkestadoEdit'])) {
                $estado = '1';
            }

            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	');
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement("Ejercicio");
            $xml->startElement("Cabecera");
            $xml->writeElement("codigo", $codigo);
            $xml->writeElement("descripcion", $descripcion);
            $xml->writeElement("year", $year);
            $xml->writeElement("estado", $estado);
            $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory();
            $mensaje = $this->model->updateEjercicio($content);
            echo json_encode($mensaje);
        }
    }
}
