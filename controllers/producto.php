<?php
class Producto extends Controller
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
        $this->view->js = array("producto/js/script-producto.js"); 
    }

    public function index() 
    {
        if (Session::get('rutas')[6]['estado'] == '1') {
            $this->view->render('producto/index');
        } else {
            $this->view->render('error/error');# code...
        }   
    }

    function buscarProductoCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['codigo'];
            $array = $this->model->buscarProductoId($codigo);
            echo json_encode($array);            
        }
    }

    function listarTablaArticulo() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variable = $this->model->listarArticulo();
            $data = array();
            foreach ($variable as $key => $value) {
                $estado = ($value['estado'] == '1') ? "<kbd class='bg-success'>Activado</kbd>":"<kbd class='bg-danger'>No Activado</kbd>";
                   
                $datos = array(
                    'codigo' => $value['codigo'],
                    'nombre_comercial' => $value['nombre_comercial'],
                    'idcategoria' => $value['idcategoria'],
                    'categoria' => $value['categoria'],
                    'sku' => $value['sku'],
                    'idafectacion' => $value['idafectacion'],
                    'afectacion' => $value['afectacion'],
                    'porcentaje_ganancia' => $value['porcentaje_ganancia'],
                    'idunidad' => $value['idunidad'],
                    'estado' => $estado,
                    'idestado' => $value['estado'],
                    'boton' => "<div class='d-flex'><button type='button' data-productoid = ".$value['codigo']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-productoid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function listarTablaUnidad()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarUnidad();
            $this->view->render('producto/combobox/selectUnidad', true);
        }
    }

    function listarTablaCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarCategoria();
            $this->view->render('producto/combobox/selectCategoria', true);
        }
    }

    function listarTablaTipo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarTipo();
            $this->view->render('producto/combobox/selectTipo', true);
        }
    }

    function listarTablaLaboratorio()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarTablaLaboratorio();
            $this->view->render('producto/combobox/selectLaboratorio', true);
        }
    }

    function listarTablaAfectacion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarTablaAfectacion();
            $this->view->render('producto/combobox/selectAfectacion', true);
        }
    }

    //**************************** MODIFICAR  ************************/
    function listarTablaUnidadEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarUnidad();
            $this->view->render('producto/combobox/selectUnidadEdit', true);
        }
    }

    function listarTablaCategoriaEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarCategoria();
            $this->view->render('producto/combobox/selectCategoriaEdit', true);
        }
    }

    function listarTablaTipoEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarTipo();
            $this->view->render('producto/combobox/selectTipoEdit', true);
        }
    }

    function listarTablaLaboratorioEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarTablaLaboratorio();
            $this->view->render('producto/combobox/selectLaboratorioEdit', true);
        }
    }

    function listarTablaAfectacionEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            
            $this->view->Listar = $this->model->listarTablaAfectacion();
            $this->view->render('producto/combobox/selectAfectacionEdit', true);
        }
    }
    //*************************************************************** */

    public function insertarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
                $sku = $_POST['txtsku'];
                $idunidad = $_POST['txtunidad'];                
                $nombre_comercial = strtoupper($_POST['txtnombre_comercial']);
                $idcategoria = $_POST['txtcategoria'];
                $idafectacion = $_POST['txtafectacion'];
                $porcentaje = $_POST['txtporcentaje'];

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Articulo");
                $xml->startElement("Cabecera");
                $xml->writeElement("nombre_comercial", $nombre_comercial);
                $xml->writeElement("idcategoria", $idcategoria);
                $xml->writeElement("sku", $sku);
                $xml->writeElement("idafectacion", $idafectacion);
                $xml->writeElement("porcentaje", $porcentaje);
                $xml->writeElement("idunidad", $idunidad);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->insertProducto($content);
                echo json_encode($mensaje);            
        }
    }

    public function actualizarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $codigo = $_POST['txtidproducto'];
                $sku = $_POST['txtskuEdit'];
                $idunidad = $_POST['txtunidadEdit'];                
                $nombre_comercial = strtoupper($_POST['txtnombre_comercialEdit']);
                $idcategoria = $_POST['txtcategoriaEdit'];
                $idafectacion = $_POST['txtafectacionEdit'];
                $porcentaje = $_POST['txtporcentajeEdit'];

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Articulo");
                $xml->startElement("Cabecera");
                $xml->writeElement("codigo", $codigo);
                $xml->writeElement("nombre_comercial", $nombre_comercial);
                $xml->writeElement("idcategoria", $idcategoria);
                $xml->writeElement("sku", $sku);
                $xml->writeElement("idafectacion", $idafectacion);
                $xml->writeElement("porcentaje", $porcentaje);
                $xml->writeElement("idunidad", $idunidad);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->updateProducto($content);
                echo json_encode($mensaje);            
        }
    }

    function eliminarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteProducto($id);
            echo json_encode($mensaje);
        }
    }
}
