<?php
require_once __DIR__ . "\..\conexion.php";

class UsuarioModel extends db{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = $this->conexion();
    }

    public function obtenerRoles(){
        $stmt = $this->pdo->prepare("CALL sp_obtener_roles()");
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($roles){
            return $roles;
        } else {
            return false;
        }
    }

    public function crearUsuario($nombre_completo, $username, $password, $rol, $id_creador){

        $stmt = $this->pdo->prepare("CALL sp_crear_usuario(?, ?, ?, ?, ?)");

        $stmt->bindParam(1, $nombre_completo, PDO::PARAM_STR);
        $stmt->bindParam(2, $username, PDO::PARAM_STR);
        $stmt->bindParam(3, $password, PDO::PARAM_STR);
        $stmt->bindParam(4, $rol, PDO::PARAM_INT);
        $stmt->bindParam(5, $id_creador, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }

    }
}