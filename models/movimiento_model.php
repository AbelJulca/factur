<?php
class Movimiento_Model extends Model
{ 
    function __construct()
    {
        parent::__construct();
    }

    function ListaMovimiento($idperiodo,$idalmacen,$idusuario){        
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_MOVIMIENTO_CAJA (?,?,?)');
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);
            $sth->bindParam(2, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(3, $idusuario, PDO::PARAM_INT);         
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function buscarMovimientoId($codigo){
        try {
            $sth = $this->db->prepare('CALL SP_BUSCAR_MOVIMIENTO_CODIGO (?)');
            $sth->bindParam(1, $codigo, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertMovimiento($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_MOVIMIENTO_CAJA (?,@MENSAJE)');
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

    function actualizarMovimiento($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_MOVIMIENTO_CAJA (?,@MENSAJE)');
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
}
