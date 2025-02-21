<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="estilos/cuerpos.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Tipos de Cuerpo</title>
    
</head>
<body>
    <?php include 'navbar.php'; ?>

    <br><h1>Tipos de Cuerpo</h1>
    <br><p>Antes de nada, debemos conocer qué tipos de cuerpo existen y cuál coincide con el tuyo. Aquí te mostramos los tres tipos de cuerpo más comunes.</p>
    <img src="imagenes/tipos.jpg" alt="Tipos de cuerpo" width="750px" style="border-radius: 10px; margin: 20px 0;">

    <div class="container">
        <div class="tipo-cuerpo" id="ectomorfo">
            <h3>Ectomorfo</h3>
        </div>
        <div class="tipo-cuerpo" id="mesomorfo">
            <h3>Mesomorfo</h3>
        </div>
        <div class="tipo-cuerpo" id="endomorfo">
            <h3>Endomorfo</h3>
        </div>
    </div>

    <div class="content-section">
        <h3>¿Qué tipo de cuerpo tienes?</h3>
        <p>Para identificar tu tipo de cuerpo, observa la forma de tu físico, la facilidad con la que ganas o pierdes peso y la rapidez con la que desarrollas músculo.</p>
        <p>Recuerda que cada cuerpo es único y estos tipos son solo una guía general.</p>
    </div>

    <div class="content-section">
        <h3>¿Qué hacer si tu cuerpo es ectomorfo?</h3>
        <p>Si eres ectomorfo, sigue una dieta rica en proteínas y carbohidratos para ganar masa muscular y realiza entrenamientos de fuerza.</p>
    </div>

    <div class="content-section">
        <h3>¿Qué hacer si tu cuerpo es mesomorfo?</h3>
        <p>Los mesomorfos ganan músculo con facilidad. Para mantenerte en forma, combina ejercicios de fuerza con una dieta equilibrada.</p>
    </div>

    <div class="content-section">
        <h3>¿Qué hacer si tu cuerpo es endomorfo?</h3>
        <p>Si eres endomorfo, realiza ejercicios de cardio regularmente y sigue una dieta controlada para evitar el exceso de grasa.</p>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <span class="close">&times;</span>
        <h2 id="modalTitle"></h2>
        <p id="modalDescription"></p>
    </div>
    
    
    <script src="js/cuerpos.js"></script>
</body>
</html>
