<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Falta token']);
    exit;
}

$token = str_replace('Bearer ', '', $headers['Authorization']);
AutenticadorJWT::verificarToken($token);

$resultado = getConnection()->query("SELECT * FROM categorias");
$categorias = [];

$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($categorias);
