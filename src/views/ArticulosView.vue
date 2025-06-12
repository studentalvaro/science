<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const articulos = ref([])
const mensaje = ref('')
const colorMensaje = ref('')
const filtro = ref('')
const paginaActual = ref(1)
const articulosPorPagina = 5
const router = useRouter()
const token = ref(localStorage.getItem('token'))

const categoriaSeleccionada = ref('')
const ordenDescendente = ref(true)

function obtenerArticulos() {
  fetch('http://localhost/science/api/articulos/obtener_articulos.php')
    .then(res => {
      if (!res.ok) throw new Error('Error al obtener artículos. Código: ' + res.status)
      return res.json()
    })
    .then(data => {
      if (!Array.isArray(data)) throw new Error('Respuesta inválida')
      articulos.value = data
    })
    .catch(err => {
      mensaje.value = err.message
      colorMensaje.value = 'red'
    })
}

onMounted(() => {
  obtenerArticulos()
})

const categorias = computed(() => {
  const set = new Set()
  articulos.value.forEach(a => {
    if (a.categoria) set.add(a.categoria)
  })
  return Array.from(set)
})

function ordenarPorFecha() {
  ordenDescendente.value = !ordenDescendente.value
  paginaActual.value = 1
}

const articulosFiltrados = computed(() => {
  let lista = articulos.value.filter(a =>
    a.titular.toLowerCase().includes(filtro.value.toLowerCase()) ||
    a.autor.toLowerCase().includes(filtro.value.toLowerCase()) ||
    (a.descripcion && a.descripcion.toLowerCase().includes(filtro.value.toLowerCase()))
  )
  if (categoriaSeleccionada.value) {
    lista = lista.filter(a => a.categoria === categoriaSeleccionada.value)
  }
  return lista.sort((a, b) => {
    const fechaA = new Date(a.fecha_publicacion)
    const fechaB = new Date(b.fecha_publicacion)
    return ordenDescendente.value ? fechaB - fechaA : fechaA - fechaB
  })
})

const totalPaginas = computed(() => Math.ceil(articulosFiltrados.value.length / articulosPorPagina))

const articulosPagina = computed(() => {
  const start = (paginaActual.value - 1) * articulosPorPagina
  return articulosFiltrados.value.slice(start, start + articulosPorPagina)
})

function cambiarPagina(nuevaPagina) {
  if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas.value) {
    paginaActual.value = nuevaPagina
  }
}
</script>

<template>
  <div class="container-fluid my-5 px-4">
    <h2 class="text-primary mb-4">Listado de artículos científicos</h2>

    <div class="row mb-4 g-2">
      <div class="col-12 col-md-6">
        <input
          type="text"
          class="form-control"
          v-model="filtro"
          placeholder="Buscar por título, autor o descripción..."
        />
      </div>
      <div class="col-6 col-md-3">
        <select class="form-select" v-model="categoriaSeleccionada">
          <option value="">Todas las categorías</option>
          <option v-for="cat in categorias" :key="cat" :value="cat">{{ cat }}</option>
        </select>
      </div>
      <div class="col-6 col-md-3">
        <button class="btn btn-outline-primary w-100" @click="ordenarPorFecha" type="button">
          Ordenar por fecha {{ ordenDescendente ? '↑' : '↓' }}
        </button>
      </div>
    </div>

    <div v-if="mensaje" class="alert text-center" :class="{ 'alert-danger': colorMensaje === 'red' }">
      {{ mensaje }}
    </div>

    <ul v-else class="list-group shadow-sm">
      <li
        class="list-group-item py-4 px-3 border-0 border-bottom d-flex flex-column position-relative"
        v-for="articulo in articulosPagina"
        :key="articulo.id"
        style="min-height: 180px;"
      >
        <div>
          <h5 class="mb-2 fw-semibold">{{ articulo.titular }}</h5>
          <p class="mb-1 text-muted small">
            <strong>Autor:</strong> {{ articulo.autor }} |
            <strong>Fecha:</strong> {{ articulo.fecha_publicacion }} |
            <strong>Categoría:</strong> {{ articulo.categoria || 'Sin categoría' }}
          </p>
          <p class="mb-3 text-secondary">
            {{ articulo.descripcion || 'Sin descripción disponible.' }}
          </p>
        </div>
        <div class="mt-auto d-flex justify-content-end align-items-end w-100" style="position: absolute; right: 24px; bottom: 24px;">
          <template v-if="token">
            <a
              :href="'http://localhost/science/' + articulo.archivo_pdf"
              target="_blank"
              class="btn btn-outline-primary btn-sm rounded-pill px-4"
            >
              Leer artículo 📄
            </a>
          </template>
          <template v-else>
            <button
              class="btn btn-outline-primary btn-sm rounded-pill px-4"
              @click="router.push('/login')"
            >
              Inicia sesión para leer
            </button>
          </template>
        </div>
      </li>
    </ul>

    <!-- Paginación -->
    <nav v-if="totalPaginas > 1" class="mt-4 d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: paginaActual === 1 }">
          <button class="page-link" @click="cambiarPagina(paginaActual - 1)">Anterior</button>
        </li>

        <li
          class="page-item"
          v-for="n in totalPaginas"
          :key="n"
          :class="{ active: paginaActual === n }"
        >
          <button class="page-link" @click="cambiarPagina(n)">{{ n }}</button>
        </li>

        <li class="page-item" :class="{ disabled: paginaActual === totalPaginas }">
          <button class="page-link" @click="cambiarPagina(paginaActual + 1)">Siguiente</button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<style scoped>
ul.list-group {
  border-radius: 12px;
  overflow: hidden;
  max-width: 100%;
}

.list-group-item {
  margin-bottom: 16px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  background: #fff;
  display: flex;
  flex-direction: column;
  min-height: 180px;
  padding-bottom: 56px;
  position: relative;
}

.list-group-item:hover {
  background-color: #f8f9fa;
}

@media (min-width: 768px) {
  ul.list-group {
    padding-left: 0;
    padding-right: 0;
  }
  .list-group-item {
    margin-left: 0;
    margin-right: 0;
  }
}
</style>
