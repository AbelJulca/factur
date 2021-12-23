<?php
class Compras_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    //******************PROCEDIMIENTO ALMACENADO DE SP_ALMACEN */

    function listarTipoDocumento() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_TIPO_COMPROBANTE ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    //******************PROCEDIMIENTO ALMACENADO DE SP_PERIODO  */

    function listarEjercicio() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_EJERCICIO ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    //******************PROCEDIMIENTO ALMACENADO DE SP_ORDEN_COMPRAS  */
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

    function listarPeriodo() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PERIODO ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarFormaPago() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_FORMAPAGO ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
//**********************PROCEDIMIENTO ALMACENADO DE SP_ORDEN_COMPRAS */
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

    function listarOrdenCompra($serie,$correlativo) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_ORDENCOMPRA_SERIE (?,?)');
            $sth->bindParam(1, $serie, PDO::PARAM_STR);
            $sth->bindParam(2, $correlativo, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarDetalleOrdenCompra($codigo) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_DETALLE_ORDENCOMPRA (?)');
            $sth->bindParam(1, $codigo, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertCompra($content){
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_COMPRA (?,@MENSAJE)');
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

    function obtenerCompra($id) {
        try {
            $sth = $this->db->prepare('CALL SP_COMPRA_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function detalleCompra($id) {
        try {
            $sth = $this->db->prepare('CALL SP_DETALLE_COMPRA_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarvalidarPeriodo($fecha) {
        try {
            $sth = $this->db->prepare('CALL SP_PERIODO_ACTUAL (?)');
            $sth->bindParam(1, $fecha, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

}
