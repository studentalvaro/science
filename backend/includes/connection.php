<?php
function getConnection() {
    $host = 'localhost';
    $usuario = 'root';
    $contrasena = '';
    $nombre = 'science';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$nombre; charset=utf8", $usuario, $contrasena);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
}
