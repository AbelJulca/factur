<?php

class Login_Model extends Model {

    function __construct() {
        
        parent::__construct();
    }
    
    public function iniciarSesion($data) {        
        try {            
            $sth = $this->db->prepare('CALL SP_INICIAR_SESION (?,?)');
            $sth->bindParam(1, $data['user'], PDO::PARAM_STR, 80);
            $sth->bindParam(2, $data['clave'], PDO::PARAM_STR, 35);
            $sth->execute();
            $dato = $sth->fetch(PDO::FETCH_NAMED);
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
            Session::set('idperfil',$dato['idperfil']); 
            Session::set('idalmacen',$dato['idalmacen']);
            Session::set('almacen_origen',$dato['idalmacen']);
            Session::set('idacceso_almacen',$dato['idacceso_almacen']);  
            Session::set('almacen',$dato['almacen']); 
            Session::set('idsucursal',$dato['idsucursal']); 
            Session::set('sucursal',$dato['sucursal']); 
            Session::set('idCaja','0');
            Session::set('usuario',$dato['usuario']);  
            Session::set('nombreCaja','SIN NOMBRE');            
            
                return 'Validacion de usuario exitoso con recaptchaV3';
            }else{            
                return 'Usuario no existe en la base de datos';
            }
            
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    public function seleccionarRutas($idperfil){
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PERFIL_SELECCION (?)');
            $sth->bindParam(1, $idperfil, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    public function seleccionarMenu($idperfil){
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PERFIL_PADRE (?)');
            $sth->bindParam(1, $idperfil, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

}