<?php
require('db.php'); 
header('Content-Type: application/json');

function userRegistry($fullname, $email, $age, $weight, $height, $gender, $daily_calorie_goal, $password)
{
    try {
        global $pdo;

        // Hashear la contraseña
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (fullname, email, age, weight, height, gender, daily_calorie_goal, password) 
                VALUES (:fullname, :email, :age, :weight, :height, :gender, :daily_calorie_goal, :password)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':age' => (int)$age,
            ':weight' => (float)$weight,
            ':height' => (float)$height,
            ':gender' => $gender,
            ':daily_calorie_goal' => (int)$daily_calorie_goal,
            ':password' => $passwordHashed
        ]);

        return true;
    } catch (Exception $e) {
        error_log("Error en el registro de usuario: " . $e->getMessage());
        return false;
    }
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
     // Imprimir todo lo que llega en $_POST para depuración
     error_log(print_r($_POST, true)); // Esto imprimirá los datos recibidos en el log de errores de PHP

    if (isset($_POST['fullname'], $_POST['email'], $_POST['age'], $_POST['weight'], $_POST['height'], $_POST['gender'], $_POST['daily_calorie_goal'], $_POST['password'], $_POST['confirm_password'])) {

        // Campos requeridos
        $required_fields = ['fullname', 'email', 'age', 'weight', 'height', 'gender', 'daily_calorie_goal', 'password', 'confirm_password'];

        // Validar campos requeridos
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                http_response_code(400);
                echo json_encode(["error" => "Faltan campos requeridos: $field"]);
                exit();
            }
        }

        // Obtener y validar datos del formulario
        $fullname = trim($_POST['fullname']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
        $weight = filter_var($_POST['weight'], FILTER_VALIDATE_FLOAT);
        $height = filter_var($_POST['height'], FILTER_VALIDATE_FLOAT);
        $gender = trim($_POST['gender']);
        $daily_calorie_goal = filter_var($_POST['daily_calorie_goal'], FILTER_VALIDATE_INT);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validar género
        $valid_genders = ['Masculino', 'Femenino'];
        if (!in_array($gender, $valid_genders)) {
            http_response_code(400);
            echo json_encode(["error" => "El género debe ser 'Masculino' o 'Femenino'"]);
            exit();
        }

        // Validar los datos
        if (!$email || !$age || !$weight || !$height || !$daily_calorie_goal) {
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos"]);
            exit();
        }

        // Verificar coincidencia de contraseñas
        if ($password !== $confirm_password) {
            http_response_code(400);
            echo json_encode(["error" => "Las contraseñas no coinciden"]);
            exit();
        }

        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            http_response_code(400);
            echo json_encode(["error" => "El correo ya está registrado"]);
            exit();
        }

        // Llamar a la función de registro
        if (userRegistry($fullname, $email, $age, $weight, $height, $gender, $daily_calorie_goal, $password)) {
            http_response_code(201);
            echo json_encode(["message" => "Registro exitoso."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No se pudo completar el registro. Intente más tarde."]);
        }
    }
}
?>
