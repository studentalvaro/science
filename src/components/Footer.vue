<script setup>
</script>

<template>
    <footer class="bg-light shadow-sm footer-container py-4 mt-5">
        <div class="container text-center">
            <!-- Sección de derechos de autor -->
            <p class="copyright">&copy; Realizado por Álvaro Beltrán Santiago. Todos los derechos reservados.</p>

            <!-- Enlaces -->
            <div class="footer-links">
                <router-link to="/" class="footer-link">Inicio</router-link>
                <router-link to="/" class="footer-link">News</router-link>
                <router-link to="/contacto" class="footer-link">Contacto</router-link>
            </div>

            <!-- Redes sociales -->
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" class="social-icon bi bi-facebook"></a>
                <a href="https://twitter.com" target="_blank" class="social-icon bi bi-twitter"></a>
                <a href="https://instagram.com" target="_blank" class="social-icon bi bi-instagram"></a>
            </div>
        </div>
    </footer>
</template>

<style scoped></style>