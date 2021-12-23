<?php

class Index_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function iniciarSesion($data) {        
        try {
            $sth = $this->db->prepare('CALL SP_INICIAR_SESION (?,?)');
            $sth->bindParam(1, $data['user'], PDO::PARAM_STR, 80);
            $sth->bindParam(2, $data['clave'], PDO::PARAM_STR, 35);
            $sth->execute();
            $dato = $sth->fetch();
            $count = $sth->rowCount();
            
            if($count >0){
            //login
            Session::init();
            Session::set('loggedIn',true);
            Session::set('codUser',$dato['codigo']);
            Session::set('dniUser',$dato['dni']);
            Session::set('nombreUser',$dato['nombre']);
            Session::set('apellpUser',$dato['apep']);
            Session::set('apellmUser',$dato['apem']);
            Session::set('fotoUser',$dato['ruta_foto']);             
            
            return 'Validacion de usuario exitoso con recaptchaV3';
            }else{
            
            return 'Usuario no existe en la base de datos';
            }
            
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
}

