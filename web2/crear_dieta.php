<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once "conexion.php";

$sugerencias = [
    "Pérdida de peso" => "Alta en proteínas, baja en carbohidratos. Incluye pollo, pescado y muchas verduras.",
    "Ganancia muscular" => "Alto en calorías y proteínas. Come carne magra, arroz, avena y batidos proteicos.",
    "Mantenimiento" => "Balance adecuado entre proteínas, grasas y carbohidratos. Buenas porciones y sin excesos.",
    "Dieta vegana" => "Alimentos vegetales, tofu, lentejas y proteínas vegetales.",
    "Definición" => "Moderado en carbohidratos, alto en proteínas, con grasas saludables como aguacate y frutos secos."
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_dieta = trim($_POST['nombre_dieta']);
    $descripcion = trim($_POST['descripcion']);
    $tipo_dieta = $_POST['tipo_dieta'];
    $user_id = $_SESSION['user_id'];

    if (!empty($nombre_dieta) && !empty($descripcion) && !empty($tipo_dieta)) {
        $sql = "INSERT INTO dietas (user_id, nombre_dieta, descripcion, tipo_dieta) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $nombre_dieta, $descripcion, $tipo_dieta);
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Dieta creada con éxito.";
            header("Location: dietas.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al guardar la dieta.";
        }
    } else {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Dieta</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .sugerencias {
            margin-top: 20px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
        }
        .sugerencias p {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Crear Nueva Dieta</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="crear_dieta.php" method="POST">
            <label for="nombre_dieta">Nombre de la Dieta:</label>
            <input type="text" name="nombre_dieta" id="nombre_dieta" required>

            <label for="tipo_dieta">Objetivo de la Dieta:</label>
            <select name="tipo_dieta" id="tipo_dieta" required onchange="mostrarSugerencia()">
                <option value="">Selecciona un objetivo</option>
                <?php foreach ($sugerencias as $tipo => $desc) : ?>
                    <option value="<?= $tipo ?>"><?= $tipo ?></option>
                <?php endforeach; ?>
            </select>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

            <input type="submit" value="Guardar Dieta">
        </form>

        <div class="sugerencias" id="sugerenciaTexto">
            <p>Sugerencias:</p>
            <span id="sugerenciaContenido">Selecciona un tipo de dieta para ver sugerencias.</span>
        </div>

        <a href="dietas.php">⬅ Volver a Mis Dietas</a>
    </div>

    <script>
        function mostrarSugerencia() {
            let tipo = document.getElementById("tipo_dieta").value;
            let sugerencias = <?= json_encode($sugerencias) ?>;
            document.getElementById("sugerenciaContenido").innerText = sugerencias[tipo] || "Selecciona un tipo de dieta para ver sugerencias.";
        }
    </script>
</body>
</html>
