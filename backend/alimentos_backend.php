<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_name = $_POST['food_name'];
    $portion_size = $_POST['portion_size']; 
    $total_calories = $_POST['total_calories']; 
    $user_id = 2; 

    $sql_find_food = "SELECT food_id FROM foods WHERE food = :food_name LIMIT 1";
    $stmt_find_food = $pdo->prepare($sql_find_food);
    $stmt_find_food->bindParam(':food_name', $food_name);
    $stmt_find_food->execute();

    if ($stmt_find_food->rowCount() > 0) {
        $food = $stmt_find_food->fetch(PDO::FETCH_ASSOC);
        $food_id = $food['food_id'];

        $sql_insert_log = "INSERT INTO food_log (user_id, food_id, portion_size, total_calories) 
                           VALUES (:user_id, :food_id, :portion_size, :total_calories)";
        $stmt_insert_log = $pdo->prepare($sql_insert_log);
        $stmt_insert_log->bindParam(':user_id', $user_id);
        $stmt_insert_log->bindParam(':food_id', $food_id);
        $stmt_insert_log->bindParam(':portion_size', $portion_size);
        $stmt_insert_log->bindParam(':total_calories', $total_calories);

        if ($stmt_insert_log->execute()) {
            echo 'Log de alimento registrado correctamente';
        } else {
            echo 'Error al registrar el log del alimento';
        }
    } else {
        echo 'El alimento no se encuentra en la base de datos.';
    }
} else {
    echo 'No se ha enviado el formulario.';
}
