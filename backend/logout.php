<?php
session_start(); // Iniciar sesión
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión
header("Location: /frontend/index.php"); // Redirigir al inicio o página deseada
exit();
?>
