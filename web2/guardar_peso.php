<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$peso = isset($_POST['peso']) ? floatval($_POST['peso']) : 0;

// Validar que el peso sea un número válido
if ($peso <= 0) {
    $_SESSION['error'] = "Por favor, ingresa un peso válido.";
    header("Location: progreso.php");
    exit();
}

// Insertar el peso en la base de datos
$sql = "INSERT INTO historial_peso (user_id, fecha, peso) VALUES (?, CURDATE(), ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $peso);

if ($stmt->execute()) {
    $_SESSION['success'] = "Peso guardado correctamente.";
} else {
    $_SESSION['error'] = "Error al guardar el peso.";
}

header("Location: progreso.php");
exit();
?>
