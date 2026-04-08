<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../../asset/css/usuarios.css">
    <link rel="stylesheet" href="../../asset/lib/bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/lib/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../asset/lib/fontawesome-free-7.2.0-web/css/all.min.css">
</head>
<body class="bg-black text-white">
<div class="wrapper d-flex min-vh-100">
    <?php require_once __DIR__ . '/../items/sidebar.php'; ?>

    <main class="main-content flex-grow-1 p-4">
        <div class="container-fluid">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h1 class="h3 text-white mb-1">Usuarios del sistema</h1>
                    <p class="text-secondary mb-0">Lista de cuentas registradas en el portal.</p>
                </div>
                <a href="crearUsuarios.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-user-plus me-2"></i> Crear usuario
                </a>
            </div>

            <div class="card border-secondary bg-dark shadow-sm mb-4">
                <div class="card-body">
                    <div class="row gy-3 align-items-center mb-3">
                        <div class="col-md-6">
                            <div class="input-group border-secondary rounded overflow-hidden">
                                <span class="input-group-text bg-black border-secondary text-secondary">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input id="searchUsuario" type="text" class="form-control bg-black text-white border-secondary" placeholder="Buscar por nombre, usuario o rol">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tablaUsuarios" class="table table-hover table-dark align-middle mb-0">
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
                                <tr>
                                    <td colspan="6" class="text-center text-secondary py-4">Cargando usuarios...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="../../asset/lib/sweetalert2@11.js"></script>
<script src="../../asset/lib/bootstrap.bundle.min.js"></script>
<script src="../../asset/js/usuarios.js"></script>
</body>
</html>