<?php
class ReporteVenta_Model extends Model
{
    function __construct()
    {
        parent::__construct();
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

    function consultarVentas($idperiodo,$comprobante,$idalmacen) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_VENTA_POR_PERIODO (?,?,?)');           
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);
            $sth->bindParam(2, $comprobante, PDO::PARAM_STR);
            $sth->bindParam(3, $idalmacen, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    } 
}
