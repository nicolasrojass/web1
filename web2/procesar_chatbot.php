<?php
session_start(); // Iniciar sesión

function obtenerRespuesta($mensaje) {
    $mensaje = strtolower(trim($mensaje));

    $respuestas = [
        "hola" => "¡Hola! 😊 ¿En qué puedo ayudarte?",
        "ejercicio" => "¿Qué músculo quieres trabajar?",
        "rutina" => "Puedo hacerte una rutina personalizada. ¿Cuántos días entrenas?",
        "dieta" => "¿Cuál es tu objetivo? ¿Perder peso, mantener o ganar músculo?",
        "gracias" => "¡De nada! 💪 Pregunta lo que quieras.",
    ];

    if (isset($_SESSION['user_id'])) {
        $nombre = $_SESSION['nombre'];
        if ($mensaje == "quien soy") {
            return "Eres $nombre. Puedo ayudarte con rutinas y dietas personalizadas.";
        }
    }

    foreach ($respuestas as $clave => $respuesta) {
        if (strpos($mensaje, $clave) !== false) {
            return $respuesta;
        }
    }

    return "No entiendo bien 🤔. Pregunta sobre ejercicios, dietas o rutinas.";
}

if (isset($_POST['mensaje'])) {
    $mensaje = $_POST['mensaje'];
    echo obtenerRespuesta($mensaje);
} else {
    echo "No recibí ningún mensaje.";
}
?>
