<?php

class UsuarioModel
{
    private $db;
    private $usuarios;

    const HASH = PASSWORD_DEFAULT;
    const COST = 10;


    public function __construct()
    {
        $this->db = Conectar::conexion();
    }


    public function getAllUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->usuarios[] = $row;
        }

        return $this->usuarios;

    }


    public function getUsuario($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = '$id'";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $usuario[] = $row;
        }

        return $usuario;

    }


    public function createUsuario($username, $password, $nombres, $apellidos, $tipo_id)
    {
        $passHash = password_hash($password, self::HASH, ['cost' => self::COST]);
        $resultado = $this->db->query("INSERT INTO	usuarios ( username, password, nombres, apellidos, tipo_id ) 
        VALUES ('$username', '$passHash', '$nombres', '$apellidos', '$tipo_id')");
        $idRegistro = $this->db->insert_id;
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'usuario creado',
            'usuario' => $this->getUsuario($idRegistro)
        );
        echo (json_encode($res, true));

    }


    public function updateUsuario($id, $username, $nombres, $apellidos, $tipo_id)
    {
        $resultado = $this->db->query(
            "UPDATE usuarios 
             SET username='$username', nombres='$nombres', apellidos='$apellidos', tipo_id='$tipo_id'
             WHERE id = '$id'"
        );
        header('Content-type:application/json;charset=utf-8');
        $res = array(
            'ok' => "true",
            'msj' => 'usuario actualizado',
            'usuario' => $this->getUsuario($id)
        );
        echo (json_encode($res, true));

    }

    public function updatePassword($username, $nombres, $newPassword)
    {
        header('Content-type:application/json;charset=utf-8');

        $sql = "SELECT * FROM usuarios WHERE username = '$username' AND nombres = '$nombres'";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {

            $usuario = $result->fetch_assoc();

            $passHash = password_hash($newPassword, self::HASH, ['cost' => self::COST]);

            $id = $usuario['id'];

            $this->db->query(
                "UPDATE usuarios 
                 SET password='$passHash'
                 WHERE id = '$id'"
            );
            $res = array(
                'ok' => "true",
                'msj' => 'contraseña actualizada'
            );

        } else {
            $res = array(
                'ok' => "false",
                'msj' => 'usuario no encontrado, consultar al admin'
            );
        }
        echo (json_encode($res, true));
    }


    public function deleteUsuario($id)
    {
        header('Content-type:application/json;charset=utf-8');
        $this->db->query("DELETE FROM usuarios WHERE id = '$id'");
        $res = array(
            'ok' => "true",
            'msj' => 'usuario eliminado'
        );
        echo (json_encode($res, true));

    }

    public function login($username, $password)
    {
        if (!isset($_SESSION['id'])) {
            $sql = "SELECT * FROM usuarios WHERE username = '$username'";
            $result = $this->db->query($sql);

            if ($result->num_rows > 0) {

                $usuario = $result->fetch_assoc();

                $passHash = $usuario['password'];

                if (password_verify($password, $passHash)) {

                    $this->initSession($usuario);

                } elseif ($password == $passHash) {
                    // esta condicion valida los tres registros quemados en DB
                    $this->initSession($usuario);

                } else {
                    echo (json_encode(array('ok' => "false", 'msj' => 'datos incorrectos'), true));
                }
            } else {
                echo (json_encode(array('ok' => "false", 'msj' => 'lo siento, no tienes acceso'), true));
            }
        } else {
            echo (json_encode(array('ok' => "false", 'msj' => 'ya hay una sesion iniciada'), true));
        }

    }

    private function initSession($usuario)
    {
        $resUsuario = array(
            'id' => $_SESSION['id'] = $usuario['id'],
            'username' => $_SESSION['username'] = $usuario['username'],
            'nombres' => $_SESSION['nombres'] = $usuario['nombres'],
            'apellidos' => $_SESSION['apellidos'] = $usuario['apellidos'],
            'tipo_id' => $_SESSION['tipo_id'] = $usuario['tipo_id'],
        );

        echo (json_encode(array('ok' => "true", 'msj' => "welcome", 'usuario' => $resUsuario), true));
    }

}

?>