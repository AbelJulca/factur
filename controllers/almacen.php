<?php
class Almacen extends Controller
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
        $this->view->js = array("almacen/js/script-almacen.js");
    }
    public function index()
    {
        if (Session::get('rutas')[2]['estado'] == '1') {
            $this->view->render('almacen/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarTablaSucursal()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $array = $this->model->listarSucursal();           
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
                        'ubigeo' => $value['ubigeo'],
                        'departamento' => $value['departamento'],
                        'provincia' => $value['provincia'],
                        'distrito' => $value['distrito'],
                        'direccion' => $value['direccion'], 
                        'idempresa' => $value['idempresa'],                       
                        'estado' => $estado,
                        'check' => $value['estado'],
                        'boton' => "<div class='d-flex'><button type='button' data-sucursalid = ".$value['codigo']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-sucursalid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                    );

                    array_push($data, $datos);
                }               
                $mensaje['data'] = $data;
                echo json_encode($mensaje);            
        }
    }

    function listarTablaEmpresa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarEmpresa();
            $this->view->render('almacen/combobox/selectEmpresa', true);
        }
    }

    function listarComboSucursal()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarSucursal();
            $this->view->render('almacen/combobox/selectSucursal', true);
        }
    }
    function listarComboSucursalEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarSucursal();
            $this->view->render('almacen/combobox/selectSucursalEdit', true);
        }
    }
    function listarComboComprobante()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarTipoComprobante();
            $this->view->render('almacen/combobox/selectComprobante', true);
        }
    }

    function listarTablaEmpresaEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarEmpresa();
            $this->view->render('almacen/combobox/selectEmpresaEdit', true);
        }
    }

    public function insertarSucursal()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
               
                $descripcion = strtoupper($_POST['txtdesccripcion']);
                $direccion = strtoupper($_POST['txtdireccion']);
                $empresa = $_POST['txtempresa'];                
                $ubigeo = $_POST['txtubigeo'];
                $depar = $_POST['txtdepartamento'];
                $provi = $_POST['txtprovincia'];
                $dist = $_POST['txtdistrito'];
                $estado = '0';

                if (isset($_POST['chkestado'])) {
                    $estado = '1';
                }

                $lugar = $this->model->ubigeo($depar, $provi, $dist);

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Sucursal");
                $xml->startElement("Cabecera");
                $xml->writeElement("descripcion", $descripcion);
                $xml->writeElement("empresa", $empresa);
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("departamento", $lugar['departamento']);
                $xml->writeElement("provincia", $lugar['provincia']);
                $xml->writeElement("distrito", $lugar['distrito']);
                $xml->writeElement("ubigeo", $ubigeo);
                $xml->writeElement("estado", $estado);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->insertSucursal($content);
                echo json_encode($mensaje);            
        }
    }

    public function actualizarSucursal()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
                $codigo = $_POST['txtidsuc'];
                $descripcion = strtoupper($_POST['txtdesccripcionEdit']);
                $direccion = strtoupper($_POST['txtdireccionEdit']);
                $empresa = $_POST['txtempresaEdit'];                
                $ubigeo = $_POST['txtubigeoEdit'];
                $depar = $_POST['txtdepartamentoEdit'];
                $provi = $_POST['txtprovinciaEdit'];
                $dist = $_POST['txtdistritoEdit'];
                $estado = '0';

                if (isset($_POST['chkestadoEdit'])) {
                    $estado = '1';
                }

                $lugar = $this->model->ubigeo($depar, $provi, $dist);

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Sucursal");
                $xml->startElement("Cabecera");
                $xml->writeElement("codigo", $codigo);
                $xml->writeElement("descripcion", $descripcion);
                $xml->writeElement("empresa", $empresa);
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("departamento", $lugar['departamento']);
                $xml->writeElement("provincia", $lugar['provincia']);
                $xml->writeElement("distrito", $lugar['distrito']);
                $xml->writeElement("ubigeo", $ubigeo);
                $xml->writeElement("estado", $estado);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->updateSucursal($content);
                echo json_encode($mensaje);            
        }
    }

    function obtenerSucursalCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->sucursalId($id);
            echo json_encode($mensaje);
        }
    }

    function eliminarSucursal()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteSucursal($id);
            echo json_encode($mensaje);
        }
    }

    function listarTablaAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $array = $this->model->listarAlmacen();           
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
                        'condicion' => $value['condicion'],
                        'idsucursal' => $value['idsucursal'],
                        'sucursal' => $value['sucursal'],                       
                        'estado' => $estado,
                        'check' => $value['estado'],
                        'boton' => "<div class='d-flex'><button type='button' data-almacenid = ".$value['codigo']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-almacenid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                    );

                    array_push($data, $datos);
                }
                $mensaje['data'] = $data;
                echo json_encode($mensaje);            
        }
    }

    public function insertarAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
               
                $descripcion = strtoupper($_POST['txtdescalmacen']);
                $sucursal = $_POST['txtsucursal'];                
                $condicion= $_POST['txtcondicion'];                
                $estado = '0';

                if (isset($_POST['chkalmacen'])) {
                    $estado = '1';
                }

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Almacen");
                $xml->startElement("Cabecera");
                $xml->writeElement("descripcion", $descripcion);
                $xml->writeElement("idsucursal", $sucursal);
                $xml->writeElement("condicion", $condicion);
                $xml->writeElement("estado", $estado);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->insertAlmacen($content);
                echo json_encode($mensaje);            
        }
    }

    public function actualizarAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
                $codigo = $_POST['txtidalm'];
                $descripcion = strtoupper($_POST['txtdescalmacenEdit']);
                $sucursal = $_POST['txtsucursalEdit'];                
                $condicion= $_POST['txtcondicionEdit'];                
                $estado = '0';

                if (isset($_POST['chkalmacenEdit'])) {
                    $estado = '1';
                }

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Almacen");
                $xml->startElement("Cabecera");
                $xml->writeElement("codigo", $codigo);
                $xml->writeElement("descripcion", $descripcion);
                $xml->writeElement("idsucursal", $sucursal);
                $xml->writeElement("condicion", $condicion);
                $xml->writeElement("estado", $estado);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->updateAlmacen($content);
                echo json_encode($mensaje);            
        }
    }

    function obtenerAlmacenCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->almacenId($id);
            echo json_encode($mensaje);
        }
    }

    function eliminarAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteAlmacen($id);
            echo json_encode($mensaje);
        }
    }

    public function insertarSerie()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
               if($_POST['txtidsucurser'] != ''){
                $id = $_POST['txtidsucurser'];
                $ref = $_POST['txtref'];
                $serie = strtoupper($_POST['txtserie']);
                $tipocomp = $_POST['txttipocomprobante'];
                $correlativo = 0;       

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Serie");
                    $xml->startElement("Cabecera");
                        $xml->writeElement("tipocomp", $tipocomp);
                        $xml->writeElement("serie", $serie);
                        $xml->writeElement("correlativo", $correlativo);
                        $xml->writeElement("idsucursal", $id);
                        $xml->writeElement("referencia", $ref);
                    $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->insertSerie($content);
                echo json_encode($mensaje); 
               }else{
                echo json_encode('Ingrese una Sucursal');
               }                           
        }
    }

    function listarTablaSeries()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['codigo'];
            $this->view->Listar = $this->model->listarSeriesCodigo($codigo);
            $this->view->render('almacen/tabla/tablaSeries', true);
        }
    }
    function eliminarSerieCodido()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo_d = $_POST['codigo_d'];
            $codigo_s = $_POST['codigo_s'];
            $mensaje = $this->model->deleteSerie($codigo_d,$codigo_s);
            echo json_encode($mensaje);
        }
    }

}
