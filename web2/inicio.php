<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            justify-items: center;
        }
        .opcion {
            background: #007bff;
            color: white;
            padding: 15px;
            text-decoration: none;
            border-radius: 10px;
            width: 100%;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .opcion:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h2>

        <div class="grid">
            <a href="datos.php" class="opcion">📋 Mis Datos</a>
            <a href="progreso.php" class="opcion">📊 Mi Progreso</a>
            <a href="rutinas.php" class="opcion">💪 Mis Rutinas</a>
            <a href="dietas.php" class="opcion">🥗 Mis Dietas</a>
            <a href="contador_calorias.php" class="opcion">🔥 Contador de Calorías</a>
            <a href="agregar_eventos.php" class="opcion">📅 Agregar Evento</a>
  
            <a href="ajustes.php" class="opcion">⚙️ Configuración</a>
            <a href="ayuda.php" class="opcion">❓ Ayuda</a>

            <a href="cerrar.php" class="opcion" style="background: red;">🚪 Cerrar Sesión</a>
        </div>
    </div>

</body>
</html>

