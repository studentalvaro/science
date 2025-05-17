<script setup>
defineProps({
  datosSesion: {
    type: Object,
    default: null
  }
})
</script>

<template>
  <nav class="navbar bg-primary py-3 border-bottom border-dark">
    <div class="container">
      <div class="row w-100 justify-content-center">
        <!-- En caso de admin -->
        <div v-if="datosSesion?.rol === 'admin'" class="col-12 text-center">
          <RouterLink to="/aboutus" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Contacto</RouterLink>
          <RouterLink to="/gestionusuarios" class="nav-link text-white fw-bold d-inline-block mx-2">Gestión de Usuarios</RouterLink>
          <RouterLink to="/gestionarcategorias" class="nav-link text-white fw-bold d-inline-block mx-2">Gestión de Categorías</RouterLink>

        </div>

        <!-- En caso de autor -->
        <div v-else-if="datosSesion?.rol === 'autor'" class="col-12 text-center">
          <RouterLink to="/aboutus" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Contacto</RouterLink>
          <RouterLink to="/creararticulo" class="nav-link text-white fw-bold d-inline-block mx-2">Crear Artículo</RouterLink>
        </div>

        <!-- En caso de lector -->
        <div v-else-if="datosSesion?.rol === 'lector'" class="col-12 text-center">
          <RouterLink to="/aboutus" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Contacto</RouterLink>
          <p>hola</p>
        </div>
          <!-- En caso general -->
          <div v-else class="col-12 text-center mb-2">
          <RouterLink to="/aboutus" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Contacto</RouterLink>
        </div>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.nav-link:hover {
  color: #cfe2ff !important;
  text-decoration: none;
}
</style>