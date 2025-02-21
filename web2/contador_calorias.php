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


// Obtener alimentos consumidos en la fecha seleccionada
$sql = "SELECT * FROM contador_calorias WHERE user_id = ? AND fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $fecha_actual);
$stmt->execute();
$result = $stmt->get_result();

$comidas = [];
$total_calorias = 0;
$total_proteinas = 0;
$total_carbohidratos = 0;
$total_grasas = 0;

while ($row = $result->fetch_assoc()) {
    $comidas[] = $row;
    $total_calorias += $row['calorias'];
    $total_proteinas += $row['proteinas'];
    $total_carbohidratos += $row['carbohidratos'];
    $total_grasas += $row['grasas'];
}

// Alimentos predefinidos
$alimentos = [
    "Manzana" => ["calorias" => 52, "carbohidratos" => 14, "proteinas" => 0.3, "grasas" => 0.2],
    "Pollo (100g)" => ["calorias" => 165, "carbohidratos" => 0, "proteinas" => 31, "grasas" => 3.6],
    "Arroz (100g)" => ["calorias" => 130, "carbohidratos" => 28, "proteinas" => 2.7, "grasas" => 0.3],
    "Huevos (100g)" => ["calorias" => 155, "carbohidratos" => 1.1, "proteinas" => 13, "grasas" => 10.6],
];

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contador de Calorías</title>
    <style>
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        .navegacion { display: flex; justify-content: space-between; align-items: center; }
        .tarjetas { display: flex; justify-content: space-around; flex-wrap: wrap; }
        .tarjeta { padding: 15px; border: 1px solid #ddd; border-radius: 10px; background: #f9f9f9; }
        .resumen { margin-top: 20px; padding: 15px; background: #e8f0fe; border-radius: 10px; }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
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
        .navegacion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .navegacion a {
            text-decoration: none;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }
        .navegacion a:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        .totales {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .grafico {
            margin-top: 20px;
        }
        .historial { display: block; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; text-align: center; margin-top: 10px; }
        .historial:hover { background: #0056b3; }
        .boton { display: block; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; text-align: center; margin-top: 10px; }
        .boton:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="navegacion">
        <a href="?fecha=<?php echo $fecha_anterior; ?>">⬅ Día Anterior</a>
            <h3><?php echo date('d-m-Y', strtotime($fecha)); ?></h3>
            <a href="?fecha=<?php echo $fecha_siguiente; ?>">Día Siguiente ➡</a>
        </div>
        
        <div class="tarjetas">

            <?php foreach (["Desayuno", "Almuerzo", "Cena"] as $comida) : ?>
                <div class="tarjeta">
                    <h4><?= $comida ?></h4>
                    <a href=".php?tipo=<?= $comida ?>&fecha=<?= $fecha_actual ?>">➕ Agregar</a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="resumen">
            <h3>Calorías totales: <?= $total_calorias ?> kcal</h3>
            <p>Proteínas: <?= $total_proteinas ?>g | Carbohidratos: <?= $total_carbohidratos ?>g | Grasas: <?= $total_grasas ?>g</p>
            <a href="historial_calorias.php?fecha=<?= $fecha_actual ?>" class="historial">📊 Mostrar Datos</a>
        </div>
        <a href="inicio.php" class="boton">⬅ Volver</a>
    </div>
</body>
</html>
