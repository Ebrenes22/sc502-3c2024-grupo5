<?php
$page = 'profile.php';
require_once ('../backend/user.php');

// Obtener los datos del usuario desde la sesión
$fullname = $_SESSION['user']['fullname'];
$age = $_SESSION['user']['age'];
$gender = $_SESSION['user']['gender'];
$height = $_SESSION['user']['height'];
$weight = $_SESSION['user']['weight'];
?>

<link rel="stylesheet" href="/frontend/assets/css/cards-style-profile.css">

<div class="container my-4">
    <h1 class="text-center cherry-red">Perfil de Usuario</h1>

    <div class="d-flex flex-wrap justify-content-center">
        <!-- Información Personal -->
        <div class="card profile-card shadow-lg text-center">
            <div class="card-body">
                <img src="/frontend/assets/images/image-2.png" alt="Foto de Perfil" class="rounded-circle profile-picture mb-3">
                <h2 class="cherry-red">Información Personal</h2>
                <p><strong>Nombre Completo:</strong> <?php echo htmlspecialchars($fullname); ?></p>
                <p><strong>Edad:</strong> <?php echo htmlspecialchars($age); ?> años</p>
                <p><strong>Género:</strong> <?php echo htmlspecialchars($gender); ?></p>
                <p><strong>Estatura:</strong> <?php echo htmlspecialchars($height); ?> cm</p>
                <p><strong>Peso Actual:</strong> <?php echo htmlspecialchars($weight); ?> kg</p>
            </div>
        </div>

        <!-- Estadísticas de Actividad y Nutrición -->
        <div class="card profile-card shadow-lg">
            <div class="card-body">
                <h2 class="cherry-red">Estadísticas de Actividad y Nutrición</h2>
                <h3 class="mt-4">Registro de Alimentos Recientes:</h3>
                <ul class="list-group mb-3">
                    <li class="list-group-item">Desayuno - 400 kcal</li>
                    <li class="list-group-item">Almuerzo - 600 kcal</li>
                    <li class="list-group-item">Cena - 500 kcal</li>
                </ul>
                <p><strong>Calorías Consumidas Hoy:</strong> 1500 kcal</p>
                <p><strong>Calorías Recomendadas:</strong> 2000 kcal</p>
                <button class="btn btn-info update-button mt-3" onclick="window.location.href='alimentos.php';">Ver Alimentos Detallado</button>

                <h3>Registro de Ejercicios Recientes:</h3>
                <ul class="list-group">
                    <li class="list-group-item">Correr - 30 min (300 kcal quemadas)</li>
                    <li class="list-group-item">Entrenamiento de fuerza - 45 min (400 kcal quemadas)</li>
                </ul>
                <button class="btn btn-info update-button mt-3" onclick="window.location.href='ejercicios.php';">Ver Ejercicios Detallado</button>
            </div>
        </div>

        <!-- Progreso -->
        <div class="card profile-card shadow-lg">
            <div class="card-body">
                <h2 class="cherry-red">Progreso</h2>
                <p><strong>Calorías Semanales Quemadas:</strong> 2500 kcal</p>
                <p><strong>Objetivo de Peso:</strong> 70 kg</p>
                <p><strong>Kilómetros Recorridos Esta Semana:</strong> 15 km</p>
                <button class="btn btn-info update-button mt-3" onclick="window.location.href='progreso.php';">Ver Progreso Detallado</button>
            </div>
        </div>
    </div>
</div>
