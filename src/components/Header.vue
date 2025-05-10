<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const sesionIniciada = ref(false)

onMounted(() => {
  // Al cargar la página, comprobamos si hay token
  sesionIniciada.value = !!localStorage.getItem('token')
})

function cerrarSesion() {
  localStorage.removeItem('token')
  sesionIniciada.value = false
  router.push('/login')
}
</script>

<template>
  <header class="bg-light py-3 shadow-sm">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
      <RouterLink to="/" class="d-flex align-items-center mb-2 mb-md-0 text-decoration-none">
        <img src="@/images/logo_resized.jpg" alt="TheScienceHub" width="80px">
        <h1 class="h2 text-primary text-decoration-none ps-4">The Science Hub</h1>
      </RouterLink>

      <!-- Si está logueado, mostramos solo cerrar sesión -->
      <div v-if="sesionIniciada" class="d-flex justify-content-center flex-wrap">
        <button @click="cerrarSesion" class="btn btn-danger btn-sm">Cerrar sesión</button>
      </div>

      <!-- Si NO está logueado, mostramos login y registro -->
      <div v-else class="d-flex justify-content-center flex-wrap">
        <RouterLink to="/login" class="btn btn-primary btn-sm me-2 mb-2 mb-md-0">Iniciar sesión</RouterLink>
        <RouterLink to="/registro" class="btn btn-outline-primary btn-sm me-2 mb-2 mb-md-0">Registrarse</RouterLink>
      </div>
    </div>
  </header>
</template>

<style scoped>
img {
  width: 80px;
  height: auto;
  border-radius: 50%;
}
</style>
