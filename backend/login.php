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
            $_SESSION['user_id'] = $user["user_id"];
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

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(["error" => "Email no válido"]);
            exit;
        }

        if (login($email, $password)) {
            header("Location: index.php");
            exit;   
        } else {
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
?>
