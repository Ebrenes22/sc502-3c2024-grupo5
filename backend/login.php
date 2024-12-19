<?php
session_start();
require('db.php');

function login($email, $password)
{
    try {
        global $pdo;
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Arreglo asociativo con los datos del usuario

        if ($user && password_verify($password, $user['password'])) {
            // Almacenar los datos del usuario en la sesión
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['age'] = $user['age'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['height'] = $user['height'];
            $_SESSION['weight'] = $user['weight'];

            /*$_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'age' => $user['age'],
                'gender' => $user['gender'],
                'height' => $user['height'],
                'weight' => $user['weight']
            ];*/
            session_regenerate_id(true); // Regenera el ID de sesión para mayor seguridad
            return true;
        }
        return false;
    } catch (Throwable $e) {
        error_log($e->getMessage());
        return false;
    }
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validación del correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(["error" => "Email no válido"]);
            exit;
        }

        // Intentar iniciar sesión
        if (login($email, $password)) {
            // Redirigir a la página principal si el login es exitoso
            header("Location: /frontend/index.php");
            exit;
        } else {
            // En caso de credenciales incorrectas
            http_response_code(401);
            echo json_encode(["error" => "Credenciales incorrectas"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Se requieren email y password"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}
