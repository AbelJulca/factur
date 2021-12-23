<?php
class Caja_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function agregarCaja($content)
    {
        try {
            $sth = $this->db->prepare('CALL SP_INSERTAR_CAJA (?,@MENSAJE)');
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

    function verificarCaja($idusuario, $idalmacen, $fecha, $idcaja) {
        try {
            $sth = $this->db->prepare('CALL SP_VERIFICAR_CAJA (?,?,?,?,@MENSAJE,@MONTO,@ID)');
            $sth->bindParam(1, $idusuario, PDO::PARAM_INT);
            $sth->bindParam(2, $idalmacen, PDO::PARAM_STR);  
            $sth->bindParam(3, $fecha, PDO::PARAM_STR);  
            $sth->bindParam(4, $idcaja, PDO::PARAM_INT);         
            $sth->execute();
            $sth->closeCursor();
            $sms = $this->db->query("SELECT @MENSAJE AS mensaje, @MONTO AS monto, @ID AS id")->fetch(PDO::FETCH_ASSOC);
            $mensaje =[
                0 =>  sprintf($sms['mensaje']),
                1 =>  sprintf($sms['monto']),
                2 =>  sprintf($sms['id'])
            ];
            return $mensaje;
        } catch (Exception $e) {
            $mensaje = [
                0 => "ERORR DEL SISTEMA " . $e->getMessage(),
                1 => 'ERROR'
            ];
            return $mensaje;
        }
    }

    function finalizarCaja($idcaja) {
        try {
            $sth = $this->db->prepare('CALL SP_FINALIZAR_CAJA (?,@MENSAJE)');
            $sth->bindParam(1, $idcaja, PDO::PARAM_INT);
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

    function cajaPeriodo($idperiodo,$idalmacen,$idusuario) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_CAJA_PERIODO (?,?,?)');           
            $sth->bindParam(1, $idperiodo, PDO::PARAM_INT);
            $sth->bindParam(2, $idalmacen, PDO::PARAM_INT);
            $sth->bindParam(3, $idusuario, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }

    function cajaTotales($idcaja) {
        try {
            $sth = $this->db->prepare('CALL SP_LISTAR_CAJA_TOTALES (?)');           
            $sth->bindParam(1, $idcaja, PDO::PARAM_INT);
            $sth->execute();
            $datos = $sth->fetch(PDO::FETCH_NAMED);
            return $datos;
        } catch (Exception $e) {
            $mensaje = "ERORR DEL SISTEMA " . $e->getMessage();
            return $mensaje;
        }
    }
}
