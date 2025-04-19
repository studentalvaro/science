<script setup>
</script>

<template>
  <footer class="bg-light shadow-sm py-4">
    <div class="container text-center">
      <!-- Sección de derechos de autor -->
      <p class="mb-3 text-muted">
        &copy; Realizado por Álvaro Beltrán Santiago. Todos los derechos reservados.
      </p>

      <!-- Enlaces -->
      <div class="mb-3">
        <router-link to="/" class="text-primary mx-2 text-decoration-none">Inicio</router-link>
        <router-link to="/aboutus" class="text-primary mx-2 text-decoration-none">Sobre Nosotros</router-link>
        <router-link to="/contacto" class="text-primary mx-2 text-decoration-none">Contacto</router-link>
      </div>

      <!-- Redes sociales -->
      <div>
        <a href="https://facebook.com" target="_blank" class="text-primary fs-4 mx-2 bi bi-facebook"></a>
        <a href="https://twitter.com" target="_blank" class="text-primary fs-4 mx-2 bi bi-twitter"></a>
        <a href="https://instagram.com" target="_blank" class="text-primary fs-4 mx-2 bi bi-instagram"></a>
      </div>
    </div>
  </footer>
</template>

<style scoped>
</style>
