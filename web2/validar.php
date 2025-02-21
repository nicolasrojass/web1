<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}


// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";  // Cambia esto si tu base de datos tiene otro nombre

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function validarPassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

// Manejar el inicio de sesión
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Buscar usuario en la base de datos
    $sql = "SELECT id, nombre, apellidos, edad, email, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Guardar datos en la sesión para usarlos en `dashboard.php`
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['apellidos'] = $user['apellidos'];
            $_SESSION['edad'] = $user['edad'];
            $_SESSION['email'] = $user['email'];

            header("Location: inicio.php"); // Redirige al panel de usuario
            exit;
        } else {
            $_SESSION['error'] = "Contraseña incorrecta.";
            $_SESSION['notificacion'] = [
                "mensaje" => "Contraseña incorrecta.",
                "tipo" => "error"
            ];
            header("Location: login.php");
            exit();
            
        }
    } else {
        
        $_SESSION['error'] = "No se encontró un usuario con ese correo electrónico.";
    }

    header("Location: login.php");
    exit;
}

// Manejar el registro
if (isset($_POST['registrar'])) {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $edad = (int) $_POST['edad'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmar = $_POST['confirmar'];

    // Validar si las contraseñas coinciden
    if ($password !== $confirmar) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: registro.php");
        exit;
    }

    // Validar fortaleza de la contraseña (mínimo 8 caracteres y al menos un número)
    if (strlen($password) < 8 || !preg_match('/[0-9]/', $password)) {
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres y un número.";
        header("Location: registro.php");
        exit;
    }

    // Verificar si el correo ya está registrado
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "El correo electrónico ya está registrado.";
        header("Location: registro.php");
        exit;
    } else {
        // Hash de la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, apellidos, edad, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $nombre, $apellidos, $edad, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: login.php"); // Redirige al login después del registro
            exit;
        } else {
            $_SESSION['error'] = "Error en el registro. Intenta nuevamente.";
        }
    }

    header("Location: registro.php");
    exit;
}

$conn->close();
?>


