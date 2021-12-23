<?php
class Laboratorio_Model extends Model
{
    function __construct() {
        parent::__construct();
    }

    function listarLaboratorio()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_LABORATORIO ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertLaboratorio($content){
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_LABORATORIO (?,@MENSAJE)');
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

    function updateLaboratorio($content){
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_LABORATORIO (?,@MENSAJE)');
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

    function deleteLaboratorio($id) {
        try {            
            $sth = $this->db->prepare('CALL SP_ELIMINAR_LABORATORIO (?,@MENSAJE)');
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

    function obtenerLaboratorio($id) {
        try {            
            $sth = $this->db->prepare('CALL SP_BUSCAR_LABORATORIO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;           
        } catch (Exception $e) {            
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }    
    }
}
