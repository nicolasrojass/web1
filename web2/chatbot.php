<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot - Asistente Virtual</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
        }
        .chat-container {
            width: 80%;
            max-width: 500px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        .chat-box {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            background: #fafafa;
        }
        .chat-input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .chat-button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .chat-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<?php 
include 'navbar.php'; 
?>

<div class="chat-container">
    <h2>🤖 Chatbot - Asistente Virtual</h2>
    <div class="chat-box" id="chat-box">
        <p><strong>Bot:</strong> Hola 👋, ¿en qué puedo ayudarte?</p>
    </div>
    <input type="text" id="chat-input" class="chat-input" placeholder="Escribe tu mensaje...">
    <button id="send-btn" class="chat-button">Enviar</button>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const chatBox = document.getElementById("chat-box");
    const chatInput = document.getElementById("chat-input");
    const sendBtn = document.getElementById("send-btn");

    sendBtn.addEventListener("click", function () {
        enviarMensaje();
    });

    chatInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            enviarMensaje();
        }
    });

    function enviarMensaje() {
        let mensaje = chatInput.value.trim();
        if (mensaje === "") return;

        chatBox.innerHTML += `<p><strong>Tú:</strong> ${mensaje}</p>`;
        chatInput.value = "";

        fetch("procesar_chatbot.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "mensaje=" + encodeURIComponent(mensaje)
        })
        .then(response => response.text())
        .then(data => {
            chatBox.innerHTML += `<p><strong>Bot:</strong> ${data}</p>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(error => console.error("Error en el chatbot:", error));
    }
});
</script>

</body>
</html>
