<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once "conexion.php";

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM dietas WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Dietas</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .dieta {
            padding: 15px;
            margin: 10px 0;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .btn:hover 
        {
            background: #218838;
        }

        .final1
        {
            display: inline-block;
            padding: 10px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .final1:hover 
        {
            background:rgb(12, 74, 141);
        }


    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Mis Dietas</h2>
        <a href="crear_dieta.php" class="btn">+ Crear Nueva Dieta</a><br>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($dieta = $result->fetch_assoc()): ?>
                <div class="dieta">
                    <h3><?= htmlspecialchars($dieta['nombre_dieta']) ?></h3>
                    <p><strong>Objetivo:</strong> <?= htmlspecialchars($dieta['tipo_dieta']) ?></p>
                    <p><?= htmlspecialchars($dieta['descripcion']) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <br><p>Aún no has creado ninguna dieta.</p>
        <?php endif; ?>

        <div class="final">
        <a href="inicio.php" class="final1">⬅ Volver</a>

        </div>

        

    </div>
</body>
</html>
