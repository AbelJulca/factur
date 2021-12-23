<?php
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Model\Response\BillResult;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Greenter\Model\Sale\Document;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\SummaryPerception;
use Greenter\Report\XmlUtils;
use Greenter\Ws\Reader\XmlReader;

class Bajaboletas extends Controller
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
        $this->view->js = array("bajaboletas/js/script-bajaboletas.js");
    }

    public function index()
    {
        if (Session::get('rutas')[20]['estado'] == '1') {
            $this->view->render('bajaboletas/index');# code...
        } else {
            $this->view->render('error/error');# code...
        }
    }

    function odtenerSerie()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $almacen = Session::get('idalmacen');
            $tipocomp = $_POST['comp'];
            $mensaje = $this->model->obtenerSerieCorre($almacen,$tipocomp);
            echo json_encode($mensaje);            
        }
    }

    function listarBoletas() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $idalmacen = Session::get('idalmacen');
            $fecha_actual = date("Y-m-d");
            $fecha_atras = date("Y-m-d", strtotime($fecha_actual . "- 6 days"));
            $variable = $this->model->listarBoletasTobajas('03', $idalmacen, $fecha_actual, $fecha_atras);
            $data = array();
            foreach ($variable as $key => $value) { 
                $correx = strlen($value['correlativo']);
                $correlativo ='';               
                if ($correx == '1') {
                    $correlativo = '0000000'.$value['correlativo'];
                }
                if ($correx == '2') {
                    $correlativo = '000000'.$value['correlativo'];
                }
                if ($correx == '3') {
                    $correlativo = '00000'.$value['correlativo'];
                }
                if ($correx == '4') {
                    $correlativo = '0000'.$value['correlativo'];
                }
                if ($correx == '5') {
                    $correlativo = '000'.$value['correlativo'];
                }
                if ($correx == '6') {
                    $correlativo = '00'.$value['correlativo'];
                }
                if ($correx == '7') {
                    $correlativo = '0'.$value['correlativo'];
                }
                if ($correx == '8') {
                    $correlativo = $value['correlativo'];
                }              
                $datos = array(
                    'codigo' => $value['codigo'],
                    'serie' => $value['serie'].'-'.$correlativo,                    
                    'razon_social' => $value['razon_social'], 
                    'fecha_emision' => $value['fecha_emision'],                   
                    'op_gravadas' => $value['op_gravadas'],
                    'op_exoneradas' => $value['op_exoneradas'],
                    'op_inafectas' => $value['op_inafectas'],
                    'op_icbper' => $value['op_icbper'],
                    'igv' => $value['igv'],
                    'total' => $value['total'],                   
                    'boton' => "<div class='d-flex'><button type='button' data-boletaid = ".$value['codigo']." class='delete btn btn-info btn-xs'><i class='far fa-trash-alt'></i></button></div>"
                );
                array_push($data, $datos);
            }
            $mensaje['data'] = $data;
            echo json_encode($mensaje);
        }
    }

    public function sendToSunat(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $idventa = $_POST['idventa'];
            $idserie = $_POST['idserie'];
            $serie = $_POST['serie'];
            $idalmacen = Session::get('idalmacen');
            $empresa = $this->model->obtenerEmpresa($idalmacen);
            $encabezado = $this->model->obtenerVenta($idventa);
            $correlativo = $this->model->updateSerie($idserie);                                
           
            $see = new See();
            $see->setCertificate(file_get_contents('./public/certificado/'.$empresa['ruc'].'.pem'));  
            $see->setClaveSOL($empresa['ruc'], $empresa['usuario_sol_sec'], $empresa['clave_sol_sec']); 
            
            $company = (new Company())
                ->setRuc($empresa['ruc'])
                ->setRazonSocial($empresa['razon_social']);

                if($encabezado['idtipocomp'] == '07'){  
                    $item = new SummaryDetail();
                    $item->setTipoDoc($encabezado['idtipocomp'])
                        ->setSerieNro($encabezado['serie'].'-'.$encabezado['correlativo'])
                        ->setDocReferencia((new Document())
                            ->setTipoDoc($encabezado['tipo_doc_modificar'])
                            ->setNroDoc($encabezado['numero_referencia']))
                        ->setEstado('3')
                        ->setClienteTipo($encabezado['iddocumento'])
                        ->setClienteNro($encabezado['nrodoc'])
                        ->setTotal($encabezado['total'])
                        ->setMtoOperGravadas($encabezado['op_gravadas'])
                        ->setMtoOperExoneradas($encabezado['op_exoneradas'])
                        ->setMtoOperInafectas($encabezado['op_inafectas'])
                        ->setMtoIGV($encabezado['igv']);
                }else{
                    $item = new SummaryDetail();
                    $item->setTipoDoc($encabezado['idtipocomp'])
                        ->setSerieNro($encabezado['serie'].'-'.$encabezado['correlativo'])
                        ->setEstado('3')
                        ->setClienteTipo($encabezado['iddocumento'])
                        ->setClienteNro($encabezado['nrodoc'])
                        ->setTotal($encabezado['total'])
                        ->setMtoOperGravadas($encabezado['op_gravadas'])
                        ->setMtoOperExoneradas($encabezado['op_exoneradas'])
                        ->setMtoOperInafectas($encabezado['op_inafectas'])
                        ->setMtoIGV($encabezado['igv']);
                } 
                
                $items[]=$item;

                if ($empresa['modo_ft_notas']=='FE_BETA') {
                    
                    $see->setService(SunatEndpoints::FE_BETA);
                }
                else
                {
                    $see->setService(SunatEndpoints::FE_PRODUCCION);
                }
                
            $sum = new Summary();
            $sum->setFecGeneracion(new DateTime())
                ->setFecResumen(new DateTime())
                ->setCorrelativo($correlativo)    
                ->setDetails($items)
                ->setMoneda($encabezado['idmoneda'])
                ->setCompany($company);          
            
            $result = $see->send($sum);
            $ticket = $result->getTicket();  
            $res = $see->getStatus($ticket);              

                // Guardar XML firmado digitalmente.
                
                file_put_contents('./facturacion/xml_firmar_rc/'.$sum->getName().'.xml',$see->getFactory()->getLastXml());
                
                // Verificamos que la conexión con SUNAT fue exitosa.
                if (!$res->isSuccess()) {
                    // Mostrar error al conectarse a SUNAT.
                    //echo json_encode('Codigo Error: '.$result->getError()->getCode());
                    $fenvio=date("Y-m-d");
                    $data = [

                        'idventa' => $_POST['idventa'],
                        'xml'     => $sum->getName().'.xml',
                        'cdr'     => 'sin_cdr',
                        'codsunat_baja'  => $res->getError()->getCode(),                        
                        'fecha_enviosunat' => $fenvio,
                        'ticket' => $ticket,
                        'statussunat_baja' => $res->getError()->getMessage(),
                        'estado' => 1
                    ];

                    $this->model->actalizarVentaBaja($data);
                    echo json_encode('Mensaje Error: '.$res->getError()->getMessage());                    
                }else{
                    // Guardamos el CDR
                    file_put_contents('./facturacion/cdr_rc/'.'R-'.$sum->getName().'.zip', $res->getCdrZip());     

                    $zip = new ZipArchive;
                        // Declaramos el fichero a descomprimir, puede ser enviada desde un formulario
                    $comprimido= $zip->open('./facturacion/cdr_rc/'.'R-'.$sum->getName().'.zip');
                    if ($comprimido === TRUE) {                
                        // Declaramos la carpeta que almacenara ficheros descomprimidos
                        $zip->extractTo('./facturacion/cdr_rc/');
                        $zip->close();
                        rmdir('./facturacion/cdr_rc/dummy');
                    } 
                    $fenvio=date("Y-m-d");
                    $data = [
                        'idventa' => $_POST['idventa'],
                        'xml'     => $sum->getName().'.xml',
                        'cdr'     => 'R-'.$sum->getName().'.zip',
                        'codsunat_baja'  => $res->getCdrResponse()->getCode(),                        
                        'fecha_enviosunat' => $fenvio,
                        'ticket' => $ticket,
                        'statussunat_baja' => $res->getCdrResponse()->getDescription(),
                        'estado' => 0
                    ];
                    $this->model->actalizarVentaBaja($data);
                    echo json_encode($res->getCdrResponse()->getDescription()); 
                }   
        }
    }
}
 