<?php
require_once __DIR__ . '/../../views/shared/sesion.php';
/* Solo administradores pueden crear usuarios */
if ($sesion_rol !== 1) { header('Location: /views/dashboardOp.php'); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
<div class="wrapper">
    <?php require_once __DIR__ . '/../shared/sidebar.php'; ?>

    <main class="main-content">
        <h1 class="page-title">Crear Usuario</h1>

        <div class="card" style="max-width:480px;">
            <div class="form-group">
                <label>Rol</label>
                <select id="fk_rol" class="form-control">
                    <option value="">Cargando roles...</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nombre completo</label>
                <input type="text" id="nombre_completo" class="form-control" placeholder="Ej: Juan Perez">
            </div>
            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" id="username" class="form-control" placeholder="Ej: juan_perez">
            </div>
            <div class="form-group">
                <label>Contrasena</label>
                <input type="password" id="password" class="form-control">
            </div>
            <button class="btn btn-primary" id="btnCrear">
                <i class="fa-solid fa-user-plus"></i> Crear usuario
            </button>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* Carga los roles en el select al abrir la pagina */
fetch('/controllers/UsuarioController.php?action=roles')
    .then(r => r.json())
    .then(res => {
        const sel = document.getElementById('fk_rol');
        sel.innerHTML = '<option value="">-- Selecciona un rol --</option>';
        res.data.forEach(rol => {
            sel.innerHTML += `<option value="${rol.id_rol}">${rol.nombre_rol}</option>`;
        });
    });

/* Envia el formulario de creacion */
document.getElementById('btnCrear').addEventListener('click', () => {
    const data = new FormData();
    data.append('action',          'crear');
    data.append('nombre_completo', document.getElementById('nombre_completo').value.trim());
    data.append('username',        document.getElementById('username').value.trim());
    data.append('password',        document.getElementById('password').value.trim());
    data.append('fk_rol',          document.getElementById('fk_rol').value);

    fetch('/controllers/UsuarioController.php', { method: 'POST', body: data })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                Swal.fire({ icon: 'success', title: res.msg, background: '#1a1a1a', color: '#f0f0f0' })
                    .then(() => {
                        /* Limpia el formulario tras crear */
                        document.getElementById('nombre_completo').value = '';
                        document.getElementById('username').value = '';
                        document.getElementById('password').value = '';
                        document.getElementById('fk_rol').value = '';
                    });
            } else {
                Swal.fire({ icon: 'error', title: res.msg, background: '#1a1a1a', color: '#f0f0f0' });
            }
        });
});
</script>
</body>
</html>