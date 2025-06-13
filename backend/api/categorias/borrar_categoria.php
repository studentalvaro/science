<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../auth/AutenticadorJWT.php';
require_once '../../includes/connection.php';

$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : (isset($headers['authorization']) ? $headers['authorization'] : null);

if (!$authHeader) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Falta el token de autorización']);
    exit;
}

$token = str_replace('Bearer ', '', $authHeader);
AutenticadorJWT::verificarToken($token);

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el ID de la categoría']);
    exit;
}

try {
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM categorias WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    http_response_code(200);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
    