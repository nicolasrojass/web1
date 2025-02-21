<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener notificaciones del usuario
$sql = "SELECT * FROM notificaciones WHERE user_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Marcar notificaciones como leídas al entrar en la página
$updateSql = "UPDATE notificaciones SET leida = 1 WHERE user_id = ?";
$stmtUpdate = $conn->prepare($updateSql);
$stmtUpdate->bind_param("i", $user_id);
$stmtUpdate->execute();

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .notificacion { background: #e8f0fe; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: left; }
        .fecha { font-size: 12px; color: gray; }
        .boton { display: block; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; text-align: center; margin-top: 10px; }
        .boton:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔔 Notificaciones</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="notificacion">
                    <p><?php echo htmlspecialchars($row['mensaje']); ?></p>
                    <p class="fecha"><?php echo $row['fecha']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes notificaciones nuevas.</p>
        <?php endif; ?>
    </div>
</body>
</html>
