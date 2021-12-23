<?php
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Report\XmlUtils;
use Greenter\Ws\Reader\XmlReader;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;

class Comprobante extends Controller
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
        $this->view->js = array("comprobante/js/script-comprobante.js");
    }

    public function index()
    {
        if (Session::get('rutas')[7]['estado'] == '1') {
            $this->view->render('comprobante/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }  
    }
    
    function ListarComboDocumento() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarTipoDocumento();
            $this->view->render('comprobante/combobox/selectTipoDocumento', true);
        }
    }

    function ListarComboTipoNrodoc() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarTipoNrodoc();
            $this->view->render('comprobante/combobox/selectTipoNrodoc', true);
        }
    }

    function ListarProductoNew() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->render('comprobante/tabla/tablaProductoNew', true);
        }
    }

    function ListarProductosNombre() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filtro = $_POST['nombre'];
            $nombre = '%' . $filtro . '%';
            $idalmacen = Session::get('idalmacen');            
            $this->view->Listar = $this->model->obtenerProductoNombre($nombre,$idalmacen);
            $this->view->render('comprobante/tabla/tablaProducto', true);
        }
    }

    function buscarCliente() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dni = $_POST['nrodoc'];                       
            $mensaje = $this->model->obtenerClienteDni($dni);
            echo json_encode($mensaje);
        }
    }

    public function insertarCliente() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipodoc = $_POST['txttipodoc'];
            $nrodoc = $_POST['txtdni'];
            $direccion = strtoupper($_POST['txtdireccion']);
            $razonsocial = strtoupper($_POST['txtrazonsocial']);
            $tele = '000000000';
            $correo = 'SIN CORREO';
            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->setIndentString('	'); 
            $xml->startDocument('1.0', 'UTF-8');     
            $xml->startElement("Cliente"); 
            $xml->startElement("Cabecera");
                $xml->writeElement("tipodoc",$tipodoc);
                $xml->writeElement("nrodoc",$nrodoc); 
                $xml->writeElement("telefono",$tele); 
                $xml->writeElement("correo",$correo); 
                $xml->writeElement("direccion",$direccion);
                $xml->writeElement("razonsocial",$razonsocial);            
                $xml->endElement();
            $xml->endElement();
            $content = $xml->outputMemory(); 
            $mensaje = $this->model->insertCliente($content);            
            echo json_encode($mensaje);;
        }
    }

    function ListarVentaNew() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['carrito_ventas'])) {
                $this->view->carrito = $_SESSION['carrito_ventas'];
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

            $this->view->render('comprobante/tabla/tablaVenta', true);

            }else{
                $this->view->render('comprobante/tabla/tablaVentaNew', true);
            }
        }
    }

    function agregarCarrito() 
    {
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
            if (!isset($_SESSION['carrito_ventas'])) {
                $_SESSION['carrito_ventas'] = array();
            }
            $this->view->carrito = $_SESSION['carrito_ventas'];

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


            
            $_SESSION['carrito_ventas'] = $this->view->carrito;

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
            
            $this->view->render('comprobante/tabla/tablaVenta', true);
        }
    } 

    function ItemDellCarrito() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ----- INICIO LOGICA DE CARRITO ----- //
            $codigo = $_POST['codigo'];

            $this->view->carrito = $_SESSION['carrito_ventas'];
            $existe = false;
            $item = 0;
            foreach ($this->view->carrito as $k => $v) {
                if ($v['codigo'] == $_POST['codigo']) {
                    unset($this->view->carrito[$k]);
                    $existe = true;
                    break;
                }
            }

            $_SESSION['carrito_ventas'] = $this->view->carrito;

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

            $this->view->render('comprobante/tabla/tablaVenta', true);
        }
    }

    function registrarVenta(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_SESSION['carrito_ventas'])){
                $aux = array();
                $aux = $_SESSION['carrito_ventas'];
                
                if(count($aux)>0){
                    $idusuario = Session::get('codUser');
                    $idalmacen = Session::get('idalmacen');
                    $idtipocomp = $_POST['txttipodocumento'];
                    $idserie = $_POST['txtidserie'];
                    $serie = $_POST['txtserie'];
                    $fecha = date('Y-m-d');
                    $hora= date("h:i:s");
                    $idperiodo = $_POST['txtidperiodo'];
                    $idcliente = $_POST['txtidcliente'];
                    $idmoneda = $_POST['txtmoneda'];
                    $idformapago = $_POST['txtformapago'];
                    $direccion = $_POST['direccion'];

                    //DATOS DE PAGO 
                    $idcaja = Session::get('idCaja');                    
                    $monto_visa = '0.00';
                    $descripcion_visa = 'SIN DESCRIPCION';
                    $num_ope = '0';
                    $pago_con = '0.00';
                    $vuelto = number_format($_POST['txtvuelto'], 2, '.', '');

                    if ($_POST['txtmontovisa'] !== '') {
                        $monto_visa = $_POST['txtmontovisa'];
                    }

                    if ($_POST['txtdescripcionvisa'] !== '') {
                        $descripcion_visa = strtoupper($_POST['txtdescripcionvisa']);
                    }

                    if ($_POST['txtnumopvisa'] !== '') {
                        $num_ope = $_POST['txtnumopvisa'];
                    }

                    if ($_POST['txtpagocon'] !== '') {
                        $pago_con =  $_POST['txtpagocon'];
                    }

                    $carrito = array();
                    $carrito = $_SESSION['carrito_ventas'];

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
                    $xml->startElement("Venta"); 
                    $xml->startElement("Cabecera");
                    $xml->writeElement("idcaja",$idcaja);
                    $xml->writeElement("monto_visa",$monto_visa);
                    $xml->writeElement("descripcion_visa",$descripcion_visa);
                    $xml->writeElement("num_ope",$num_ope);
                    $xml->writeElement("pago_con",$pago_con);
                    $xml->writeElement("vuelto",$vuelto);
                    $xml->writeElement("idusuario",$idusuario);
                    $xml->writeElement("idtipocomp",$idtipocomp);
                    $xml->writeElement("idserie",$idserie);
                    $xml->writeElement("serie",$serie);
                    $xml->writeElement("fecha_emision",$fecha); 
                    $xml->writeElement("hora",$hora); 
                    $xml->writeElement("idperiodo",$idperiodo); 
                    $xml->writeElement("idcliente",$idcliente);       
                    $xml->writeElement("idmoneda", $idmoneda); 
                    $xml->writeElement("op_gravadas",$op_gravadas);
                    $xml->writeElement("op_exoneradas",$op_exoneradas);
                    $xml->writeElement("op_inafectas",$op_inafectas);
                    $xml->writeElement("op_icbper",$op_icbper);
                    $xml->writeElement("igv",$igv);
                    $xml->writeElement("total",$total);
                    $xml->writeElement("idformapago",$idformapago);
                    $xml->writeElement("direccion",$direccion);
                    $xml->writeElement("idalmacen",$idalmacen);          
                    $xml->endElement(); 

                    foreach ($detalle as $key => $value) {
                        $xml->startElement("Detalle");
                        $xml->writeElement("item",$value['item']);
                        $xml->writeElement("idexistencia_lotes",$value['codigo']);            
                        $xml->writeElement("cantidad",$value['cantidad']);
                        $xml->writeElement("precio_compra",$value['precio']);
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
                
                    $mensaje = $this->model->insertVenta($content);
                    unset($_SESSION['carrito_ventas']);
                    echo json_encode($mensaje);
                }else{
                    echo json_encode('ESCOJA PRODUCTOS');
                }

            }else{
                echo json_encode('ESCOJA PRODUCTOS');
            }
        }    
    }

    function pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idVenta',$_POST['codigo']);           
        }else {
            $id = Session::get('idVenta');
            $id = trim($id);
            $idalmacen = Session::get('idalmacen');
            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen); 
            $this->view->venta = $this->model->obtenerVenta($id); 
            $this->view->detalle = $this->model->detalleVenta($id); 
            if ($this->view->venta['idtipocomp'] == '07') {
                $this->view->movito = $this->model->obtenerMotivo('C',$this->view->venta['motivo_baja']); 
            } 
            if ($this->view->venta['idtipocomp'] == '08') {
                $this->view->movito = $this->model->obtenerMotivo('D',$this->view->venta['motivo_baja']); 
            }         
            $this->view->render('pdf/ex', true);
        }       
    }

    function ticket()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idVenta',$_POST['codigo']);           
        }else {
            $id = Session::get('idVenta');
            $id = trim($id);
            $idalmacen = Session::get('idalmacen');
            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen); 
            $this->view->venta = $this->model->obtenerVenta($id); 
            $this->view->detalle = $this->model->detalleVenta($id); 
            if ($this->view->venta['idtipocomp'] == '07') {
                $this->view->movito = $this->model->obtenerMotivo('C',$this->view->venta['motivo_baja']); 
            } 
            if ($this->view->venta['idtipocomp'] == '08') {
                $this->view->movito = $this->model->obtenerMotivo('D',$this->view->venta['motivo_baja']); 
            }         
            $this->view->render('pdf/ticket', true);
        }       
    }

    public function sendToSunat(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $idventa = $_POST['idventa'];
            $idalmacen = Session::get('idalmacen');
            $empresa = $this->model->obtenerEmpresa($idalmacen);
            $encabezado = $this->model->obtenerVenta($idventa);

           // echo  json_encode($encabezado);

            if($encabezado['idtipocomp'] == '03' || $encabezado['idtipocomp'] == '01'){
                    

                    $see = new See();
                    $see->setCertificate(file_get_contents('./public/certificado/'.$empresa['ruc'].'.pem'));                    
                    
                   // $see->setService(SunatEndpoints::FE_BETA);

                    if ($empresa['modo_ft_notas']=='FE_BETA') {
                        $see->setService(SunatEndpoints::FE_BETA);
                    }
                    else{$see->setService(SunatEndpoints::FE_PRODUCCION);}
                    
                    $see->setClaveSOL($empresa['ruc'], $empresa['usuario_sol_sec'], $empresa['clave_sol_sec']); 

                    // Cliente
                    $client = (new Client())
                        ->setTipoDoc($encabezado['iddocumento'])
                        ->setNumDoc($encabezado['nrodoc'])
                        ->setRznSocial($encabezado['razon_social']);

                    // Emisor
                    
                    $address = (new Address())
                    ->setUbigueo($empresa['ubigeo'])
                    ->setDepartamento($empresa['departamento'])
                    ->setProvincia($empresa['provincia'])
                    ->setDistrito($empresa['distrito'])
                    ->setUrbanizacion('-')
                    ->setDireccion($empresa['direccion'].'/'.$empresa['direccion_sucursal']);
                   // ->setCodLocal($empresa['CODIGO_ESTABLECIMIENTO']); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

                    $company = (new Company())
                        ->setRuc($empresa['ruc'])
                        ->setRazonSocial($empresa['razon_social'])
                        ->setNombreComercial($empresa['descripcion'])
                        ->setAddress($address);

                    $invoice = new Invoice();

                    $invoice
                        ->setUblVersion('2.1')
                        ->setTipoOperacion('0101') // Catalogo 51: Detracción
                        ->setTipoDoc($encabezado['idtipocomp'])
                        ->setSerie($encabezado['serie'])
                        ->setCorrelativo($encabezado['correlativo']);
                        if($encabezado['formapago']=='Contado') {
                            $invoice->setFormaPago(new FormaPagoContado());
                        }
                        else {
                        $invoice->setFormaPago(new FormaPagoCredito($encabezado['total']))
                                ->setCuotas([
                                    (new Cuota())
                                    ->setMonto($encabezado['total'])
                                    ->setFechaPago(new DateTime($encabezado['fecha_vencimiento']))
                                ]);
                        }
                        $invoice 
                        ->setFechaEmision(new DateTime($encabezado['fecha_emision']))                        
                        ->setTipoMoneda($encabezado['idmoneda'])
                        ->setCompany($company)
                        ->setClient($client)
                        ->setMtoOperGravadas($encabezado['op_gravadas'])
                        ->setMtoOperInafectas($encabezado['op_inafectas'])
                        ->setMtoOperExoneradas($encabezado['op_exoneradas'])
                        ->setMtoIGV($encabezado['igv'])
                        ->setIcbper($encabezado['op_icbper'])
                        ->setTotalImpuestos($encabezado['igv'] + $encabezado['op_icbper'])
                        ->setValorVenta($encabezado['op_gravadas'] + $encabezado['op_inafectas'] + $encabezado['op_exoneradas'])
                        ->setSubTotal($encabezado['total'])
                        ->setMtoImpVenta($encabezado['total']);
                          

                        $Detalles = $this->model->detalleVenta($idventa);

                        $array=array();
                       
                        foreach ($Detalles as $key => $value) {

                            if ($value['cant_icbper'] > 0) {
                                $detail = new SaleDetail();
                                $detail 
                                    ->setCodProducto($value['sku'])
                                    ->setUnidad($value['idunidad'])
                                    ->setCantidad($value['cant_icbper'])
                                    ->setDescripcion($value['nombre_comercial'])
                                    ->setMtoValorUnitario($value['valor_unitario'])
                                    ->setMtoPrecioUnitario($value['precio_unitario'])
                                    ->setMtoValorVenta($value['valor_total'])
                                    ->setTipAfeIgv($value['idafectacion']) // Catalogo 07 - Gravado
                                    ->setMtoBaseIgv($value['valor_total'])
                                    ->setPorcentajeIgv($value['porcentaje_igv'])
                                    ->setIgv($value['igv'])
                                    ->setIcbper($value['cant_icbper']*$value['imps_icbper']) // (cantidad)*(factor ICBPER)
                                    ->setFactorIcbper($value['imps_icbper'])
                                    ->setTotalImpuestos(($value['cant_icbper']*$value['imps_icbper'])+$value['igv']);
                                    array_push($array, $detail);
                            } else {
                                $detail = new SaleDetail();
                                $detail
                                    ->setCodProducto($value['sku'])
                                    ->setUnidad($value['idunidad'])
                                    ->setCantidad($value['cantidad'])
                                    ->setDescripcion($value['nombre_comercial'])
                                    ->setMtoBaseIgv($value['valor_total'])
                                    ->setPorcentajeIgv($value['porcentaje_igv'])
                                    ->setIgv($value['igv'])
                                    ->setTotalImpuestos($value['igv'])
                                    ->setTipAfeIgv($value['idafectacion']) // Catalogo 07 
                                    ->setMtoValorVenta($value['valor_total'])
                                    ->setMtoValorUnitario($value['valor_unitario'])
                                    ->setMtoPrecioUnitario($value['precio_unitario']);
                                    array_push($array, $detail);
                            } 
                        }                       
                       

                        $formatter = new NumeroALetras();

                        $invoice->setDetails(array_values($array))
                        ->setLegends([
                            (new Legend())
                                ->setCode('1000')
                                ->setValue($formatter->toInvoice($encabezado['total'], 2, 'soles'))
                        ]);   

                        $result = $see->send($invoice);
                        $xml = $see->getXmlSigned($invoice);
                        $hash = $this->getHashXml($xml);

                        //echo  json_encode($hash);

                        // Guardar XML firmado digitalmente.
                        if($encabezado['idtipocomp'] == '03'){
                            file_put_contents('./facturacion/xml_firmar_boleta/'.$invoice->getName().'.xml',$see->getFactory()->getLastXml());
                        }
                        if($encabezado['idtipocomp'] == '01'){
                            file_put_contents('./facturacion/xml_firmar_factura/'.$invoice->getName().'.xml',$see->getFactory()->getLastXml());
                        }
                        // Verificamos que la conexión con SUNAT fue exitosa.
                        if (!$result->isSuccess()) {
                            // Mostrar error al conectarse a SUNAT.
                            //echo json_encode('Codigo Error: '.$result->getError()->getCode());
                            $fenvio=date("Y-m-d");
                            $data = [

                                'idventa' => $_POST['idventa'],
                                'xml'     => $invoice->getName().'.xml',
                                'codigoerror'  => $result->getError()->getCode(),
                                'hash'     => $hash,
                                'fecha_envio' => $fenvio,
                                'mensajesunat' => $result->getError()->getMessage()
                            ];

                            $this->model->actalizarVentaError($data);
                            echo json_encode('Mensaje Error: '.$result->getError()->getMessage());
                            exit();
                        }
        
                        // Guardamos el CDR
                        if($encabezado['idtipocomp'] == '03'){

                            file_put_contents('./facturacion/cdr_boleta/'.'R-'.$invoice->getName().'.zip', $result->getCdrZip());     

                            $zip = new ZipArchive;
                                // Declaramos el fichero a descomprimir, puede ser enviada desde un formulario
                            $comprimido= $zip->open('./facturacion/cdr_boleta/'.'R-'.$invoice->getName().'.zip');
                            if ($comprimido === TRUE) {
                        
                                // Declaramos la carpeta que almacenara ficheros descomprimidos
                                $zip->extractTo('./facturacion/cdr_boleta/');
                                $zip->close();
                                rmdir('./facturacion/cdr_boleta/dummy');
                            }
                        }

                        if($encabezado['idtipocomp'] == '01'){

                            file_put_contents('./facturacion/cdr_factura/'.'R-'.$invoice->getName().'.zip', $result->getCdrZip());     

                            $zip = new ZipArchive;
                                // Declaramos el fichero a descomprimir, puede ser enviada desde un formulario
                            $comprimido= $zip->open('./facturacion/cdr_factura/'.'R-'.$invoice->getName().'.zip');
                            if ($comprimido === TRUE) {
                        
                                // Declaramos la carpeta que almacenara ficheros descomprimidos
                                $zip->extractTo('./facturacion/cdr_factura/');
                                $zip->close();
                                rmdir('./facturacion/cdr_factura/dummy');
                            }
                        }

                        $cdr = $result->getCdrResponse();

                        $code = (int)$cdr->getCode();

                        if ($code === 0) {
                            
                            $fenvio=date("Y-m-d");

                            $data = [

                                'idventa' => $_POST['idventa'],
                                'xml'     => $invoice->getName().'.xml',
                                'cdr'     => 'R-'.$invoice->getName().'.zip',
                                'codigo'  => $code,
                                'hash'     => $hash,
                                'fecha_envio' => $fenvio,
                                'mensajesunat' => $cdr->getDescription().PHP_EOL
                            ];

                            $this->model->actalizarVenta($data);
                            echo  json_encode($cdr->getDescription().PHP_EOL);

                        } else if ($code >= 2000 && $code <= 3999) {
                            echo json_encode('ESTADO: RECHAZADA'.PHP_EOL);
                        } else {
                            // Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. 
                            //code: 0100 a 1999 
                          echo json_encode('Excepción');
                        }                                                                              
            }else{
                echo  json_encode('Ticket'); 
            }           
        }
    }

    public function getHashXml($xml)
    {
            $parser = new XmlReader();
            $documento = $parser->getDocument($xml);
            $hash = $documento->getElementsByTagName('DigestValue')->item(0)->nodeValue;
            return $hash;
    }
    
}
