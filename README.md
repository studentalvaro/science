
# 🌐 The Science Hub

**The Science Hub** es una plataforma web desarrollada como proyecto final del ciclo de Desarrollo de Aplicaciones Web (DAW).  
Su objetivo es facilitar la publicación, consulta y difusión de artículos científicos por parte de diferentes tipos de usuarios.

---

## 🧠 Funcionalidades principales

- Registro e inicio de sesión con autenticación mediante JWT
- Gestión de usuarios con diferentes roles: lector, autor y administrador
- Publicación de artículos científicos en formato PDF
- Visualización y lectura de artículos desde la página principal
- Filtrado de artículos por categorías
- Gestión de categorías por parte del administrador
- Sistema de subida de archivos
- Interfaz moderna, responsive y minimalista usando Vue.js + Bootstrap 5
- Comunicación segura entre frontend y backend

---

## 🧱 Tecnologías utilizadas

### 🔹 Frontend
- **Vue.js 3** (Composition API)
- **Bootstrap 5**
- **JavaScript**, **HTML5**, **CSS3**

### 🔹 Backend
- **PHP** (sin frameworks)
- **API RESTful**
- **JWT (Firebase/php-jwt)** para autenticación
- **MySQL** como base de datos
- **Composer** para gestión de dependencias
- **Mailtrap** para pruebas de envío de correos

---

## 🚀 Cómo ejecutar el proyecto

### 1. Clonar el repositorio
```bash
git clone https://github.com/studentalvaro/science
```

### 2. Backend
- Configura un servidor local (como XAMPP)
- Coloca la carpeta `backend/` en `htdocs`
- Importa el archivo `science_hub.sql` en tu base de datos MySQL
- Instala dependencias con Composer:
```bash
composer install
```

### 3. Frontend
- Ve a la carpeta `frontend/`
- Instala dependencias:
```bash
npm install
```
- Ejecuta la aplicación:
```bash
npm run dev
```

---

## 👤 Roles en el sistema

- **Lector**: puede ver y descargar artículos
- **Autor**: puede publicar y gestionar sus artículos
- **Administrador**: gestiona usuarios, categorías y todo el contenido

---

## 📌 Estado actual

✅ Funcionalidad completa  
✅ Seguridad básica implementada  
✅ UI responsive terminada  
🛠 Próximas mejoras: sistema de comentarios, buscador avanzado, integración con APIs externas

---

## 🧾 Licencia

Proyecto de fin de ciclo formativo. Código abierto para fines educativos y de demostración.

---

## ✍ Autor

Desarrollado por [Álvaro Beltrán] – [studentalvaro](https://github.com/tu_usuario)  
DAW · Proyecto Final · 2025
