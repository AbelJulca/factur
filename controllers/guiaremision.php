<?php
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\Document;
use Greenter\Report\XmlUtils;
use Greenter\Ws\Reader\XmlReader;
class Guiaremision extends Controller
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
        $this->view->js = array("guiaremision/js/script-guiaremision.js");
    }

    public function index()
    {
        if (Session::get('rutas')[26]['estado'] == '1') {
            $this->view->render('guiaremision/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    public function ListarCompro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarTipoComprobante();
            $this->view->render('guiaremision/combobox/selectCompro', true);
        }
    }

    function listarMotivo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarMotivoGuia();
            $this->view->render('guiaremision/combobox/selectMotivo', true);
        }
    }

    function listarModo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarModoGuia();
            $this->view->render('guiaremision/combobox/selectModo', true);
        }
    }

    function ListarComboUnid() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarUnidadGuia();
            $this->view->render('guiaremision/combobox/selectUnidad', true);
        }
    }

    function listarTablaDocumento()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->Listar = $this->model->listarDocumento();
            $this->view->render('guiaremision/combobox/selectDocumento', true);
        }
    }

    function listarTablaNueva() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->view->render('guiaremision/tabla/tablaNuevo', true);
        }
    }

    function llenaDetalle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idventa = $_POST['idventa'];
            $this->view->carrito = $this->model->detalleVenta($idventa);            

            if (!isset($_SESSION['carritoguia'])) {
                $_SESSION['carritoguia'] = array();
            }
            $_SESSION['carritoguia'] = $this->view->carrito;

            $this->view->render('guiaremision/tabla/tablaGuia', true);
        }
    }

    function registrarGuia(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_SESSION['carritoguia'])){
                $aux = array();
                $aux = $_SESSION['carritoguia'];
                
                if(count($aux)>0){
                    $idusuario = Session::get('codUser');
                    $idperiodo = $_POST['txtidperiodo'];
                    $idtipocomp = $_POST['txtcomprobante'];
                    $idserie = $_POST['txtidserie'];
                    $serie = $_POST['txtserie'];
                    $fecha_emision = date('Y-m-d');
                    $hora= date("h:i:s");
                    $observacion = strtoupper($_POST['txtobservacion']);
                    $idcliente = $_POST['txtidcliente'];
                    $peso = $_POST['txtpeso'];
                    $cant_peso = $_POST['txtnumeropaq'];
                    $idtransporte = $_POST['txtmodotraslado'];                    
                    $idmotivo = $_POST['txtmotivo'];
                    $ubigeo_llegada = $_POST['txtubigeoLL'];
                    $direccion_llegada = strtoupper($_POST['txtdireccionLL']);
                    $dni_chofer = $_POST['txtdocum'];
                    $placa = $_POST['txtplaca'];
                    $ubigeo_partida = $_POST['txtubigeo'];
                    $direccion_partida = strtoupper($_POST['txtdireccionPart']);
                    $idtransportista = $_POST['txtidtrans'];
                    $rz_empresa_trans = strtoupper($_POST['txtrazonsocialempresa']);
                    $ruc_empresa_trans = $_POST['txtrucempresa'];

                    $carrito = array();
                    $carrito = $_SESSION['carritoguia'];                     
                    $cont = 1;
                    foreach ($carrito as $k => $v) {
                        $itemx = array(
                            'item' => $cont,
                            'idarticulo' => $v['idarticulo'],
                            'cantidad' => $v['cantidad']                   
                        );
                        $itemx;
                        $detalle[] = $itemx;
                    }                   

                    $xml = new XMLWriter();
                    $xml->openMemory();
                    $xml->setIndent(true);
                    $xml->setIndentString('	'); 
                    $xml->startDocument('1.0', 'UTF-8');     
                    $xml->startElement("Guia"); 
                    $xml->startElement("Cabecera");
                    $xml->writeElement("idusuario",$idusuario);
                    $xml->writeElement("idperiodo",$idperiodo);
                    $xml->writeElement("idtipocomp",$idtipocomp);
                    $xml->writeElement("idserie",$idserie);
                    $xml->writeElement("serie",$serie);
                    $xml->writeElement("fecha_emision",$fecha_emision);
                    $xml->writeElement("hora",$hora); 
                    $xml->writeElement("observacion",$observacion); 
                    $xml->writeElement("idcliente",$idcliente);       
                    $xml->writeElement("peso",$peso); 
                    $xml->writeElement("cant_peso",$cant_peso);
                    $xml->writeElement("idtransporte",$idtransporte);
                    $xml->writeElement("idmotivo",$idmotivo);
                    $xml->writeElement("ubigeo_llegada",$ubigeo_llegada);
                    $xml->writeElement("direccion_llegada",$direccion_llegada);
                    $xml->writeElement("dni_chofer",$dni_chofer);
                    $xml->writeElement("placa",$placa);
                    $xml->writeElement("ubigeo_partida",$ubigeo_partida);
                    $xml->writeElement("direccion_partida",$direccion_partida);
                    $xml->writeElement("idtransportista",$idtransportista);
                    $xml->writeElement("ruc_empresa_trans",$ruc_empresa_trans);
                    $xml->writeElement("rz_empresa_trans",$rz_empresa_trans);        
                    $xml->endElement(); 

                    foreach ($detalle as $key => $value) {
                        $xml->startElement("Detalle");
                        $xml->writeElement("item",$value['item']);
                        $xml->writeElement("idarticulo",$value['idarticulo']);            
                        $xml->writeElement("cantidad",$value['cantidad']);                        
                        $xml->endElement();   
                    }        
                    $xml->endElement(); 
                    $content = $xml->outputMemory();                
                    $mensaje = $this->model->insertGuiaremision($content);

                    unset($_SESSION['carritoguia']);
                    echo json_encode($mensaje);
                }else{
                    echo json_encode('ESCOJA PRODUCTOS');
                }

            }else{
                echo json_encode('ESCOJA PRODUCTOS');
            }
        }    
    }

    public function sendToSunat(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $idventa = $_POST['idventa'];
            $idalmacen = Session::get('idalmacen');
            $empresa = $this->model->obtenerEmpresa($idalmacen);
            $encabezado = $this->model->obtenerGuia($idventa);
            $receptor = $this->model->obtenerCliente($encabezado['idcliente']);

           // echo  json_encode($encabezado);

            if($encabezado['idtipocomp'] == '09'){
                    

                    $see = new See();
                    $see->setCertificate(file_get_contents('./public/certificado/'.$empresa['ruc'].'.pem'));                    
                  
                    if ($empresa['modo_guias']=='GUIA_BETA') {
                        $see->setService(SunatEndpoints::GUIA_BETA);
                    }
                    else{$see->setService(SunatEndpoints::GUIA_PRODUCCION);}
                    
                    $see->setClaveSOL($empresa['ruc'], $empresa['usuario_sol_sec'], $empresa['clave_sol_sec']); 

                    $address = (new Address())
                    ->setUbigueo($empresa['ubigeo'])
                    ->setDepartamento($empresa['departamento'])
                    ->setProvincia($empresa['provincia'])
                    ->setDistrito($empresa['distrito'])
                    ->setUrbanizacion('-')
                    ->setDireccion($empresa['direccion'].'/'.$empresa['direccion_sucursal']);
              
                    
                    $company = (new Company())
                        ->setRuc($empresa['ruc'])
                        ->setRazonSocial($empresa['razon_social'])
                        ->setNombreComercial($empresa['descripcion'])
                        ->setAddress($address);
                    
                    if ($encabezado['idtransporte'] =='01') {
                        $transp = new Transportist();
                        $transp->setTipoDoc('6')
                            ->setPlaca($encabezado['placa'])
                            ->setChoferTipoDoc('1')
                            ->setChoferDoc($encabezado['dni_chofer']);
                    }
                    else {
                        $transp = new Transportist();
                        $transp->setTipoDoc('6')
                            ->setNumDoc($encabezado['ruc_empresa_trans'])
                            ->setRznSocial($encabezado['rz_empresa_trans'])
                            ->setPlaca($encabezado['placa'])
                            ->setChoferTipoDoc('1')
                            ->setChoferDoc($encabezado['dni_chofer']);
                    }

                    $motivo = $this->model->obtenerMotivo($encabezado['idmotivo']);
                    
                    
                    $envio = new Shipment();
                    $envio->setCodTraslado($encabezado['idmotivo']) // Cat.20
                        ->setDesTraslado($motivo['descripcion'])
                        ->setModTraslado($encabezado['idtransporte']) // Cat.18
                        ->setFecTraslado(new Datetime($encabezado['fecha_emision']))
                        ->setIndTransbordo(false)
                        ->setPesoTotal($encabezado['peso'])
                        ->setnumBultos($encabezado['cant_peso'])    
                        ->setUndPesoTotal('KGM')
                        ->setLlegada(new Direction($encabezado['ubigeo_llegada'], $encabezado['direccion_llegada']))
                        ->setPartida(new Direction($encabezado['ubigeo_partida'], $encabezado['direccion_partida']))
                        ->setTransportista($transp);
                    
                    $despatch = new Despatch();
                    $despatch->setTipoDoc('09')
                        ->setSerie($encabezado['serie'])
                        ->setCorrelativo($encabezado['correlativo'])
                        ->setFechaEmision(new Datetime())
                        ->setCompany($company)
                        ->setDestinatario((new Client())
                            ->setTipoDoc($receptor['iddocumento'])
                            ->setNumDoc($receptor['nrodocu'])
                            ->setRznSocial($receptor['razon_social']))
                        ->setObservacion($encabezado['observacion'])
                        ->setEnvio($envio);

                    $detalle = $this->model->obtenerDetalleGuia($idventa);

                    foreach ($detalle as $key => $value) {
                        $item = new DespatchDetail();
                          $item->setCodigo($value['sku'])      
                          ->setDescripcion($value['nombre_comercial'])
                          //->setCodProdSunat($valor['codexist'])
                          ->setUnidad($value['idunidad'])
                          ->setCantidad($value['cantidad']);
                        
                           $items[]=$item;
                    }    
                    
                    $despatch->setDetails($items);
                    
                    $res = $see->send($despatch);
                    $xml = $see->getXmlSigned($despatch); 
                    $hash = $this->getHashXml($xml);

                        //echo  json_encode($hash);

                        // Guardar XML firmado digitalmente. 
                        file_put_contents('./facturacion/xml_firmar_guia/'.$despatch->getName().'.xml',$see->getFactory()->getLastXml());
                       
                        // Verificamos que la conexión con SUNAT fue exitosa.
                        if (!$res->isSuccess()) {
                            // Mostrar error al conectarse a SUNAT.
                            //echo json_encode('Codigo Error: '.$result->getError()->getCode());
                            $fenvio=date("Y-m-d");
                            $data = [

                                'idventa' => $_POST['idventa'],
                                'xml'     => $despatch->getName().'.xml',
                                'codigoerror'  => $res->getError()->getCode(),
                                'hash'     => $hash,
                                'fecha_envio' => $fenvio,
                                'mensajesunat' => $res->getError()->getMessage()
                            ];

                            $this->model->actalizarGuiaError($data);
                            echo json_encode('Mensaje Error: '.$res->getError()->getMessage());
                            exit();
                        }
                        
                        file_put_contents('./facturacion/cdr_guia/'.'R-'.$despatch->getName().'.zip', $res->getCdrZip());     

                        $zip = new ZipArchive;
                            // Declaramos el fichero a descomprimir, puede ser enviada desde un formulario
                        $comprimido= $zip->open('./facturacion/cdr_guia/'.'R-'.$despatch->getName().'.zip');
                        if ($comprimido === TRUE) {
                    
                            // Declaramos la carpeta que almacenara ficheros descomprimidos
                            $zip->extractTo('./facturacion/cdr_guia/');
                            $zip->close();
                            rmdir('./facturacion/cdr_guia/dummy');
                        }
                       

                        $cdr = $res->getCdrResponse();

                        $code = (int)$cdr->getCode();

                        if ($code === 0) {
                            
                            $fenvio=date("Y-m-d");

                            $data = [

                                'idventa' => $_POST['idventa'],
                                'xml'     => $despatch->getName().'.xml',
                                'cdr'     => 'R-'.$despatch->getName().'.zip',
                                'codigo'  => $code,
                                'hash'     => $hash,
                                'fecha_envio' => $fenvio,
                                'mensajesunat' => $cdr->getDescription().PHP_EOL
                            ];

                            $this->model->actalizarGuia($data);
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

    function pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Session::set('idguia',$_POST['codigo']);           
        }else {
            $id = Session::get('idguia');            
            $idalmacen = Session::get('idalmacen');
            $this->view->empresa = $this->model->obtenerEmpresa($idalmacen);
            $this->view->guia = $this->model->obtenerGuiaTwo($id);
            $this->view->detalle = $this->model->obtenerDetalleGuia($id);        
            $this->view->render('pdf/guia', true);
        }       
    }

}
 