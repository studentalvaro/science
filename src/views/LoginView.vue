<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const form = ref({ email: '', contrasena: '' })
const mensaje = ref('')
const colorMensaje = ref('black')
const router = useRouter()

//Función para comprobar si un campo está vacío
function isEmpty(str) {
  return str.trim().length === 0
}

function iniciarSesion(e) {
  e.preventDefault()

  if (isEmpty(form.value.email) || isEmpty(form.value.contrasena)) {
    mensaje.value = 'Todos los campos son obligatorios.'
    colorMensaje.value = 'red'
  } else {
    const data = {
      email: form.value.email,
      contrasena: form.value.contrasena
    }
    //Aquí me falta el fetch
  }
}
</script>

<template>
<div class="image-background">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <form @submit="iniciarSesion" class="p-4 bg-white rounded shadow-sm w-100" style="max-width: 400px;">
      <h2 class="mb-4 text-center">Iniciar sesión</h2>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" v-model="form.email" class="form-control" placeholder="Email" required />
      </div>

      <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" id="contrasena" v-model="form.contrasena" class="form-control" placeholder="Contraseña" required />
      </div>

      <p :style="{ color: colorMensaje }" class="mb-3 text-center">{{ mensaje }}</p>

      <button type="submit" class="btn btn-primary w-100">Entrar</button>

      <p class="mt-3 text-center">¿No tienes cuenta? <RouterLink to="/registro" class="text-primary">Regístrate</RouterLink></p>
    </form>
  </div>
</div>
</template>

<style scoped>
 .image-background {
    background-image: url('@/images/login_image.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
::placeholder {
    color: #adb5bd;
    opacity: 1;
}
</style>
