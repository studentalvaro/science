<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../auth/AutenticadorJWT.php';
require_once '../../includes/connection.php';

$headers = getallheaders();
$token = str_replace('Bearer ', '', $headers['Authorization']);
AutenticadorJWT::verificarToken($token);

$data = json_decode(file_get_contents("php://input"), true);
$nombre = $data['nombre'];

$conn = getConnection();
$stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
$stmt->bindParam(':nombre', $nombre);
$stmt->execute();

echo json_encode(['success' => true]);
