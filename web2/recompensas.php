<?php
session_start();
require 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener recompensas del usuario
$sql = "SELECT * FROM recompensas WHERE user_id = ? ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recompensas</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .recompensa { background: #e8f0fe; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: left; }
        .desbloqueada { background: gold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🏆 Recompensas</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="recompensa <?php echo $row['desbloqueada'] ? 'desbloqueada' : ''; ?>">
                    <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                    <p><?php echo $row['desbloqueada'] ? "Desbloqueada el: " . $row['fecha_desbloqueo'] : "Bloqueada 🔒"; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes recompensas aún. ¡Sigue avanzando! 💪</p>
        <?php endif; ?>
    </div>
</body>
</html>
