<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="estilos/registro.css">

    
</head>
<body>

<div class="container">
    <h2>Registro de Usuario</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p class='error'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']); // Limpiar el mensaje
    }
    if (isset($_SESSION['success'])) {
        echo "<p style='color:green;'>".$_SESSION['success']."</p>";
        unset($_SESSION['success']); // Limpiar el mensaje
    }
    ?>

    <form action="validar.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" required>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <label for="confirmar">Confirmar contraseña:</label>
        <input type="password" name="confirmar" id="confirmar" required>

        <input type="submit" name="registrar" value="Registrarse">
    </form>

    <div class="mensaje">
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
        <a href="index.php">Volver al inicio</a>
    </div>
</div>

</body>
</html>
