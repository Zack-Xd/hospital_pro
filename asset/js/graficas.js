const GRAFICAS_ENDPOINT = '../../controller/graficasControler.php';

let rolChart = null;
let fechaChart = null;
let adminChart = null;

const buildChartOptions = (title) => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            labels: {
                color: '#f8fafc'
            }
        },
        title: {
            display: false,
            text: title,
            color: '#f8fafc'
        },
        tooltip: {
            bodyColor: '#f8fafc',
            titleColor: '#f8fafc',
            backgroundColor: 'rgba(15, 23, 42, 0.95)'
        }
    },
    scales: {
        x: {
            ticks: { color: '#f8fafc' },
            grid: { color: 'rgba(148, 163, 184, 0.2)' }
        },
        y: {
            beginAtZero: true,
            ticks: { color: '#f8fafc' },
            grid: { color: 'rgba(148, 163, 184, 0.2)' }
        }
    }
});

const showGraficasError = (message) => {
    console.error('Error de gráficas:', message);
    if (window.Swal) {
        Swal.fire({
            icon: 'error',
            title: 'Error de gráficas',
            text: String(message),
            confirmButtonColor: '#0d6efd',
            background: '#111827',
            color: '#f8fafc'
        });
    } else {
        alert(`Error de gráficas: ${message}`);
    }
};

const createDoughnutChart = (context, labels, values) => {
    if (rolChart) {
        rolChart.destroy();
    }

    rolChart = new Chart(context, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: values,
                backgroundColor: ['rgba(148, 163, 184, 0.7)', 'rgba(100, 116, 139, 0.7)', 'rgba(209, 213, 219, 0.7)', 'rgba(148, 163, 184, 0.5)'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: buildChartOptions('Usuarios por rol')
    });
};

const createLineChart = (context, labels, values) => {
    if (fechaChart) {
        fechaChart.destroy();
    }

    fechaChart = new Chart(context, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Usuarios registrados',
                data: values,
                borderColor: '#ffffff',
                backgroundColor: 'rgba(148, 163, 184, 0.45)',
                fill: true,
                tension: 0.35,
                pointRadius: 4,
                pointBackgroundColor: '#f8fafc',
                pointBorderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: buildChartOptions('Usuarios por fecha')
    });
};

const createBarChart = (context, labels, values) => {
    if (adminChart) {
        adminChart.destroy();
    }

    adminChart = new Chart(context, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Usuarios creados',
                data: values,
                backgroundColor: 'rgba(148, 163, 184, 0.75)',
                borderColor: '#ffffff',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: buildChartOptions('Usuarios creados por admin')
    });
};

const renderCharts = (stats) => {
    const roles = stats.usuariosRol || [];
    const fecha = stats.usuariosFecha || [];
    const admins = stats.usuariosPorAdmin || [];

    const rolLabels = roles.map((row) => row.nombre_rol ?? row.rol ?? 'Desconocido');
    const rolValues = roles.map((row) => Number(row.cantidad ?? 0));

    const sortedFecha = [...fecha].sort((a, b) => new Date(a.fecha_registro) - new Date(b.fecha_registro));
    const fechaLabels = sortedFecha.map((row) => {
        if (!row.fecha_registro) return '--';
        const date = new Date(row.fecha_registro);
        return Number.isNaN(date.getTime()) ? row.fecha_registro : date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
    });
    const fechaValues = sortedFecha.map((row) => Number(row.cantidad ?? 0));

    const adminLabels = admins.map((row) => row.admin_nombre ?? row.nombre_admin ?? 'Administrador');
    const adminValues = admins.map((row) => Number(row.usuarios_creados ?? row.cantidad ?? 0));

    const rolCanvas = document.getElementById('rolChart');
    const fechaCanvas = document.getElementById('fechaChart');
    const adminCanvas = document.getElementById('adminChart');

    if (rolCanvas) createDoughnutChart(rolCanvas.getContext('2d'), rolLabels, rolValues);
    if (fechaCanvas) createLineChart(fechaCanvas.getContext('2d'), fechaLabels, fechaValues);
    if (adminCanvas) createBarChart(adminCanvas.getContext('2d'), adminLabels, adminValues);
};

const fetchGraficas = async () => {
    try {
        const response = await fetch(GRAFICAS_ENDPOINT, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
            cache: 'no-store'
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        if (typeof Chart === 'undefined') {
            throw new Error('Chart.js no se ha cargado correctamente. Revisa el CDN de Chart.js.');
        }

        if (data.status !== 'success' || !data.data) {
            throw new Error(data.message || 'No se pudieron cargar las gráficas');
        }

        renderCharts(data.data);
    } catch (error) {
        showGraficasError(error.message || error);
    }
};

window.addEventListener('DOMContentLoaded', () => {
    fetchGraficas();
});
