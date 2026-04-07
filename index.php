<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/lib/bootstrap.min.css">
    <link rel="stylesheet" href="asset/lib/bootstrap-icons.min.css">
    <link rel="stylesheet" href="asset/css/index.css">
    <title>Hospital Pro | Gestión Integral</title>
</head>

<body class="bg-black text-white d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span class="fw-bold tracking-tight">HOSPITAL <span class="text-secondary">PRO</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Nosotros</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light btn-sm px-4 rounded-pill" href="pages/login.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="py-5 bg-dark shadow-sm">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-3 fw-bold mb-3 text-white">SISTEMA DE GESTIÓN <br><span class="text-secondary">HOSPITALARIA</span></h1>
                    <p class="lead text-secondary-emphasis mb-4">
                        Hospital Pro es una plataforma CRM avanzada de grado clínico diseñada para centralizar la administración hospitalaria. 
                        Desde la trazabilidad de pacientes hasta el control exhaustivo de inventarios médicos, nuestra solución garantiza 
                        eficiencia operativa y seguridad en cada proceso.
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="#modulo-usuarios" class="btn btn-light btn-lg px-4 me-md-2">Ver Módulos</a>
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4 text-white">Saber más</button>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <img src="asset/img/HIcon.webp" alt="Logo" style="font-size: 10rem; opacity: 0.5;" class="me-2">
                </div>
            </div>
        </div>
    </header>

    <main class="container my-5 py-5" id="modulo-usuarios">
        <div class="row mb-5 text-center">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold border-bottom border-secondary d-inline-block pb-2">Gestión de Usuarios y Seguridad</h2>
                <p class="text-secondary mt-3">Nuestro núcleo administrativo permite una jerarquía de acceso robusta, asegurando que la información sensible sea manejada únicamente por personal autorizado.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card bg-dark text-white border-secondary h-100 shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-person-gear fs-1 text-secondary me-3"></i>
                            <h3 class="h4 mb-0">Perfil Administrador</h3>
                        </div>
                        <p class="text-secondary-emphasis">Control total sobre el ecosistema de usuarios del sistema.</p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Creación y registro de nuevos colaboradores.</li>
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Edición de perfiles y actualización de datos.</li>
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Desactivación de cuentas y gestión de bajas.</li>
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Auditoría de accesos al sistema.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-dark text-white border-secondary h-100 shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-person-vcard fs-1 text-secondary me-3"></i>
                            <h3 class="h4 mb-0">Perfil Operativo</h3>
                        </div>
                        <p class="text-secondary-emphasis">Acceso enfocado a la ejecución de tareas asistenciales y clínicas.</p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Autogestión de perfil y datos personales.</li>
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Visualización de agenda y pacientes asignados.</li>
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Registro de reportes y novedades de turno.</li>
                            <li><i class="bi bi-check2 text-secondary me-2"></i> Interfaz optimizada para tareas diarias.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark border-top border-secondary py-5 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">HOSPITAL PRO</h5>
                    <p class="small text-secondary">Tecnología de vanguardia para el cuidado de la salud. Medellín, Colombia.</p>
                </div>
                <div class="col-6 col-md-4 mb-4 text-center">
                    <h6 class="fw-bold mb-3">Enlaces</h6>
                    <ul class="list-unstyled small text-secondary">
                        <li><a href="#" class="text-decoration-none text-secondary">Privacidad</a></li>
                        <li><a href="#" class="text-decoration-none text-secondary">Términos de uso</a></li>
                        <li><a href="#" class="text-decoration-none text-secondary">Soporte técnico</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-4 mb-4 text-end">
                    <h6 class="fw-bold mb-3">Contacto</h6>
                    <p class="small text-secondary mb-0">soporte@hospitalpro.com</p>
                    <p class="small text-secondary">+57 (604) 000-0000</p>
                    <div class="mt-2">
                        <i class="bi bi-facebook me-2"></i>
                        <i class="bi bi-linkedin me-2"></i>
                        <i class="bi bi-twitter-x"></i>
                    </div>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center">
                <p class="small text-secondary mb-0">&copy; 2026 Hospital Pro - Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="asset/lib/bootstrap.bundle.min.js"></script>
</body>

</html>