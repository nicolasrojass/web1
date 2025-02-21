<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Barra de navegación -->
<div class="enlaces">
    <p>Menú</p>
    <div>
        <a href="index.php">Inicio</a>
        <a href="imc.php">IMC</a>
        <a href="cuerpos.php">Tipos de Cuerpos</a>
        <a href="ejercicios.php">Ejercicios</a>
        <a href="dieta.php">Dieta</a>
        <a href="volumen.php">Volumen</a>

    </div>

    <div class="botones">
        <button id="modoOscuro">Modo Oscuro 🌙</button>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <!-- Menú de usuario si está logueado -->
            <div class="user-menu">
                <img src="imagenes/user.png" alt="Usuario" class="user-icon">
                <div class="user-dropdown">
                <a href="inicio.php">Panel de Control</a>
                    <a href="datos.php">Mis Datos</a>
                    <a href="progreso.php">Mi Progreso</a>
                    <a href="contador_calorias.php">Contador de calorias</a>
                    <a href="rutinas.php">Rutinas</a>
                    <a href="dietas.php">Dietas</a>
                    <a href="cerrar.php">Cerrar Sesión</a>
                </div>
            </div>


        <?php else : ?>
            <!-- Botones de acceso si NO ha iniciado sesión -->
            <form action="login.php" method="post">
                <input type="submit" value="Iniciar sesión">
            </form>
            <form action="registro.php" method="post">
                <input type="submit" value="Registrarse">
            </form>
        <?php endif; ?>
        
    </div>
</div>

<!-- Botón de chat flotante -->
<div id="chatbot-button">💬</div>

<!-- Ventana del chat -->
<div id="chatbot-window">
    <div class="chat-header">
        <span>🤖 Chatbot</span>
        <button id="close-chat">✖</button>
    </div>
    <div class="chat-body" id="chat-body">
        <p>Hola 👋, ¿en qué puedo ayudarte?</p>
    </div>
    <input type="text" id="chat-input" placeholder="Escribe un mensaje...">
</div>

<!-- Script de interacciones -->
 
<script>
    
document.addEventListener("DOMContentLoaded", function () {
    const botonModoOscuro = document.getElementById("modoOscuro");
    const chatButton = document.getElementById("chatbot-button");
    const chatWindow = document.getElementById("chatbot-window");
    const closeChat = document.getElementById("close-chat");
    const chatInput = document.getElementById("chat-input");
    const chatBody = document.getElementById("chat-body");

    // Guardar preferencia de modo oscuro
    if (localStorage.getItem("modoOscuro") === "activado") {
        document.body.classList.add("modo-oscuro");
    }

    botonModoOscuro.addEventListener("click", () => {
        document.body.classList.toggle("modo-oscuro");
        localStorage.setItem("modoOscuro", document.body.classList.contains("modo-oscuro") ? "activado" : "desactivado");
    });

    // Chatbot
    chatButton.addEventListener("click", function () {
        chatWindow.style.display = "flex";
    });

    closeChat.addEventListener("click", function () {
        chatWindow.style.display = "none";
    });

    chatInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter" && chatInput.value.trim() !== "") {
            const userMessage = chatInput.value.trim();
            chatBody.innerHTML += `<p><strong>Tú:</strong> ${userMessage}</p>`;
            chatInput.value = "";
            setTimeout(() => {
                const botResponse = obtenerRespuestaBot(userMessage);
                chatBody.innerHTML += `<p><strong>Bot:</strong> ${botResponse}</p>`;
                chatBody.scrollTop = chatBody.scrollHeight;
            }, 1000);
        }
    });

    function obtenerRespuestaBot(mensaje) {
        mensaje = mensaje.toLowerCase();
        if (mensaje.includes("hola")) return "¡Hola! ¿Cómo puedo ayudarte? 😊";
        if (mensaje.includes("ejercicio")) return "Depende del músculo que quieras entrenar. ¿Cuál te interesa?";
        if (mensaje.includes("tipo de cuerpo")) return "Los principales tipos de cuerpo son ectomorfo, mesomorfo y endomorfo.";
        return "No estoy seguro de lo que dices, pero seguiré aprendiendo. 🤖";
    }
});
</script>

<!-- Estilos mejorados -->
<style>
/* Estilos generales */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f5f5f5;
    text-align: center;
    transition: 0.3s;
}

/* Barra de navegación */
.enlaces {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #A8D08D;
    padding: 15px;
    box-shadow: 4px 8px 12px rgba(0, 0, 0, 0.15);
}

.enlaces a {
    color: black;
    text-decoration: none;
    padding: 10px;
    background-color: #ffffff;
    border-radius: 5px;
    transition: 0.3s;
}

.enlaces a:hover {
    background-color: #000000;
    color: white;
}

/* Botones */
.botones {
    display: flex;
    align-items: center;
}

.botones input {
    margin-left: 10px;
    padding: 10px 15px;
    background-color: #ffffff;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s;
}

.botones input:hover {
    background-color: #000000;
    color: white;
}

/* Botón de modo oscuro */
#modoOscuro {
    padding: 10px 15px;
    cursor: pointer;
    border: none;
    background-color: #222;
    color: white;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
    display: flex;
    align-items: center;
    gap: 5px;
}

#modoOscuro:hover {
    background-color: #444;
    transform: scale(1.05);
}

#modoOscuro i {
    font-size: 18px;
}

/* Modo oscuro general */
.modo-oscuro {
    background-color: #222;
    color: white;
}

/* Cambios en enlaces y botones para modo oscuro */
.modo-oscuro a {
    color: #A8D08D;
}

.modo-oscuro a:hover {
    color: white;
}

.modo-oscuro .botones input {
    background-color: #444;
    color: white;
}

.modo-oscuro .botones input:hover {
    background-color: black;
}
/* Menú de usuario */
.user-menu {
    position: relative;
    display: inline-block;
    margin-left: 20px;
}

.user-menu img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
}

.user-dropdown {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    width: 150px;
    text-align: left;
}

.user-dropdown a {
    display: block;
    padding: 10px;
    color: black;
}

.user-dropdown a:hover {
    background: #f4f4f4;
}

.user-menu:hover .user-dropdown {
    display: block;
}


/* Botón flotante de chat */
#chatbot-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #007bff;
    color: white;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    transition: background 0.3s;
    z-index: 1000;
}
#chatbot-button:hover {
    background: #0056b3;
}

/* Ventana del chatbot */
#chatbot-window {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 300px;
    background: white;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    z-index: 1000;
}

.chat-header {
    background: #007bff;
    color: white;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
.chat-header button {
    background: none;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
}
.chat-body {
    padding: 10px;
    max-height: 200px;
    overflow-y: auto;
}
#chat-input {
    width: 100%;
    padding: 8px;
    border: none;
    border-top: 1px solid #ddd;
    outline: none;
}
</style>
