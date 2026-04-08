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
<script>
const ROL_SESION = <?= $sesion_rol ?>;
const ID_SESION  = <?= $sesion_id ?>;

/* Carga y dibuja la tabla de usuarios */
function cargarUsuarios() {
    fetch('/controllers/UsuarioController.php?action=listar')
        .then(r => r.json())
        .then(res => {
            const tbody = document.getElementById('tbodyUsuarios');
            if (!res.success || !res.data.length) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center">Sin usuarios</td></tr>';
                return;
            }
            tbody.innerHTML = res.data.map(u => {
                const badge = u.fk_rol == 1
                    ? `<span class="badge badge-admin">${u.nombre_rol}</span>`
                    : `<span class="badge badge-op">${u.nombre_rol}</span>`;

                /* Determina que botones mostrar segun el rol de sesion */
                let acciones = '';
                if (ROL_SESION === 1) {
                    /* Admin: puede editar y eliminar a cualquiera (menos a si mismo en eliminar) */
                    acciones = `<button class="btn btn-secondary" style="padding:5px 12px;font-size:.8rem"
                                    onclick="abrirModal(${u.id_user})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>`;
                    if (u.id_user != ID_SESION) {
                        acciones += ` <button class="btn btn-danger" style="padding:5px 12px;font-size:.8rem"
                                        onclick="eliminarUsuario(${u.id_user}, '${u.nombre_completo}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>`;
                    }
                } else if (u.id_user === ID_SESION) {
                    /* Operativo: solo puede editarse a si mismo */
                    acciones = `<button class="btn btn-secondary" style="padding:5px 12px;font-size:.8rem"
                                    onclick="abrirModal(${u.id_user})">
                                    <i class="fa-solid fa-pen"></i> Mi perfil
                                </button>`;
                }

                return `<tr>
                    <td>${u.id_user}</td>
                    <td>${u.nombre_completo}</td>
                    <td>${u.username}</td>
                    <td>${badge}</td>
                    <td>${u.fecha_registro}</td>
                    <td>${acciones}</td>
                </tr>`;
            }).join('');
        });
}

/* Carga los roles en el select del modal */
function cargarRolesModal() {
    fetch('/controllers/UsuarioController.php?action=roles')
        .then(r => r.json())
        .then(res => {
            const sel = document.getElementById('edit_rol');
            sel.innerHTML = res.data.map(r =>
                `<option value="${r.id_rol}">${r.nombre_rol}</option>`
            ).join('');
        });
}

/* Abre el modal prellenado con los datos del usuario */
function abrirModal(id) {
    fetch(`/controllers/UsuarioController.php?action=obtener&id=${id}`)
        .then(r => r.json())
        .then(res => {
            if (!res.success) return;
            const u = res.data;
            document.getElementById('edit_id').value       = u.id_user;
            document.getElementById('edit_nombre').value   = u.nombre_completo;
            document.getElementById('edit_username').value = u.username;
            document.getElementById('edit_rol').value      = u.fk_rol;

            /* Si es operativo editando su propio perfil: muestra campo password, oculta select rol */
            if (ROL_SESION === 2) {
                document.getElementById('edit_rol_group').style.display  = 'none';
                document.getElementById('edit_pass_group').style.display = 'block';
                document.getElementById('edit_password_actual').value    = '';
            } else {
                document.getElementById('edit_rol_group').style.display  = 'block';
                document.getElementById('edit_pass_group').style.display = 'none';
            }

            document.getElementById('modalOverlay').style.display = 'flex';
        });
}

/* Guarda los cambios del modal */
document.getElementById('btnGuardarEdicion').addEventListener('click', () => {
    const data = new FormData();
    data.append('id_user',          document.getElementById('edit_id').value);
    data.append('nombre_completo',  document.getElementById('edit_nombre').value.trim());
    data.append('username',         document.getElementById('edit_username').value.trim());

    let endpoint;
    if (ROL_SESION === 1) {
        /* Admin: usa la accion de actualizar general */
        data.append('action',  'actualizar');
        data.append('fk_rol',  document.getElementById('edit_rol').value);
        endpoint = '/controllers/UsuarioController.php';
    } else {
        /* Operativo: usa la accion de perfil propio con confirmacion de password */
        data.append('action',          'actualizar_propio');
        data.append('password_actual', document.getElementById('edit_password_actual').value);
        endpoint = '/controllers/UsuarioController.php';
    }

    fetch(endpoint, { method: 'POST', body: data })
        .then(r => r.json())
        .then(res => {
            cerrarModal();
            Swal.fire({
                icon: res.success ? 'success' : 'error',
                title: res.msg,
                background: '#1a1a1a',
                color: '#f0f0f0'
            }).then(() => cargarUsuarios());
        });
});

/* Confirmacion para eliminar usuario */
function eliminarUsuario(id, nombre) {
    Swal.fire({
        title: `Eliminar a ${nombre}?`,
        text: 'Esta accion es permanente y no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#e53935',
        background: '#1a1a1a',
        color: '#f0f0f0'
    }).then(result => {
        if (!result.isConfirmed) return;
        const data = new FormData();
        data.append('action',  'eliminar');
        data.append('id_user', id);
        fetch('/controllers/UsuarioController.php', { method: 'POST', body: data })
            .then(r => r.json())
            .then(res => {
                Swal.fire({ icon: res.success ? 'success' : 'error', title: res.msg,
                            background: '#1a1a1a', color: '#f0f0f0' })
                    .then(() => cargarUsuarios());
            });
    });
}

function cerrarModal() {
    document.getElementById('modalOverlay').style.display = 'none';
}

document.getElementById('btnCerrarModal').addEventListener('click', cerrarModal);

/* Inicio */
cargarRolesModal();
cargarUsuarios();
</script>
</body>
</html>