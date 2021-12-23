<?php
class Reporteguia_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }   
    
    function consultarGuia($idperiodo,$comprobante,$idalmacen,$idusuario) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_GUIA_POR_PERIODO_SUNAT (?,?,?,?)');           
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);
            $sth->bindParam(2, $comprobante, PDO::PARAM_STR);
            $sth->bindParam(3, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(4, $idusuario, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
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
}
 
