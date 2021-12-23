<?php
class Categoria_Model extends Model{
    function __construct() {
        parent::__construct();
    }

    function listarCategoria() {        
        try {
             $sth = $this->db->prepare('CALL SP_LISTAR_CATEGORIA ()');           
             $sth->execute();
             $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
             return $datos;
         } catch (Exception $e) {
             $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
             return $mensaje;
         }
    }
    function listarTipoArticulo() {        
        try {
             $sth = $this->db->prepare('CALL SP_LISTAR_TIPO_ARTICULO ()');           
             $sth->execute();
             $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
             return $datos;
         } catch (Exception $e) {
             $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
             return $mensaje;
         }
    }

    function insertCategoria($descrip) {
        try {            
            $sth = $this->db->prepare('CALL SP_INSERTAR_CATEGORIA (?,@MENSAJE)');
            $sth->bindParam(1, $descrip, PDO::PARAM_STR,255);
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

    function updateCategoria($id,$descrip) {
        try {            
            $sth = $this->db->prepare('CALL SP_MODIFICAR_CATEGORIA (?,?,@MENSAJE)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->bindParam(2, $descrip, PDO::PARAM_STR,255);
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

    function deleteCategoria($id) {
        try {            
            $sth = $this->db->prepare('CALL SP_ELIMINAR_CATEGORIA (?,@MENSAJE)');
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

    function insertTipoArticulo($descrip) {
        try {            
            $sth = $this->db->prepare('CALL SP_INSERTAR_TIPO_ARTICULO (?,@MENSAJE)');
            $sth->bindParam(1, $descrip, PDO::PARAM_STR,255);
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

    function updateTipoArticulo($id,$descrip) {
        try {            
            $sth = $this->db->prepare('CALL SP_MODIFICAR_TIPO_ARTICULO (?,?,@MENSAJE)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->bindParam(2, $descrip, PDO::PARAM_STR,255);
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

    function deleteTipoArticulo($id) {
        try {            
            $sth = $this->db->prepare('CALL SP_ELIMINAR_TIPO_ARTICULO (?,@MENSAJE)');
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
}