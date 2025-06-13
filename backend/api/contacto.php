<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cabeceras CORS
header("Access-Control-Allow-Origin: *"); // En producción, reemplaza * por tu dominio frontend
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Looking to send emails in production? Check out our Email API/SMTP product!
$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = '7ec0f233d1e370';
$phpmailer->Password = 'f9edd917a8d597';

//Evitamos inyección SQL
$nombre = htmlspecialchars($_POST['nombre'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$mensaje = htmlspecialchars($_POST['mensaje'] ?? '');

//Validamos que todos los campos estén completos
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($nombre) || empty($mensaje)) {
    echo 'Por favor, completa todos los campos correctamente.';
    exit;
}

try {
    $phpmailer->setFrom('contacto@TheScienceHub.com', 'The Science Hub');
    $phpmailer->addAddress('contacto@TheScienceHub.com');
    $phpmailer->Subject = 'Nuevo mensaje de contacto';
    $phpmailer->Body = "Nombre: $nombre\nEmail: $email\nMensaje:\n$mensaje";
    $phpmailer->send();
    echo 'Mensaje enviado correctamente.';
} catch (Exception $e) {
    echo 'Error al enviar el mensaje: ', $phpmailer->ErrorInfo;
}
