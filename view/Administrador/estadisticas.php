<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas | Administrador</title>
    <link rel="stylesheet" href="../../asset/lib/bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/lib/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../asset/lib/fontawesome-free-7.2.0-web/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/estadisticas.css">
</head>

<body class="bg-black text-white">
    <div class="wrapper d-flex min-vh-100">
        <?php require_once __DIR__ . '/../items/sidebar.php'; ?>

        <main class="main-content flex-grow-1 p-4">
            <div class="container-fluid">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                    <div>
                        <h1 class="h3 text-white mb-1">Estadísticas del sistema</h1>
                        <p class="text-secondary mb-0">Resumen general de usuarios y actividad reciente.</p>
                    </div>
                </div>

                <div class="row gy-4" id="statsResumen">
                    <div class="col-12 col-md-4">
                        <div class="card stat-card bg-dark border-secondary shadow-sm">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-users stat-icon mb-3"></i>
                                <p class="small text-white mb-1">Total de usuarios</p>
                                <h2 id="totalUsuarios" class="text-white">--</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="card stat-card bg-dark border-secondary shadow-sm">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-user-shield stat-icon mb-3"></i>
                                <p class="small text-white mb-1">Administradores</p>
                                <h2 id="totalAdmins" class="text-white">--</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="card stat-card bg-dark border-secondary shadow-sm">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-user-gear stat-icon mb-3"></i>
                                <p class="small text-white mb-1">Operativos</p>
                                <h2 id="totalOps" class="text-white">--</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card stat-card-lg bg-dark border-secondary shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="icon-box bg-secondary text-black">
                                        <i class="fa-solid fa-user-check fa-2x"></i>
                                    </div>
                                    <div>
                                        <p class="small text-secondary mb-1">Último usuario registrado</p>
                                        <h4 id="nombreUltimoUsuario" class="mb-1 text-white">--</h4>
                                        <p id="rolUltimoUsuario" class="text-secondary mb-0">--</p>
                                    </div>
                                </div>

                                <div class="row gx-3 gy-3">
                                    <div class="col-12 col-md-4">
                                        <div class="stat-detail bg-black border-secondary rounded p-3">
                                            <p class="text-secondary small mb-1">ID</p>
                                            <strong id="ultimoUsuario" class="text-white">--</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="stat-detail bg-black border-secondary rounded p-3">
                                            <p class="text-secondary small mb-1">Fecha registro</p>
                                            <strong id="fechaUltimoUsuario" class="text-white">--</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-4 mt-1">
                    <div class="col-12 col-lg-4">
                        <div class="card bg-dark border-secondary shadow-sm chart-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 text-white">Usuarios por rol</h5>
                                </div>
                                <canvas id="rolChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card bg-dark border-secondary shadow-sm chart-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 text-white">Usuarios por fecha</h5>
                                </div>
                                <canvas id="fechaChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card bg-dark border-secondary shadow-sm chart-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 text-white">Usuarios creados por admin</h5>
                                </div>
                                <canvas id="adminChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../../asset/lib/bootstrap.bundle.min.js"></script>
    <script src="../../asset/lib/sweetalert2@11.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
    <script src="../../asset/js/graficas.js"></script>
    <script src="../../asset/js/estadisticas.js"></script>
</body>

</html>