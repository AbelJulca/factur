<?php
class Orden_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }
//********************* FUNCION DE SP_PROVEEDOR ************* */
    function listarProveedor() {        
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
//****************** FIN ****************************************/
//********************* FUNCION DE SP_USUARIO ************* */
    function listarAlmacen() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_ALMACEN_SUCUR ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
//****************** FIN ****************************************/

    function obtenerAlmacen($codigo)
    {
        try {
            $sth = $this->db->prepare('CALL SP_GET_ALMACEN_USUARIO (?,@MENSAJE)');
            $sth->bindParam(1, $codigo, PDO::PARAM_INT);
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

    function obtenerSerieCorre($almacen,$tipocomp)
    {
        try {
            $sth = $this->db->prepare('CALL SP_GET_SERIE_CORR (?,?)');
            $sth->bindParam(1, $almacen, PDO::PARAM_INT);
            $sth->bindParam(2, $tipocomp, PDO::PARAM_STR);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA" . $e->getMessage();
            return $mensaje;
        }
    }

    function listarMoneda() {
        return $this->db->query("CALL SP_LISTAR_MONEDA()");
    }

    function obtenerProductoNombre($nombre) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PRODUCTO_LIKE_NOMBRE (?)');           
            $sth->bindParam(1, $nombre, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerProductoCodigo($codigo) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PRODUCTO_CODIGO (?)');
            $sth->bindParam(1, $codigo, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerOrdenCompra($id) {
        try {
            $sth = $this->db->prepare('CALL SP_ORDEN_COMPRA_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function detalleOrdenCompra($id) {
        try {
            $sth = $this->db->prepare('CALL SP_ORDEN_DETALLE_COMPRA_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertOrden($content){
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_ORDEN_COMPRA (?,@MENSAJE)');
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
}
