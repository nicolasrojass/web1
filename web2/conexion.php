<?php
$host = "localhost"; // Servidor de base de datos
$user = "root"; // Usuario de MySQL (en XAMPP por defecto es 'root')
$pass = ""; // Contraseña (vacía por defecto en XAMPP)
$db = "web"; // Cambia por el nombre de tu base de datos

$conn = new mysqli($host, $user, $pass, $db);

// Verifica si hay error en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
