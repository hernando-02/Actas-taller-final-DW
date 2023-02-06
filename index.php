<?php

require_once "config/config.php";
require_once "core/routes.php";
require_once "config/db.php";
require_once "controllers/Usuarios.php";

session_start();

header('Content-type:application/json;charset=utf-8');
if (isset($_SESSION['id']) and isset($_GET['c'])) {

    $controlador = cargarControlador($_GET['c']);

    if (isset($_GET['a'])) {
        if (isset($_GET['id'])) {
            cargarAccion($controlador, $_GET['a'], $_GET['id']);
        } else {
            cargarAccion($controlador, $_GET['a']);
        }
    }

} elseif ($_GET['c'] == 'usuarios') {

    $controlador = cargarControlador($_GET['c']);
    
    // si se va a crear un usuario o hacer login:
    if ($_GET['a'] == 'create' or $_GET['a'] == 'login' or $_GET['a'] == 'updatePassword' ) {
        cargarAccion($controlador, $_GET['a']);
    } else {
        echo (json_encode(array('ok' => "false", 'msj' => 'error, no tiene acceso a este modulo'), true));
    }

} else {
    echo (json_encode(array('ok' => "false", 'msj' => 'error, no ha iniciado sesion'), true));
}
?>