<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const form = ref({
  titular: '',
  categoria_id: null,
  autor_id: null,
  descripcion: '',
  fecha_publicacion: '',
  archivo_pdf: null
});
const router = useRouter();
const error = ref('');
const token = localStorage.getItem('token');
</script>

<template>
    <div class="contenedor-formulario">
      <form @submit.prevent="enviarFormulario" enctype="multipart/form-data" class="p-4 border rounded bg-light">
  
        <div class="mb-3">
          <label for="titular" class="form-label">Titular</label>
          <input v-model="form.titular" type="text" id="titular" class="form-control" required />
        </div>
  
        <div class="mb-3">
          <label for="categoria_id" class="form-label">Categoría</label>
          <input v-model="form.categoria_id" type="number" id="categoria_id" class="form-control" required />
        </div>
  
        <div class="mb-3">
          <label for="autor_id" class="form-label">Autor</label>
          <input v-model="form.autor_id" type="number" id="autor_id" class="form-control" required />
        </div>
  
        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea v-model="form.descripcion" id="descripcion" class="form-control"></textarea>
        </div>
  
        <div class="mb-3">
          <label for="fecha_publicacion" class="form-label">Fecha de publicación</label>
          <input v-model="form.fecha_publicacion" type="date" id="fecha_publicacion" class="form-control" required />
        </div>
  
        <div class="mb-3">
          <label for="archivo_pdf" class="form-label">Archivo PDF</label>
          <input @change="handleFileUpload" type="file" id="archivo_pdf" accept="application/pdf" class="form-control" />
        </div>
  
        <button type="submit" class="btn btn-primary w-100">Publicar artículo</button>
      </form>
    </div>
  </template>
  
  
  <style scoped>
  .contenedor-formulario {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
    background-color: #f8f9fa;
  }
  
  form {
    max-width: 600px;
    width: 100%;
    background: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  </style>
  