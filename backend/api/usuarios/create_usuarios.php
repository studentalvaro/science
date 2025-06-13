<?php
//Para los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Para las CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
//Includes
require_once("../../includes/Usuario.php");

// Petición POST normal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["nombre"]) && isset($data["email"]) && isset($data["contrasena"])) {
        Usuario::create_usuario($data["nombre"], $data["email"], $data["contrasena"]);
        echo json_encode(["mensaje" => "Usuario creado"]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Faltan campos"]);
    }
}
