<?php
session_start();
require 'conexion.php';

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Ayuda</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .faq { text-align: left; margin-bottom: 15px; }
        .faq h3 { cursor: pointer; color: #007bff; }
        .respuesta { display: none; padding-left: 10px; }
        .form-container { margin-top: 20px; }
        .boton { display: block; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; text-align: center; margin-top: 10px; }
        .boton:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>❓ Centro de Ayuda</h2>

        <div class="faq">
            <h3 onclick="toggleFAQ(1)">📌 ¿Cómo puedo registrar mis comidas?</h3>
            <p id="faq1" class="respuesta">Puedes registrar tus comidas en la sección "Contador de Calorías".</p>
        </div>
        
        <div class="faq">
            <h3 onclick="toggleFAQ(2)">📌 ¿Dónde puedo ver mi progreso?</h3>
            <p id="faq2" class="respuesta">En la sección "Progreso", puedes visualizar gráficos y estadísticas.</p>
        </div>

        <div class="faq">
            <h3 onclick="toggleFAQ(3)">📌 ¿Cómo cambiar mi información personal?</h3>
            <p id="faq3" class="respuesta">Ve a "Configuración" y edita tus datos personales.</p>
        </div>

        <div class="form-container">
            <h3>📩 Contactar Soporte</h3>
            <form action="enviar_consulta.php" method="POST">
                <textarea name="mensaje" rows="4" placeholder="Escribe tu consulta aquí..." required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
        <a href="inicio.php" class="boton">⬅ Volver</a>
    </div>

    <script>
        function toggleFAQ(num) {
            let respuesta = document.getElementById('faq' + num);
            respuesta.style.display = (respuesta.style.display === "none" || respuesta.style.display === "") ? "block" : "none";
        }
    </script>
</body>
</html>
