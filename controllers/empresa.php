<?php
class Empresa extends Controller
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
        $this->view->js = array("empresa/js/script-empresa.js");
    }
    public function index()
    {
        if (Session::get('rutas')[0]['estado'] == '1') {
            $this->view->render('empresa/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }        
    }

    public function insertarEmpresa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Session::get('idperfil') == 1) {
                $tipodoc = $_POST['cmbdocumP'];
                $nrodoc = $_POST['dniP'];
                $direccion = strtoupper($_POST['direccionP']);
                $razonsocial = strtoupper($_POST['razonsocialP']);
                $nombrecomercial = strtoupper($_POST['nombrecomercialP']);
                $pais = $_POST['txtpais'];
                $ubigeo = $_POST['txtubigeo'];
                $depar = $_POST['txtdepartamento'];
                $provi = $_POST['txtprovincia'];
                $dist = $_POST['txtdistrito'];

                $usuario_sol = $_POST['txtusuariosol'];
                $clave_sol = $_POST['txtclavesol'];

                $fe_nota = $_POST['txtmodonota'];
                $fe_guia = $_POST['txtmodoguia'];

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
                $xml->startElement("Empresa");
                $xml->startElement("Cabecera");
                $xml->writeElement("tipodoc", $tipodoc);
                $xml->writeElement("ruc", $nrodoc);
                $xml->writeElement("razon_social", $razonsocial);
                $xml->writeElement("nombre_comercial", $nombrecomercial);
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("idpais", $pais);
                $xml->writeElement("departamento", $lugar['departamento']);
                $xml->writeElement("provincia", $lugar['provincia']);
                $xml->writeElement("distrito", $lugar['distrito']);
                $xml->writeElement("ubigeo", $ubigeo);
                $xml->writeElement("usuario_sol", $usuario_sol);
                $xml->writeElement("clave_sol", $clave_sol);
                $xml->writeElement("modo_ft_notas", $fe_nota);
                $xml->writeElement("modo_guias", $fe_guia);
                $xml->writeElement("estado", $estado);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->insertEmpresa($content);
                echo json_encode($mensaje);
            } else {
                echo json_encode('NO PUEDE GUARDAR EMPRESA, NO TIENE ACCESO A ESTE MODULO');
            }
        }
    }

    public function actualizarEmpresa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Session::get('idperfil') == 1) {
                $tipodoc = $_POST['cmbdocumPEdit'];
                $nrodoc = $_POST['dniPEdit'];
                $direccion = strtoupper($_POST['direccionPEdit']);
                $razonsocial = strtoupper($_POST['razonsocialPEdit']);
                $nombrecomercial = strtoupper($_POST['nombrecomercialPEdit']);
                $codigo = $_POST['txtcodigo'];
                $pais = $_POST['txtpaisEdit'];
                $ubigeo = $_POST['txtubigeoEdit'];
                $depar = $_POST['txtdepartamentoEdit'];
                $provi = $_POST['txtprovinciaEdit'];
                $dist = $_POST['txtdistritoEdit'];
                $usuario_sol = $_POST['txtusuariosolEdit'];
                $clave_sol = $_POST['txtclavesolEdit'];
                $fe_nota = $_POST['txtmodonotaEdit'];
                $fe_guia = $_POST['txtmodoguiaEdit'];

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
                $xml->startElement("Empresa");
                $xml->startElement("Cabecera");
                $xml->writeElement("codigo", $codigo);
                $xml->writeElement("ruc", $nrodoc);
                $xml->writeElement("razon_social", $razonsocial);
                $xml->writeElement("nombre_comercial", $nombrecomercial);
                $xml->writeElement("direccion", $direccion);
                $xml->writeElement("idpais", $pais);
                $xml->writeElement("departamento", $lugar['departamento']);
                $xml->writeElement("provincia", $lugar['provincia']);
                $xml->writeElement("distrito", $lugar['distrito']);
                $xml->writeElement("ubigeo", $ubigeo);
                $xml->writeElement("usuario_sol", $usuario_sol);
                $xml->writeElement("clave_sol", $clave_sol);
                $xml->writeElement("modo_ft_notas", $fe_nota);
                $xml->writeElement("modo_guias", $fe_guia);
                $xml->writeElement("estado", $estado);
                $xml->endElement();
                $xml->endElement();
                $content = $xml->outputMemory();
                $mensaje = $this->model->updateEmpresa($content);
                echo json_encode($mensaje);
            } else {
                echo json_encode('NO PUEDE MODIFICAR EMPRESA, NO TIENE ACCESO A ESTE MODULO');
            }
        }
    }

    function eliminarEmpresa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->deleteEmpresa($id);
            echo json_encode($mensaje);
        }
    }

    
    function listarEmpresaCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $mensaje = $this->model->obtenerEmpresa($id);
            echo json_encode($mensaje);
        }
    }

    function listarTablaEmpresa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $array = $this->model->listarEmpresa();
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
                        'tipodoc' => $value['tipodoc'],
                        'ruc' => $value['ruc'],
                        'razon_social' => $value['razon_social'],
                        'nombre_comercial' => $value['nombre_comercial'],
                        'direccion' => $value['direccion'],
                        'idpais' => $value['idpais'],
                        'departamento' => $value['departamento'],
                        'provincia' => $value['provincia'],
                        'distrito' => $value['distrito'],
                        'ubigeo' => $value['ubigeo'],
                        'usuario_sol_sec' => $value['usuario_sol_sec'],
                        'clave_sol_sec' => $value['clave_sol_sec'],
                        'modo_ft_notas' => $value['modo_ft_notas'],
                        'modo_guias' => $value['modo_guias'],
                        'estado' => $estado,
                        'check' => $value['estado'],
                        'boton' => "<div class='d-flex'><button type='button' data-empresaid = ".$value['codigo']." class='editar btn btn-info btn-xs'><i class='fas fa-pencil-alt'></i></button><button data-dellid = ".$value['codigo']." type='button' class='eliminar ml-2  btn btn-danger btn-xs'><i class='fas fa-trash-alt'></i></button></div>"
                    );
                    array_push($data, $datos);
                }
                $mensaje['data'] = $data;
                echo json_encode($mensaje);
            } else {
                $mensaje['data'] = $array;
                echo json_encode($mensaje);
            }

           // $mensaje['data'] = $array;
           // echo json_encode($mensaje);
        }
    }

    function listarSelect()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->render('empresa/combobox/select', true);
        }
    }

    function listarTablaPais()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarPais();
            $this->view->render('empresa/combobox/selectPais', true);
        }
    }

    function listarTablaPaisEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarPais();
            $this->view->render('empresa/combobox/selectPaisEdit', true);
        }
    }

    function listarTablaDepartamento()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarDepartamento();
            $this->view->render('empresa/combobox/selectDepartamento', true);
        }
    }

    function listarTablaDepartamentoEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarDepartamento();
            $this->view->render('empresa/combobox/selectDepartamentoEdit', true);
        }
    }

    function listarTablaProvincia()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['codigo'];
            $this->view->Listar = $this->model->listarProvincia($codigo);
            $this->view->render('empresa/combobox/selectProvincia', true);
        }
    }

    function listarTablaProvinciaEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['codigo'];
            $this->view->Listar = $this->model->listarProvincia($codigo);
            $this->view->render('empresa/combobox/selectProvinciaEdit', true);
        }
    }

    function listarTablaDistrito()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $provin = $_POST['provin'];
            $depar = $_POST['depar'];
            $this->view->Listar = $this->model->listarDistrito($depar, $provin);
            $this->view->render('empresa/combobox/selectDistrito', true);
        }
    }

    function listarTablaDistritoEdit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $provin = $_POST['provin'];
            $depar = $_POST['depar'];
            $this->view->Listar = $this->model->listarDistritoEdit($depar, $provin);
            $this->view->render('empresa/combobox/selectDistritoEdit', true);
        }
    }
}
