<?php
/*
 * Modelo de usuarios
 * Ejecuta los stored procedures y retorna los datos
 */
require_once __DIR__ . '/../database/conexion.php';

class UsuarioModel {

    private PDO $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    /* Llama un SP sin parametros y retorna todos los registros */
    private function fetchAll(string $sp): array {
        $stmt = $this->pdo->query("CALL $sp()");
        return $stmt->fetchAll();
    }

    /* Llama un SP con parametros posicionales */
    private function execute(string $sp, array $params): bool {
        $placeholders = implode(',', array_fill(0, count($params), '?'));
        $stmt = $this->pdo->prepare("CALL $sp($placeholders)");
        return $stmt->execute($params);
    }

    /* Llama un SP con parametros y retorna el primer registro */
    private function fetchOne(string $sp, array $params): array|false {
        $placeholders = implode(',', array_fill(0, count($params), '?'));
        $stmt = $this->pdo->prepare("CALL $sp($placeholders)");
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /* Llama un SP con parametros y retorna todos los registros */
    private function fetchAllParams(string $sp, array $params): array {
        $placeholders = implode(',', array_fill(0, count($params), '?'));
        $stmt = $this->pdo->prepare("CALL $sp($placeholders)");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function obtenerRoles(): array {
        return $this->fetchAll('sp_obtener_roles');
    }

    public function obtenerUsuarios(): array {
        return $this->fetchAll('sp_obtener_usuarios');
    }

    public function obtenerUsuarioPorId(int $id): array|false {
        return $this->fetchOne('sp_obtener_usuario_por_id', [$id]);
    }

    public function crearUsuario(string $nombre, string $username, string $password, int $rol, int $id_creador): bool {
        return $this->execute('sp_crear_usuario', [$nombre, $username, $password, $rol, $id_creador]);
    }

    public function actualizarUsuario(int $id, string $nombre, string $username, int $rol): bool {
        return $this->execute('sp_actualizar_usuario', [$id, $nombre, $username, $rol]);
    }

    public function actualizarPerfilPropio(int $id, string $nombre, string $username, string $pass_actual): string {
        /* El SP retorna 'ok' o 'password_incorrecta' */
        $resultado = $this->fetchOne('sp_actualizar_perfil_propio', [$id, $nombre, $username, $pass_actual]);
        return $resultado['resultado'] ?? 'error';
    }

    public function eliminarUsuario(int $id): bool {
        return $this->execute('sp_eliminar_usuario', [$id]);
    }

    /* Estadisticas */
    public function totalUsuarios(): int {
        $row = $this->fetchOne('sp_total_usuarios', []);
        // sp sin params: usar fetchAll normal
        $stmt = $this->pdo->query("CALL sp_total_usuarios()");
        $row  = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }

    public function usuariosPorRol(): array {
        return $this->fetchAll('sp_usuarios_por_rol');
    }

    public function usuariosComoCreadosPorAdmin(): array {
        return $this->fetchAll('sp_usuarios_creados_por_admin');
    }

    public function ultimoUsuario(): array|false {
        $stmt = $this->pdo->query("CALL sp_ultimo_usuario()");
        return $stmt->fetch();
    }

    public function usuariosPorFecha(): array {
        return $this->fetchAll('sp_usuarios_por_fecha');
    }
}