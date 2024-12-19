<?php
/**
 * Obtiene información del usuario desde la sesión.
 * 
 * @param string $key Clave específica de los datos del usuario ('fullname', 'email', etc.).
 * @return mixed|null Retorna el valor correspondiente o null si no existe.
 */
function getUserData($key = null) {
    if (!isset($_SESSION['user'])) {
        return null;  // Si no hay usuario logueado, retorna null
    }
    
    if ($key) {
        return $_SESSION['user'][$key] ?? null;  // Retorna la clave específica o null si no existe
    }
    
    return $_SESSION['user'];  // Retorna todos los datos del usuario
}
?>
