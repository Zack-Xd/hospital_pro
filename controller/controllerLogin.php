<?php

header('Content-Type: application/json');
session_start();

require_once __DIR__ . "../../model/modelLogin.php";
require_once __DIR__ . "../../conexion.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'metodo no permitido'
    ]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$user = $data['username'] ?? '';
$password = $data['password'] ?? '';
$csrf_token = $data['csrf_token'] ?? '';

if (empty($user) && empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => '¡Campos vacíos!'
    ]);
    exit;
} elseif(empty($user) || empty($password)){
    echo json_encode([
        'status' => 'error',
        'message' => '¡Debe llenar todos los campos!'
    ]);
    exit;
} 

if ($tokenValido = validarCrsf($csrf_token)) {
    $user = limpiarCampos($user);

    try {

        $login = login($pdo, $user, $password);

        if (!$login){
            echo json_encode([
                'status' => 'error',
                'message' => '¡Ingresa un usuario valido!'
            ]);
            exit;

        } elseif ($login['password'] !== $password){
            echo json_encode([
                'status' => 'error',
                'message' => 'Contraseña incorrecta'
            ]);
            exit;
        }

        $_SESSION['user'] = [
            'id_user' => $login['id_user'],
            'nombre' => $login['nombre_completo'],
            'username' => $login['username'],
            'rol' => $login['fk_rol']
        ];

        $admin = $_SESSION['user']['rol'] == '1';
        $operat = $_SESSION['user']['rol'] == '2';

        unset($_SESSION['csrf_token']);

        if ($admin) {
            echo json_encode([
                'status' => 'success',
                'redirect' => '../view/dashboardAd.php'
            ]);
        } elseif ($operat) {
            echo json_encode([
                'status' => 'success',
                'redirect' => '../view/dashboardOp.php'
            ]);
        } else {
            session_destroy();
            session_unset();
        }

    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
    }
} else {
    echo json_encode([
        'status' => 'ok',
        'message' => 'Error de seguridad, csrf invalido o nulo'
    ]);
}
