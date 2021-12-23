<?php
class Guiaremision_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listarTipoComprobante()
    {
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

    function listarMotivoGuia() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_MOTIVO ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarModoGuia() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_MODO_GUIA ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarUnidadGuia() {
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

    function listarDocumento()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_DOCUMENTO ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
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

    function insertGuiaremision($content) {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_GUIA_REMISION (?,@MENSAJE)');
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

    function obtenerMotivo($id) {
        try {
            $sth = $this->db->prepare('CALL SP_OBTENER_MOTIVO_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerGuia($id) {
        try {
            $sth = $this->db->prepare('CALL SP_GUIA_REMISION_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerGuiaTwo($id) {
        try {
            $sth = $this->db->prepare('CALL SP_GUIA_REMISION_CODIGO_TWO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerDetalleGuia($id) {
        try {
            $sth = $this->db->prepare('CALL SP_OBTENER_DETALLE_GUIA (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerCliente($id) {
        try {
            $sth = $this->db->prepare('CALL SP_BUSCAR_CLIENTE_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function actalizarGuia($data) {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_GUIA_CODIGO (?,?,?,?,?,?,?)');
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

    function actalizarGuiaError($data) {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_GUIA_CODIGO_ERROR (?,?,?,?,?,?)');
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
}
 