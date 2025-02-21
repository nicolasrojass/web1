<?php
session_start();
require 'navbar.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_nombre = $_SESSION['nombre'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rutinas de Entrenamiento</title>
    <link rel="stylesheet" href="estilos/rutinas.css">
   
</head>
    <style>
        .volver
        {
            display: inline-block;
            padding: 10px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .volver:hover 
        {
            background:rgb(12, 74, 141);
        }

    </style>
<body>
    <div class="container">
        <h2>Hola, <?php echo $user_nombre; ?> 👋</h2>
        <h3>Tu Plan de Entrenamiento</h3>
        
        <div class="rutina">
            <h4>Rutina para ganar masa muscular</h4>
            <p>- Press de banca (4x10)</p>
            <p>- Sentadillas (4x12)</p>
            <p>- Dominadas (3x8)</p>
            <p>- Curl de bíceps (4x12)</p>
        </div>

        <div class="rutina">
            <h4>Rutina para perder grasa</h4>
            <p>- Cardio HIIT (20 min)</p>
            <p>- Peso muerto (4x10)</p>
            <p>- Fondos en paralelas (3x12)</p>
            <p>- Abdominales en banco inclinado (4x15)</p>
        </div>

        <a href="crear_rutina.php" class="btn-agregar">+ Agregar Rutina</a>

        <div class="abajo">
        <a href="inicio.php" class="volver">⬅ Volver</a>
        </div>
    </div>
</body>
</html>
