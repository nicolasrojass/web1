<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="estilos/login.css">
       
    
</head>
<body>

<div class="container">
    <h2>Inicio de Sesión</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p class='error'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']); // Limpiar el mensaje
    }
    ?>

    <form action="validar.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" name="login" value="Iniciar Sesión">
    </form>

    <p><a href="recuperar.php">¿Olvidaste tu contraseña?</a></p>

    <div class="mensaje">
        <a href="index.php">Volver al inicio</a>
    </div>
</div>

</body>
</html>
