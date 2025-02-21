<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Incluye la barra de navegación
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Datos</title>
    <link rel="stylesheet" href="estilos/datos.css">
    
    
</head>
<body>

    <div class="container">
        
        <h2>Mis Datos</h2>
        <p><strong>Nombre:</strong> <?php echo $_SESSION['nombre']; ?></p>
        <p><strong>Apellidos:</strong> <?php echo $_SESSION['apellidos']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Edad:</strong> <?php echo $_SESSION['edad']; ?></p>

        <a href="nuevos_datos.php" class="boton">➕ Datos Físicos</a>
        <a href="editar_datos.php" class="boton">✏ Editar Datos</a>
        <a href="inicio.php" class="boton">⬅ Volver</a>
       
    </div>

</body>
</html>
