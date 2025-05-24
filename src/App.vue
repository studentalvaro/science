<script setup>
import { ref, watch } from 'vue';
import { RouterView } from 'vue-router';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';
import NavBar from './components/NavBar.vue';
import { jwtDecode } from 'jwt-decode';

const token = ref(localStorage.getItem("token"));
const datosSesion = ref(null);

function actualizarDatosSesion() {
  if (token.value) {
    try {
      datosSesion.value = jwtDecode(token.value);
    } catch (error) {
      console.error("Error al decodificar el token:", error);
      localStorage.removeItem("token");
      token.value = null;
      datosSesion.value = null;
    }
  } else {
    datosSesion.value = null;
  }
}

// Inicializar y observar token
actualizarDatosSesion();
watch(token, () => actualizarDatosSesion());

// Manejar cierre de sesión
function handleCerrarSesion() {
  localStorage.removeItem("token");
  token.value = null;
}

// Manejar inicio de sesión emitido desde Login.vue
function handleIniciarSesion(nuevoToken) {
  token.value = nuevoToken;
  localStorage.setItem('token', nuevoToken);
}
</script>

<template>
  <div class="layout">
    <Header :datos-sesion="datosSesion" :token="token" @cerrar-sesion="handleCerrarSesion" />
    <NavBar :datos-sesion="datosSesion" />

    <div class="main-content">
      <!-- Interceptar el evento desde el login -->
      <RouterView @iniciar-sesion="handleIniciarSesion" :usuario="datosSesion" />
    </div>

    <Footer />
  </div>
</template>

<style scoped>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
}
</style>
