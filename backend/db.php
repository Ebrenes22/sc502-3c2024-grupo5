<?php
require 'message_log.php';

$host = 'localhost';
$dbname = 'nutrirecomienda';
$user = 'root';
$password = 'test123';
$port = '3306';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    logDebug("DB: Conexión exitosa");
} catch (PDOException $e) {
    logError($e->getMessage());
    die("Error de conexión: " . $e->getMessage());
}