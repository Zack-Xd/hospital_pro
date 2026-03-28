<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../asset/css/login.css">
    <title>Hospital Pro | Acceso al Sistema</title>
</head>
<body class="bg-black text-white">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100 justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <div class="card bg-dark border-secondary shadow-lg p-4 login-card">
                    <div class="text-center mb-4">
                        <img src="../asset/img/HIcon.webp" alt="Logo" width="60" class="mb-3">
                        <h2 class="fw-bold h4 text-white">INICIAR SESIÓN</h2>
                        <p class="text-secondary small">Gestión de Usuarios - Hospital Pro</p>
                    </div>

                    <form id="loginForm">
                        <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label small text-secondary">Usuario</label>
                            <div class="input-group border-secondary">
                                <span class="input-group-text bg-black border-secondary text-secondary">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control bg-black text-white border-secondary custom-input" id="username" placeholder="Ingrese su usuario" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small text-secondary">Contraseña</label>
                            <div class="input-group border-secondary">
                                <span class="input-group-text bg-black border-secondary text-secondary">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control bg-black text-white border-secondary custom-input" id="password" placeholder="Ingrese su contraseña" required>
                                <button class="btn btn-outline-secondary border-secondary" type="button" id="B-icon">
                                    <i class="fas fa-eye text-secondary" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" id="loginButton" class="btn btn-light fw-bold py-2">Ingresar al Sistema</button>
                            <a href="../index.php" class="btn btn-link btn-sm text-secondary text-decoration-none mt-2">
                                <i class="bi bi-arrow-left me-1"></i> Volver al Inicio
                            </a>
                        </div>
                    </form>
                </div>

                <p class="text-center text-secondary mt-4 mb-0 small" style="opacity: 0.6;">
                    &copy; 2026 Hospital Pro. Todos los derechos reservados.
                </p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../asset/js/login.js"></script>
</body>
</html>