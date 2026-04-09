const ENDPOINT = '../../controller/UsuarioController.php';

const tablaBody = document.getElementById('tbodyUsuarios');
const searchInput = document.getElementById('searchUsuario');
let usuariosData = [];

const formatRol = (rol) => {
    if (rol === '1' || rol === 1) return 'Administrador';
    if (rol === '2' || rol === 2) return 'Operativo';
    return 'Desconocido';
};

const formatFecha = (fecha) => {
    if (!fecha) return '-';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

const renderTable = (usuarios) => {
    if (!usuarios || usuarios.length === 0) {
        tablaBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-secondary py-4">No hay usuarios para mostrar</td>
            </tr>
        `;
        return;
    }

    tablaBody.innerHTML = usuarios.map((usuario, index) => {
        return `
            <tr>
                <td>${usuario.id_user ?? index + 1}</td>
                <td>${usuario.nombre_completo ?? '-'}</td>
                <td>${usuario.username ?? '-'}</td>
                <td>${formatRol(usuario.fk_rol ?? usuario.nombre_rol)}</td>
                <td>${formatFecha(usuario.fecha_registro)}</td>
                <td>
                    <button class="btnVer btn btn-sm btn-outline-light"
  data-id="${usuario.id_user}"
  data-nombre="${usuario.nombre_completo}"
  data-username="${usuario.username}"
  data-rol="${usuario.fk_rol}">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                </td>
            </tr>
        `;
    }).join('');
};

const filterUsuarios = (query) => {
    const search = query.trim().toLowerCase();
    if (!search) return usuariosData;
    return usuariosData.filter(usuario => {
        return (
            (usuario.nombre_completo || '').toLowerCase().includes(search) ||
            (usuario.username || '').toLowerCase().includes(search) ||
            (formatRol(usuario.fk_rol || usuario.nombre_rol).toLowerCase().includes(search))
        );
    });
};

const fetchUsuarios = async () => {
    tablaBody.innerHTML = `
        <tr>
            <td colspan="6" class="text-center text-secondary py-4">Cargando usuarios...</td>
        </tr>
    `;

    try {
        const response = await fetch(ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (data.status === 'ok') {
            usuariosData = data.usuarios || [];
            renderTable(usuariosData);
        } else {
            renderTable([]);
                Swal.fire({
                    icon: 'info',
                    title: 'Usuarios',
                    text: data.message || 'No se pudieron cargar los usuarios',
                    theme: 'dark',
                    timer: 1800,
                    showConfirmButton: false,
                    zIndex: 10000
                });
        }
    } catch (error) {
        tablaBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger py-4">Error al cargar usuarios</td>
            </tr>
        `;
        console.error('Error cargando usuarios:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo conectar con el servidor.',
            theme: 'dark',
            timer: 2000,
            showConfirmButton: false,
            zIndex: 10000
        });
    }
};

const crearModal = () => {
    const modal = document.createElement('div');
    modal.id = 'modalUsuario';
    modal.style = `
        position: fixed;
        top:0; left:0;
        width:100%; height:100%;
        background: rgba(0,0,0,0.7);
        display:flex;
        justify-content:center;
        align-items:center;
        z-index:9999;
    `;

    modal.innerHTML = `
        <div style="background:#111; padding:20px; border-radius:10px; width:400px;">
            <h4 class="text-white mb-3">Editar Usuario</h4>
            <label for="editNombre" class="form-label small text-secondary">Nombre</label>
            <input id="editNombre" class="form-control mb-2 bg-dark text-white border-secondary" placeholder="Nombre">
            <label for="editUsername" class="form-label small text-secondary">Username</label>
            <input id="editUsername" class="form-control mb-2 bg-dark text-white border-secondary" placeholder="Username">
            <label for="editRol" class="form-label small text-secondary">Rol</label>
            <select id="editRol" class="form-control mb-2 bg-dark text-white border-secondary">
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="1">Administrador</option>
                                <option value="2">Opertativo</option>
            </select>
            <label for="editPassword" class="form-label small text-secondary">Nueva contraseña</label>
            <input id="editPassword" type="password" class="form-control mb-3 bg-dark text-white border-secondary" placeholder="Nueva contraseña">

            <div class="d-flex justify-content-end gap-2">
                <button id="cerrarModal" class="btn btn-secondary btn-sm">Cerrar</button>
                <button id="guardarCambios" class="btn btn-light btn-sm">Guardar</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    return modal;
};

document.addEventListener('click', (e) => {
    if (e.target.closest('.btnVer')) {

        const btn = e.target.closest('.btnVer');

        const usuario = {
            id: btn.dataset.id,
            nombre: btn.dataset.nombre,
            username: btn.dataset.username,
            rol: btn.dataset.rol
        };

        const modal = crearModal();

        const nombre = modal.querySelector('#editNombre');
        const username = modal.querySelector('#editUsername');
        const rol = modal.querySelector('#editRol');
        const password = modal.querySelector('#editPassword');

        nombre.value = usuario.nombre;
        username.value = usuario.username;
        rol.value = usuario.rol;

        modal.querySelector('#cerrarModal').addEventListener('click', () => {
            modal.remove();
        });

        const saveButton = modal.querySelector('#guardarCambios');
        saveButton.addEventListener('click', async (event) => {
            event.stopPropagation();
            saveButton.disabled = true;

            const datos = {
                id: usuario.id,
                nombre_completo: nombre.value,
                username: username.value,
                rol: parseInt(rol.value),
                password: password.value
            };

            try {
                const response = await fetch('../../controller/actualizarUsuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datos)
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (data.status !== 'success') {
                    throw new Error(data.message || 'No se pudo actualizar el usuario');
                }

                modal.remove();

                await Swal.fire({
                    icon: 'success',
                    title: 'Usuario actualizado',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false,
                    zIndex: 10000
                });

                fetchUsuarios();
            } catch (error) {
                console.error('Error al actualizar usuario:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Error al actualizar el usuario',
                    timer: 2000,
                    showConfirmButton: false,
                    zIndex: 10000
                });
            } finally {
                saveButton.disabled = false;
            }
        });
    }
});

window.addEventListener('DOMContentLoaded', () => {
    fetchUsuarios();
    searchInput.addEventListener('input', (event) => {
        renderTable(filterUsuarios(event.target.value));
    });
});