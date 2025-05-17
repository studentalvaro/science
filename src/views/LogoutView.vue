<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

onMounted(() => {
  setTimeout(() => {
    router.push('/')
  }, 3000)
})
</script>

<template>
  <div class="d-flex justify-content-center align-items-center bg-light">
    <div class="bg-white shadow rounded p-5 text-center" style="max-width: 400px; width: 100%;">
      <h1 class="text-primary mb-3">¡Hasta pronto!</h1>
      <p class="mb-4 fs-5 text-primary">Gracias por visitarnos. Redirigiendo a la página principal...</p>
      <button class="btn btn-primary" disabled>
        Redirigiendo...
      </button>
    </div>
  </div>
</template>

<style scoped>
</style>
