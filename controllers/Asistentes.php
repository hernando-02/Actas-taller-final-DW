<?php

class AsistentesController
{
    public function __construct()
    {
        require_once "models/AsistentesModel.php";
    }

    public function index()
    {
        header("Content-type:application/json;charset=utf-8");
        $asistentes = new AsistentesModel();
        echo (json_encode($asistentes->getAllAsistentes()));
    }

    public function getOne()
    {
        if($_SERVER["REQUEST_METHOD"]== "GET"){

            $id = $_GET['id'];
            header("Content-type:application/json;charset=utf-8");
            $asistente = new AsistentesModel();
            echo (json_encode($asistente->getAsistente($id)));
        }
    }

    public function create()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $acta_id = $body['acta_id'];
            $asistente_id = $body['asistente_id'];

            $asistente = new AsistentesModel();
            $asistente->createAsistente($acta_id, $asistente_id);
        }
    }

    public function update()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            $id = $body['id'];
            $acta_id = $body['acta_id'];
            $asistente_id = $body['asistente_id'];

            $asistente = new AsistentesModel();
            $asistente->updateAsistente($id, $acta_id, $asistente_id);
        }

    }

    public function delete()
    {
        if($_SERVER["REQUEST_METHOD"] == "DELETE"){
            $id = $_GET["id"];
            $asistente = new AsistentesModel();
            $asistente->deleteAsistente($id);
        }

    }


}
?>