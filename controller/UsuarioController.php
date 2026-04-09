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

$model = new UsuarioModel();

try {
    $usuariosListados = $model->consultaSimple('sp_obtener_usuarios()', null);

    echo json_encode([
        'status' => 'ok',
        'usuarios' => $usuariosListados,
    ]);

} catch (Exception $e) {
    error_log("Error en UsuarioController.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Error del servidor al listar usuarios'
    ]);
}
exit;