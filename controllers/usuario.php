<?php

class Usuario extends Controller
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
        $this->view->js = array("usuario/js/script-usuario.js");
    }
    public function index()
    {
        if (Session::get('rutas')[29]['estado'] == '1') {
            $this->view->render('usuario/index');
        } else {
            $this->view->render('error/error');
        }
    }

    function listarTablaUsuario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Session::get('idperfil') == 1 || Session::get('idperfil') == 2) {
                $variable = $this->model->listarUsuarioAll();
            }else{
                $variable = $this->model->listarUsuario();  
            }
            $data = array();
            foreach ($variable as $key => $value) {
                $estado = '';
                    if ($value['estado'] == '1') {
                        $estado = "<kbd class='bg-success'>Activado</kbd>";
                    } else {
                        $estado = "<kbd class='bg-danger'>No Activado</kbd>";
                    }

                $datos = array(
                    'codigo' => $value['codigo'],
                    'nombres' => $value['nombre'].' '.$value['apep'].' '.$value['apem'],
                    'telefono' => $value['telefono'],
                    'direccion' => $value['direccion'],
                    'usuario' => $value['usuario'],
                    'perfil' => $value['perfil'],
                    'almacen' => $value['almacen'],
                    'estado' => $estado,
                    'boton' => "<div class='d-flex'><button type='button' data-usuarioid = ".$value['codigo']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button type='button' data-usuarioid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button><button type='button' data-usuarioid = ".$value['codigo']." class='permiso ml-2  btn btn-warning btn-xs'><i class='fas fa-key'></i></button></div>",
                    'add' => "<button type='button' data-usuarioid = ".$value['codigo']." class='add btn btn-warning btn-xs'><i class='far fa-hand-point-up'></i></button>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function listarAccesoAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = Session::get('au_tabla');
            $variable = $this->model->AccesoAlmacen($id);
            $data = array();
            foreach ($variable as $key => $value) { 
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
                    'sucursal' => $value['sucursal'],
                    'estado' => $estado,
                    'boton' => "<div class='d-flex'><button type='button' data-accesoid = ".$value['codigo']." class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button><button type='button' data-estadoid = ".$value['codigo']." class='estado ml-2  btn btn-info btn-xs'><i class='fas fa-check-square'></i></button></div>"
                );

                array_push($data, $datos);
            }

            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    function empresaCA()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user =  Session::get('codUser');
            $this->view->Listar = $this->model->listarEmpresaCA($user);
            $this->view->render('usuario/combobox/empresa', true);
        }
    }

    function sucursalCA()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id =  $_POST['id'];
            $this->view->Listar = $this->model->listarSucursalCA($id);
            $this->view->render('usuario/combobox/sucursal', true);
        }
    }

    function CambioAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idalmacen =  $_POST['idalmacen'];
            $idsucursal =  $_POST['idsucursal'];
            $nombre_almacen =  $_POST['nombre_almacen'];
            $nombre_sucursal =  $_POST['nombre_sucursal'];
            $idusuario =  Session::get('codUser');
            $mensaje = $this->model->validarAccessoAlmacen($idusuario,$idalmacen);

            Session::set('idalmacen',$idalmacen); 
            Session::set('almacen',$nombre_almacen); 
            Session::set('idsucursal',$idsucursal); 
            Session::set('sucursal',$nombre_sucursal);
            Session::set('idCaja','0');

            echo json_encode('LISTO'); 
        }
    }

    function almacenCA()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id =  $_POST['id'];
            $this->view->Listar = $this->model->listarAlmacenCA($id);
            $this->view->render('usuario/combobox/almacen', true);
        }
    }

    function listarTablaPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarPerfil();
            $this->view->render('usuario/combobox/selectPerfil', true);
        }
    }

    function listarTablaAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarAlmacen();
            $this->view->render('usuario/combobox/selectAlmacen', true);
        }
    }

    function listarTablaSucursal()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarSucursal();
            $this->view->render('usuario/combobox/selectSucursal', true);
        }
    }

    function listarSelectnuevo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->render('usuario/combobox/selectNuevo', true);
        }
    }

    function listarAlamacenSucursal()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $this->view->Listar = $this->model->listarAlmacenIdSucursal($id);
            $this->view->render('usuario/combobox/selectAlmacenSucursal', true);
        }
    }

    function listarTablaPerfilEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarPerfil();
            $this->view->render('usuario/combobox/selectPerfilEdit', true);
        }
    }

    function listarTablaAlmacenEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarAlmacen();
            $this->view->render('usuario/combobox/selectAlmacenEdit', true);
        }
    }

    function buscarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nrodoc = $_POST['nrodoc'];
            $array = $this->model->buscarUsuarionrodoc($nrodoc);
            echo json_encode($array);            
        }
    }

    function buscarUsuarioId()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nrodoc = $_POST['id'];
            $array = $this->model->buscarUsuarioCodigo($nrodoc);
            echo json_encode($array);            
        }
    }

    function vs_usuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            Session::set('au_tabla',$id);
            echo json_encode('LISTO');            
        }
    }

    function eliminarAcceso()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nrodoc = $_POST['id'];
            $array = $this->model->deleteAcceso($nrodoc);
            echo json_encode($array);            
        }
    }

    function estadoAcceso()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $array = $this->model->accesoEstado($id);
            echo json_encode($array);            
        }
    }

    function insertarAccesso()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idalmacen = $_POST['txtalmacenidSucursal'];
            $idusuario =  $_POST['txtidusuarioacces'];
            $array = $this->model->insertAccesso($idalmacen,$idusuario);
            echo json_encode($array);            
        }
    }

    public function insertarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Session::get('idperfil') == 1 || Session::get('idperfil') == 2) {
                $dni = $_POST['txtdni'];
                $nombre = strtoupper($_POST['txtnombre']);
                $apep = strtoupper($_POST['txtapep']);
                $apem = strtoupper($_POST['txtapem']);
                $telefono = strtoupper($_POST['txttelefono']);
                $direccion = strtoupper($_POST['txtdireccion']);
                $usuario = $_POST['txtusuario'];
                $clave = $_POST['txtpass'];
                $idperfil = $_POST['txtperfil'];
                $almacen_actual = $_POST['txtalmacen'];

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Usuario");
                $xml->startElement("Cabecera");
                $xml->writeElement("dni", $dni);
                $xml->writeElement("nombre", $nombre);
                $xml->writeElement("apep", $apep);
                $xml->writeElement("apem", $apem);
                $xml->writeElement("telefono", $telefono);
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("usuario", $usuario);
                $xml->writeElement("clave", $clave);
                $xml->writeElement("idperfil", $idperfil);
                $xml->writeElement("almacen_actual", $almacen_actual);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->insertUsuario($content);
                echo json_encode($mensaje);
            } else {
                echo json_encode('NO PUEDE REGISTRAR USUARIO, NO TIENE ACCESO A ESTE MODULO');
            }
        }
    }

    public function actualizarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Session::get('idperfil') == 1 || Session::get('idperfil') == 2) {
                $id = $_POST['txtidusuario'];
                $dni = $_POST['txtdniEdit'];
                $nombre = strtoupper($_POST['txtnombreEdit']);
                $apep = strtoupper($_POST['txtapepEdit']);
                $apem = strtoupper($_POST['txtapemEdit']);
                $telefono = strtoupper($_POST['txttelefonoEdit']);
                $direccion = $_POST['txtdireccionEdit'];
                $usuario = $_POST['txtusuarioEdit'];
                $clave = $_POST['txtpassEdit'];
                $idperfil = $_POST['txtperfilEdit'];
                $almacen_actual = $_POST['txtalmacenEdit'];
                $estado = '0';

                if(isset($_POST['chkestado'])){
                    $estado = '1';
                }

                $xml = new XMLWriter();
                $xml->openMemory();
                $xml->setIndent(true);
                $xml->setIndentString('	');
                $xml->startDocument('1.0', 'UTF-8');
                $xml->startElement("Usuario");
                $xml->startElement("Cabecera");
                $xml->writeElement("codigo", $id);
                $xml->writeElement("dni", $dni);
                $xml->writeElement("nombre", $nombre);
                $xml->writeElement("apep", $apep);
                $xml->writeElement("apem", $apem);
                $xml->writeElement("telefono", $telefono);
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("usuario", $usuario);
                $xml->writeElement("clave", $clave);
                $xml->writeElement("idperfil", $idperfil);
                $xml->writeElement("almacen_actual", $almacen_actual);
                $xml->writeElement("estado", $estado);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->updateUsuario($content);
                echo json_encode($mensaje);
            } else {
                echo json_encode('NO PUEDE MODIFICAR USUARIO, NO TIENE ACCESO A ESTE MODULO');
            }
        }
    }

    function eliminarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteUsuario($id);
            echo json_encode($mensaje);
        }
    }
}
