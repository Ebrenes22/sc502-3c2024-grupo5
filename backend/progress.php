<?php
require_once 'db.php';

function createProgress($exerciseLogId, $userId, $weight, $caloriesConsumed, $caloriesBurned, $exercisesCompleted, $hoursSleep, $distanceKm, $recordedAt, $meats) {
    global $pdo; 

    $sql = "INSERT INTO PROGRESS 
            (exercise_log_id, user_id, weight, calories_consumed, calories_burned, exercises_completed, hours_sleep, distance_km, recorded_at, meats) 
            VALUES (:exerciseLogId, :userId, :weight, :caloriesConsumed, :caloriesBurned, :exercisesCompleted, :hoursSleep, :distanceKm, :recordedAt, :meats)";

    $stmt = $pdo->prepare($sql);

    // Enlazar los parámetros utilizando bindValue-
    $stmt->bindValue(':exerciseLogId', $exerciseLogId, PDO::PARAM_INT);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':weight', $weight, PDO::PARAM_STR); 
    $stmt->bindValue(':caloriesConsumed', $caloriesConsumed, PDO::PARAM_INT);
    $stmt->bindValue(':caloriesBurned', $caloriesBurned, PDO::PARAM_INT);
    $stmt->bindValue(':exercisesCompleted', $exercisesCompleted, PDO::PARAM_INT);
    $stmt->bindValue(':hoursSleep', $hoursSleep, PDO::PARAM_STR); 
    $stmt->bindValue(':distanceKm', $distanceKm, PDO::PARAM_STR); 
    $stmt->bindValue(':recordedAt', $recordedAt, PDO::PARAM_STR);
    $stmt->bindValue(':meats', $meats, PDO::PARAM_STR);

    return $stmt->execute();
}



// Function to retrieve all progress entries for a user
function getProgressByUser($userId) {
    global $pdo;
    try {
        $sql = "Select * from PROGRESS where user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        logError("Error al obtener progreso: " . $e->getMessage());
        return [];
    }
}

// Function to delete a progress entry by ID
function deleteProgress($progressId) {
    global $pdo;

    try {
        $sql = "DELETE FROM PROGRESS WHERE progress_id = :progress_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['progress_id' => $progressId]);
        echo "Progreso eliminado correctamente.\n";
    } catch (PDOException $e) {
        echo "Error al eliminar el progreso: " . $e->getMessage() . "\n";
    }
}

function updateProgress($progressId, $exerciseLogId, $userId, $weight, $caloriesConsumed, $caloriesBurned, $exercisesCompleted, $hoursSleep, $distanceKm, $recordedAt, $meats) {
    global $pdo;

    $sql = "UPDATE PROGRESS SET 
                exercise_log_id = :exercise_log_id, 
                weight = :weight, 
                calories_consumed = :calories_consumed, 
                calories_burned = :calories_burned, 
                exercises_completed = :exercises_completed, 
                hours_sleep = :hours_sleep, 
                distance_km = :distance_km, 
                recorded_at = :recorded_at, 
                meats = :meats
            WHERE progress_id = :progress_id AND user_id = :user_id";

    $stmt = $pdo->prepare($sql);

    // Enlazar parámetros
    $stmt->bindValue(':exercise_log_id', $exerciseLogId, PDO::PARAM_INT);
    $stmt->bindValue(':weight', $weight, PDO::PARAM_STR);
    $stmt->bindValue(':calories_consumed', $caloriesConsumed, PDO::PARAM_INT);
    $stmt->bindValue(':calories_burned', $caloriesBurned, PDO::PARAM_INT);
    $stmt->bindValue(':exercises_completed', $exercisesCompleted, PDO::PARAM_INT);
    $stmt->bindValue(':hours_sleep', $hoursSleep, PDO::PARAM_INT);
    $stmt->bindValue(':distance_km', $distanceKm, PDO::PARAM_STR);
    $stmt->bindValue(':recorded_at', $recordedAt, PDO::PARAM_STR);
    $stmt->bindValue(':meats', $meats, PDO::PARAM_STR);
    $stmt->bindValue(':progress_id', $progressId, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        print_r($stmt->errorInfo()); // Mostrar errores
        return false;
    }

    // Verificar filas afectadas
    if ($stmt->rowCount() === 0) {
        echo "No se actualizó ninguna fila. Verifica el progress_id y user_id.";
        return false;
    }

    return true;
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
            //devolver las tareas del usuario conectado
            $progreso = getProgressByUser($user_id);
            echo json_encode($progreso);
            break;
        

            case 'POST':
                $input = getJsonInput();
                if (isset($input['exercise_log_id'], $input['weight'], $input['calories_consumed'], $input['calories_burned'], $input['exercises_completed'], $input['hours_sleep'], $input['distance_km'], $input['recorded_at'], $input['meats'])) {
                    if (createProgress($input['exercise_log_id'], $user_id, $input['weight'], $input['calories_consumed'], $input['calories_burned'], $input['exercises_completed'], $input['hours_sleep'], $input['distance_km'], $input['recorded_at'], $input['meats'])) {
                        http_response_code(201);
                        echo json_encode(["message" => "Progreso creado"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["error" => "Error al crear el progreso"]);
                    }
                } else {
                    $input = getJsonInput();
                    error_log(print_r($input, true));  // Esto registrará los datos recibidos
                    http_response_code(400);
                    echo json_encode(["error" => "Datos insuficientes"]);
                }
                break;
    
                case 'PUT':
                    $input = getJsonInput();
                    if (isset($input['exercise_log_id'], $input['weight'], $input['calories_consumed'], $input['calories_burned'], $input['exercises_completed'], $input['hours_sleep'], $input['distance_km'], $input['recorded_at'], $input['meats'])) {
                        // Validate numeric fields
                        if (!is_numeric($input['weight']) || !is_numeric($input['calories_consumed']) || !is_numeric($input['calories_burned']) || !is_numeric($input['distance_km'])) {
                            http_response_code(400);
                            echo json_encode(["error" => "Campos numéricos inválidos"]);
                            return;
                        }
                    
                        // Validate meats (ensure it's a valid JSON array)
                        $meats = json_decode($input['meats'], true);
                        if (json_last_error() !== JSON_ERROR_NONE || !is_array($meats)) {
                            http_response_code(400);
                            echo json_encode(["error" => "El campo 'meats' no tiene un formato válido"]);
                            return;
                        }
                        
                        // Call the update function if validation passes
                        if (updateProgress(
                            $_GET['progress_id'], 
                            $input['exercise_log_id'], 
                            $user_id, 
                            $input['weight'], 
                            $input['calories_consumed'], 
                            $input['calories_burned'], 
                            $input['exercises_completed'], 
                            $input['hours_sleep'], 
                            $input['distance_km'], 
                            $input['recorded_at'], 
                            $input['meats']
                        )) {
                            http_response_code(200);
                            echo json_encode(["message" => "Progreso actualizado"]);
                        } else {
                            http_response_code(500);
                            echo json_encode(["error" => "Error al actualizar el progreso"]);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(["error" => "Datos insuficientes"]);
                    }
                    
                    break;                                
                
                case 'DELETE':
                    if (isset($_GET['progress_id'])) {
                        if (deleteProgress($_GET['progress_id'])) {
                            http_response_code(200);
                            echo json_encode(["message" => "Progreso eliminado"]);
                        } else {
                            http_response_code(500);
                            echo json_encode(["error" => "Error al eliminar el progreso"]);
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
