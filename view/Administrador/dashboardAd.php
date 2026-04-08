<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador</title>
    
    <link rel="stylesheet" href="../../assets/css/dashboardAd.css">
    <link rel="stylesheet" href="../../asset/lib/bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/lib/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../asset/lib/fontawesome-free-7.2.0-web/css/all.min.css">
</head>
<body class="bg-black text-white">

<div class="d-flex vh-100">

    <?php require_once __DIR__ . '\..\items\sidebar.php'; ?>

    
    <main class="main-content flex-grow-1 p-4">

        <!-- Título -->
        <div class="mb-4">
            <h1 class="fw-bold">
                Bienvenido, <?= htmlspecialchars($_SESSION['user']['nombre']) ?>
            </h1>
            <p class="text-light">Panel de administración del sistema</p>
        </div>

        <!-- Card info -->
        <div class="card bg-dark border-secondary shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fa-solid fa-shield-halved me-2 text-secondary"></i>
                    Panel de Administrador
                </h5>

                <p class="text-light mb-0">
                    Como administrador tienes acceso completo al módulo de usuarios:
                    puedes <strong>crear</strong>, <strong>ver</strong>, <strong>editar</strong>
                    y <strong>eliminar</strong> usuarios del sistema. También puedes consultar
                    estadísticas y generar reportes.
                </p>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-4" id="statsResumen">

            <div class="col-md-4">
                <div class="card stat-card bg-dark border-secondary text-center p-4">
                    <i class="fa-solid fa-users stat-icon mb-2"></i>
                    <h2 id="totalUsuarios">--</h2>
                    <p class="text-light mb-0">Total de usuarios</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card bg-dark border-secondary text-center p-4">
                    <i class="fa-solid fa-user-shield stat-icon mb-2"></i>
                    <h2 id="totalAdmins">--</h2>
                    <p class="text-light mb-0">Administradores</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card bg-dark border-secondary text-center p-4">
                    <i class="fa-solid fa-user-gear stat-icon mb-2"></i>
                    <h2 id="totalOps">--</h2>
                    <p class="text-light mb-0">Operativos</p>
                </div>
            </div>

        </div>

    </main>

</div>

<script src="../../asset/lib/bootstrap.bundle.min.js"></script>

<script>
/* Carga el resumen numerico al abrir el dashboard */
fetch('/controllers/EstadisticaController.php?action=resumen')
    .then(r => r.json())
    .then(res => {
        if (!res.success) return;
        document.getElementById('totalUsuarios').textContent = res.total;
        res.por_rol.forEach(r => {
            if (r.nombre_rol === 'Administrador') document.getElementById('totalAdmins').textContent = r.cantidad;
            if (r.nombre_rol === 'Operativo')     document.getElementById('totalOps').textContent    = r.cantidad;
        });
    });
</script>
</body>
</html>