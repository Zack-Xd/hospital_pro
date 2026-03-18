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
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Iniciar Sesión - Hospital Pro</title>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2 class="text-center text-white mb-4">Iniciar Sesión</h2>
            <div id="loginForm">
                <div class="mb-3">
                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo htmlspecialchars($token); ?>">
                    <label for="username" class="form-label text-light">Usuario</label>
                    <input type="text" class="form-control bg-dark text-white border-secondary" id="username" placeholder="Ingrese su usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-light">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control bg-dark text-white border-secondary" id="password" placeholder="Ingrese su contraseña" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" id="loginButton" class="btn btn-primary">Iniciar Sesión</button>
                    <a href="../index.php" class="btn btn-outline-light">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
