<?php

class ActasModel
{

    private $db;
    private $actas;

    public function __construct()
    {
        $this->db = Conectar::conexion();
    }


    public function getAllActas()
    {
        $sql = "SELECT * FROM actas";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->actas[] = $row;
        }
        return $this->actas;
    }


    public function getActa($id)
    {
        $sql = "SELECT * FROM actas WHERE id = '$id'";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $actas[] = $row;
        }
        return $actas;
    }


    public function createActa($asunto, $hora_inicio, $hora_final, $responsable_id, $orden_del_dia, $descripcion_hechos)
    {
        $fecha_creacion =  date("Y-m-d");
        $creador_id = $_SESSION['id'];
        $resultado = $this->db->query(
            "INSERT INTO actas ( creador_id,asunto,fecha_creacion,hora_inicio,hora_final,responsable_id,orden_del_dia,descripcion_hechos )
            VALUES ('$creador_id', '$asunto', '$fecha_creacion', '$hora_inicio', '$hora_final', '$responsable_id', '$orden_del_dia', '$descripcion_hechos')"
        );
        $idRegistro = $this->db->insert_id;
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'acta creada',
            'acta' => $this->getActa($idRegistro)
        );
        echo (json_encode($res, true));
    }


    public function updateActa($id, $asunto, $hora_inicio, $hora_final, $responsable_id, $orden_del_dia, $descripcion_hechos)
    {
        $resultado = $this->db->query(
            "UPDATE actas
             SET asunto = '$asunto',
                 hora_inicio = '$hora_inicio',
                 hora_final = '$hora_final',
                 responsable_id = '$responsable_id',
                 orden_del_dia = '$orden_del_dia',
                 descripcion_hechos = '$descripcion_hechos'
             WHERE id = '$id'"
        );
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'acta actualizada',
            'acta' => $this->getActa($id)
        );
        echo (json_encode($res, true));
    }


    public function deleteActa($id)
    {
        header('Content-type:application/json;charset=utf-8');
        $resultado = $this->db->query("DELETE FROM actas WHERE id = '$id'");
        $res = array(
            'ok' => "true",
            'msj' => 'acta eliminada'
        );
        echo (json_encode($res, true));
    }

    public function filtroPorFechas($fechaInicial, $fechaFinal)
    {
        header('Content-type:application/json;charset=utf-8');
        $sql = "SELECT * FROM  actas a WHERE fecha_creacion BETWEEN '$fechaInicial' AND '$fechaFinal'";
        $resul = $this->db->query($sql);
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $actas[] = $row;
            }

            $res = array(
                'ok' => 'true',
                'msj' => 'se encontraron ' . $resul->num_rows . ' elementos',
                'actas' => $actas
            );
            echo (json_encode($res, true));
        } else {
            $res = array(
                'ok' => 'false',
                'msj' => 'no se encontraron elementos'
            );
            echo (json_encode($res, true));
        }
    }

    public function listaActasCompromisosPendientes()
    {
        header('Content-type:application/json;charset=utf-8');
        $sql = "SELECT DISTINCT a.* FROM actas a RIGHT JOIN compromisos c ON a.id = c.acta_id WHERE c.fecha_final = 'NULL'";
        $resul = $this->db->query($sql);
        if ($resul->num_rows > 0) {
            $i = 0;
            while ($row = $resul->fetch_assoc()) {
                $actas[] = $row;
                $actas[$i]['compromisos'] = $this->consultarCompromisoActa($actas[$i]['id']);
                $i++;
            }

            $res = array(
                'ok' => 'true',
                'msj' => 'se encontraron ' . $resul->num_rows . ' elementos',
                'actas' => $actas
            );
            echo (json_encode($res, true));
        } else {
            $res = array(
                'ok' => 'false',
                'msj' => 'no se encontraron compromisos pendientes'
            );
            echo (json_encode($res, true));
        }
    }

    private function consultarCompromisoActa($idActa)
    {
        $sql = "SELECT * FROM compromisos c WHERE acta_id = '$idActa' AND c.fecha_final = 'NULL'";
        $resul = $this->db->query($sql);
        while ($row = $resul->fetch_assoc()) {
            $acta[] = $row;
        }
        return $acta;
    }

    public function filtroPorUsuarioCreacion($idUsuarioCreacion)
    {
        header('Content-type:application/json;charset=utf-8');
        $sql = "SELECT * FROM actas a WHERE creador_id = '$idUsuarioCreacion'";
        $resul = $this->db->query($sql);
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $actas[] = $row;
            }
            $res = array(
                'ok' => 'true',
                'msj' => 'se encontraron ' . $resul->num_rows . ' elementos',
                'actas' => $actas
            );
            echo (json_encode($res, true));
        } else {
            $res = array(
                'ok' => 'false',
                'msj' => 'este usuario no ha creado actas'
            );
            echo (json_encode($res, true));
        }
    }

    public function filtroPorAsunto($asunto)
    {
        header('Content-type:application/json;charset=utf-8');
        $sql = "SELECT * FROM actas WHERE asunto LIKE('%$asunto%')";
        $resul = $this->db->query($sql);
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $actas[] = $row;
            }
            $res = array(
                'ok' => 'true',
                'msj' => 'se encontraron ' . $resul->num_rows . ' elementos',
                'actas' => $actas
            );
            echo (json_encode($res, true));
        } else {
            $res = array(
                'ok' => 'false',
                'msj' => 'este usuario no ha creado actas'
            );
            echo (json_encode($res, true));
        }
    }

}
?>