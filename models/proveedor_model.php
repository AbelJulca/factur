<?php

class Proveedor_Model extends Model{

    function __construct() {
        parent::__construct();
    }
    
    function insertProveedor($content){
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_PROVEEDOR (?,@MENSAJE)');
            $sth->bindParam(1, $content, PDO::PARAM_LOB);
            $sth->execute();
            $sth->closeCursor();            
            $sms = $this->db->query("SELECT @MENSAJE AS mensaje")->fetch(PDO::FETCH_ASSOC);                     
            $mensaje = sprintf($sms['mensaje']);           
            return $mensaje;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();            
            return $mensaje;
        }           
    }
    
    function updateProveedor($content) {
        try {            
            $sth = $this->db->prepare('CALL SP_ACTUALIZAR_PROVEEDOR (?,@MENSAJE)');
            $sth->bindParam(1, $content, PDO::PARAM_LOB);
            $sth->execute();
            $sth->closeCursor();
            $sms = $this->db->query("SELECT @MENSAJE AS mensaje")->fetch(PDO::FETCH_ASSOC);
            $mensaje = sprintf($sms['mensaje']);
            return $mensaje;            
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }    
    }
    
    function deleteProveedor($id) {
        try {            
            $sth = $this->db->prepare('CALL SP_ELIMINAR_PROVEEDOR (?,@MENSAJE)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $sth->closeCursor();
            $sms = $this->db->query("SELECT @MENSAJE AS mensaje")->fetch(PDO::FETCH_ASSOC);
            $mensaje = sprintf($sms['mensaje']);
            return $mensaje;            
        } catch (Exception $e) {            
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }    
    }
    
    function buscarProvee($nrodoc) {
        try {            
            $sth = $this->db->prepare('CALL SP_BUSCAR_REG_PROVEEDOR (?)');
            $sth->bindParam(1, $nrodoc, PDO::PARAM_STR);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
            return $mensaje;
            
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }    
    }
    
    function activarCli($id) {
        try {            
            $sth = $this->db->prepare('CALL SP_ACTIVAR_CLIENTE (?,@MENSAJE)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $sth->closeCursor();
            $sms = $this->db->query("SELECT @MENSAJE AS mensaje")->fetch(PDO::FETCH_ASSOC);
            $mensaje = sprintf($sms['mensaje']);
            return $mensaje;
            
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }    
    }
    
    function listarProveedor() {
       ///return $this->db->query("CALL SP_LISTAR_PROVEEDOR()");
       try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PROVEEDOR ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
    function listarBajasCliente() {
       return $this->db->query("CALL SP_LISTAR_CLIENTE_BAJAS()");
    }

}
