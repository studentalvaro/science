<?php
require_once '../../includes/connection.php';

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Falta el parámetro ID']);
    exit;
}

$id = $_GET['id'];

try {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM articulos WHERE id = ?");
    $stmt->execute([$id]);
    $articulo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($articulo) {
        echo json_encode($articulo);
    } else {
        echo json_encode(['success' => false, 'message' => 'Artículo no encontrado']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
