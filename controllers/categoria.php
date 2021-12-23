<?php

class Categoria extends Controller
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
        $this->view->js = array("categoria/js/script-categoria.js"); 
    }
    public function index() { 
        if (Session::get('rutas')[5]['estado'] == '1') {
            $this->view->render('categoria/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }         
    }

    function tablaCategoria() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variable = $this->model->listarCategoria();
            $data = array();
            foreach ($variable as $key => $value) {
                $datos = array(
                    'codigo' => $value['codigo'],
                    'descripcion' => $value['descripcion'],
                    'boton' => "<div class='d-flex'><button type='button' data-categoriaid = ".$value['codigo']." data-categorianom = ".$value['descripcion']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-categoriaid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }
            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }
    function tablaTipoArticulo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variable = $this->model->listarTipoArticulo();
            $data = array();
            foreach ($variable as $key => $value) {
                $datos = array(
                    'codigo' => $value['codigo'],
                    'descripcion' => $value['descripcion'],
                    'boton' => "<div class='d-flex'><button type='button' data-articuloid = ".$value['codigo']." data-articulonom = ".$value['descripcion']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-articuloid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                );

                array_push($data, $datos);
            }
            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function insertarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $descrip = strtoupper($_POST['txtdescripcionC']);
            $mensaje = $this->model->insertCategoria($descrip);
            echo json_encode($mensaje);
        }
    }

    function actualizarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['txtidcategoria'];
            $descrip = strtoupper($_POST['txtdescripcionCEdit']);
            $mensaje = $this->model->updateCategoria($id,$descrip);
            echo json_encode($mensaje);
        }
    }

    function eliminarCategoria()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteCategoria($id);
            echo json_encode($mensaje);
        }
    }

    function insertarTipoArticulo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $descrip = strtoupper($_POST['txtdescripcionT']);
            $mensaje = $this->model->insertTipoArticulo($descrip);
            echo json_encode($mensaje);
        }
    }

    function actualizarTipoArticulo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['txtidarticulo'];
            $descrip = strtoupper($_POST['txtdescripcionTEdit']);
            $mensaje = $this->model->updateTipoArticulo($id,$descrip);
            echo json_encode($mensaje);
        }
    }

    function eliminarTipoArticulo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteTipoArticulo($id);
            echo json_encode($mensaje);
        }
    }
}
