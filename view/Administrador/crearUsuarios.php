<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../../asset/css/crearUsuario.css">
    <link rel="stylesheet" href="../../asset/lib/bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/lib/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../asset/lib/fontawesome-free-7.2.0-web/css/all.min.css">
</head>

<body class="bg-black text-white">

    <div class="d-flex vh-100">

        <?php require_once __DIR__ . '\..\items\sidebar.php'; ?>

        <main class="main-content flex-grow-1 p-4 d-flex justify-content-center align-items-center">
            <div class="card bg-dark border-secondary shadow-lg p-4 crear-usuario-card" style="max-width: 480px; width: 100%;">
                <div class="text-center mb-4">
                    <h2 class="fw-bold h4 text-white">CREAR USUARIO</h2>
                    <p class="text-secondary small">Gestión de Usuarios - Hospital Pro</p>
                </div>
                <form id="crearUsuarioForm">
                    <div class="mb-3">
                        <label for="rol" class="form-label small text-secondary">Rol</label>
                        <div class="input-group border-secondary">
                            <span class="input-group-text bg-black border-secondary text-secondary">
                                <i class="fas fa-users"></i>
                            </span>
                            <select id="rol" class="form-select bg-black text-white border-secondary custom-input">
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="1">Administrador</option>
                                <option value="2">Opertativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nombre_completo" class="form-label small text-secondary">Nombre completo</label>
                        <div class="input-group border-secondary">
                            <span class="input-group-text bg-black border-secondary text-secondary">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" id="nombre_completo" class="form-control bg-black text-white border-secondary custom-input" placeholder="Ej: Juan Perez" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label small text-secondary">Nombre de usuario</label>
                        <div class="input-group border-secondary">
                            <span class="input-group-text bg-black border-secondary text-secondary">
                                <i class="fas fa-at"></i>
                            </span>
                            <input type="text" id="username" class="form-control bg-black text-white border-secondary custom-input" placeholder="Ej: juan_perez" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label small text-secondary">Contraseña</label>
                        <div class="input-group border-secondary">
                            <span class="input-group-text bg-black border-secondary text-secondary">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" class="form-control bg-black text-white border-secondary custom-input" placeholder="Ingrese su contraseña" required>
                            <button class="btn btn-outline-secondary border-secondary" type="button" id="B-icon">
                                <i class="fas fa-eye text-secondary" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" id="btnCrear" class="btn btn-light fw-bold py-2">
                            <i class="fa-solid fa-user-plus"></i> Crear usuario
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../../asset/lib/sweetalert2@11.js"></script>
    <script src="../../asset/lib/bootstrap.bundle.min.js"></script>
    <script src="../../asset/js/crearUsuarios.js"></script>
</body>

</html>