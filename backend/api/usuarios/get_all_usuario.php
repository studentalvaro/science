<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Content-Type: application/json');

// Si la petición es OPTIONS, solo responder con los headers y terminar
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../auth/AutenticadorJWT.php';
require_once '../../includes/Usuario.php';

// Obtener headers HTTP Authorization
$headers = apache_request_headers();

if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(['mensaje' => 'No se ha enviado el token']);
    exit();
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

try {
    $usuario = AutenticadorJWT::verificarToken($token);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['mensaje' => 'Token inválido']);
    exit();
}

// Si el token es válido, obtener usuarios
Usuario::get_all_usuarios();
