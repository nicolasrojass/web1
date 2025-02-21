<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener la fecha seleccionada (o la actual si no se elige ninguna)
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

// Calcular días anteriores y siguientes
$fecha_anterior = date('Y-m-d', strtotime($fecha . ' -1 day'));
$fecha_siguiente = date('Y-m-d', strtotime($fecha . ' +1 day'));

// Obtener el historial de comidas para la fecha seleccionada
$sql = "SELECT tipo_comida, comida, cantidad, calorias, carbohidratos, proteinas, grasas FROM contador_calorias WHERE user_id = ? AND fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $fecha);
$stmt->execute();
$result = $stmt->get_result();

// Variables para totales
$total_calorias = 0;
$total_carbohidratos = 0;
$total_proteinas = 0;
$total_grasas = 0;
$comidas = [];

while ($row = $result->fetch_assoc()) {
    $comidas[] = $row;
    $total_calorias += $row['calorias'];
    $total_carbohidratos += $row['carbohidratos'];
    $total_proteinas += $row['proteinas'];
    $total_grasas += $row['grasas'];
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Calorías</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body 
        {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container 
        {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
        }
        .navegacion 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .navegacion a 
        {
            text-decoration: none;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }
        .navegacion a:hover 
        {
            background: #0056b3;
        }
        table 
        {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td 
        {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th 
        {
            background: #007bff;
            color: white;
        }
        .totales 
        {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .grafico 
        {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>📅 Historial de Calorías</h2>

        <div class="navegacion">
            <a href="?fecha=<?php echo $fecha_anterior; ?>">⬅ Día Anterior</a>
            <h3><?php echo date('d-m-Y', strtotime($fecha)); ?></h3>
            <a href="?fecha=<?php echo $fecha_siguiente; ?>">Día Siguiente ➡</a>
        </div>

        <!-- Tabla de comidas -->
        <table>
            <thead>
                <tr>
                    <th>Tipo de comida</th>
                    <th>Alimento</th>
                    <th>Cantidad</th>
                    <th>Calorías</th>
                    <th>Carbohidratos (g)</th>
                    <th>Proteínas (g)</th>
                    <th>Grasas (g)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($comidas)): ?>
                    <?php foreach ($comidas as $comida): ?>
                        <tr>
                            <td><?php echo $comida['tipo_comida']; ?></td>
                            <td><?php echo $comida['comida']; ?></td>
                            <td><?php echo $comida['cantidad']; ?></td>
                            <td><?php echo $comida['calorias']; ?> kcal</td>
                            <td><?php echo $comida['carbohidratos']; ?> g</td>
                            <td><?php echo $comida['proteinas']; ?> g</td>
                            <td><?php echo $comida['grasas']; ?> g</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No hay registros para este día.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="totales">
            <p>🔥 Calorías Totales: <?php echo $total_calorias; ?> kcal</p>
            <p>🥖 Carbohidratos: <?php echo $total_carbohidratos; ?> g</p>
            <p>🍗 Proteínas: <?php echo $total_proteinas; ?> g</p>
            <p>🥑 Grasas: <?php echo $total_grasas; ?> g</p>
        </div>

        <!-- Gráfico de Macronutrientes -->
        <div class="grafico">
            <canvas id="graficoMacronutrientes"></canvas>
        </div>
    </div>

    <script>
        // Datos para el gráfico
        const ctx = document.getElementById('graficoMacronutrientes').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Carbohidratos', 'Proteínas', 'Grasas'],
                datasets: [{
                    data: [<?php echo $total_carbohidratos; ?>, <?php echo $total_proteinas; ?>, <?php echo $total_grasas; ?>],
                    backgroundColor: ['#ffcc00', '#ff5733', '#33ff57'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</body>
</html>