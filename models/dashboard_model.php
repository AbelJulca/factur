<?php
class Dashboard_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function consultarCantCliente() 
    {
        try {
            $sth = $this->db->prepare('CALL SP_CANT_CLIENTE ()');           
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function consultarCantVenta($idperiodo) 
    {
        try {
            $sth = $this->db->prepare('CALL SP_CANT_VENTA (?)'); 
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);          
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function consultarCantCompras($idperiodo) 
    {
        try {
            $sth = $this->db->prepare('CALL SP_CANT_COMPRAS (?)'); 
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);          
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function consultarCantProveedor() 
    {
        try {
            $sth = $this->db->prepare('CALL SP_CANT_PROVEEDOR ()');        
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerMeses($year) 
    {
        try {
            $sth = $this->db->prepare('CALL SP_MESES (?)'); 
            $sth->bindParam(1, $year, PDO::PARAM_STR);          
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
}
 