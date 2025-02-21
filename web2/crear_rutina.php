<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once "conexion.php";

$sugerencias = [
    "Fuerza" => "Entrenamiento de 5x5, con ejercicios básicos como sentadillas, press de banca y peso muerto.",
    "Hipertrofia" => "Rutina de 4 series de 8-12 repeticiones enfocada en músculos individuales.",
    "Resistencia" => "Circuitos de alta intensidad con poco descanso entre series.",
    "Definición" => "Combinación de pesas y cardio para maximizar la quema de grasa.",
    "Calistenia" => "Rutina con dominadas, fondos, flexiones y planchas para mejorar la fuerza funcional."
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_rutina = trim($_POST['nombre_rutina']);
    $descripcion = trim($_POST['descripcion']);
    $tipo_rutina = $_POST['tipo_rutina'];
    $user_id = $_SESSION['user_id'];

    if (!empty($nombre_rutina) && !empty($descripcion) && !empty($tipo_rutina)) {
        $sql = "INSERT INTO rutinas (user_id, nombre_rutina, descripcion, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $nombre_rutina, $descripcion, $tipo_rutina);
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Rutina creada con éxito.";
            header("Location: rutinas.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al guardar la rutina.";
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
    <title>Crear Rutina</title>
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
        <h2>Crear Nueva Rutina</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="crear_rutina.php" method="POST">
            <label for="nombre_rutina">Nombre de la Rutina:</label>
            <input type="text" name="nombre_rutina" id="nombre_rutina" required>

            <label for="tipo_rutina">Tipo de Rutina:</label>
            <select name="tipo_rutina" id="tipo_rutina" required onchange="mostrarSugerencia()">
                <option value="">Selecciona un tipo</option>
                <?php foreach ($sugerencias as $tipo => $desc) : ?>
                    <option value="<?= $tipo ?>"><?= $tipo ?></option>
                <?php endforeach; ?>
            </select>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

            <input type="submit" value="Guardar Rutina">
        </form>

        <div class="sugerencias" id="sugerenciaTexto">
            <p>Sugerencias:</p>
            <span id="sugerenciaContenido">Selecciona un tipo de rutina para ver sugerencias.</span>
        </div>

        <a href="rutinas.php">⬅ Volver a Rutinas</a>
    </div>

    <script>
        function mostrarSugerencia() {
            let tipo = document.getElementById("tipo_rutina").value;
            let sugerencias = <?= json_encode($sugerencias) ?>;
            document.getElementById("sugerenciaContenido").innerText = sugerencias[tipo] || "Selecciona un tipo de rutina para ver sugerencias.";
        }
    </script>
</body>
</html>

