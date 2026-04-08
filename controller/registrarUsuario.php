<?php

header('Content-Type: application/json');
session_start();

require_once __DIR__ . "../../model/UsuarioModel.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'metodo no permitido'
    ]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$rol = (int)$data['rol'] ?? '';
$nombre_completo = $data['nombre_completo'] ?? ''; 
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';
$id_creador = $_SESSION['user']['id_user'];


if (empty($rol) || empty($nombre_completo) || empty($username) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => '¡Debe llenar todos los campos!'
    ]);
    exit;
}

if(!$rol){
    echo json_encode([
        'status' => 'error',
        'message' => 'debe seleccionar un rol'
    ]);
    exit;
}

if(!$nombre_completo){
    echo json_encode([
        'status' => 'error',
        'message' => 'Escriba un nombre completo válido'
    ]);
    exit;
}

if(!$username){
    echo json_encode([
        'status' => 'error',
        'message' => 'Escriba un nombre de usuario válido'
    ]);
    exit;
}

if(!$password){
    echo json_encode([
        'status' => 'error',
        'message' => 'Contraseña inválida'
    ]);
    exit;
}

if(!$id_creador){
    echo json_encode([
        'status' => 'error',
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

try {
    $usuarioModel = new UsuarioModel();
    $resultado = $usuarioModel->crearUsuario($nombre_completo, $username, $password, $rol, $id_creador);

    if ($resultado) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Usuario creado exitosamente'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al crear el usuario'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}