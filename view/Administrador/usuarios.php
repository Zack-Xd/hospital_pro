<?php
require_once __DIR__ . '/../../views/shared/sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
<div class="wrapper">
    <?php require_once __DIR__ . '/../shared/sidebar.php'; ?>

    <main class="main-content">
        <h1 class="page-title">Usuarios del sistema</h1>

        <div class="card">
            <div class="table-wrapper">
                <table id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Fecha registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyUsuarios">
                        <tr><td colspan="6" style="text-align:center;color:#888">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal edicion (admin: puede cambiar rol; operativo: solo su propio perfil) -->
<div id="modalOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:1000;align-items:center;justify-content:center;">
    <div class="card" style="width:420px;">
        <h3 style="margin-bottom:20px;font-size:1rem;">Editar usuario</h3>
        <input type="hidden" id="edit_id">
        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" id="edit_nombre" class="form-control">
        </div>
        <div class="form-group">
            <label>Nombre de usuario</label>
            <input type="text" id="edit_username" class="form-control">
        </div>
        <!-- El select de rol solo aparece para administradores -->
        <div class="form-group" id="edit_rol_group">
            <label>Rol</label>
            <select id="edit_rol" class="form-control"></select>
        </div>
        <!-- El campo de password solo aparece cuando el operativo edita su propio perfil -->
        <div class="form-group" id="edit_pass_group" style="display:none;">
            <label>Confirmar contrasena actual</label>
            <input type="password" id="edit_password_actual" class="form-control">
        </div>
        <div style="display:flex;gap:10px;margin-top:10px;">
            <button class="btn btn-primary" id="btnGuardarEdicion">Guardar</button>
            <button class="btn btn-secondary" id="btnCerrarModal">Cancelar</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../asset/js/usuarios.js"></script>
</body>
</html>