<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { jwtDecode } from 'jwt-decode'

// 🔒 Control de acceso
const router = useRouter()

onMounted(() => {
  const token = localStorage.getItem('token')
  if (!token) {
    router.push('/')
    return
  }

  try {
    const usuario = jwtDecode(token)
    if (usuario.rol !== 'admin') {
      router.push('/')
    }
  } catch (e) {
    router.push('/')
  }
})

const articulos = ref([])
const categorias = ref([])
const mensaje = ref('')
const colorMensaje = ref('')
const paginaActual = ref(1)
const porPagina = 10
const busqueda = ref('')
const articuloAEliminar = ref(null)

const token = localStorage.getItem('token')

const articulosFiltrados = computed(() => {
  if (!busqueda.value.trim()) return articulos.value
  return articulos.value.filter(a =>
    a.titular.toLowerCase().includes(busqueda.value.toLowerCase())
  )
})

const totalPaginas = computed(() =>
  Math.ceil(articulosFiltrados.value.length / porPagina)
)

const articulosPaginados = computed(() => {
  const inicio = (paginaActual.value - 1) * porPagina
  return articulosFiltrados.value.slice(inicio, inicio + porPagina)
})

function cambiarPagina(nuevaPagina) {
  if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas.value) {
    paginaActual.value = nuevaPagina
  }
}

function obtenerArticulos() {
  fetch('http://localhost/science/api/articulos/obtener_articulos.php')
    .then(res => res.json())
    .then(data => {
      articulos.value = data
    })
    .catch(err => {
      mensaje.value = 'Error al obtener artículos'
      colorMensaje.value = 'red'
    })
}

function obtenerCategorias() {
  fetch('http://localhost/science/api/categorias/obtener_categorias.php', {
    headers: { Authorization: 'Bearer ' + token }
  })
    .then(res => res.json())
    .then(data => {
      categorias.value = data
    })
    .catch(() => {
      mensaje.value = 'Error al cargar categorías'
      colorMensaje.value = 'red'
    })
}

function guardarCambios(articulo) {
  const formData = new FormData()
  formData.append('id', articulo.id)
  formData.append('titular', articulo.titular)
  formData.append('descripcion', articulo.descripcion)
  formData.append('categoria_id', articulo.categoria_id)
  formData.append('autor_id', articulo.autor_id)
  formData.append('fecha_publicacion', articulo.fecha_publicacion)

  fetch('http://localhost/science/api/articulos/editar_articulo.php', {
    method: 'POST',
    headers: {
      Authorization: 'Bearer ' + token
    },
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      mensaje.value = data.message
      colorMensaje.value = data.success ? 'green' : 'red'
      obtenerArticulos()
    })
    .catch(() => {
      mensaje.value = 'Error al guardar cambios'
      colorMensaje.value = 'red'
    })
}

function pedirConfirmacion(articulo) {
  articuloAEliminar.value = articulo
  const modal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'))
  modal.show()
}

function confirmarEliminacion() {
  if (!articuloAEliminar.value) return

  fetch('http://localhost/science/api/articulos/eliminar_articulo.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: 'Bearer ' + token
    },
    body: JSON.stringify({ id: articuloAEliminar.value.id })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        articulos.value = articulos.value.filter(a => a.id !== articuloAEliminar.value.id)
        mensaje.value = data.message
        colorMensaje.value = 'green'
      } else {
        throw new Error(data.message)
      }
    })
    .catch(err => {
      mensaje.value = err.message
      colorMensaje.value = 'red'
    })
}

onMounted(() => {
  obtenerArticulos()
  obtenerCategorias()
})
</script>


<template>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Gestión de Artículos</h2>

    <div v-if="mensaje" class="alert text-center" :class="{
      'alert-success': colorMensaje === 'green',
      'alert-danger': colorMensaje === 'red'
    }">
      {{ mensaje }}
    </div>

    <div class="mb-3">
      <input
        v-model="busqueda"
        type="text"
        class="form-control"
        placeholder="Buscar por titular"
        @input="paginaActual = 1"
      />
    </div>

    <table class="table table-bordered table-striped align-middle">
      <thead class="table-primary">
        <tr>
          <th>Titular</th>
          <th>Descripción</th>
          <th>Categoría</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="articulo in articulosPaginados" :key="articulo.id">
          <td><input type="text" class="form-control" v-model="articulo.titular" /></td>
          <td><textarea class="form-control" v-model="articulo.descripcion"></textarea></td>
          <td>
            <select class="form-select" v-model="articulo.categoria_id">
                <option v-for="cat in categorias" :key="cat.id" :value="cat.id">{{ cat.nombre }}</option>
            </select>
          </td>
          <td class="text-center">
            <div class="d-flex justify-content-center w-100">
              <button class="btn btn-primary btn-sm me-2 flex-fill" @click="guardarCambios(articulo)">Editar</button>
              <button class="btn btn-danger btn-sm flex-fill" @click="pedirConfirmacion(articulo)">Eliminar</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <nav class="mt-3 d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: paginaActual === 1 }">
          <button class="page-link" @click="cambiarPagina(paginaActual - 1)">Anterior</button>
        </li>
        <li v-for="n in totalPaginas" :key="n" class="page-item" :class="{ active: n === paginaActual }">
          <button class="page-link" @click="cambiarPagina(n)">{{ n }}</button>
        </li>
        <li class="page-item" :class="{ disabled: paginaActual === totalPaginas }">
          <button class="page-link" @click="cambiarPagina(paginaActual + 1)">Siguiente</button>
        </li>
      </ul>
    </nav>

    <div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalLabel">Confirmar eliminación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            ¿Estás seguro de que deseas eliminar el artículo
            <strong>{{ articuloAEliminar?.titular }}</strong>?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="confirmarEliminacion">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
