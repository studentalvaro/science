<?php
// Cabeceras CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../includes/connection.php';
require_once '../../auth/AutenticadorJWT.php';

// Verificar JWT
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Falta token']);
    exit;
}

$token = trim(str_replace('Bearer', '', $headers['Authorization']));

try {
    AutenticadorJWT::verificarToken($token);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token inválido: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Falta el ID del artículo']);
    exit;
}

try {
    $conn = getConnection();

    // Eliminar archivo físico si existe
    $stmt = $conn->prepare("SELECT archivo_pdf FROM articulos WHERE id = ?");
    $stmt->execute([$id]);
    $articulo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($articulo && $articulo['archivo_pdf']) {
        $rutaArchivo = '../../' . $articulo['archivo_pdf'];
        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
    }

    // Eliminar el registro
    $stmt = $conn->prepare("DELETE FROM articulos WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true, 'message' => 'Artículo eliminado']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
