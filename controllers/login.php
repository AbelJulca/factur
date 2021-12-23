<?php
class Login extends Controller {

    function __construct() {
      Session::init();
      parent::__construct(); 
    }
    
   /* public function index() {
      $this->view->render('login/index');
    }  */
    
  public function login() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if($_POST['token'])
        {
          $googleToken = $_POST['token'];
          $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$googleToken}"); 
          $response = json_decode($response);
          $response = (array) $response;
          if($response['success'] && ($response['score'] && $response['score'] > 0.5))
          {

            $data = [
              'user' => trim($_POST['user']),
              'clave' => trim($_POST['clave'])
            ];                        
            $mensaje = $this->model->iniciarSesion($data);
            

            if ($mensaje == 'Validacion de usuario exitoso con recaptchaV3') {
              //$_SESSION['perfiles'] = Session::get('idperfil'); 

              $_SESSION['rutas'] = array();
              $_SESSION['menu'] = array();
              $datos = array();
              $ruta = $this->model->seleccionarRutas(Session::get('idperfil')); 
              $menu = $this->model->seleccionarMenu(Session::get('idperfil'));             

              foreach ($ruta as $key => $value) {              
                $data = array(
                    'descripcion' => $value['descripcion'],
                    'padre' => $value['padre'],
                    'ruta' => $value['ruta'],
                    'estado' => $value['estado']
                );
                array_push($_SESSION['rutas'], $data); 
              }

              foreach ($menu as $key => $value) {              
                $dato = array(
                    'padre' => $value['padre'],
                    'estado' => $value['estado']
                );
                array_push($_SESSION['menu'], $dato); 
              }
            }

            echo json_encode($mensaje);             
          }
          else
          {
            echo json_encode('Problemas internos con RecaptchaV3,actualice la pagina y vuelva a intentarlo');
          }
          
          //echo json_encode($mensaje);                       
        }
      }
  }


  public function prueba() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mensaje = [
          'gato' => 'pekin',
          'razon' => 'almuerzo'
        ]; 
        
        echo json_encode($mensaje);                       
    }
}

}
