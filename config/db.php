<?php

class Conectar
{
    public static function conexion()
    {
        $conexion = new mysqli("localhost", "root", "", "taller_actas");
        return $conexion;
    }
}
?>