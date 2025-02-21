<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Manejar el envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $descripcion = trim($_POST['descripcion']);

    $sql = "INSERT INTO eventos (user_id, titulo, fecha, tipo, descripcion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $titulo, $fecha, $tipo, $descripcion);
    if ($stmt->execute()) {
        header("Location: calendario.php");
        exit();
    } else {
        echo "Error al guardar el evento.";
    }
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Evento</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; }
        .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px; }
        button:hover { background-color: #0056b3; }
        .boton { display: block; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; text-align: center; margin-top: 10px; }
        .boton:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>➕ Agregar Evento</h2>
        <form action="" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>
            
            <label for="tipo">Tipo de evento:</label>
            <select name="tipo" required>
                <option value="entrenamiento">Entrenamiento</option>
                <option value="comida">Comida</option>
            </select>
            
            <label for="descripcion">Descripción (opcional):</label>
            <textarea name="descripcion"></textarea>
            
            <button type="submit">Guardar Evento</button>
        </form>
        <a href="inicio.php" class="boton">⬅ Volver</a>
    </div>
</body>
</html>
