<?php
session_start(); 
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">NutriRecomienda</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto justify-content-end">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Si hay un usuario en sesión, mostrar el nombre del usuario y la opción de cerrar sesión -->
                <li class="nav-item">
                    <span class="nav-link">Bienvenido, <?php echo $_SESSION['user']['fullname']; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/backend/logout.php">Cerrar sesión</a>
                </li>
            <?php else: ?>
                <!-- Si no hay sesión activa, mostrar las opciones de Iniciar sesión y Registrarse -->
                <li class="nav-item">
                    <a class="nav-link" href="/frontend/pages/login.php">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/frontend/pages/register.php">Registrarse</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
