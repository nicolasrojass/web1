<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configurar servidor SMTP de Outlook
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // Servidor de Outlook
    $mail->SMTPAuth = true;
    $mail->Username = 'tuemail@outlook.com'; // Tu correo Outlook
    $mail->Password = 'tucontraseña'; // Usa "Contraseña de Aplicación" si Outlook bloquea el acceso
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configurar remitente y destinatario
    $mail->setFrom('tuemail@outlook.com', 'Tu Nombre');
    $mail->addAddress('destinatario@example.com', 'Destinatario');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Correo de Prueba con PHPMailer';
    $mail->Body = '<h1>¡Hola!</h1><p>Este es un correo de prueba enviado desde PHP con PHPMailer y Outlook SMTP.</p>';

    // Enviar correo
    $mail->send();
    echo "✅ Correo enviado correctamente.";
} catch (Exception $e) {
    echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
