<?php
class Acceso_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listarMenu()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_MENU ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarPerfil()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_PERFIL ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertPerfil($nombre)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_PERFIL (?,@MENSAJE)');
            $sth->bindParam(1,$nombre, PDO::PARAM_STR);
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

    function updatePerfil($id,$nombre)
    {
        try {
            $sth = $this->db->prepare('CALL SP_MODIFICAR_PERFIL (?,?,@MENSAJE)');
            $sth->bindParam(1,$id, PDO::PARAM_STR);
            $sth->bindParam(2,$nombre, PDO::PARAM_STR);
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

    function deletePerfil($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_PERFIL (?,@MENSAJE)');
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

    function listarHijos($idperfil,$padre)
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_HIJOS (?,?)');
            $sth->bindParam(1,$idperfil, PDO::PARAM_INT);
            $sth->bindParam(2,$padre, PDO::PARAM_STR);
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function updatePermisoCero($idperfil,$nombre)
    {
        try {
            $sth = $this->db->prepare('CALL SP_MODIFICAR_PERMISOS_CERO (?,?)');
            $sth->bindParam(1,$idperfil, PDO::PARAM_INT);
            $sth->bindParam(2,$nombre, PDO::PARAM_STR);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function updatePermiso($value)
    {
        try {
            $sth = $this->db->prepare('CALL SP_MODIFICAR_PERMISOS (?,@MENSAJE)');
            $sth->bindParam(1,$value, PDO::PARAM_INT);
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

    function updatePadre($idperfil,$padre,$estado)
    {
        try {
            $sth = $this->db->prepare('CALL SP_MODIFICAR_ESTADO_PADRE (?,?,?,@MENSAJE)');
            $sth->bindParam(1,$idperfil, PDO::PARAM_INT);
            $sth->bindParam(2,$padre, PDO::PARAM_STR);
            $sth->bindParam(3,$estado, PDO::PARAM_STR);
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
