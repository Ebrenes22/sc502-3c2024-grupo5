<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - NutriRecomienda</title>
    <link href="/frontend/assets/css/registerformstyle.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="form-container bg-white p-5 rounded shadow">
            <h2 class="text-center mb-4">Registro de Usuario</h2>
            <form id="registerForm" action="/backend/register.php" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fullname">Nombre Completo</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required placeholder="Ingresa tu nombre completo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Ingresa tu correo electrónico">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="edad">Edad</label>
                        <input type="number" class="form-control" id="age" name="age" min="1" max="100" required placeholder="Ingresa tu edad">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="weight">Peso (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="weight" name="weight" required placeholder="Ingresa tu peso en kilogramos">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="height">Altura (cm)</label>
                        <input type="number" class="form-control" id="height" name="height" required placeholder="Ingresa tu altura en centímetros">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender">Género</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Selecciona tu género</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="meta_calorias">Meta Calorías (kcal)</label>
                    <input type="number" class="form-control" id="daily_calorie_goal" name="daily_calorie_goal" required placeholder="Ingresa tu meta diaria de calorías">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Ingresa tu contraseña">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Confirma tu contraseña">
                    </div>
                </div>
                <!-- Campo role_id oculto -->
                <input type="hidden" id="role_id" name="role_id">
                <div class="form-group text-center">
                    <div id="register-error"></div>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
                <div class="form-group text-center">
                    <p>¿Ya tienes una cuenta? <a href="/frontend/pages/login.php">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript para manejar el formulario -->
    <script src="/frontend/assets/js/register.js"></script>
</body>

</html>
