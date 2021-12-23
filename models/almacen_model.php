<?php
class Almacen_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function listarSucursal()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_SUCURSAL ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarAlmacen()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_ALMACEN ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarEmpresa()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_EMPRESA_ALMACEN ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
    //********INICIO**************PROCEDIMIENTO PRESTADO DE SP_EMPRESA */

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
    //********************FIN************************************* */

    function insertSucursal($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_SUCURSAL (?,@MENSAJE)');
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

    function updateSucursal($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_SUCURSAL (?,@MENSAJE)');
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

    function deleteSucursal($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_SUCURSAL (?,@MENSAJE)');
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

    function insertAlmacen($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_ALMACEN (?,@MENSAJE)');
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

    function updateAlmacen($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_UPDATE_ALMACEN (?,@MENSAJE)');
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

    function deleteAlmacen($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_ALMACEN (?,@MENSAJE)');
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

    function sucursalId($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_SUCURSAL_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function almacenId($id)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ALMACEN_CODIGO (?)');
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function listarTipoComprobante()
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_TIPO_COMPROBANTE ()');
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function insertSerie($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_SERIE (?,@MENSAJE)');
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

    function listarSeriesCodigo($codigo)
    {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_SERIE_CODIGO (?)');
            $sth->bindParam(1, $codigo, PDO::PARAM_INT);
            $sth->execute();
            $datos =  $sth->fetchAll(PDO::FETCH_NAMED);
            return $datos;
            return $mensaje;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function deleteSerie($codigo_d,$codigo_s)
    {
        try {
            $sth = $this->db->prepare('CALL SP_ELIMINAR_SERIE_CODIGO(?,?,@MENSAJE)');
            $sth->bindParam(1, $codigo_d, PDO::PARAM_INT);
            $sth->bindParam(2, $codigo_s, PDO::PARAM_INT);
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
