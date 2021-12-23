<?php
class Cliente_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listarCliente()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_CLIENTE ()');
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

    function buscarClientenrodoc($nrodoc)
    {
        try {
            $sth = $this->db->prepare('CALL SP_BUSCAR_DOC (?)');
            $sth->bindParam(1, $nrodoc, PDO::PARAM_STR);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertCliente($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_CLIENTE (?,@MENSAJE)');
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

    function updateCliente($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_CLIENTE (?,@MENSAJE)');
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

    function deleteCliente($id) {
        try {
            
            $sth = $this->db->prepare('CALL SP_ELIMINAR_CLIENTE (?,@MENSAJE)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
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
