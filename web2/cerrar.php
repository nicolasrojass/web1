<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o login
header("Location: index.php");
exit();
?>
