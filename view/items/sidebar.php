<nav class="sidebar bg-dark text-white p-3">

    <div class="text-center mb-4">
        <i class="fa-solid fa-hospital fs-3"></i>
        <h6 class="mt-2">HOSPITAL PRO</h6>
    </div>

    <ul class="nav flex-column">

        <!-- Inicio -->
        <li class="nav-item mb-2">
            <a href="/views/dashboardAd.php" class="nav-link text-white">
                <i class="fa-solid fa-house me-2"></i> Inicio
            </a>
        </li>

        <!-- Usuarios (DROPDOWN REAL) -->
        <li class="nav-item dropdown mb-2">
            <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                <i class="fa-solid fa-users me-2"></i> Usuarios
            </a>

            <ul class="dropdown-menu dropdown-menu-dark">

                <?php if ($_SESSION['user']['rol'] == 1): ?>
                <li>
                    <a class="dropdown-item" href="/views/crearUsuarios.php">
                        <i class="fa-solid fa-user-plus me-2"></i> Crear Usuario
                    </a>
                </li>
                <?php endif; ?>

                <li>
                    <a class="dropdown-item" href="/views/usuarios.php">
                        <i class="fa-solid fa-list me-2"></i> Lista de Usuarios
                    </a>
                </li>

            </ul>
        </li>

        <!-- Estadísticas -->
        <li class="nav-item mb-2">
            <a href="/views/estadisticas.php" class="nav-link text-white">
                <i class="fa-solid fa-chart-bar me-2"></i> Estadísticas
            </a>
        </li>

        <!-- Reportes -->
        <li class="nav-item mb-2">
            <a href="/views/reportes.php" class="nav-link text-white">
                <i class="fa-solid fa-file-lines me-2"></i> Reportes
            </a>
        </li>

    </ul>

    <!-- Usuario -->
    <div class="mt-auto pt-3 border-top border-secondary">
        <div class="small"><?= htmlspecialchars($_SESSION['user']['nombre']) ?></div>
        <div class="text-muted small">
            <?= $_SESSION['user']['rol'] == 1 ? 'Administrador' : 'Operativo' ?>
        </div>

        <a href="/controllers/UsuarioController.php?action=logout" class="text-danger small">
            <i class="fa-solid fa-right-from-bracket"></i> Salir
        </a>
    </div>


</nav>