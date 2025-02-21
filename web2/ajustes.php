<?php
session_start();
require 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener configuración actual del usuario
$sql = "SELECT notificaciones FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$notificaciones = $user['notificaciones'] ?? 1; // Por defecto activado

// Procesar cambios en configuración
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cambiar_password'])) {
        $password_actual = $_POST['password_actual'];
        $password_nueva = $_POST['password_nueva'];
        $password_confirmar = $_POST['password_confirmar'];

        // Validar la contraseña actual
        $sql = "SELECT password FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!password_verify($password_actual, $user['password'])) {
            $_SESSION['error'] = "La contraseña actual es incorrecta.";
            header("Location: configuracion.php");
            exit();
        }

        // Validar la nueva contraseña
        if ($password_nueva !== $password_confirmar) {
            $_SESSION['error'] = "Las contraseñas no coinciden.";
            header("Location: configuracion.php");
            exit();
        }
        if (strlen($password_nueva) < 8 || !preg_match('/[0-9]/', $password_nueva) || 
            !preg_match('/[A-Z]/', $password_nueva) || !preg_match('/[\W]/', $password_nueva)) {
            $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres, 1 mayúscula, 1 número y 1 símbolo.";
            header("Location: configuracion.php");
            exit();
        }

        // Actualizar la contraseña
        $password_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $password_hash, $user_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Contraseña actualizada correctamente.";
        } else {
            $_SESSION['error'] = "Error al actualizar la contraseña.";
        }
        header("Location: configuracion.php");
        exit();
    }

    if (isset($_POST['notificaciones'])) {
        $notificaciones = $_POST['notificaciones'];
        $sql = "UPDATE usuarios SET notificaciones = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $notificaciones, $user_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Configuración actualizada correctamente.";
        } else {
            $_SESSION['error'] = "Error al actualizar configuración.";
        }
        header("Location: configuracion.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); text-align: left; }
        h2 { color: #007bff; text-align: center; }
        label { font-weight: bold; margin-top: 10px; display: block; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        .boton { display: block; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; text-align: center; margin-top: 10px; }
        .boton:hover { background: #0056b3; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Configuración</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <h3>Cambiar Contraseña</h3>
        <form action="" method="POST">
            <label for="password_actual">Contraseña Actual:</label>
            <input type="password" name="password_actual" required>

            <label for="password_nueva">Nueva Contraseña:</label>
            <input type="password" name="password_nueva" required>

            <label for="password_confirmar">Confirmar Nueva Contraseña:</label>
            <input type="password" name="password_confirmar" required>

            <input type="submit" name="cambiar_password" value="Actualizar Contraseña" class="boton">
        </form>

        <h3>Preferencias de Notificaciones</h3>
        <form action="" method="POST">
            <label for="notificaciones">Recibir Notificaciones:</label>
            <select name="notificaciones">
                <option value="1" <?php echo $notificaciones ? 'selected' : ''; ?>>Sí</option>
                <option value="0" <?php echo !$notificaciones ? 'selected' : ''; ?>>No</option>
            </select>
            <input type="submit" value="Guardar Configuración" class="boton">
        </form>

        <a href="inicio.php" class="boton">⬅ Volver</a>
    </div>

</body>
</html>
