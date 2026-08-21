<?php
// procesar.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 1. Capturar los datos enviados por el formulario
$nombre  = $_POST['nombre'] ?? '';
$apellido =$_POST['apellido']??'';
$email   = $_POST['email'] ?? '';
$mensaje1 = $_POST['mensaje1'] ?? '';
$mensaje2 = $_POST['mensaje2'] ?? '';



// 3. Configuración y envío con PHPMailer
$mail = new PHPMailer(true);

try {
    // --- Configuración del Servidor SMTP ---
    $mail->isSMTP();                                       // Le indicamos que use SMTP
    $mail->Host       = 'sandbox.smtp.mailtrap.io';       // Servidor de Mailtrap
    $mail->SMTPAuth   = true;                              // Habilita autenticación
    $mail->Username   = '60bdb0c4926790';     // Tu usuario copiado de Mailtrap
    $mail->Password   = '4d2fdaaca3cb12';     // Tu password copiado de Mailtrap
    $mail->Port       = 2525;                              // Puerto SMTP de Mailtrap

    // --- Dirección y Destinatarios ---
    // setFrom: Dirección técnica que figura como emisora (la que vos controlás)
    $mail->setFrom('noreply@tudominio.com', 'Formulario de Contacto');

    // addAddress: Quién recibe el correo (capturado en Mailtrap)
    $mail->addAddress('admin@tudominio.com');

    // addReplyTo: Si hacés clic en "Responder" en el cliente de correo, le responderá a la persona que llenó el form
    $mail->addReplyTo($email, $nombre);

    // --- Contenido del Mensaje ---
    $mail->isHTML(true);                                  // Habilitar formato HTML
    $mail->Subject = 'Nuevo mensaje desde el portfolio';
    $mail->Body    = "
        <h2>Nuevo mensaje recibido</h2>
        <p><strong>Nombre:</strong> {$nombre}</p>
         <p><strong>Nombre:</strong> {$apellido}</p>
        <p><strong>Email:</strong> {$email}</p>
         <p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje1)) . "</p>
        <p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje2)) . "</p>
    ";

    // 4. Despachar
    $mail->send();
    echo "¡Mensaje enviado con éxito!";

} catch (Exception $e) {
    // Si la conexión SMTP falla, capturamos el error técnico
    echo "No se pudo enviar el mensaje. Error de PHPMailer: {$mail->ErrorInfo}";
}

?>