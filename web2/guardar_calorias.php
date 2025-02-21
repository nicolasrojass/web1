<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener todas las entradas del historial
$sql = "SELECT fecha, SUM(calorias) AS total_calorias, SUM(carbohidratos) AS total_carbohidratos, 
        SUM(proteinas) AS total_proteinas, SUM(grasas) AS total_grasas 
        FROM contador_calorias 
        WHERE user_id = ? 
        GROUP BY fecha 
        ORDER BY fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$historial = [];
while ($row = $result->fetch_assoc()) {
    $historial[] = $row;
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Consumo</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        .chart-container { max-width: 600px; margin: auto; }
    </style>
</head>
<body>

    <div class="container">
        <h2>📊 Historial de Consumo</h2>
        
        <table>
            <tr>
                <th>Fecha</th>
                <th>Calorías (kcal)</th>
                <th>Carbohidratos (g)</th>
                <th>Proteínas (g)</th>
                <th>Grasas (g)</th>
            </tr>
            <?php foreach ($historial as $dia): ?>
                <tr>
                    <td><?php echo $dia['fecha']; ?></td>
                    <td><?php echo number_format($dia['total_calorias'], 2); ?></td>
                    <td><?php echo number_format($dia['total_carbohidratos'], 2); ?></td>
                    <td><?php echo number_format($dia['total_proteinas'], 2); ?></td>
                    <td><?php echo number_format($dia['total_grasas'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>📈 Distribución de Macronutrientes</h3>
        <div class="chart-container">
            <canvas id="macroChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('macroChart').getContext('2d');
        const chartData = {
            labels: ["Carbohidratos", "Proteínas", "Grasas"],
            datasets: [{
                data: [
                    <?php echo isset($historial[0]) ? $historial[0]['total_carbohidratos'] : 0; ?>, 
                    <?php echo isset($historial[0]) ? $historial[0]['total_proteinas'] : 0; ?>, 
                    <?php echo isset($historial[0]) ? $historial[0]['total_grasas'] : 0; ?>
                ],
                backgroundColor: ["#f39c12", "#27ae60", "#e74c3c"]
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: { responsive: true }
        });
    </script>

</body>
</html>
