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

// Verificar método y campos obligatorios
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['id'], $_POST['titular'], $_POST['categoria_id'], $_POST['fecha_publicacion'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
    exit;
}

$id = $_POST['id'];
$titular = $_POST['titular'];
$categoria_id = $_POST['categoria_id'];
$descripcion = $_POST['descripcion'] ?? null;
$fecha_publicacion = $_POST['fecha_publicacion'];

try {
    $conn = getConnection();

    // Obtener autor_id y archivo_pdf actual desde la base de datos
    $stmt = $conn->prepare("SELECT autor_id, archivo_pdf FROM articulos WHERE id = ?");
    $stmt->execute([$id]);
    $articulo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$articulo) {
        echo json_encode(['success' => false, 'message' => 'Artículo no encontrado']);
        exit;
    }

    $autor_id = $articulo['autor_id'];
    $archivo_pdf = $articulo['archivo_pdf'];

    // Si se sube un nuevo archivo, lo reemplazamos
    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] === 0) {
        $directorio = '../../files/';
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreTemp = $_FILES['archivo_pdf']['tmp_name'];
        $nombreFinal = uniqid() . '_' . basename($_FILES['archivo_pdf']['name']);
        $rutaFinal = $directorio . $nombreFinal;

        if (move_uploaded_file($nombreTemp, $rutaFinal)) {
            $archivo_pdf = 'files/' . $nombreFinal;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al subir el nuevo PDF']);
            exit;
        }
    }

    // Actualizar artículo
    $sql = "UPDATE articulos SET titular = ?, categoria_id = ?, autor_id = ?, descripcion = ?, fecha_publicacion = ?, archivo_pdf = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titular, $categoria_id, $autor_id, $descripcion, $fecha_publicacion, $archivo_pdf, $id]);

    echo json_encode(['success' => true, 'message' => 'Artículo actualizado correctamente']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $e->getMessage()]);
}
