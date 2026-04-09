<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../model/UsuarioModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'status' => 'error',
        'message' => 'metodo no permitido'
    ]);
    exit();
}

try {
    $usuarioModel = new UsuarioModel();
    $stats = $usuarioModel->estadisticasUsuarios();
    echo json_encode([
        'status' => 'success',
        'data' => $stats
    ]);
} catch (Exception $e) {
    error_log("Error al obtener estadísticas de usuarios: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al obtener estadísticas de usuarios'
    ]);
}