<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Si el usuario selecciona una fecha específica
$fecha_seleccionada = $_GET['fecha'] ?? date("Y-m-d");

// Obtener datos del día seleccionado
$sql = "SELECT * FROM contador_calorias WHERE user_id = ? AND fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $fecha_seleccionada);
$stmt->execute();
$result = $stmt->get_result();

$comidas = [];
$total_calorias = 0;
$total_carbohidratos = 0;
$total_proteinas = 0;
$total_grasas = 0;

while ($row = $result->fetch_assoc()) {
    $comidas[] = $row;
    $total_calorias += $row['calorias'];
    $total_carbohidratos += $row['carbohidratos'];
    $total_proteinas += $row['proteinas'];
    $total_grasas += $row['grasas'];
}

// Obtener fechas únicas registradas
$sql = "SELECT DISTINCT fecha FROM contador_calorias WHERE user_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$fechas_result = $stmt->get_result();

$fechas = [];
while ($row = $fechas_result->fetch_assoc()) {
    $fechas[] = $row['fecha'];
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador de Calorías</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        h2 { color: #007bff; }
        form { margin-top: 20px; }
        label, select, input { margin-top: 10px; display: block; width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; border: none; padding: 10px; margin-top: 15px; border-radius: 5px; cursor: pointer; width: 100%; }
        button:hover { background-color: #0056b3; }
        .tabla-calorias { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .tabla-calorias th, .tabla-calorias td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .tabla-calorias th { background-color: #007bff; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <h2>🍽 Contador de Calorías</h2>

        <form action="" method="GET">
            <label for="fecha">Seleccionar Fecha:</label>
            <select name="fecha" id="fecha" onchange="this.form.submit()">
                <?php foreach ($fechas as $fecha): ?>
                    <option value="<?php echo $fecha; ?>" <?php echo ($fecha == $fecha_seleccionada) ? 'selected' : ''; ?>>
                        <?php echo $fecha; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <h3>🔥 Calorías totales: <?php echo $total_calorias; ?> kcal</h3>
        <h3>🍞 Carbohidratos: <?php echo $total_carbohidratos; ?>g</h3>
        <h3>🍗 Proteínas: <?php echo $total_proteinas; ?>g</h3>
        <h3>🥑 Grasas: <?php echo $total_grasas; ?>g</h3>

        <h3>🍽 Registro de comidas del día <?php echo $fecha_seleccionada; ?></h3>
        <table class="tabla-calorias">
            <tr>
                <th>Comida</th>
                <th>Calorías</th>
                <th>Carbohidratos</th>
                <th>Proteínas</th>
                <th>Grasas</th>
            </tr>
            <?php foreach ($comidas as $comida): ?>
                <tr>
                    <td><?php echo $comida['comida']; ?></td>
                    <td><?php echo $comida['calorias']; ?> kcal</td>
                    <td><?php echo $comida['carbohidratos']; ?> g</td>
                    <td><?php echo $comida['proteinas']; ?> g</td>
                    <td><?php echo $comida['grasas']; ?> g</td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>📈 Evolución de Calorías</h3>
        <canvas id="graficoCalorias"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('graficoCalorias').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_reverse($fechas)); ?>,
                datasets: [{
                    label: 'Calorías consumidas',
                    data: <?php echo json_encode(array_reverse(array_column($comidas, 'calorias'))); ?>,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: false } } }
        });
    </script>

</body>
</html>
