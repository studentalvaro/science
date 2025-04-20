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
        

        <!--En caso de guia-->
       

        <!--En caso de cliente-->
        
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
