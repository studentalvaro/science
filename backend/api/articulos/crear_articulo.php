<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CABECERAS CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../includes/connection.php';
require_once '../../auth/AutenticadorJWT.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar token
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

    if (!isset($_POST['titular'], $_POST['categoria_id'], $_POST['autor_id'], $_POST['fecha_publicacion'])) {
        echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
        exit;
    }

    $titular = $_POST['titular'];
    $categoria_id = $_POST['categoria_id'];
    $autor_id = $_POST['autor_id'];
    $descripcion = $_POST['descripcion'] ?? null;
    $fecha_publicacion = $_POST['fecha_publicacion'];

    $archivo_pdf = null;

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
            echo json_encode(['success' => false, 'message' => 'Error al subir el archivo PDF']);
            exit;
        }
    }

    try {
        $conn = getConnection();
        $sql = "INSERT INTO articulos (titular, categoria_id, autor_id, descripcion, fecha_publicacion, archivo_pdf) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$titular, $categoria_id, $autor_id, $descripcion, $fecha_publicacion, $archivo_pdf]);

        echo json_encode(['success' => true, 'message' => 'Artículo creado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en base de datos: ' . $e->getMessage()]);
    }
}
