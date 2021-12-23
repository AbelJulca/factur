<?php

class Usuario_Model extends Model
{
    function __construct() {
        parent::__construct();
    }

    function listarEmpresaCA($user) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_EMPRESA_ACCESSO (?)');
            $sth->bindParam(1, $user, PDO::PARAM_INT);           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarSucursalCA($id) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_SUCURSAL_ACCESSO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarAlmacenCA($id) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_ALMACEN_ACCESSO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarUsuarioAll() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_USER_ALL ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarUsuario() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_USER_EMPLEADO ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarPerfil() {
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

    function listarAlmacen() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_ALMACEN_SUCUR ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarSucursal() {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_SUCURSALES ()');           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarAlmacenIdSucursal($id) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_SUCURSALE_IDALMACEN (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function AccesoAlmacen($id) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_ACCESSO_ALMACEN (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function validarAccessoAlmacen($idusuario,$idalmacen){
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_ACCESSO_ALMACEN (?,?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);           
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertAccesso($idalmacen,$idusuario) {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_ACCESSO_ALMACEN (?,?,@MENSAJE)');
            $sth->bindParam(1, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(2, $idusuario, PDO::PARAM_INT);           
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

    function accesoEstado($id) {
        try {
            $sth = $this->db->prepare('CALL SP_ESTADO_ACCESSO (?,@MENSAJE)');
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

    function deleteAcceso($id) {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_ACCESSO (?,@MENSAJE)');
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

    function buscarUsuarionrodoc($nrodoc)
    {
        try {
            $sth = $this->db->prepare('CALL SP_BUSCAR_USER_DOC (?)');
            $sth->bindParam(1, $nrodoc, PDO::PARAM_STR);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function buscarUsuarioCodigo($nrodoc)
    {
        try {
            $sth = $this->db->prepare('CALL SP_BUSCAR_USER_CODIGO (?)');
            $sth->bindParam(1, $nrodoc, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertUsuario($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_USUARIO (?,@MENSAJE)');
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

    function updateUsuario($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ACTUALIZAR_USUARIO (?,@MENSAJE)');
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

    function deleteUsuario($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_USUARIO (?,@MENSAJE)');
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
