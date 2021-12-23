<?php

class Producto_Model extends Model
{
    function __construct() {
        parent::__construct();
    }

    function listarArticulo() {
         try {
             $sth = $this->db->prepare('CALL SP_LISTAR_PRODUCTO ()');           
             $sth->execute();
             $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
             return $datos;
         } catch (Exception $e) {
             $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
             return $mensaje;
         }
    }

    function buscarProductoId($codigo){
        try {
            $sth = $this->db->prepare('CALL SP_BUSCAR_PRODUCTO_CODIGO (?)');
            $sth->bindParam(1, $codigo, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarUnidad() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_UNIDAD ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
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

    function listarTipo() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_TIPO ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
             return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
    //**************** PRESTADO DE LA MODEL LABORATOTIO */
    function listarTablaLaboratorio() {
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
    //***************************************************** */

    function listarTablaAfectacion() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_TIPO_AFECTACION ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
             return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertProducto($content){
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_PRODUCTO (?,@MENSAJE)');
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

    function updateProducto($content){
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_PRODUCTO (?,@MENSAJE)');
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

    function deleteProducto($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_PRODUCTO (?,@MENSAJE)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $sth->closeCursor();
            $sms = $this->db->query("SELECT @MENSAJE AS mensaje")->fetch(PDO::FETCH_ASSOC);
            $mensaje = sprintf($sms['mensaje']);
            return $mensaje;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA" . $e->getMessage();
            return $mensaje;
        }
    }    
    
}
