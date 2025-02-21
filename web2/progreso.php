<?php
session_start();
require 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obtener historial de peso
$sql = "SELECT fecha, peso FROM historial_peso WHERE user_id = ? ORDER BY fecha ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$fechas = [];
$pesos = [];
while ($row = $result->fetch_assoc()) {
    $fechas[] = $row['fecha'];
    $pesos[] = $row['peso'];
}

// Obtener la fecha de registro del usuario
$sql = "SELECT fecha_registro FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$fecha_registro = $user['fecha_registro'] ?? date("Y-m-d");

// Calcular días activos
$fecha_inicio = new DateTime($fecha_registro);
$fecha_actual = new DateTime();
$dias_activos = $fecha_inicio->diff($fecha_actual)->days;

// Calcular el progreso de peso
$peso_inicial = count($pesos) > 0 ? $pesos[0] : null;
$peso_actual = count($pesos) > 0 ? end($pesos) : null;
$peso_perdido = ($peso_inicial !== null && $peso_actual !== null) ? $peso_inicial - $peso_actual : 0;

// Definir las medallas y sus condiciones
$medallas = [
    ["img" => "imagenes/medalla7dias.png", "desc" => "Activo por 7 días", "condicion" => $dias_activos >= 7],
    ["img" => "imagenes/medalla30dias.png", "desc" => "Activo por 30 días", "condicion" => $dias_activos >= 30],
    ["img" => "imagenes/medalla90dias.png", "desc" => "Activo por 90 días", "condicion" => $dias_activos >= 90],
    ["img" => "imagenes/medalla_perdida5kg.png", "desc" => "Bajaste 5 kg", "condicion" => $peso_perdido >= 5]
];

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreso</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        h2 { color: #007bff; }
        .medallas { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
        .medalla { width: 80px; height: 80px; background-color: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; opacity: 0.5; position: relative; }
        .medalla img { width: 70%; }
        .desbloqueado { opacity: 1; background-color: gold; }
        .medalla span { position: absolute; bottom: -20px; font-size: 12px; width: 100px; text-align: center; }
        .consejos { margin-top: 20px; background: #e8f0fe; padding: 15px; border-radius: 10px; }
        input[type="number"], input[type="submit"] { padding: 10px; margin-top: 10px; border-radius: 5px; }
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

    <div class="container">
        <h2>Tu Progreso</h2><br>

        <!-- Formulario para ingresar peso -->
        <form action="guardar_peso.php" method="POST">
            <label for="peso">Ingresa tu peso actual (kg):</label>
            <br>
            <input type="number" name="peso" id="peso" step="0.1" required><br>
            <input type="submit" value="Guardar Peso"><br>
        </form>

        <h3>📅 Días Activos: <?php echo $dias_activos; ?></h3>
        <h3>⚖️ Peso Perdido: <?php echo $peso_perdido; ?> kg</h3>

        <h3>📈 Progreso de Peso</h3>
        <p>Registra tu peso diariamente para ver tu progreso.</p><br>
        <p>Último peso registrado: <?php echo $peso_actual ?? 'N/A'; ?> kg</p><br>

        <!-- Gráfico de Peso -->
        <canvas id="graficoPeso"></canvas>

        <h3>🏅 Medallas</h3>
        <div class="medallas">
            <?php foreach ($medallas as $medalla): ?>
                <div class="medalla <?php echo $medalla['condicion'] ? 'desbloqueado' : ''; ?>">
                    <img src="<?php echo $medalla['img']; ?>" alt="Medalla">
                    <span><?php echo $medalla['desc']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Consejos personalizados -->
        <div class="consejos">
            <h3>💡 Consejos</h3>
            <?php
            $consejos = [
                "💧 Recuerda beber al menos 2 litros de agua al día.",
                "💤 Dormir bien mejora el rendimiento en el entrenamiento.",
                "🍏 La alimentación balanceada es clave para el éxito.",
                "🏋️‍♂️ La constancia es la clave, ¡sigue adelante!",
                "🚶‍♂️ Caminar 10.000 pasos al día ayuda a mantener un estilo de vida activo."
            ];
            echo "<p>" . $consejos[array_rand($consejos)] . "</p>";
            ?>
        </div>
        <div class="final">
        <a href="inicio.php" class="final1">⬅ Volver</a>

        </div>
    </div>

    <script>
        // Datos para el gráfico
        const fechas = <?php echo json_encode($fechas); ?>;
        const pesos = <?php echo json_encode($pesos); ?>;
        
        const ctx = document.getElementById('graficoPeso').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Peso (kg)',
                    data: pesos,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: false }
                }
            }
        });
    </script>

</body>
</html>
