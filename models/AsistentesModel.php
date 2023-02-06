<?php
class AsistentesModel
{
    private $db;
    private $asistentes;

    public function __construct()
    {
        $this->db = Conectar::conexion();
    }

    public function getAllAsistentes()
    {
        $sql = "SELECT * FROM asistentes";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->asistentes[] = $row;
        }
        return $this->asistentes;

    }

    public function getAsistente($id)
    {
        $sql = "SELECT * FROM asistentes WHERE id = $id";
        $resultado = $this->db->query($sql);
        while($row = $resultado->fetch_assoc()){
            $this->asistentes[] = $row;
        }
        return $this->asistentes;

    }

    public function createAsistente($acta_id, $asistente_id)
    {
        $resultado = $this->db->query(
            "INSERT INTO asistentes (acta_id, asistente_id) 
             VALUES ('$acta_id', '$asistente_id')"
        );
        $idRegistro = $this->db->insert_id;
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'asistente creado',
            'asistente' => $this->getAsistente($idRegistro)
        );
        echo (json_encode($res, true));
    }

    public function updateAsistente($id, $acta_id, $asistente_id)
    {
        $resultado = $this->db->query(
            "UPDATE asistentes
             SET acta_id = '$acta_id', 
                 asistente_id = '$asistente_id'
             WHERE id = '$id'"
        );
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'asistente actualizado',
            'asistente' => $this->getAsistente($id)
        );
        echo (json_encode($res, true));
    }

    public function deleteAsistente($id)
    {
        header('Content-type:application/json;charset=utf-8');
        $resultado = $this->db->query("DELETE FROM asistentes WHERE id = $id");
        $res = array(
            'ok' => "true",
            'msj' => 'asistente eliminado'
        );
        echo (json_encode($res, true));
    }
}
?>