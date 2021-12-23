<?php
class Reportebajacompras_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function comprasPeriodo($idperiodo,$idalmacen) {
        try {
            $sth = $this->db->prepare('CALL SP_BAJA_COMPRAS_POR_PERIODO (?,?)');           
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);
            $sth->bindParam(2, $idalmacen, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function comprasProveedor($idperiodo,$idalmacen,$idproveedor) {
        try {
            $sth = $this->db->prepare('CALL SP_BAJA_COMPRAS_POR_PERIODO_PROVE (?,?,?)');           
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);
            $sth->bindParam(2, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(3, $idproveedor, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    } 
}
