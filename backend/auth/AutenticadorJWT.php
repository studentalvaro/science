<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../vendor/autoload.php';

class AutenticadorJWT {
    private static $claveSecreta = 'PrOyEcTo';

    public static function verificarToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(self::$claveSecreta, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            throw new Exception('Token inválido: ' . $e->getMessage());
        }
    }
}
