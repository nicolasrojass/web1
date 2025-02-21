<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC</title>
    <link rel="stylesheet" href="estilos/imc.css">
   
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>¿Qué es el IMC?</h2>
        <div class="imc-info">
            <p>El índice de masa corporal (IMC) es una medida de asociación entre el peso y la altura de una persona.
               Se calcula dividiendo el peso en kilogramos entre la altura en metros al cuadrado.</p>
            <p>El IMC es un indicador de la gordura corporal y se usa como referencia para evaluar riesgos de salud.</p>
        </div>
        
        <h2>Calculadora de IMC</h2>
        <div class="calculadora">
            <fieldset>
                <legend>Introduce tus datos</legend>
                <form action="" method="post">
                    <label for="peso">Peso (Kg):</label>
                    <input type="text" name="peso" id="peso"><br><br>

                    <label for="altura">Altura (m):</label>
                    <input type="text" name="altura" id="altura"><br><br>
                    
                    <input type="submit" value="Calcular">
                </form>
            </fieldset>
        </div>
        
        <div class="resultado">

        
            <?php
            function imc($peso, $altura) {
                return $peso / ($altura * $altura);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $peso = $_POST['peso'];
                $altura = $_POST['altura'];

                if (empty($peso) || empty($altura)) {
                    echo "Por favor, rellena los campos.";
                } elseif ($peso <= 0 || $altura <= 0) {
                    echo "Introduce valores positivos válidos.";
                } else {
                    $resultadoIMC = imc($peso, $altura);
                    echo "<p>Tu IMC es: " . number_format($resultadoIMC, 2) . "</p>";
                    
                    if ($resultadoIMC < 18.5) {
                        echo "<p>Estado: Peso insuficiente</p>";
                    } elseif ($resultadoIMC >= 18.5 && $resultadoIMC <= 24.9) {
                        echo "<p>Estado: Peso normal</p>";
                    } elseif ($resultadoIMC >= 25 && $resultadoIMC <= 29.9) {
                        echo "<p>Estado: Sobrepeso</p>";
                    } else {
                        echo "<p>Estado: Obesidad</p>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
