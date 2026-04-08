<?php
/*
 * Controlador de usuarios
 * Recibe las peticiones de los archivos JS via fetch y responde en JSON
 * Tambien maneja el logout
 */
session_start();
require_once __DIR__ . '../../models/UsuarioModel.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

/* Logout: destruye la sesion y redirige */
if ($action === 'logout') {
    session_destroy();
    header('Location: /hospital_pro/index.php');
    exit;
}

/* Todas las demas acciones requieren sesion activa */
if (!isset($_SESSION['id_user'])) {
    echo json_encode([
    'status' => 'error',
    'message' => 'Sin sesion']);
    exit;
}

$model     = new UsuarioModel();
$sesion_id  = (int)$_SESSION['user']['id_user'];
$sesion_rol = (int)$_SESSION['user']['rol'];

switch ($action) {

    /* Lista todos los usuarios */
    case 'listar':
        $usuarios = $model->obtenerUsuarios();
        echo json_encode([
            'status' => 'error', 
            'data' => $usuarios]);
        break;

    /* Trae los datos de un usuario para pre-llenar el modal de edicion */
    case 'obtener':
        $id = (int)($_GET['id'] ?? 0);
        $usuario = $model->obtenerUsuarioPorId($id);
        echo json_encode(['success' => (bool)$usuario, 'data' => $usuario]);
        break;

    /* Trae los roles para el select */
    case 'roles':
        $roles = $model->obtenerRoles();
        echo json_encode([
        'status' => 'success', 
        'data' => $roles]);
        break;

    /* Crea un nuevo usuario (solo administradores) */
    case 'crear':
        if ($sesion_rol !== 1) { echo json_encode(['success' => false, 'msg' => 'Sin permiso']); break; }
        $nombre   = trim($_POST['nombre_completo'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $rol      = (int)($_POST['fk_rol'] ?? 0);

        if (!$nombre || !$username || !$password || !$rol) {
            echo json_encode(['success' => false, 'msg' => 'Todos los campos son obligatorios']);
            break;
        }

        $ok = $model->crearUsuario($nombre, $username, $password, $rol, $sesion_id);
        echo json_encode(['success' => $ok, 'msg' => $ok ? 'Usuario creado correctamente' : 'Error al crear usuario']);
        break;

    /* Actualiza un usuario (admin actualiza cualquiera) */
    case 'actualizar':
        if ($sesion_rol !== 1) { echo json_encode(['success' => false, 'msg' => 'Sin permiso']); break; }
        $id       = (int)($_POST['id_user'] ?? 0);
        $nombre   = trim($_POST['nombre_completo'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $rol      = (int)($_POST['fk_rol'] ?? 0);

        if (!$id || !$nombre || !$username || !$rol) {
            echo json_encode(['success' => false, 'msg' => 'Datos incompletos']);
            break;
        }

        $ok = $model->actualizarUsuario($id, $nombre, $username, $rol);
        echo json_encode(['success' => $ok, 'msg' => $ok ? 'Usuario actualizado' : 'Error al actualizar']);
        break;

    /* Operativo actualiza solo su propio perfil con confirmacion de password */
    case 'actualizar_propio':
        $id          = (int)($_POST['id_user'] ?? 0);
        $nombre      = trim($_POST['nombre_completo'] ?? '');
        $username    = trim($_POST['username'] ?? '');
        $pass_actual = trim($_POST['password_actual'] ?? '');

        /* Solo puede modificarse a si mismo */
        if ($id !== $sesion_id) {
            echo json_encode(['success' => false, 'msg' => 'No puedes modificar a otro usuario']);
            break;
        }

        $resultado = $model->actualizarPerfilPropio($id, $nombre, $username, $pass_actual);
        if ($resultado === 'ok') {
            /* Actualiza el nombre en sesion si cambio */
            $_SESSION['nombre_completo'] = $nombre;
            $_SESSION['username']        = $username;
            echo json_encode(['success' => true, 'msg' => 'Perfil actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Contrasena actual incorrecta']);
        }
        break;

    /* Elimina un usuario de forma permanente (solo administradores) */
    case 'eliminar':
        if ($sesion_rol !== 1) { echo json_encode(['success' => false, 'msg' => 'Sin permiso']); break; }
        $id = (int)($_POST['id_user'] ?? 0);

        /* No puede eliminarse a si mismo */
        if ($id === $sesion_id) {
            echo json_encode(['success' => false, 'msg' => 'No puedes eliminarte a ti mismo']);
            break;
        }

        $ok = $model->eliminarUsuario($id);
        echo json_encode(['success' => $ok, 'msg' => $ok ? 'Usuario eliminado' : 'Error al eliminar']);
        break;

    default:
        echo json_encode(['success' => false, 'msg' => 'Accion no reconocida']);
}