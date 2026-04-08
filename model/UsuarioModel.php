<?php
require_once __DIR__ . "\SQLmodel.php";

class UsuarioModel extends SQLmodel{

    public function crearUsuario($nombre_completo, $username, $password, $rol, $id_creador){
        try {

            $userData = [
                ['value' => $nombre_completo, 'type' => PDO::PARAM_STR],
                ['value' => $username, 'type' => PDO::PARAM_STR],
                ['value' => password_hash($password, PASSWORD_BCRYPT), 'type' => PDO::PARAM_STR],
                ['value' => $rol, 'type' => PDO::PARAM_INT],
                ['value' => $id_creador, 'type' => PDO::PARAM_INT]
            ];

            $this->consultaSimple("CALL sp_crear_usuario(?, ?, ?, ?, ?)", $userData);
            return true;
        } catch (Exception $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    } 

    public function obtenerUsuarios(){
        try {
            $usuarios = $this->consultaSimple("CALL sp_obtener_usuarios()", null);
            return $usuarios;
        } catch (Exception $e) {
            error_log("Error al obtener usuarios: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarUsuario($nombre_completo, $username, $rol, $password, $id){
        try {
            $updateData = [
                ['value' => $nombre_completo, 'type' => PDO::PARAM_STR],
                ['value' => $username, 'type' => PDO::PARAM_STR],
                ['value' => $rol, 'type' => PDO::PARAM_INT],
                ['value' => password_hash($password, PASSWORD_BCRYPT), 'type' => PDO::PARAM_STR],
                ['value' => $id, 'type' => PDO::PARAM_INT]
            ];

            $this->consultaSimple("CALL sp_actualizar_usuario(?, ?, ?, ?, ?)", $updateData);
            return true;
        } catch (Exception $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }
}