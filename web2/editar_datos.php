<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos actuales del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT nombre, apellidos, edad, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Procesar el formulario si se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $edad = (int)$_POST['edad'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Verificar si el email ya existe en otro usuario
    $sql = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "El email ya está en uso.";
    } else {
        // Si el usuario quiere cambiar su contraseña
        if (!empty($password)) {
            if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || 
                !preg_match('/[A-Z]/', $password) || !preg_match('/[\W]/', $password)) {
                $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres, 1 mayúscula, 1 número y 1 símbolo.";
                header("Location: editar_datos.php");
                exit();
            }
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nombre=?, apellidos=?, edad=?, email=?, password=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssissi", $nombre, $apellidos, $edad, $email, $password_hash, $user_id);
        } else {
            // Si no cambia la contraseña
            $sql = "UPDATE usuarios SET nombre=?, apellidos=?, edad=?, email=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisi", $nombre, $apellidos, $edad, $email, $user_id);
        }

        if ($stmt->execute()) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellidos'] = $apellidos;
            $_SESSION['edad'] = $edad;
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "Datos actualizados con éxito.";
            header("Location: datos.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al actualizar los datos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Datos</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        h2 {
            color: #007bff;
            text-align: center;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="text"], input[type="email"], input[type="number"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .boton {
            display: block;
            background: #007bff;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }
        .boton:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Editar Datos</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($user['apellidos']); ?>" required>

            <label for="edad">Edad:</label>
            <input type="number" name="edad" id="edad" value="<?php echo htmlspecialchars($user['edad']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="password">Nueva Contraseña (opcional):</label>
            <input type="password" name="password" id="password">

            <input type="submit" value="Actualizar Datos" class="boton">
        </form>

        <a href="datos.php" class="boton">⬅ Volver a Mis Datos</a>
    </div>

</body>
</html>
