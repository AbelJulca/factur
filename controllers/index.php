<?php
class Index extends Controller {

    function __construct() {
        parent::__construct();       
    }    
    
    public function index() {
      $this->view->render('index/index');
    }
    
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

    
}

