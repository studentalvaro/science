<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const form = ref({ email: '', contrasena: '' })
const mensaje = ref('')
const colorMensaje = ref('black')
const router = useRouter()

// EMITIR el token al App.vue
const emit = defineEmits(['iniciar-sesion'])

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
    fetch('http://localhost/science/api/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
      if (result.token) {
        // Guardar token en localStorage
        localStorage.setItem('token', result.token)
        mensaje.value = 'Login exitoso'
        colorMensaje.value = 'green'

        // Emitir token al padre
        emit('iniciar-sesion', result.token)

        setTimeout(() => {
          router.push('/')
        }, 1000)
      } else {
        mensaje.value = result.mensaje || 'Error al iniciar sesión'
        colorMensaje.value = 'red'
      }
    })
    .catch(error => {
      console.error('Error:', error)
      mensaje.value = 'Error en la conexión con el servidor'
      colorMensaje.value = 'red'
    })
  }
}
</script>

<template>
  <div class="image-background min-vh-100 d-flex flex-column">
    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
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

        <div v-if="mensaje" :class="{
            'alert alert-danger': colorMensaje == 'red', 
            'alert alert-success': colorMensaje == 'green'
          }" role="alert" class="mb-3 text-center">{{ mensaje }}</div>

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
  min-height: 100vh;
  width: 100%;
  display: flex;
  flex-direction: column;
}
::placeholder {
  color: #adb5bd;
  opacity: 1;
}
</style>
