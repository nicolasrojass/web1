<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="estilos/ejercicios.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios</title>

</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Planifica tu entrenamiento</h2>
        <p>Ahora que ya conocemos nuestro cuerpo, es momento de decidir nuestros objetivos. Dependiendo de lo que desees lograr, debes seguir un plan de entrenamiento adecuado.</p>

        <div class="info-section">
            <h3>🔻 Quiero adelgazar</h3>
            <p>Para perder peso, necesitas mantener un déficit calórico (más detalles en la sección de dietas). Lo ideal es combinar ejercicios de cardio con entrenamientos de fuerza.</p>
        </div>

        <div class="info-section">
            <h3>💪 Quiero ganar masa muscular</h3>
            <p>Para aumentar tu musculatura, es importante seguir un superávit calórico y realizar ejercicios de fuerza con cargas progresivas.</p>
        </div>

        <div class="info-section">
            <h3>⚖️ Quiero mantenerme</h3>
            <p>Si deseas mantenerte activo y tonificado, sigue una dieta equilibrada y realiza una combinación de ejercicios de fuerza y cardio.</p>
        </div>

        <p>Recuerda que tanto el ejercicio de fuerza como el cardio son esenciales para la salud. ¡Selecciona un músculo para conocer los ejercicios ideales para él!</p>
    </div>

    <div class="info-section">
        <h3>🏃 Ejercicios de Cardio</h3><br>
        <p>El entrenamiento cardiovascular es fundamental para mejorar la resistencia y la salud del corazón. Aquí algunos ejercicios recomendados:</p><br>
        <ul>
            <li>Correr o trotar</li>
            <li>Saltar la cuerda</li>
            <li>Burpees</li>
            <li>Bicicleta</li>
            <li>Natación</li>
            <li>Clases de HIIT</li>
        </ul>
    </div>

    <h3>📌 Selecciona un músculo para ver los ejercicios</h3>
    <div class="exercise-box">
        <object id="svgObject1" type="image/svg+xml" data="svg/musculos2.svg" width="500"></object>
        <object id="svgObject2" type="image/svg+xml" data="svg/musculos1.svg" width="500"></object>
    </div>

    <div id="infoMusculo"></div>

<script src="js/ejercicios.js">

</script>
</body>
</html>
