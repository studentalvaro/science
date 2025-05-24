<script setup>
import { useRouter } from 'vue-router'

const props = defineProps({
  datosSesion: {
    type: Object,
    default: null
  },
  token: {
    type: String,
    default: null
  }
});

const emit = defineEmits(['cerrar-sesion']);
const router = useRouter();

function cerrarSesion() {
  emit('cerrar-sesion'); //Emitimos un evento para que App.vue maneje el cierre de sesión
  router.push('/logout'); 
}
</script>

<template>
  <header class="bg-light py-3 shadow-sm w-100">
    <div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start px-4">
      <RouterLink to="/" class="d-flex align-items-center mb-2 mb-md-0 text-decoration-none">
        <img src="@/images/logo_resized.jpg" alt="TheScienceHub" width="80px" />
        <h1 class="h2 text-primary text-decoration-none ps-4 mb-0">The Science Hub</h1>
      </RouterLink>

      <div class="d-flex justify-content-center flex-wrap align-items-center">
        <template v-if="token">
          <span class="text-primary fw-semibold me-3">
            Bienvenido, {{ datosSesion?.nombre || 'Usuario' }}
          </span>
          <button @click="cerrarSesion" class="btn btn-danger btn-sm">Cerrar sesión</button>
        </template>
        <template v-else>
          <RouterLink to="/login" class="btn btn-primary btn-sm me-2 mb-2 mb-md-0">Iniciar sesión</RouterLink>
          <RouterLink to="/registro" class="btn btn-outline-primary btn-sm me-2 mb-2 mb-md-0">Registrarse</RouterLink>
        </template>
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
