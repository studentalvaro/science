<?php
require_once('connection.php');

class Usuario {
    public static function create_usuario($nombre, $email, $contrasena, $rol='lector') {
        $conn = getConnection();

        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('INSERT INTO usuarios (nombre, email, contrasena, rol, fin_suscripcion)
                            VALUES (:nombre, :email, :contrasena, :rol, NULL)');
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $hash);
        $stmt->bindParam(':rol', $rol);

        if ($stmt->execute()) {
            header('HTTP/1.1 201 Usuario creado correctamente');
        } else {
            header('HTTP/1.1 400 Usuario no se ha creado correctamente');
        }
    }

    public static function delete_usuario_by_id($id) {
        $conn = getConnection();

        $stmt = $conn->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header('HTTP/1.1 200 Usuario borrado correctamente');
        } else {
            header('HTTP/1.1 400 Usuario no se ha podido borrar correctamente');
        }
    }

    public static function get_all_usuarios() {
        $conn = getConnection();

        $stmt = $conn->prepare('SELECT id, nombre, email, rol FROM usuarios');

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($result);
            http_response_code(200);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'No se ha podido consultar los usuarios']);
        }
    }

    public static function update_rol_usuario($id, $rol) {
        $conn = getConnection();

        $stmt = $conn->prepare('UPDATE usuarios SET rol = :rol WHERE id = :id');
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function obtenerUsuarioPorEmail($email) {
        $conn = getConnection();
        $stmt = $conn->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




}