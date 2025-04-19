<script setup>
</script>

<template>
  <nav class="navbar bg-primary py-3 border-bottom border-dark">
    <div class="container">
      <div class="row w-100 justify-content-center">
        <!--En caso general-->
        <div class="col-12 text-center mb-2">
          <RouterLink to="/aboutus" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Contacto</RouterLink>
        </div>

        <!--En caso de admin-->
        <div v-if="propSesion?.rol == 'admin'" class="col-12 text-center">
          <RouterLink to="/" class="nav-link text-white fw-bold d-inline-block mx-2">Ver tours</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/crearruta" class="nav-link text-white fw-bold d-inline-block mx-2">Crear ruta</RouterLink>
          <RouterLink to="/gestionarruta" class="nav-link text-white fw-bold d-inline-block mx-2">Gestión rutas</RouterLink>
          <RouterLink to="/gestionusuarios" class="nav-link text-white fw-bold d-inline-block mx-2">Gestión usuarios</RouterLink>
        </div>

        <!--En caso de guia-->
        <div v-if="propSesion?.rol == 'guia'" class="col-12 text-center">
          <RouterLink to="/" class="nav-link text-white fw-bold d-inline-block mx-2">Ver tours</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/verrutas" class="nav-link text-white fw-bold d-inline-block mx-2">Ver rutas</RouterLink>
        </div>

        <!--En caso de cliente-->
        <div v-if="propSesion?.rol == 'cliente'" class="col-12 text-center">
          <RouterLink to="/" class="nav-link text-white fw-bold d-inline-block mx-2">Ver tours</RouterLink>
          <RouterLink to="/contacto" class="nav-link text-white fw-bold d-inline-block mx-2">Sobre nosotros</RouterLink>
          <RouterLink to="/reservas" class="nav-link text-white fw-bold d-inline-block mx-2">Mis reservas</RouterLink>
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
