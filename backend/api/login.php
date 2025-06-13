<?php
require '../vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

use Firebase\JWT\JWT;

header('Content-Type: application/json');

$claveSecreta = "PrOyEcTo";

require_once '../includes/connection.php';
$conn = getConnection();

$datos = json_decode(file_get_contents("php://input"), true);

$email = $datos['email'];
$contrasena = $datos['contrasena'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
    // Generar JWT
    $payload = [
        "id" => $usuario['id'],
        "nombre" => $usuario['nombre'],
        "email" => $usuario['email'],
        "rol" => $usuario['rol'],
        "fin_suscripcion" => $usuario['fin_suscripcion'],
        "exp" => time() + (60 * 60)
    ];

    $jwt = JWT::encode($payload, $claveSecreta, 'HS256');

    echo json_encode([
        "mensaje" => "Login exitoso",
        "token" => $jwt
    ]);

} else {
    http_response_code(401);
    echo json_encode(["mensaje" => "Email o contraseña incorrectos"]);
}
