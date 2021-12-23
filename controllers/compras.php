<?php
class Compras extends Controller
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
        $this->view->js = array("compras/js/script-compras.js");
    }
    
    public function index()
    {
        if (Session::get('rutas')[10]['estado'] == '1') {
            $this->view->render('compras/index');# code...
        } else {
            $this->view->render('error/error');# code...
        } 
    }  

    function ListarComboDocumento() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarTipoDocumento();
            $this->view->render('compras/combobox/selectTipoDocumento', true);
        }
    }

    function ListarComboYearContable() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarEjercicio();
            $this->view->render('compras/combobox/selectYearContable', true);
        }
    }

    function ListarComboPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarPeriodo();
            $this->view->render('compras/combobox/selectPeriodo', true);
        }
    }

    function ListarComboFormaPago() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarFormaPago();
            $this->view->render('compras/combobox/selectFormaPago', true);
        }
    }    

    function buscarOrdenCompra() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $serie = $_POST['serie'];
            $correlativo = $_POST['correlativo'];
            $mensaje = $this->model->listarOrdenCompra($serie,$correlativo);
            echo json_encode($mensaje);
        }
    }

    function validarPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fecha = date('Y-m-d');
            $mensaje = $this->model->listarvalidarPeriodo($fecha);
            echo json_encode($mensaje);
        }
    }

    function ListarVentaNew() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['carrito_compras'])) {
                $this->view->carrito = $_SESSION['carrito_compras'];
                //-------------- INICIO DE CALCULO DE TOTALES -------//
            $this->view->op_gravadas = 0.00;
            $this->view->op_exoneradas = 0.00;
            $this->view->op_inafectas = 0.00;
            $this->view->op_icbper = 0.00;
            $this->view->igv = 0.0;
            $this->view->igv_porcentaje = 0.18;
            $this->view->igv_gravada = 1.18;
            $this->view->total = 0.00;

            foreach ($this->view->carrito as $K => $v) {
                if ($v['idafectacion'] == '10') {
                    $this->view->op_gravadas = $this->view->op_gravadas + $v['precio'] * $v['cantidad'];
                }

                if ($v['idafectacion'] == '20') {
                    $this->view->op_exoneradas = $this->view->op_exoneradas + $v['precio'] * $v['cantidad'];
                }

                if ($v['idafectacion'] == '30') {
                    $this->view->op_inafectas = $this->view->op_inafectas + $v['precio'] * $v['cantidad'];
                }

                if ($v['cant_icbper'] > 0) {
                    $this->view->op_icbper = $this->view->op_icbper + ($v['cant_icbper'] * $v['imps_icbper']);
                }
            }

            $this->view->op_gravadas = $this->view->op_gravadas / $this->view->igv_gravada;

            $this->view->igv = $this->view->op_gravadas * $this->view->igv_porcentaje;

            $this->view->total = $this->view->total + $this->view->op_gravadas + $this->view->op_exoneradas + $this->view->op_inafectas + $this->view->igv + $this->view->op_icbper;
            //$this->view->total = $this->view->op_gravadas;
            //----- FIN DEL CALCULO DE TOTALES --------//

            $this->view->render('compras/tabla/tablaVenta', true);

            }else{
                $this->view->render('compras/tabla/tablaVentaNew', true);
            }
        }
    }

    function ListarDetalleOrden() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = $_POST['codigo'];
            $detalle = $this->model->listarDetalleOrdenCompra($codigo);
            
            if (!isset($_SESSION['carrito_compras'])) {
                $_SESSION['carrito_compras'] = array();
            }else{
                unset($_SESSION['carrito_compras']);
                $_SESSION['carrito_compras'] = array();
            }

            $this->view->carrito = array();

            foreach ($detalle as $key => $value) {
                $canasta = array(
                    'codigo' => $value['codigo'],
                    'sku' => $value['sku'],
                    'nombre_comercial' => $value['nombre_comercial'],
                    'fecha_vencimiento' => '',                        
                    'precio' => $value['precio_unitario'],
                    'idunidad' => $value['idunidad'],
                    'idafectacion' => $value['idafectacion'],
                    'cant_icbper' => $value['cant_icbper'],
                    'imps_icbper' => $value['imps_icbper'],
                    'cantidad' => $value['cantidad'], 
                    'valor_unitario' => number_format($value['valor_unitario'], 2, '.', ''), //SIN IGV
                    'precio_unitario' => number_format($value['precio_unitario'], 2, '.', ''), //CON IGV                    
                    'igv' => number_format($value['igv'], 2, '.', ''),
                    'porcentaje_igv' => $value['porcentaje_igv'],
                    'valor_total' => number_format($value['valor_total'], 2, '.', ''), //SIN IGV
                    'importe_total' => number_format($value['importe_total'], 2, '.', '') //CON IGV
                );
                array_push($this->view->carrito, $canasta);
            }

            $_SESSION['carrito_compras'] = $this->view->carrito;

            //------------------ FIN LOGICA DE CARRITO ---------- //
            //-------------- INICIO DE CALCULO DE TOTALES -------//
            $this->view->op_gravadas = 0.00;
            $this->view->op_exoneradas = 0.00;
            $this->view->op_inafectas = 0.00;
            $this->view->op_icbper = 0.00;
            $this->view->igv = 0.0;
            $this->view->igv_porcentaje = IGV_PORC;;
            $this->view->igv_gravada = IGV_GRAVADA;
            $this->view->total = 0.00;

            foreach ($this->view->carrito as $K => $v) {
                if ($v['idafectacion'] == '10') {
                    $this->view->op_gravadas = $this->view->op_gravadas + $v['precio'] * $v['cantidad'];
                }
                if ($v['idafectacion'] == '20') {
                    $this->view->op_exoneradas = $this->view->op_exoneradas + $v['precio'] * $v['cantidad'];
                }
                if ($v['idafectacion'] == '30') {
                    $this->view->op_inafectas = $this->view->op_inafectas + $v['precio'] * $v['cantidad'];
                }
                if ($v['cant_icbper'] > 0) {
                    $this->view->op_icbper = $this->view->op_icbper + ($v['cant_icbper'] * $v['imps_icbper']);
                }
            }

            $this->view->op_gravadas = $this->view->op_gravadas / $this->view->igv_gravada;

            $this->view->igv = $this->view->op_gravadas * $this->view->igv_porcentaje;

            $this->view->total = $this->view->total + $this->view->op_gravadas + $this->view->op_exoneradas + $this->view->op_inafectas + $this->view->igv + $this->view->op_icbper;
            
            $this->view->render('compras/tabla/tablaVenta', true);
        }
    }

    function agregarCarrito() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ----- INICIO LOGICA DE CARRITO ----- //
            $codigo = $_POST['codigo'];
            $preciocompra = $_POST['precio'];
            $incluyeigv = $_POST['igv'];
            $fechav = $_POST['fecha'];
            $cantidad_agregar = 1;

            if (isset($_POST['cantidad'])) {
                if ($_POST['cantidad'] != '') {
                    $cantidad_agregar = $_POST['cantidad'];
                }
            }

            $articulo = $this->model->obtenerProductoCodigo($codigo);
            if (!isset($_SESSION['carrito_compras'])) {
                $_SESSION['carrito_compras'] = array();
            }
            $this->view->carrito = $_SESSION['carrito_compras'];

            $item = count($this->view->carrito) + 1;
            $cantidad = $cantidad_agregar;
            $existe = false;
            foreach ($this->view->carrito as $k => $v) {
                if ($v['codigo'] == $_POST['codigo']) {
                    $item = $k;
                    $existe = true;
                    break;
                }
            }

            $canticbper = 0;
            $impsicbper = ICBPER;
            $igv_porcentaje = IGV_PORC;
            $igv_gravada = IGV_GRAVADA;
            if (!$existe) {
                $igv_detalle = 0;
                $factor_porcentaje = 1;
                if($incluyeigv == '0'){
                    if ($articulo['idafectacion'] == 10) {
                        $igv_detalle = ($preciocompra * $cantidad) * $igv_porcentaje;
                        $factor_porcentaje = 1 + $igv_porcentaje;
                    }
                    if ($articulo['idunidad'] == 'BG') {
                        $canasta = array(
                            'codigo' => $articulo['codigo'],
                            'sku' => $articulo['sku'],
                            'nombre_comercial' => $articulo['nombre_comercial'],
                            'fecha_vencimiento' => $fechav,                          
                            'precio' => $preciocompra * $factor_porcentaje,
                            'idunidad' => $articulo['idunidad'],
                            'idafectacion' => $articulo['idafectacion'],
                            'cant_icbper' => $cantidad,
                            'imps_icbper' => $impsicbper,
                            'cantidad' => $cantidad, 
                            'valor_unitario' => number_format($preciocompra, 2, '.', ''), //SIN IGV
                            'precio_unitario' => number_format($preciocompra * $factor_porcentaje, 2, '.', ''), //CON IGV                    
                            'igv' => number_format($igv_detalle, 2, '.', ''),
                            'porcentaje_igv' => $igv_porcentaje * 100,
                            'valor_total' => number_format($preciocompra * $cantidad, 2, '.', ''), //SIN IGV
                            'importe_total' => number_format(($preciocompra * $factor_porcentaje) * $cantidad, 2, '.', '') //CON IGV
                        );
                        array_push($this->view->carrito, $canasta);
                    } else {
                        $canasta = array(
                            'codigo' => $articulo['codigo'],
                            'sku' => $articulo['sku'],
                            'nombre_comercial' => $articulo['nombre_comercial'],
                            'fecha_vencimiento' => $fechav,
                            'precio' => $preciocompra * $factor_porcentaje,
                            'idunidad' => $articulo['idunidad'],
                            'idafectacion' => $articulo['idafectacion'],
                            'cant_icbper' => $canticbper,
                            'imps_icbper' => $impsicbper,
                            'cantidad' => $cantidad,
                            'valor_unitario' => number_format($preciocompra, 2, '.', ''),
                            'precio_unitario' => number_format($preciocompra * $factor_porcentaje, 2, '.', ''),                    
                            'igv' => number_format($igv_detalle, 2, '.', ''),
                            'porcentaje_igv' => $igv_porcentaje * 100,
                            'valor_total' => number_format($preciocompra * $cantidad, 2, '.', ''),
                            'importe_total' => number_format(($preciocompra * $factor_porcentaje) * $cantidad , 2, '.', '')
                        );
                        array_push($this->view->carrito, $canasta);
                    }
                }else{
                    if ($articulo['idafectacion'] == 10) {
                        $igv_detalle = (($preciocompra * $cantidad) / $igv_gravada) * $igv_porcentaje;
                        $factor_porcentaje = 1 + $igv_porcentaje;
                    }
                    if ($articulo['idunidad'] == 'BG') {
                        $canasta = array(
                            'codigo' => $articulo['codigo'],
                            'sku' => $articulo['sku'],
                            'nombre_comercial' => $articulo['nombre_comercial'],
                            'fecha_vencimiento' => $fechav,                       
                            'precio' => $preciocompra,
                            'idunidad' => $articulo['idunidad'],
                            'idafectacion' => $articulo['idafectacion'],
                            'cant_icbper' => $cantidad,
                            'imps_icbper' => $impsicbper,
                            'cantidad' => $cantidad, 
                            'valor_unitario' => number_format($preciocompra/ $factor_porcentaje, 2, '.', ''), //SIN IGV
                            'precio_unitario' => number_format($preciocompra, 2, '.', ''), //CON IGV                    
                            'igv' => number_format($igv_detalle, 2, '.', ''),
                            'porcentaje_igv' => $igv_porcentaje * 100,
                            'valor_total' => number_format(($preciocompra / $factor_porcentaje) * $cantidad, 2, '.', ''), //SIN IGV
                            'importe_total' => number_format(($preciocompra * $cantidad), 2, '.', '') //CON IGV
                        );
                        array_push($this->view->carrito, $canasta);
                    } else {
                        $canasta = array(
                            'codigo' => $articulo['codigo'],
                            'sku' => $articulo['sku'],
                            'nombre_comercial' => $articulo['nombre_comercial'],
                            'fecha_vencimiento' => $fechav,
                            'precio' => $preciocompra,
                            'idunidad' => $articulo['idunidad'],
                            'idafectacion' => $articulo['idafectacion'],
                            'cant_icbper' => $canticbper,
                            'imps_icbper' => $impsicbper,
                            'cantidad' => $cantidad,
                            'valor_unitario' => number_format($preciocompra/ $factor_porcentaje, 2, '.', ''),
                            'precio_unitario' => number_format($preciocompra, 2, '.', ''),                    
                            'igv' => number_format($igv_detalle, 2, '.', ''),
                            'porcentaje_igv' => $igv_porcentaje * 100,
                            'valor_total' => number_format(($preciocompra / $factor_porcentaje) * $cantidad, 2, '.', ''),
                            'importe_total' => number_format(($preciocompra * $cantidad) , 2, '.', '')
                        );
                        array_push($this->view->carrito, $canasta);
                    }
                }
            } else {
                //$carrito[$item]['cantidad']++;
                
                 if ($articulo['idunidad'] == 'BG') {
                     $this->view->carrito[$item]['cant_icbper'] = $this->view->carrito[$item]['cant_icbper'] +$cantidad_agregar;
                     $this->view->carrito[$item]['cantidad'] = $this->view->carrito[$item]['cantidad'] + $cantidad_agregar;
                 }else{
                     $this->view->carrito[$item]['cantidad'] = $this->view->carrito[$item]['cantidad'] + $cantidad_agregar;
                 }
                
            }


            
            $_SESSION['carrito_compras'] = $this->view->carrito;

            //------------------ FIN LOGICA DE CARRITO ---------- //
            //-------------- INICIO DE CALCULO DE TOTALES -------//
            $this->view->op_gravadas = 0.00;
            $this->view->op_exoneradas = 0.00;
            $this->view->op_inafectas = 0.00;
            $this->view->op_icbper = 0.00;
            $this->view->igv = 0.0;
            $this->view->igv_porcentaje = IGV_PORC;;
            $this->view->igv_gravada = IGV_GRAVADA;
            $this->view->total = 0.00;

            foreach ($this->view->carrito as $K => $v) {
                if ($v['idafectacion'] == '10') {
                    $this->view->op_gravadas = $this->view->op_gravadas + $v['precio'] * $v['cantidad'];
                }
                if ($v['idafectacion'] == '20') {
                    $this->view->op_exoneradas = $this->view->op_exoneradas + $v['precio'] * $v['cantidad'];
                }
                if ($v['idafectacion'] == '30') {
                    $this->view->op_inafectas = $this->view->op_inafectas + $v['precio'] * $v['cantidad'];
                }
                if ($v['cant_icbper'] > 0) {
                    $this->view->op_icbper = $this->view->op_icbper + ($v['cant_icbper'] * $v['imps_icbper']);
                }
            }

            $this->view->op_gravadas = $this->view->op_gravadas / $this->view->igv_gravada;

            $this->view->igv = $this->view->op_gravadas * $this->view->igv_porcentaje;

            $this->view->total = $this->view->total + $this->view->op_gravadas + $this->view->op_exoneradas + $this->view->op_inafectas + $this->view->igv + $this->view->op_icbper;
            
            $this->view->render('compras/tabla/tablaVenta', true);
        }
    } 

    function ItemDellCarrito() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ----- INICIO LOGICA DE CARRITO ----- //
            $codigo = $_POST['codigo'];

            $this->view->carrito = $_SESSION['carrito_compras'];
            $existe = false;
            $item = 0;
            foreach ($this->view->carrito as $k => $v) {
                if ($v['codigo'] == $_POST['codigo']) {
                    unset($this->view->carrito[$k]);
                    $existe = true;
                    break;
                }
            }

            $_SESSION['carrito_compras'] = $this->view->carrito;

            //------------------ FIN LOGICA DE CARRITO ---------- //
            //-------------- INICIO DE CALCULO DE TOTALES -------//
            $this->view->op_gravadas = 0.00;
            $this->view->op_exoneradas = 0.00;
            $this->view->op_inafectas = 0.00;
            $this->view->op_icbper = 0.00;
            $this->view->igv = 0.0;
            $this->view->igv_porcentaje = 0.18;
            $this->view->igv_gravada = 1.18;
            $this->view->total = 0.00;

            foreach ($this->view->carrito as $K => $v) {
                if ($v['idafectacion'] == '10') {
                    $this->view->op_gravadas = $this->view->op_gravadas + $v['precio'] * $v['cantidad'];
                }

                if ($v['idafectacion'] == '20') {
                    $this->view->op_exoneradas = $this->view->op_exoneradas + $v['precio'] * $v['cantidad'];
                }

                if ($v['idafectacion'] == '30') {
                    $this->view->op_inafectas = $this->view->op_inafectas + $v['precio'] * $v['cantidad'];
                }

                if ($v['cant_icbper'] > 0) {
                    $this->view->op_icbper = $this->view->op_icbper + ($v['cant_icbper'] * $v['imps_icbper']);
                }
            }

            $this->view->op_gravadas = $this->view->op_gravadas / $this->view->igv_gravada;

            $this->view->igv = $this->view->op_gravadas * $this->view->igv_porcentaje;

            $this->view->total = $this->view->total + $this->view->op_gravadas + $this->view->op_exoneradas + $this->view->op_inafectas + $this->view->igv + $this->view->op_icbper;
            //$this->view->total = $this->view->op_gravadas;
            //----- FIN DEL CALCULO DE TOTALES --------//

            $this->view->render('compras/tabla/tablaVenta', true);
        }
    }

    function editFechaCarrito() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ----- INICIO LOGICA DE CARRITO ----- //
            $codigo = $_POST['codigo'];
            $fechav = $_POST['fecha'];

            $this->view->carrito = $_SESSION['carrito_compras'];
            $existe = false;
            $item = 0;
            foreach ($this->view->carrito as $k => $v) {
                if ($v['codigo'] == $_POST['codigo']) {                    
                    $existe = true;
                    $this->view->carrito[$k]['fecha_vencimiento'] = $fechav;
                    break;
                }
            }

            $_SESSION['carrito_compras'] = $this->view->carrito;

            //------------------ FIN LOGICA DE CARRITO ---------- //
            //-------------- INICIO DE CALCULO DE TOTALES -------//
            $this->view->op_gravadas = 0.00;
            $this->view->op_exoneradas = 0.00;
            $this->view->op_inafectas = 0.00;
            $this->view->op_icbper = 0.00;
            $this->view->igv = 0.0;
            $this->view->igv_porcentaje = 0.18;
            $this->view->igv_gravada = 1.18;
            $this->view->total = 0.00;

            foreach ($this->view->carrito as $K => $v) {
                if ($v['idafectacion'] == '10') {
                    $this->view->op_gravadas = $this->view->op_gravadas + $v['precio'] * $v['cantidad'];
                }

                if ($v['idafectacion'] == '20') {
                    $this->view->op_exoneradas = $this->view->op_exoneradas + $v['precio'] * $v['cantidad'];
                }

                if ($v['idafectacion'] == '30') {
                    $this->view->op_inafectas = $this->view->op_inafectas + $v['precio'] * $v['cantidad'];
                }

                if ($v['cant_icbper'] > 0) {
                    $this->view->op_icbper = $this->view->op_icbper + ($v['cant_icbper'] * $v['imps_icbper']);
                }
            }

            $this->view->op_gravadas = $this->view->op_gravadas / $this->view->igv_gravada;

            $this->view->igv = $this->view->op_gravadas * $this->view->igv_porcentaje;

            $this->view->total = $this->view->total + $this->view->op_gravadas + $this->view->op_exoneradas + $this->view->op_inafectas + $this->view->igv + $this->view->op_icbper;
            //$this->view->total = $this->view->op_gravadas;
            //----- FIN DEL CALCULO DE TOTALES --------//

            $this->view->render('compras/tabla/tablaVenta', true);
        }
    }

    function ListarProductosNombre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtro = $_POST['nombre'];
            $nombre = '%' . $filtro . '%';            
            $this->view->Listar = $this->model->obtenerProductoNombre($nombre);
            $this->view->render('compras/tabla/tablaProducto', true);
        }
    }

    public function insertarCompras() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_SESSION['carrito_compras'])){

                $aux = array();
                $aux = $_SESSION['carrito_compras'];
                $existe = false;
                foreach ($aux as $key => $value) {
                    if ($value['fecha_vencimiento'] == '') {                        
                        $existe = true;
                        break;
                    }
                }

                if ($existe) {
                    echo json_encode('ALGUNOS PRODUCTOS LES FALTA INGRESAR FECHA DE VENCIMIENTO');
                } else {
                    if(count($aux)>0){
                        $conflete = count($aux);
                        $idalmacen = '';
                        $inventario = '0';
                        if($_POST['txtidalmacen'] == ''){
                                $idalmacen = Session::get('idalmacen');
                        }else{
                                $idalmacen = $_POST['txtidalmacen'];
                        }
    
                        if(isset($_POST['ckbinventario'])){
                                $inventario = '1';
                        }                   
                            $serie = strtoupper($_POST['txtserie']);
                            $correlativo = $_POST['txtcorrelativo'];
                            $tipocomp = $_POST['txttipocompro'];
                            $fechaemision = $_POST['txtfecha'];
                            $documento = $_POST['txttipodocumento'];
                            $formapago = $_POST['txtformapago'];
                            $periodo = $_POST['txtperiodo'];            
                            $idproveedor = $_POST['txtproveedor'];
                            $idusuario = Session::get('codUser');
                            $idmoneda = $_POST['txtmoneda'];
                            $tipocambio = $_POST['txttipocambio'];
                            $guia_remision = '0000-0';
                            $flete = 0;
            
                            $serie_ref = '0000';
                            $correlativo_ref = 0;
                            $idordencompra = 0;
                            $division = 0;
                            $glosa = 'COMPRAS';

                            $carrito = array();
                            $carrito = $_SESSION['carrito_compras'];

                            $suma = 0;

                            foreach ($carrito as $key => $value)
                            {
                                $suma = $suma + $value['cantidad'];
                            }
            
                            if($_POST['txtflete'] !== '')
                            {
                                $flete = $_POST['txtflete'];
                                $division = number_format(($flete / $suma), 2, '.', '');
                            }                            
                            
                            if($_POST['txtguiaremision'] !== '')
                            {
                                $guia_remision = $_POST['txtguiaremision'];
                            }

                            if($_POST['txtglosa'] !== '')
                            {
                                $glosa = strtoupper($_POST['txtglosa']);
                            }
                        
                            $hora= date("h:i:s");
                            $fecharegistro = $fechaemision.' '. $hora;
                            $fechaaux = date('Y-m-d').' '. $hora;
            
                            $op_gravadas = 0.00;
                            $op_exoneradas = 0.00;
                            $op_inafectas = 0.00;
                            $op_icbper = 0.00;
                            $igv = 0;
                            $igv_gravada = IGV_GRAVADA;
                            $igv_porcentaje = IGV_PORC;
            
                            $cont = 1;
            
                            foreach ($carrito as $k => $v) {       

                                $igv_detalle = 0;
                                $factor_porcentaje = 1;
                                if ($v['idafectacion'] == 10) {
                                    $igv_detalle = $v['igv'];
                                    $factor_porcentaje = 1 + $igv_porcentaje;
                                }
            
                                $itemx = array(
                                    'item' => $cont,
                                    'fecha_vencimiento' => $v['fecha_vencimiento'], 
                                    'codigo' => $v['codigo'],
                                    'cantidad' => $v['cantidad'],
                                    'precio' => $v['precio'],
                                    'idunidad' => $v['idunidad'],
                                    'valor_unitario' => number_format($v['valor_unitario'], 2, '.', ''),
                                    'precio_unitario' => number_format($v['precio_unitario'], 2, '.', ''),
                                    'cant_icbper' => $v['cant_icbper'],
                                    'imps_icbper' => $v['imps_icbper'],
                                    'igv' => number_format($v['igv'], 2, '.', ''),
                                    'porcentaje_igv' => $v['porcentaje_igv'],
                                    'valor_total' => number_format($v['valor_total'], 2, '.', ''),
                                    'importe_total' => number_format($v['importe_total'], 2, '.', ''),                    
                                    'idafectacion' => $v['idafectacion']                    
                                );
            
                                $itemx;
            
                                $detalle[] = $itemx;
            
                                if ($itemx['idafectacion'] == 10) 
                                {
                                    $op_gravadas = $op_gravadas + $itemx['valor_total'];
                                }
            
                                if ($itemx['idafectacion'] == 20) 
                                {
                                    $op_exoneradas = $op_exoneradas + $itemx['valor_total'];
                                }
            
                                if ($itemx['idafectacion'] == 30) 
                                {
                                    $op_inafectas = $op_inafectas + $itemx['valor_total'];
                                }
            
                                if ($itemx['cant_icbper'] > 0) 
                                {
                                    $op_icbper = $op_icbper + ($itemx['cant_icbper'] * $itemx['imps_icbper']);
                                }
                                $cont = $cont + 1;
                                $igv = $igv + $igv_detalle;
                            }
            
                            $total = $op_gravadas + $op_exoneradas + $op_inafectas + $igv + $op_icbper;
                            $total = number_format($total, 2, '.', '');
                            $igv = number_format($igv, 2, '.', '');
            
                            $xml = new XMLWriter();
                            $xml->openMemory();
                            $xml->setIndent(true);
                            $xml->setIndentString('	'); 
                            $xml->startDocument('1.0', 'UTF-8');     
                            $xml->startElement("Compra");
                            $xml->startElement("Cabecera");
                            $xml->writeElement("idtipocomp", $tipocomp);
                            $xml->writeElement("serie", $serie);
                            $xml->writeElement("correlativo", $correlativo);
                            $xml->writeElement("fecha_emision", $fechaemision);
                            $xml->writeElement("fecha_registro", $fechaaux);  
                            $xml->writeElement("idusuario", $idusuario); 
                            $xml->writeElement("idalmacen", $idalmacen); 
                            $xml->writeElement("idproveedor", $idproveedor);
                            $xml->writeElement("glosa", $glosa);        
                            $xml->writeElement("idmoneda",  $idmoneda); 
                            $xml->writeElement("tipocambio", $tipocambio);
                            $xml->writeElement("op_gravadas", $op_gravadas);
                            $xml->writeElement("op_exoneradas", $op_exoneradas);
                            $xml->writeElement("op_inafectas", $op_inafectas);
                            $xml->writeElement("op_icbper", $op_icbper);
                            $xml->writeElement("igv", $igv);
                            $xml->writeElement("total", $total);
                            $xml->writeElement("idformapago", $formapago);
                            $xml->writeElement("idcomprobante", $documento);
                            $xml->writeElement("guia_remision", $guia_remision);
                            $xml->writeElement("flete", $flete);
                            $xml->writeElement("flete_division", $division);
                            $xml->writeElement("idperiodo", $periodo);
                            $xml->writeElement("ingreso_almacen", $inventario);
                            $xml->endElement(); 
            
                            foreach ($detalle as $key => $value) {
                                $xml->startElement("Detalle");
                                $xml->writeElement("item",$value['item']);
                                $xml->writeElement("fecha_vencimiento",$value['fecha_vencimiento']);
                                $xml->writeElement("idarticulo",$value['codigo']);
                                $xml->writeElement("idunidad",$value['idunidad']);             
                                $xml->writeElement("cantidad",$value['cantidad']);
                                $xml->writeElement("valor_unitario",$value['valor_unitario']);
                                $xml->writeElement("precio_unitario",$value['precio_unitario']);
                                $xml->writeElement("cant_icbper",$value['cant_icbper']);
                                $xml->writeElement("imps_icbper",$value['imps_icbper']);
                                $xml->writeElement("igv",$value['igv']);
                                $xml->writeElement("porcentaje_igv",$value['porcentaje_igv']);
                                $xml->writeElement("valor_total",$value['valor_total']);
                                $xml->writeElement("importe_total",$value['importe_total']);                         
                                $xml->endElement();   
                            }
            
                            //   $xml->endElement();
                            $xml->endElement(); 
                            $content = $xml->outputMemory();
                        
                            $mensaje = $this->model->insertCompra($content);
                            unset($_SESSION['carrito_compras']);                            
                            echo json_encode($mensaje);
                    }else{
                        echo json_encode('NO HA INGRESADO PRODUCTOS');
                    }
                }
                
            }else{
                echo json_encode('NO HA INGRESADO PRODUCTOS');
            }
        }
    }

    function cancelarCompra() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            unset($_SESSION['carrito_compras']);
            echo json_encode('LISTO');
        }
    }

    function pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idCompra',$_POST['codigo']);           
        }else {
            $id = Session::get('idCompra');
            $id = trim($id);
            $this->view->venta = $this->model->obtenerCompra($id); 
            $this->view->detalle = $this->model->detalleCompra($id);          
            $this->view->render('pdf/ex', true);
        }       
    }
}
