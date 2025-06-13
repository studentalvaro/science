<?php
// Cabeceras CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../includes/connection.php';

try {
    $conn = getConnection();

    $sql = "SELECT 
                a.id,
                a.titular,
                a.categoria_id,
                u.nombre AS autor,
                a.fecha_publicacion,
                a.descripcion,
                a.archivo_pdf,
                c.nombre AS categoria
            FROM articulos a
            LEFT JOIN usuarios u ON a.autor_id = u.id
            LEFT JOIN categorias c ON a.categoria_id = c.id
            ORDER BY a.fecha_publicacion DESC";

    $stmt = $conn->query($sql);
    $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($articulos);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
