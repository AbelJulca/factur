<?php
class Reportekardex_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function obtenerProductoNombre($nombre) {
        try {
            $sth = $this->db->prepare('CALL SP_KARDEX_PRODUCTO_LIKE_NOMBRE (?)');           
            $sth->bindParam(1, $nombre, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
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

    function obtenerProducto($idalmacen,$idarticulo,$fechainicio,$fechafin) {
        try {
            $sth = $this->db->prepare('CALL SP_KARDEX_INDIVIDUAL (?,?,?,?)');           
            $sth->bindParam(1, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(2, $idarticulo, PDO::PARAM_INT);
            $sth->bindParam(3, $fechainicio, PDO::PARAM_STR);
            $sth->bindParam(4, $fechafin, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerProductoExcel($idalmacen,$idarticulo,$fechainicio,$fechafin) {
        try {
            $sth = $this->db->prepare('CALL SP_KARDEX_INDIVIDUAL_EXCEL (?,?,?,?)');           
            $sth->bindParam(1, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(2, $idarticulo, PDO::PARAM_INT);
            $sth->bindParam(3, $fechainicio, PDO::PARAM_STR);
            $sth->bindParam(4, $fechafin, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerProductoGnd($idalmacen,$fechainicio,$fechafin) {
        try {
            $sth = $this->db->prepare('CALL SP_KARDEX_GENERAL (?,?,?)');           
            $sth->bindParam(1, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(2, $fechainicio, PDO::PARAM_STR);
            $sth->bindParam(3, $fechafin, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerIdProductoGnd($idalmacen,$fechainicio,$fechafin) {
        try {
            $sth = $this->db->prepare('CALL SP_KARDEX_GENERAL_ART (?,?,?)');           
            $sth->bindParam(1, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(2, $fechainicio, PDO::PARAM_STR);
            $sth->bindParam(3, $fechafin, PDO::PARAM_STR);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
}
 