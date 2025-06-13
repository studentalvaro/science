<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../includes/connection.php';
require_once '../../includes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    Usuario::delete_usuario_by_id($_GET['id']);
    echo json_encode(['success' => true, 'message' => 'Usuario eliminado']);
} else {
    echo json_encode(['success' => false, 'message' => 'ID faltante o método no permitido']);
}
