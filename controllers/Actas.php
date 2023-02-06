<?php

class ActasController
{
    public function __construct()
    {
        require_once "models/ActasModel.php";
    }

    public function index()
    {
        header("Content-type:application/json;charset=utf-8");
        $actas = new ActasModel();
        echo (json_encode($actas->getAllActas()));
    }

    public function getOne()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $id = $_GET['id'];

            header('Content-type:application/json;charset=utf-8');
            $acta = new ActasModel();
            echo (json_encode($acta->getActa($id)));

        }
    }

    public function create()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $asunto = $body['asunto'];
            $hora_inicio = $body['hora_inicio'];
            $hora_final = $body['hora_final'];
            $responsable_id = $body['responsable_id'];
            $orden_del_dia = $body['orden_del_dia'];
            $descripcion_hechos = $body['descripcion_hechos'];


            $acta = new ActasModel();
            $acta->createActa($asunto, $hora_inicio, $hora_final, $responsable_id, $orden_del_dia, $descripcion_hechos);
        }
    }

    public function update()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "PUT") {

            $id = $body['id'];
            $asunto = $body['asunto'];
            $hora_inicio = $body['hora_inicio'];
            $hora_final = $body['hora_final'];
            $responsable_id = $body['responsable_id'];
            $orden_del_dia = $body['orden_del_dia'];
            $descripcion_hechos = $body['descripcion_hechos'];

            $acta = new ActasModel();
            $acta->updateActa($id, $asunto, $hora_inicio, $hora_final, $responsable_id, $orden_del_dia, $descripcion_hechos);
        }
    }

    public function delete()
    {
        $body = json_decode(file_get_contents("php://input"), true);

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

            $id = $_GET['id'];

            $acta = new ActasModel();
            $acta->deleteActa($id);

        }
    }

    public function informeFecha()
    {

        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $fechaInicial = $_GET['fechaInicial'];
            $fechaFinal = $_GET['fechaFinal'];

            $acta = new ActasModel();
            $acta->filtroPorFechas($fechaInicial, $fechaFinal);

        }
    }

    public function informeCompromisosPendientes()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $acta = new ActasModel();
            $acta->listaActasCompromisosPendientes();

        }
    }

    public function informeActasPorUsuarioCreacion()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $id = $_GET['id'];
            
            $acta = new ActasModel();
            $acta->filtroPorUsuarioCreacion($id);

        }
    }

    public function informeActasPorAsunto()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            
            $asunto = $_GET['asunto'];

            $acta = new ActasModel();
            $acta->filtroPorAsunto($asunto);
        }
    }


}
?>