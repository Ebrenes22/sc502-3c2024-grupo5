<?php

require 'db.php';


function crearExerciseLog($user_id, $exercise_id, $repetitions, $exercise_log_date, $calories_burned)
{
    global $pdo;
    try {
        //Traer calorias del ejercicio
        $sql = "SELECT calories_per_repetition FROM EXERCISES WHERE exercise_id = :exercise_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['exercise_id' => $exercise_id]);
        $exercise = $stmt->fetch(PDO::FETCH_ASSOC);

        //Calcular calorias quemadas
        $calories_burned = $exercise['calories_per_repetition'] * $repetitions;

        //Insertar
        $sql = "INSERT INTO EXERCISE_LOG (user_id, exercise_id, repetitions, exercise_log_date,calories_burned)
         values (:user_id, :exercise_id, :repetitions, :exercise_log_date,:calories_burned)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'exercise_id' => $exercise_id,
            'repetitions' => $repetitions,
            'exercise_log_date' => $exercise_log_date,
            'calories_burned' => $calories_burned

        ]);
        //devuelve el id del ExerciseLog creado en la linea anterior
        return $pdo->lastInsertId();
    } catch (Exception $e) {
        logError("Error creando ExerciseLog: " . $e->getMessage());
        return 0;
    }
}

function editarExerciseLog($exercise_log_id, $exercise_id, $repetitions, $exercise_log_date, $calories_burned)
{
    global $pdo;
    try {
        //Traer calorias del ejercicio
        $sql = "SELECT calories_per_repetition FROM EXERCISES WHERE exercise_id = :exercise_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['exercise_id' => $exercise_id]);
        $exercise = $stmt->fetch(PDO::FETCH_ASSOC);

        //Calcular calorias quemadas
        $calories_burned = $exercise['calories_per_repetition'] * $repetitions;


        //Modificar
        $sql = "UPDATE EXERCISE_LOG 
        set exercise_id = :exercise_id, repetitions = :repetitions, exercise_log_date =:exercise_log_date,calories_burned = :calories_burned 
        where exercise_log_id = :exercise_log_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'exercise_log_id' => $exercise_log_id,
            'exercise_id' => $exercise_id,
            'repetitions' => $repetitions,
            'exercise_log_date' => $exercise_log_date,
            'calories_burned' => $calories_burned
        ]);
        $affectedRows = $stmt->rowCount();
        return $affectedRows > 0;
    } catch (Exception $e) {
        logError($e->getMessage());
        return false;
    }
}

//obtenerExerciseLogsPorUsuario
function obtenerExerciseLogsPorUsuario($user_id)
{
    global $pdo;
    try {
        // $sql = "Select * from EXERCISE_LOG where user_id = :user_id";
        $sql = "SELECT el.*, e.name AS exercise_name 
            FROM EXERCISE_LOG el
            JOIN EXERCISES e ON el.exercise_id = e.exercise_id
            WHERE el.user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $exerciseLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $exerciseLogs;
    } catch (Exception $e) {
        logError("Error al obtener exerciseLogs: " . $e->getMessage());
        return [];
    }
}


function obtenerExercises()
{
    global $pdo;
    try {
        $sql = "SELECT *
            FROM EXERCISES";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $exercises;
    } catch (Exception $e) {
        logError("Error al obtener exercises " . $e->getMessage());
        return [];
    }
}


//Eliminar ExerciseLog
function eliminarExerciseLog($exercise_log_id)
{
    global $pdo;
    try {
        $sql = "DELETE FROM exercise_log WHERE exercise_log_id = :exercise_log_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['exercise_log_id' => $exercise_log_id]);
        return $stmt->rowCount() > 0;// true si se elimina algo
    } catch (Exception $e) {
        logError("Error al eliminar el exercise_log: " . $e->getMessage());
        return false;
    }
}

$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');
function getJsonInput()
{
    return json_decode(file_get_contents("php://input"), true);
}

session_start();
// if (isset($_SESSION['user_id'])) {
//el usuario tiene sesion
// $user_id = $_SESSION['user_id'];

$user_id = 2;//Cambiar a $_SESSION['user_id'] cuando se incorpore el login
logDebug($user_id);
switch ($method) {
    case 'GET':
        //devolver las tareas del usuario conectado
        $exerciseLogs = obtenerExerciseLogsPorUsuario($user_id);
        echo json_encode($exerciseLogs);
        break;

    case 'POST':
        $input = getJsonInput();
        if (isset($user_id, $input['exercise_id'], $input['repetitions'], $input['exercise_log_date'], $input['calories_burned'])) {
            $id = crearExerciseLog($user_id, $input['exercise_id'], $input['repetitions'], $input['exercise_log_date'], $input['calories_burned']);
            if ($id > 0) {
                http_response_code(201);
                echo json_encode(value: ["messsage" => "Exercise Log creado: ID:" . $id]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error general creando Exercise Log"]);
            }
        } else {
            //retornar un error
            http_response_code(400);
            echo json_encode(["error" => "Datos insuficientes"]);
        }
        break;

    case 'PUT':
        $input = getJsonInput();
        if (isset($input['exercise_id'], $input['repetitions'], $input['exercise_log_date'], $input['calories_burned']) && $_GET['id']) {
            $editResult = editarExerciseLog($_GET['id'],$input['exercise_id'], $input['repetitions'], $input['exercise_log_date'], $input['calories_burned']);
            if ($editResult) {
                http_response_code(201);
                echo json_encode(['message' => "Tarea actualizada"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Error actualizando la tarea"]);
            }
        } else {
            //retornar un error
            http_response_code(400);
            echo json_encode(["error" => "Datos insuficientes"]);
        }
        break;

    // case 'GET_EJERCICIOS':
    //         //devolver ejercicios
    //         $exercises = obtenerExercises();
    //         echo json_encode($exercises);
    //         break;

    case 'DELETE':
        if ($_GET['id']) {
            $fueEliminado = eliminarExerciseLog($_GET['id']);
            if ($fueEliminado) {
                http_response_code(200);
                echo json_encode(['message' => "Registro de ejercicio eliminado"]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Sucedio un error al eliminar Registro de ejercicio ']);
            }

        } else {
            //retornar un error
            http_response_code(400);
            echo json_encode(["error" => "Datos insuficientes"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Metodo no permitido"]);
        break;
}

// } else {
//     http_response_code(401);
//     echo json_encode(["error" => "Sesion no activa"]);
// }