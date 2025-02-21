
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/index.css">
    <title>Mi Web de Fitness</title>

</head>
<body>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1); 
    include 'navbar.php'; 
    ?>

    <!-- Contenido principal -->
    <div class="contenido">
        <div class="seccion">
            <img src="fitness1.jpg" alt="Fitness">
            <div>
                <h2>¿Qué es el fitness?</h2>
                <p>El fitness es un estilo de vida basado en la actividad física y la alimentación saludable para mejorar la salud y el bienestar general.</p>
            </div>
        </div>

        <div class="seccion">
            <img src="imc.jpg" alt="IMC">
            <div>
                <h2>¿Cómo se calcula el IMC?</h2>
                <p>El Índice de Masa Corporal (IMC) se calcula dividiendo el peso (kg) entre la altura (m) al cuadrado. Es una referencia para conocer el estado físico de una persona.</p>
            </div>
        </div>
    </div>



</body>
</html>