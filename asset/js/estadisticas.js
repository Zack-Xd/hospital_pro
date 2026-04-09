const ESTADISTICAS_ENDPOINT = '../../controller/estadisticasController.php';

const totalUsuariosElem = document.getElementById('totalUsuarios');
const totalAdminsElem = document.getElementById('totalAdmins');
const totalOpsElem = document.getElementById('totalOps');
const ultimoUsuarioElem = document.getElementById('ultimoUsuario');
const nombreUltimoUsuarioElem = document.getElementById('nombreUltimoUsuario');
const rolUltimoUsuarioElem = document.getElementById('rolUltimoUsuario');
const fechaUltimoUsuarioElem = document.getElementById('fechaUltimoUsuario');

const formatFecha = (fecha) => {
    if (!fecha) return '--';
    const date = new Date(fecha);
    if (Number.isNaN(date.getTime())) return fecha;
    return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

const safeNumber = (value) => {
    const parsed = parseInt(value, 10);
    return Number.isNaN(parsed) ? 0 : parsed;
};

const renderResumen = (stats) => {
    totalUsuariosElem.textContent = stats.totalUsuarios?.[0]?.total ?? 0;
    totalAdminsElem.textContent = stats.usuariosRol?.find((row) => String(row.nombre_rol).toLowerCase().includes('admin') || String(row.nombre_rol).toLowerCase().includes('administrador'))?.cantidad ?? 0;
    totalOpsElem.textContent = stats.usuariosRol?.find((row) => String(row.nombre_rol).toLowerCase().includes('operativo'))?.cantidad ?? 0;

    const ultimo = stats.ultimoUsuario?.[0] ?? {};
    ultimoUsuarioElem.textContent = ultimo.id_user ?? ultimo.id ?? ultimo.id_usuario ?? '--';
    nombreUltimoUsuarioElem.textContent = ultimo.nombre_completo ?? ultimo.nombre ?? '--';
    rolUltimoUsuarioElem.textContent = ultimo.nombre_rol ?? ultimo.rol ?? '--';
    fechaUltimoUsuarioElem.textContent = formatFecha(ultimo.fecha_registro ?? ultimo.fecha ?? '--');
};

const renderError = () => {
    totalUsuariosElem.textContent = '--';
    totalAdminsElem.textContent = '--';
    totalOpsElem.textContent = '--';
    ultimoUsuarioElem.textContent = '--';
    nombreUltimoUsuarioElem.textContent = '--';
    rolUltimoUsuarioElem.textContent = '--';
    fechaUltimoUsuarioElem.textContent = '--';
};

const fetchEstadisticas = async () => {
    try {
        const response = await fetch(ESTADISTICAS_ENDPOINT, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
            cache: 'no-store'
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        if (data.status !== 'success' || !data.data) {
            throw new Error(data.message || 'No se pudo obtener las estadísticas');
        }

        renderResumen(data.data);
    } catch (error) {
        console.error('Error cargando estadísticas:', error);
        renderError();
    }
};

window.addEventListener('DOMContentLoaded', () => {
    fetchEstadisticas();
});

