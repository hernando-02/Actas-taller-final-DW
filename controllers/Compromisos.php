<?php

class CompromisosController
{
    public function __construct()
    {
        require_once "models\CompromisosModel.php";
    }

    public function index()
    {
        header("Content-Type:application/json;charset=utf-8");
        $compromisos = new CompromisosModel();
        echo (json_encode($compromisos->getAllCompromisos()));
    }

    public function getOne()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $id = $_GET['id'];

            header('Content-type:application/json;charset=utf-8');
            $compromisos = new CompromisosModel();
            echo (json_encode($compromisos->getCompromiso($id)));

        }
    }

    public function create()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $acta_id = $body['acta_id'];
            $responsable_id = $body['responsable_id'];
            $descripcion = $body['descripcion'];
            $fecha_inicio = $body['fecha_inicio'];
            $fecha_final = $body['fecha_final'];

            $compromisos = new CompromisosModel();
            $compromisos->createCompromiso($acta_id, $responsable_id, $descripcion, $fecha_inicio, $fecha_final);
        }
    }

    public function update()
    {
        $body = json_decode(file_get_contents("php://input"), true);
        if($_SERVER["REQUEST_METHOD"] == "PUT"){

            $id = $body['id'];
            $acta_id = $body['acta_id'];
            $responsable_id = $body['responsable_id'];
            $descripcion = $body['descripcion'];
            $fecha_inicio = $body['fecha_inicio'];
            $fecha_final = $body['fecha_final'];

            $compromisos = new CompromisosModel();
            $compromisos->updateCompromiso($id, $acta_id, $responsable_id, $descripcion, $fecha_inicio, $fecha_final);

        }
    }

    public function delete()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

            $id = $_GET['id'];

            $compromiso = new CompromisosModel();
            $compromiso->deleteCompromiso($id);

        }
    }
}
?>