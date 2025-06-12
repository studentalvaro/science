<script setup>
import { ref } from 'vue'

const nombre = ref('')
const email = ref('')
const mensaje = ref('')
const mensajeFeedback = ref('')
const colorFeedback = ref('') // 'success' o 'danger'

function enviarFormulario() {
  mensajeFeedback.value = ''
  colorFeedback.value = ''

  const datos = new FormData()
  datos.append('nombre', nombre.value)
  datos.append('email', email.value)
  datos.append('mensaje', mensaje.value)

  fetch('http://localhost/science/api/contacto.php', {
    method: 'POST',
    body: datos
  })
    .then(res => res.text())
    .then(data => {
      if (data.includes('correctamente')) {
        colorFeedback.value = 'success'
        nombre.value = ''
        email.value = ''
        mensaje.value = ''
      } else {
        colorFeedback.value = 'danger'
      }
      mensajeFeedback.value = data
    })
    .catch(err => {
      colorFeedback.value = 'danger'
      mensajeFeedback.value = 'Error al enviar el formulario.'
    })
}
</script>

<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <h1 class="display-5 fw-bold text-primary text-center">Contáctanos</h1>
        <p class="lead text-muted text-center">Estamos abiertos a sugerencias e ideas nuevas. No importa si tienes una recomendación, duda o queja, te responderemos en un plazo de 24 horas.</p>

        <div v-if="mensajeFeedback" :class="['alert', `alert-${colorFeedback}`]" role="alert">
          {{ mensajeFeedback }}
        </div>

        <form @submit.prevent="enviarFormulario">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
            <input type="text" v-model="nombre" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico<span class="text-danger">*</span></label>
            <input type="email" v-model="email" class="form-control" id="email" name="email" placeholder="ejemplo@ejemplo.com" required>
          </div>
          <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje<span class="text-danger">*</span></label>
            <textarea v-model="mensaje" class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100">Enviar mensaje</button>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
::placeholder {
  color: #adb5bd;
  opacity: 1;
}
</style>
