<?php
class Bajaboletas_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listarBoletasTobajas($comp, $idalmacen, $fecha_actual, $fecha_atras) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_BAJAS_TO_COMPROBANTE(?,?,?,?)');
            $sth->bindParam(1, $comp, PDO::PARAM_STR);
            $sth->bindParam(2, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(3, $fecha_actual, PDO::PARAM_STR);
            $sth->bindParam(4, $fecha_atras, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerSerieCorre($almacen,$tipocomp)
    {
        try {
            $sth = $this->db->prepare('CALL SP_GET_SERIE_RESUMEN (?,?)');
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

    function updateSerie($idserie)
    {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_SERIE_RESUMEN (?,@MENSAJE)');
            $sth->bindParam(1, $idserie, PDO::PARAM_INT);
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

    function actalizarVentaBaja($data) {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_VENTA_BAJA (?,?,?,?,?,?,?,?)');
            $sth->bindParam(1, $data['idventa'], PDO::PARAM_INT);
            $sth->bindParam(2, $data['xml'], PDO::PARAM_STR);
            $sth->bindParam(3, $data['cdr'], PDO::PARAM_STR);
            $sth->bindParam(4, $data['codsunat_baja'], PDO::PARAM_STR);
            $sth->bindParam(5, $data['fecha_enviosunat'], PDO::PARAM_STR);
            $sth->bindParam(6, $data['ticket'], PDO::PARAM_STR);
            $sth->bindParam(7, $data['statussunat_baja'], PDO::PARAM_STR);
            $sth->bindParam(8, $data['estado'], PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

}
 