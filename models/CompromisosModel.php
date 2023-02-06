<?php

class CompromisosModel
{
    private $db;
    private $compromisos;

    public function __construct()
    {
        $this->db = Conectar::conexion();
    }

    public function getAllCompromisos()
    {
        $sql = "SELECT * FROM compromisos";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->compromisos[] = $row;
        }
        return $this->compromisos;
    }

    public function getCompromiso($id)
    {
        $sql = "SELECT * FROM compromisos WHERE id = '$id'";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $compromisos[] = $row;
        }
        return $compromisos;
    }
    
    public function createCompromiso($acta_id, $responsable_id, $descripcion, $fecha_inicio, $fecha_final)
    {
        $resultado = $this->db->query(
            "INSERT INTO compromisos ( acta_id, responsable_id, descripcion, fecha_inicio, fecha_final )
            VALUES ('$acta_id', '$responsable_id', '$descripcion', '$fecha_inicio', '$fecha_final')"
        );
        $idRegistro = $this->db->insert_id;
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'compromiso creado',
            'compromiso' => $this->getCompromiso($idRegistro)
        );
        echo (json_encode($res, true));
    }

    public function updateCompromiso($id, $acta_id, $responsable_id, $descripcion, $fecha_inicio, $fecha_final)
    {
        $resultado = $this->db->query(
            "UPDATE compromisos
             SET acta_id= '$acta_id',
                 responsable_id= '$responsable_id',
                 descripcion= '$descripcion',
                 fecha_inicio= '$fecha_inicio',
                 fecha_final= '$fecha_final'
             WHERE id= '$id'"
        );
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'compromiso actualizado',
            'compromiso' => $this->getCompromiso($id)
        );
        echo (json_encode($res, true));
    }

    public function deleteCompromiso($id)
    {
        header('Content-type:application/json;charset=utf-8');
        $resultado = $this->db->query("DELETE FROM compromisos WHERE id = '$id'");
        $res = array(
            'ok' => "true",
            'msj' => 'compromiso eliminado'
        );
        echo (json_encode($res, true));
    }
}
?>