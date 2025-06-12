# 🧠 The Science Hub

Proyecto desarrollado por **Álvaro Beltrán Santiago** como trabajo final del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (IES Virgen del Carmen, Jaén).

---

## 📚 Descripción del proyecto

**The Science Hub** es una plataforma web orientada a la **difusión y consulta de contenido científico**, diseñada con el objetivo de facilitar el acceso abierto a artículos académicos y promover la divulgación del conocimiento en un entorno claro, accesible y ordenado.

El proyecto permite a los usuarios registrarse, iniciar sesión, consultar artículos clasificados por categorías científicas, y a los autores, publicar sus propios trabajos en formato PDF. La administración del sistema permite la gestión de categorías y usuarios, según el rol.

---

## 🎯 Funcionalidades principales

- Registro e inicio de sesión mediante autenticación con **JWT**.
- Consulta de artículos científicos, con filtro por categorías.
- Subida y almacenamiento de artículos en PDF.
- Roles diferenciados: lector, autor y administrador.
- Gestión de artículos, usuarios y categorías según permisos.
- Interfaz responsive adaptada a todos los dispositivos.
- Comunicación frontend-backend vía API REST.

---

## 🛠️ Tecnologías utilizadas

- **Vue 3**: framework JavaScript para la creación del frontend.
- **Bootstrap 5**: sistema de diseño para interfaz responsive.
- **PHP puro**: lenguaje del backend para lógica de negocio.
- **MySQL**: sistema de gestión de bases de datos relacional.
- **XAMPP**: entorno local con Apache y MySQL.
- **JWT (JSON Web Tokens)**: sistema de autenticación sin estado.
- **Mailtrap**: simulación de envío de correos electrónicos en entorno de desarrollo.

---

[!NOTE]
Este proyecto ha sido desarrollado con fines académicos como demostración de conocimientos adquiridos en backend (PHP y MySQL), frontend (Vue y Bootstrap), y seguridad (JWT).

[!TIP]
El backend puede probarse fácilmente usando herramientas como Postman o Thunder Client.

[!CAUTION]
El sistema requiere tener levantado el entorno local con Apache y MySQL (por ejemplo, con XAMPP) y ajustar las rutas si se despliega en un servidor real.