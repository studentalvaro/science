<script setup>
import { ref, onMounted, computed } from 'vue'
import { jwtDecode } from 'jwt-decode'

const titular = ref('')
const categoria_id = ref('')
const categoriaTexto = ref('')
const categorias = ref([])
const descripcion = ref('')
const archivo_pdf = ref(null)
const mensaje = ref('')
const colorMensaje = ref('')
const autor_id = ref(null)

onMounted(() => {
  const token = localStorage.getItem('token')

  if (token) {
    try {
      const decoded = jwtDecode(token)
      autor_id.value = decoded.id
    } catch (e) {
      mensaje.value = 'Token inválido'
      colorMensaje.value = 'red'
      return
    }
  }

  fetch('http://localhost/science/api/categorias/obtener_categorias.php', {
    headers: {
      'Authorization': 'Bearer ' + token
    }
  })
    .then(res => res.json())
    .then(data => {
      if (Array.isArray(data)) {
        categorias.value = data
      } else {
        mensaje.value = data?.error || 'No se pudieron cargar las categorías'
        colorMensaje.value = 'red'
      }
    })
    .catch(err => {
      console.error(err)
      mensaje.value = 'Error de conexión al cargar categorías'
      colorMensaje.value = 'red'
    })
})

const categoriasFiltradas = computed(() => {
  if (!Array.isArray(categorias.value)) return []
  if (!categoriaTexto.value.trim()) return []
  return categorias.value.filter(c =>
    c.nombre.toLowerCase().includes(categoriaTexto.value.toLowerCase())
  )
})

function seleccionarCategoria(c) {
  categoria_id.value = c.id
  categoriaTexto.value = c.nombre
}

function manejarArchivo(e) {
  archivo_pdf.value = e.target.files[0]
}

function obtenerFechaActual() {
  const hoy = new Date()
  const yyyy = hoy.getFullYear()
  const mm = String(hoy.getMonth() + 1).padStart(2, '0')
  const dd = String(hoy.getDate()).padStart(2, '0')
  return `${yyyy}-${mm}-${dd}`
}

function publicarArticulo() {
  const categoriaElegida = categorias.value.find(cat => cat.nombre.toLowerCase() === categoriaTexto.value.toLowerCase())

  if (!titular.value.trim() || !categoriaTexto.value.trim() || !categoriaElegida || !autor_id.value) {
    mensaje.value = 'Por favor, completa todos los campos obligatorios y selecciona una categoría válida.'
    colorMensaje.value = 'red'
    return
  }

  categoria_id.value = categoriaElegida.id // Confirmar ID real

  const formData = new FormData()
  formData.append('titular', titular.value)
  formData.append('categoria_id', categoria_id.value)
  formData.append('autor_id', autor_id.value)
  formData.append('descripcion', descripcion.value)
  formData.append('fecha_publicacion', obtenerFechaActual())
  if (archivo_pdf.value) {
    formData.append('archivo_pdf', archivo_pdf.value)
  }

fetch('http://localhost/science/api/articulos/crear_articulo.php', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer ' + localStorage.getItem('token')
  },
  body: formData
})

    .then(res => res.json())
    .then(data => {
      mensaje.value = data.message
      colorMensaje.value = data.success ? 'green' : 'red'
      if (data.success) {
        titular.value = ''
        categoria_id.value = ''
        categoriaTexto.value = ''
        descripcion.value = ''
        archivo_pdf.value = null
      }
    })
    .catch(err => {
      mensaje.value = 'Error al enviar el formulario.'
      colorMensaje.value = 'red'
      console.error(err)
    })
}
</script>

<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Publicar nuevo artículo</h2>

    <div v-if="mensaje" class="text-center mb-3" :style="{ color: colorMensaje }">
      {{ mensaje }}
    </div>

    <form @submit.prevent="publicarArticulo" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">
          Titular <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" v-model="titular" required>
      </div>

      <div class="mb-3 position-relative">
        <label class="form-label">
          Categoría <span class="text-danger">*</span>
        </label>
        <input type="text"
               class="form-control"
               v-model="categoriaTexto"
               placeholder="Escribe para buscar..."
               @input="categoria_id = ''">
        <ul v-if="categoriaTexto && !categoria_id" class="list-group position-absolute w-100 z-3">
          <li v-for="c in categoriasFiltradas"
              :key="c.id"
              @click="seleccionarCategoria(c)"
              class="list-group-item list-group-item-action"
              style="cursor: pointer;">
            {{ c.nombre }}
          </li>
        </ul>
      </div>

      <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea class="form-control" v-model="descripcion"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Archivo PDF</label>
        <input type="file" class="form-control" accept="application/pdf" @change="manejarArchivo">
      </div>

      <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
  </div>
</template>

<style scoped>
textarea {
  resize: vertical;
}
ul.list-group {
  max-height: 200px;
  overflow-y: auto;
  z-index: 9999;
  background-color: white;
}
</style>
