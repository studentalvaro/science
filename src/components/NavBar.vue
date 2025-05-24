<script setup>
import { onMounted } from 'vue'

defineProps({
  datosSesion: {
    type: Object,
    default: null
  }
})

onMounted(() => {
  document.querySelectorAll('.navbar-collapse .nav-link').forEach(link => {
    link.addEventListener('click', () => {
      const menu = document.querySelector('.navbar-collapse.show')
      if (menu) {
        const bsCollapse = bootstrap.Collapse.getInstance(menu)
        if (bsCollapse) bsCollapse.hide()
      }
    })
  })
})
</script>

<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary py-3 border-bottom border-dark">
    <div class="container-fluid">
      <!-- Botón hamburguesa -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarContenido"
        aria-controls="navbarContenido"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Contenido colapsable -->
      <div class="collapse navbar-collapse justify-content-center" id="navbarContenido">
        <!-- Admin -->
        <ul v-if="datosSesion?.rol === 'admin'" class="navbar-nav text-center">
          <li class="nav-item"><RouterLink to="/" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Inicio</RouterLink></li>
          <li class="nav-item"><RouterLink to="/articulos" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Artículos</RouterLink></li>
          <li class="nav-item"><RouterLink to="/aboutus" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Sobre nosotros</RouterLink></li>
          <li class="nav-item"><RouterLink to="/contacto" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Contacto</RouterLink></li>
          <li class="nav-item"><RouterLink to="/gestionusuarios" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Gestión de Usuarios</RouterLink></li>
          <li class="nav-item"><RouterLink to="/gestionarcategorias" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Gestión de Categorías</RouterLink></li>
          <li class="nav-item"><RouterLink to="/creararticulo" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Publicar Articulo</RouterLink></li>
          <li class="nav-item"><RouterLink to="/gestionararticulos" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Gestión de Artículos</RouterLink></li>
        </ul>

        <!-- Autor -->
        <ul v-else-if="datosSesion?.rol === 'autor'" class="navbar-nav text-center">
          <li class="nav-item"><RouterLink to="/" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Inicio</RouterLink></li>
          <li class="nav-item"><RouterLink to="/articulos" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Artículos</RouterLink></li>
          <li class="nav-item"><RouterLink to="/aboutus" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Sobre nosotros</RouterLink></li>
          <li class="nav-item"><RouterLink to="/contacto" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Contacto</RouterLink></li>
          <li class="nav-item"><RouterLink to="/creararticulo" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Crear Artículo</RouterLink></li>
        </ul>

        <!-- Lector -->
        <ul v-else-if="datosSesion?.rol === 'lector'" class="navbar-nav text-center">
          <li class="nav-item"><RouterLink to="/" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Inicio</RouterLink></li>
          <li class="nav-item"><RouterLink to="/articulos" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Artículos</RouterLink></li>
          <li class="nav-item"><RouterLink to="/aboutus" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Sobre nosotros</RouterLink></li>
          <li class="nav-item"><RouterLink to="/contacto" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Contacto</RouterLink></li>
        </ul>

        <!-- Sin sesión -->
        <ul v-else class="navbar-nav text-center">
          <li class="nav-item"><RouterLink to="/" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Inicio</RouterLink></li>
          <li class="nav-item"><RouterLink to="/articulos" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Artículos</RouterLink></li>
          <li class="nav-item"><RouterLink to="/aboutus" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Sobre nosotros</RouterLink></li>
          <li class="nav-item"><RouterLink to="/contacto" class="nav-link fw-bold text-white mx-2" active-class="nav-link-active">Contacto</RouterLink></li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.nav-link:hover,
.nav-link-active {
  color: #cfe2ff !important;
  text-decoration: none;
}
</style>
