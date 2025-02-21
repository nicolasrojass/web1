<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener eventos futuros y pasados
$sql_futuros = "SELECT * FROM eventos WHERE fecha >= CURDATE() ORDER BY fecha ASC";
$result_futuros = $conn->query($sql_futuros);

$sql_pasados = "SELECT * FROM eventos WHERE fecha < CURDATE() ORDER BY fecha DESC";
$result_pasados = $conn->query($sql_pasados);

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .evento { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; background: #fff; }
        .evento h3 { margin-bottom: 5px; }
        .btn { padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 5px; }
        .btn:hover { background-color: #0056b3; }
        .seccion { margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>📅 Eventos</h2>

    <div class="seccion">
        <h3>🆕 Próximos Eventos</h3>
        <?php if ($result_futuros->num_rows > 0): ?>
            <?php while ($evento = $result_futuros->fetch_assoc()): ?>
                <div class="evento">
                    <h3><?php echo htmlspecialchars($evento['titulo']); ?></h3>
                    <p><strong>📅 Fecha:</strong> <?php echo $evento['fecha']; ?></p>
                    <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                    <a href="registrar_evento.php?id=<?php echo $evento['id']; ?>" class="btn">🔔 Registrarse</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay eventos futuros.</p>
        <?php endif; ?>
    </div>

    <div class="seccion">
        <h3>📜 Eventos Pasados</h3>
        <?php if ($result_pasados->num_rows > 0): ?>
            <?php while ($evento = $result_pasados->fetch_assoc()): ?>
                <div class="evento">
                    <h3><?php echo htmlspecialchars($evento['titulo']); ?></h3>
                    <p><strong>📅 Fecha:</strong> <?php echo $evento['fecha']; ?></p>
                    <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay eventos pasados.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
