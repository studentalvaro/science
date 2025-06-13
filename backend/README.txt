
# 🧠 The Science Hub – Backend

Este repositorio contiene el backend del proyecto **The Science Hub**, una plataforma de publicación y consulta de artículos científicos.
Está desarrollado en PHP y ofrece una **API RESTful** para gestionar usuarios, categorías y artículos.
La autenticación se realiza mediante **JSON Web Tokens (JWT)**.

---

## 📁 Estructura del proyecto

```
science/
│
├── api/
│   ├── articulos/
│   │   ├── crear_articulo.php
│   │   ├── editar_articulo.php
│   │   ├── eliminar_articulo.php
│   │   └── obtener_articulos.php
│   ├── categorias/
│   │   ├── crear_categoria.php
│   │   ├── eliminar_categoria.php
│   │   └── obtener_categorias.php
│   ├── usuarios/
│   │   ├── login.php
│   │   ├── registrar.php
│   │   ├── obtener_usuarios.php
│   │   ├── actualizar_rol.php
│   │   └── eliminar_usuario.php
│
├── auth/
│   └── AutenticadorJWT.php
│
├── includes/
│   ├── Usuario.php
│   ├── Categoria.php
│   ├── Articulo.php
│   └── conexion.php
│
├── files/
│   └── (archivos PDF subidos por los autores)
```

---

## ⚙️ Requisitos

- PHP ≥ 7.4
- MySQL o MariaDB
- Servidor local (XAMPP, MAMP o similar)
- [Firebase JWT para PHP](https://github.com/firebase/php-jwt) (`composer require firebase/php-jwt`)
- Composer instalado

---

## 🔑 Autenticación con JWT

El backend utiliza tokens JWT para proteger endpoints.
Un usuario recibe su token al hacer login, y debe enviarlo en la cabecera `Authorization`:

```
Authorization: Bearer <token>
```

El archivo `AutenticadorJWT.php` gestiona la generación y verificación del token, usando una clave secreta definida en el propio script.

---

## 📬 Endpoints disponibles

| Endpoint                        | Método | Autenticación | Descripción                       |
|--------------------------------|--------|---------------|-----------------------------------|
| `/usuarios/registrar.php`      | POST   | ❌            | Registro de nuevos usuarios       |
| `/usuarios/login.php`          | POST   | ❌            | Inicio de sesión y obtención JWT |
| `/usuarios/obtener_usuarios.php`| GET   | ✅ Admin       | Obtener lista de usuarios         |
| `/usuarios/eliminar_usuario.php`| DELETE| ✅ Admin       | Eliminar usuario                  |
| `/usuarios/actualizar_rol.php` | PUT    | ✅ Admin       | Cambiar rol de usuario            |
| `/categorias/crear_categoria.php`| POST | ✅             | Crear nueva categoría             |
| `/categorias/obtener_categorias.php`| GET| ✅            | Listar categorías                 |
| `/categorias/eliminar_categoria.php`| DELETE | ✅         | Eliminar categoría                |
| `/articulos/crear_articulo.php`| POST   | ✅ Autor       | Publicar artículo con PDF         |
| `/articulos/editar_articulo.php`| PUT   | ✅ Autor       | Editar artículo propio            |
| `/articulos/eliminar_articulo.php`| DELETE | ✅ Autor     | Eliminar artículo propio          |
| `/articulos/obtener_articulos.php`| GET | ❌            | Obtener todos los artículos       |

---

## 📄 Subida de archivos PDF

- Los artículos incluyen un archivo PDF.
- Se almacenan en la carpeta `/files/`.
- La ruta del archivo se guarda en la base de datos.

---

## 🛡 Seguridad

- Los endpoints sensibles están protegidos con JWT.
- Los roles (`admin`, `autor`, `lector`) definen el nivel de acceso.
- No se permite que un usuario elimine a sí mismo o edite artículos ajenos.

---

## 📬 Notificaciones por email

- Se ha integrado **Mailtrap** para el envío de correos de prueba en entornos de desarrollo.
- Composer también se ha utilizado para gestionar dependencias como PHPMailer.

---

## 🧪 Pruebas y desarrollo

Durante el desarrollo se ha probado la API usando:
- **Postman** para simular peticiones HTTP.
- **Vue.js** en el frontend para integrar la lógica del usuario con el backend.

---

## 🧠 Autor

Desarrollado por Álvaro Beltrán Santiago, como parte del proyecto final de DAW.
El objetivo ha sido crear una plataforma funcional, segura y modular para la difusión del conocimiento científico.
