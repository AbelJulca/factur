<?php
class Empresa_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listarEmpresa()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_EMPRESA ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function obtenerEmpresa($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_EMPRESA_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarPais()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PAIS ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarDepartamento()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_DEPARTAMENTO ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarProvincia($codigo)
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PROVINCIA (?)');
            $sth->bindParam(1, $codigo, PDO::PARAM_STR, 2);
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarDistrito($depar, $provin)
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_DSITRITO (?,?)');
            $sth->bindParam(1, $depar, PDO::PARAM_STR, 2);
            $sth->bindParam(2, $provin, PDO::PARAM_STR, 2);
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarDistritoEdit($depar, $provin)
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_DSITRITO (?,?)');
            $sth->bindParam(1, $depar, PDO::PARAM_STR, 2);
            $sth->bindParam(2, $provin, PDO::PARAM_STR, 2);
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function ubigeo($depar, $provi, $dist)
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_UBIGEO (?,?,?)');
            $sth->bindParam(1, $depar, PDO::PARAM_STR, 2);
            $sth->bindParam(2, $provi, PDO::PARAM_STR, 2);
            $sth->bindParam(3, $dist, PDO::PARAM_STR, 2);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertEmpresa($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_EMPRESA (?,@MENSAJE)');
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

    function updateEmpresa($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_EMPRESA (?,@MENSAJE)');
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

    function deleteEmpresa($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_EMPRESA (?,@MENSAJE)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $sth->closeCursor();
            $sms = $this->db->query("SELECT @MENSAJE AS mensaje")->fetch(PDO::FETCH_ASSOC);
            $mensaje = sprintf($sms['mensaje']);
            return $mensaje;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA" . $e->getMessage();
            return $mensaje;
        }
    }
}
