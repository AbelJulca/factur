<?php
class Comprobante_Model extends Model
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

    //******************PROCEDIMIENTO ALMACENADO DE SP_ORDEN_COMPRAS  */
    function obtenerProductoNombre($nombre,$idalmacen) {
        try {
            $sth = $this->db->prepare('CALL SP_VENTA_PRODUCTO_LIKE_NOMBRE (?,?)');           
            $sth->bindParam(1, $nombre, PDO::PARAM_STR);
            $sth->bindParam(2, $idalmacen, PDO::PARAM_INT);
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
            $sth = $this->db->prepare('CALL SP_VENTA_PRODUCTO_CODIGO (?)');
            $sth->bindParam(1, $codigo, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarTipoNrodoc() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_TIPO_DOCUMENTO ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerClienteDni($dni) {
        try {
            $sth = $this->db->prepare('CALL SP_CLIENTE_DNI (?)');
            $sth->bindParam(1, $dni, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertCliente($content) {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_CLIENTE_VENTA (?)');
            $sth->bindParam(1, $content, PDO::PARAM_LOB);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertVenta($content) {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_VENTA (?,@MENSAJE)');
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

    function obtenerEmpresa($idalmacen) {
        try {
            $sth = $this->db->prepare('CALL SP_EMPRESA_IDALMACEN (?)');
            $sth->bindParam(1, $idalmacen, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }


    function obtenerVenta($id) {
        try {
            $sth = $this->db->prepare('CALL SP_VENTA_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function detalleVenta($id) {
        try {
            $sth = $this->db->prepare('CALL SP_DETALLE_VENTA_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function actalizarVenta($data) {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_VENTA_CODIGO (?,?,?,?,?,?,?)');
            $sth->bindParam(1, $data['idventa'], PDO::PARAM_INT);
            $sth->bindParam(2, $data['xml'], PDO::PARAM_STR);
            $sth->bindParam(3, $data['cdr'], PDO::PARAM_STR);
            $sth->bindParam(4, $data['codigo'], PDO::PARAM_STR);
            $sth->bindParam(5, $data['hash'], PDO::PARAM_STR);
            $sth->bindParam(6, $data['fecha_envio'], PDO::PARAM_STR);
            $sth->bindParam(7, $data['mensajesunat'], PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function actalizarVentaError($data) {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_VENTA_CODIGO_ERROR (?,?,?,?,?,?)');
            $sth->bindParam(1, $data['idventa'], PDO::PARAM_INT);
            $sth->bindParam(2, $data['xml'], PDO::PARAM_STR);
            $sth->bindParam(3, $data['codigoerror'], PDO::PARAM_STR);
            $sth->bindParam(4, $data['hash'], PDO::PARAM_STR);
            $sth->bindParam(5, $data['fecha_envio'], PDO::PARAM_STR);
            $sth->bindParam(6, $data['mensajesunat'], PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerMotivo($tipo,$codigo) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_TABLA_PARAMETRICA_DES (?,?)');
            $sth->bindParam(1, $tipo, PDO::PARAM_STR);
            $sth->bindParam(2, $codigo, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

}
