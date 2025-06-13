<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Permitir CORS (ajusta el dominio en producción)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Responder rápido a preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../includes/Usuario.php';
require_once '../../auth/AutenticadorJWT.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Verificar JWT
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'No autorizado. Falta token']);
        exit();
    }

    $token = trim(str_replace('Bearer', '', $headers['Authorization']));

    try {
        AutenticadorJWT::verificarToken($token);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token inválido o expirado']);
        exit();
    }

    // Leer JSON body
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['id']) || !isset($data['rol'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Faltan parámetros id o rol o JSON mal formado.']);
        exit();
    }

    // Llamar al método para actualizar solo el rol
    $resultado = Usuario::update_rol_usuario($data['id'], $data['rol']);
    //var_dump($resultado);
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Rol actualizado correctamente']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el rol']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
