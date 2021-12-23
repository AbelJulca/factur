<?php
class Orden extends Controller
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
        $this->view->js = array("orden/js/script-orden.js");
    }
    public function index()
    {
        if (Session::get('rutas')[12]['estado'] == '1') {
            $this->view->render('orden/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function listarTablaProveedor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarProveedor();
            $this->view->render('orden/combobox/selectProveedor', true);
        }
    }

    function listarTablaAlmacen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarAlmacen();
            $this->view->render('orden/combobox/selectAlmacen', true);
        }
    }

    function pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idOrdenCompra',$_POST['codigo']);           
        }else {
            $id = Session::get('idOrdenCompra');
            $id = trim($id);
            $this->view->venta = $this->model->obtenerOrdenCompra($id); 
            $this->view->detalle = $this->model->detalleOrdenCompra($id);          
            $this->view->render('pdf/ex', true);
        }       
    }

    function tck()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idOrdenCompra',$_POST['codigo']);           
        }else {
            $id = Session::get('idOrdenCompra');
            $id = trim($id);
            $this->view->venta = $this->model->obtenerOrdenCompra($id); 
            $this->view->detalle = $this->model->detalleOrdenCompra($id);          
            $this->view->render('pdf/ticket', true);
        }       
    }

    function validarAlmacenUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idalmacen = Session::get('idalmacen');            
            echo json_encode($idalmacen);          
        }
    }

    function odtenerSerieCorrelativo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $almacen = $_POST['almacen'];
            $tipocomp = $_POST['comp'];
            $mensaje = $this->model->obtenerSerieCorre($almacen,$tipocomp);
            echo json_encode($mensaje);            
        }
    }

    function ListarComboMoneda() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarMoneda();
            $this->view->render('orden/combobox/selectMoneda', true);
        }
    }

    function consultarTipoCambio() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fecha = date('Y-m-d');

            // Iniciar llamada a API
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha=' . $fecha,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/tipo-de-cambio-sunat-api',
                'Authorization: Bearer'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // Datos listos para usar
            echo ($response);
            //var_dump($tipoCambioSunat);
        }
    }

    function ListarProductosNew() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->render('orden/tabla/tablaProductoNew', true);
        }
    }

    function cancelarVenta() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            unset($_SESSION['carrito']);
            $this->view->render('orden/tabla/tablaVentaNew', true);
        }
    }

    function ListarVentaNew() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['carrito'])) {
                $this->view->carrito = $_SESSION['carrito'];
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

            $this->view->render('orden/tabla/tablaVenta', true);

            }else{
                $this->view->render('orden/tabla/tablaVentaNew', true);
            }
        }
    }

    function ListarProductosNombre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtro = $_POST['nombre'];
            $nombre = '%' . $filtro . '%';            
            $this->view->Listar = $this->model->obtenerProductoNombre($nombre);
            $this->view->render('orden/tabla/tablaProducto', true);
        }
    }

    function agregarCarrito() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ----- INICIO LOGICA DE CARRITO ----- //
            $codigo = $_POST['codigo'];
            $preciocompra = $_POST['precio'];
            $incluyeigv = $_POST['igv'];
            $cantidad_agregar = 1;

            if (isset($_POST['cantidad'])) {
                if ($_POST['cantidad'] != '') {
                    $cantidad_agregar = $_POST['cantidad'];
                }
            }
            $articulo = $this->model->obtenerProductoCodigo($codigo);
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }
            $this->view->carrito = $_SESSION['carrito'];

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


            
            $_SESSION['carrito'] = $this->view->carrito;

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
            
            $this->view->render('orden/tabla/tablaVenta', true);
        }
    }

    function ItemDellCarrito() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ----- INICIO LOGICA DE CARRITO ----- //
            $codigo = $_POST['codigo'];

            $this->view->carrito = $_SESSION['carrito'];
            $existe = false;
            $item = 0;
            foreach ($this->view->carrito as $k => $v) {
                if ($v['codigo'] == $_POST['codigo']) {
                    unset($this->view->carrito[$k]);
                    $existe = true;
                    break;
                }
            }

            $_SESSION['carrito'] = $this->view->carrito;

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

            $this->view->render('orden/tabla/tablaVenta', true);
        }
    }

    public function insertarOrden() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_SESSION['carrito'])){
            $idalmacen = Session::get('idalmacen');
            $idserie = $_POST['txtidserie'];
            $serie = $_POST['txtserie'];
            $fecha = $_POST['txtfecha'];
            $idproveedor = $_POST['txtproveedor'];
            $idusuario = Session::get('codUser');
            $idmoneda = $_POST['txtmoneda'];
            $tipocambio = $_POST['txttipocambio'];

            $carrito = array();
            $carrito = $_SESSION['carrito'];

            $hora= date("h:i:s");
            $fecharegistro = $fecha.' '. $hora;

            $op_gravadas = 0.00;
            $op_exoneradas = 0.00;
            $op_inafectas = 0.00;
            $op_icbper = 0.00;
            $igv = 0;
            $igv_gravada = IGV_GRAVADA;
            $igv_porcentaje = IGV_PORC;

            $cont = 1;

            foreach ($carrito as $k => $v) {
               // $producto = $this->model->obtenerProductoCodigo($v['codigo']);

                $igv_detalle = 0;
                $factor_porcentaje = 1;
                if ($v['idafectacion'] == 10) {
                    $igv_detalle = $v['igv'];
                    $factor_porcentaje = 1 + $igv_porcentaje;
                }

                $itemx = array(
                    'item' => $cont,
                    'codigo' => $v['codigo'],
                    'cantidad' => $v['cantidad'],
                    'precio' => $v['precio'],
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

                if ($itemx['idafectacion'] == 10) {
                    $op_gravadas = $op_gravadas + $itemx['valor_total'];
                }

                if ($itemx['idafectacion'] == 20) {
                    $op_exoneradas = $op_exoneradas + $itemx['valor_total'];
                }

                if ($itemx['idafectacion'] == 30) {
                    $op_inafectas = $op_inafectas + $itemx['valor_total'];
                }

                if ($itemx['cant_icbper'] > 0) {
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
            $xml->startElement("Orden"); 
            $xml->startElement("Cabecera");
            $xml->writeElement("idserie",$idserie);
            $xml->writeElement("serie",$serie);
            $xml->writeElement("fecha",  $fecharegistro); 
            $xml->writeElement("idusuario", $idusuario); 
            $xml->writeElement("idalmacen", $idalmacen); 
            $xml->writeElement("idproveedor", $idproveedor);       
            $xml->writeElement("idmoneda",  $idmoneda); 
            $xml->writeElement("tipocambio", $tipocambio);
            $xml->writeElement("op_gravadas", $op_gravadas);
            $xml->writeElement("op_exoneradas", $op_exoneradas);
            $xml->writeElement("op_inafectas", $op_inafectas);
            $xml->writeElement("op_icbper", $op_icbper);
            $xml->writeElement("igv", $igv);
            $xml->writeElement("total", $total);
          
            $xml->endElement(); 

            foreach ($detalle as $key => $value) {
                $xml->startElement("Detalle");
                $xml->writeElement("item",$value['item']);
                $xml->writeElement("idarticulo",$value['codigo']);            
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
           
            $mensaje = $this->model->insertOrden($content);
            unset($_SESSION['carrito']);
            echo json_encode($mensaje);
            }else{
                echo json_encode('NO HA INGRESADO PRODUCTOS');
            }
        }
    }
}
