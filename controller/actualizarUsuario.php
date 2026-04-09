<?php

header('Content-Type: application/json');
session_start();

require_once __DIR__ . "../../model/UsuarioModel.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$nombre_completo = $data['nombre_completo'] ?? '';
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';
$rol = (int)$data['rol'] ?? '';
$id = (int)$data['id'] ?? '';

if (empty($nombre_completo) && empty($username) && empty($password) && empty($rol)) {
    echo json_encode([
        'status' => 'error',
        'message' => '¡Debe llenar todos los campos!'
    ]);
    exit;
}

$model = new UsuarioModel();
try {
   $resultado = $model->actualizarUsuario($nombre_completo, $username, $rol, $password, $id); 

   if(!$resultado){
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al actualizar usuario'
    ]);
    exit;
   }

    echo json_encode([
        'status' => 'success',
        'message' => 'Usuario actualizado exitosamente'
    ]);

} catch (Exception $e) {
    error_log("Error en actualizarUsuario.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Error del servidor al actualizar usuario'
    ]);
    exit();
}

