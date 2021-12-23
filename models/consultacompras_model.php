<?php

class Consultacompras_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    //*********************PROCEDIMIENTO ALMACENNADO SP_COMPRAS */
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

    function comprasPeriodo($idperiodo,$idalmacen) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_COMPRAS_POR_PERIODO (?,?)');           
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
            $sth = $this->db->prepare('CALL SP_LISTAR_COMPRAS_POR_PERIODO_PROVE (?,?,?)');           
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
