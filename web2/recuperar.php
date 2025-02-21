<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="estilos/recuperar.css">
    
</head>
<body>

    <div class="container">
        <h2>Recuperar Contraseña</h2>
        <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
        <form action="recuperar.php" method="POST">
            <input type="email" name="email" placeholder="Tu correo electrónico" required>
            <input type="submit" name="enviar" value="Enviar enlace de recuperación">
        </form>
        
        <?php
        if (isset($_POST['enviar'])) {
            require 'conexion.php'; // Archivo con la conexión a la base de datos
            
            $email = $_POST['email'];
            $token = bin2hex(random_bytes(50)); // Generar un token único
            $expira = date("Y-m-d H:i:s", strtotime("+1 hour")); // El enlace expira en 1 hora

            // Verificar si el correo existe
            $sql = "SELECT id FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Guardar el token en la base de datos
                $sql = "INSERT INTO reseteo_password (email, token, expira) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $email, $token, $expira);
                $stmt->execute();

                // Enviar email con el enlace de recuperación
                $link = "http://tuweb.com/restablecer.php?token=" . $token;
                $mensaje = "Haz clic en el siguiente enlace para restablecer tu contraseña: " . $link;
                mail($email, "Recuperar Contraseña", $mensaje, "From: soporte@tuweb.com");

                echo "<p class='mensaje'>¡Correo enviado! Revisa tu bandeja de entrada.</p>";
            } else {
                echo "<p class='mensaje' style='color: red;'>El correo no está registrado.</p>";
            }
        }
        ?>
    </div>

</body>
</html>
