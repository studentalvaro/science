<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const form = ref({nombre: '',email: '',contrasena: '',contrasena2: ''})
const mensaje = ref('')
const colorMensaje = ref('') //Como me daba error a veces lo he hecho reactivo y puesto negro por defecto.
const router = useRouter()

//Función para comprobar si algún campo está vacío
function isEmpty(str) {
  return str.trim().length === 0
}
//Función para validar contraseñas
function validaContrasena(password) {
  let patron = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,}$/
  return patron.test(password)
}
//Función para registrar un usuario 
function registrarUsuario(e) {
  e.preventDefault() //Para evitar que se recargue la página al enviar el formulario

  if (isEmpty(form.value.nombre) || isEmpty(form.value.email) || isEmpty(form.value.contrasena) || isEmpty(form.value.contrasena2)) {
    mensaje.value = 'Todos los campos son obligatorios.'
    colorMensaje.value = 'red'

  } else if (!validaContrasena(form.value.contrasena)) {
    mensaje.value = 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial.'
    colorMensaje.value = 'red'

  } else if (form.value.contrasena !== form.value.contrasena2) {
    mensaje.value = 'Las contraseñas no coinciden.'
    colorMensaje.value = 'red'

  } else {
  const data = {
    nombre: form.value.nombre,
    email: form.value.email,
    contrasena: form.value.contrasena
  }

  fetch('http://localhost/science/api/usuarios/create_usuarios.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data)
  })
    .then(function(response) {
      return response.text()
    })
    .then(function(textResponse) {
      try {
        const responseData = JSON.parse(textResponse)
        mensaje.value = 'Usuario registrado correctamente'
        colorMensaje.value = 'green'

        setTimeout(function() {
          router.push('/')
        }, 2000)
      } catch (error) {
        mensaje.value = 'Error al crear el usuario: ' + error.message
        colorMensaje.value = 'red'
      }
    })
    .catch(function(error) {
      mensaje.value = 'Error al crear el usuario: ' + error.message
      colorMensaje.value = 'red'
    })
}
}
</script>

<template>
<div class="image-background">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <form @submit="registrarUsuario" class="p-4 bg-white rounded shadow-sm w-100" style="max-width: 400px;">
      <h2 class="mb-4 text-center">Registro</h2>

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
        <input type="text" id="nombre" v-model="form.nombre" class="form-control"  placeholder="Nombre" required />
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
        <input type="email" id="email" v-model="form.email" class="form-control" placeholder="Email" required />
      </div>

      <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña<span class="text-danger">*</span></label>
        <input type="password" id="contrasena" v-model="form.contrasena" class="form-control" placeholder="Contraseña" required />
      </div>

      <div class="mb-3">
        <label for="contrasena2" class="form-label">Repetir contraseña<span class="text-danger">*</span></label>
        <input type="password" id="contrasena2" v-model="form.contrasena2" class="form-control" placeholder="Repetir contraseña" required />
      </div>

      <div v-if="mensaje" :class="{
        'alert alert-danger': colorMensaje == 'red', //En caso de que sea red toma esta clase
        'alert alert-success': colorMensaje == 'green', //En caso de que sea green toma esta clase
      }" role="alert" :style="{ color: colorMensaje }" class="mb-3 text-center">{{ mensaje }}</div>

      <button type="submit" class="btn btn-primary w-100">Registrarse</button>

      <p class="mt-3 text-center">¿Ya tienes cuenta? <RouterLink to="/login" class="text-primary">Iniciar sesión</RouterLink></p>
    </form>
  </div>
</div>
</template>

<style scoped>
 .image-background {
    background-image: url('@/images/registro_image.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
::placeholder {
    color: #adb5bd;
    opacity: 1;
}
</style>
