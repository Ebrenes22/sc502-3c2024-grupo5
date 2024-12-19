<?php

require_once 'db.php';

function createRecommendation($type, $userId, $progressId, $description, $minWeight, $maxWeight) {
    global $pdo;

    $sql = "INSERT INTO RECOMMENDATIONS 
            (type, user_id, progress_id, description, min_weight, max_weight) 
            VALUES (:type, :userId, :progressId, :description, :minWeight, :maxWeight)";

    $stmt = $pdo->prepare($sql);

    // Enlazar los parámetros utilizando bindValue
    $stmt->bindValue(':type', $type, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':progressId', $progressId, PDO::PARAM_INT);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':minWeight', $minWeight, PDO::PARAM_STR);
    $stmt->bindValue(':maxWeight', $maxWeight, PDO::PARAM_STR);

    return $stmt->execute();
}

function getRecommendationsByUser($userId) {
    global $pdo;
    try {
        $sql = "SELECT * FROM RECOMMENDATIONS WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        logError("Error al obtener recomendaciones: " . $e->getMessage());
        return [];
    }
}

function deleteRecommendation($recommendationId) {
    global $pdo;

    try {
        $sql = "DELETE FROM RECOMMENDATIONS WHERE recommendations_id = :recommendations_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['recommendations_id' => $recommendationId]);
        echo "Recomendación eliminada correctamente.\n";
    } catch (PDOException $e) {
        echo "Error al eliminar la recomendación: " . $e->getMessage() . "\n";
    }
}

function getJsonInput() {
    return json_decode(file_get_contents("php://input"), true);
}

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            // Devolver las recomendaciones del usuario conectado
            $recommendations = getRecommendationsByUser($user_id);
            echo json_encode($recommendations);
            break;

        case 'POST':
            $input = getJsonInput();
            if (
                isset($input['type'], $input['progress_id'], $input['description'], $input['min_weight'], $input['max_weight'])
            ) {
                // Crear la recomendación
                if (createRecommendation(
                    $input['type'], 
                    $user_id, 
                    $input['progress_id'], 
                    $input['description'], 
                    $input['min_weight'], 
                    $input['max_weight']
                )) {
                    http_response_code(201);
                    echo json_encode(["message" => "Recomendación creada"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error al crear la recomendación"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Datos insuficientes"]);
            }
            break;

        case 'DELETE':
            if (isset($_GET['recommendations_id'])) {
                if (deleteRecommendation($_GET['recommendations_id'])) {
                    http_response_code(200);
                    echo json_encode(["message" => "Recomendación eliminada"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error al eliminar la recomendación"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Datos insuficientes"]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            break;
    }
} else {
    http_response_code(401);
    echo json_encode(["error" => "Sesión no activa"]);
}


?>