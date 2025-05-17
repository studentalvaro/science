<script setup>
import { ref, computed, onMounted } from 'vue'

const categorias = ref([])
const categoriaSeleccionada = ref(null)
const categoriaAEliminar = ref(null)
const nuevoNombre = ref('')
const nuevaCategoria = ref('')
const mensajeExito = ref('')

const filtro = ref('')
const paginaActual = ref(1)
const porPagina = 10

const categoriasFiltradas = computed(() => {
  if (!filtro.value.trim()) return categorias.value
  return categorias.value.filter(c =>
    c.nombre.toLowerCase().includes(filtro.value.toLowerCase())
  )
})

const totalPaginas = computed(() => Math.ceil(categoriasFiltradas.value.length / porPagina))

const categoriasPaginadas = computed(() => {
  const inicio = (paginaActual.value - 1) * porPagina
  return categoriasFiltradas.value.slice(inicio, inicio + porPagina)
})

function cambiarPagina(nuevaPagina) {
  if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas.value) {
    paginaActual.value = nuevaPagina
  }
}

onMounted(() => {
  obtenerCategorias()
})

function obtenerCategorias() {
  const token = localStorage.getItem('token')
  fetch('http://localhost/science/api/categorias/obtener_categorias.php', {
    headers: {
      'Authorization': 'Bearer ' + token
    }
  })
    .then(res => res.json())
    .then(data => {
      categorias.value = data
      paginaActual.value = 1
    })
}

function crearCategoria() {
  if (!nuevaCategoria.value.trim()) return

  const token = localStorage.getItem('token')
  fetch('http://localhost/science/api/categorias/crear_categoria.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + token
    },
    body: JSON.stringify({ nombre: nuevaCategoria.value })
  })
    .then(async res => {
      if (!res.ok) throw new Error('Error al crear la categoría')
      return res.json()
    })
    .then(data => {
      if (data.success) {
        nuevaCategoria.value = ''
        obtenerCategorias()
        mostrarMensajeExito('Categoría creada correctamente.')
      }
    })
    .catch(err => {
      console.error(err)
      alert('Error: ' + err.message)
    })
}

function abrirModalEditar(categoria) {
  categoriaSeleccionada.value = { ...categoria }
  nuevoNombre.value = categoria.nombre
  const modal = new bootstrap.Modal(document.getElementById('modalEditar'))
  modal.show()
}

function guardarCambios() {
  const token = localStorage.getItem('token')
  fetch('http://localhost/science/api/categorias/editar_categoria.php', {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + token
    },
    body: JSON.stringify({
      id: categoriaSeleccionada.value.id,
      nombre: nuevoNombre.value
    })
  })
    .then(async res => {
      if (!res.ok) {
        const errorData = await res.json().catch(() => ({}))
        throw new Error(errorData.message || 'Error desconocido')
      }
      return res.json()
    })
    .then(data => {
      if (data.success) {
        obtenerCategorias()
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'))
        modal.hide()
        mostrarMensajeExito('Categoría actualizada correctamente.')
      }
    })
    .catch(err => {
      console.error(err)
      alert('Error: ' + err.message)
    })
}

function confirmarEliminacion(categoria) {
  categoriaAEliminar.value = categoria
  const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'))
  modal.show()
}

function eliminarCategoriaConfirmada() {
  const token = localStorage.getItem('token')
  fetch('http://localhost/science/api/categorias/borrar_categoria.php', {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + token
    },
    body: JSON.stringify({ id: categoriaAEliminar.value.id })
  })
    .then(async res => {
      if (!res.ok) {
        const errorData = await res.json().catch(() => ({}))
        throw new Error(errorData.message || 'Error al eliminar')
      }
      return res.json()
    })
    .then(data => {
      if (data.success) {
        obtenerCategorias()
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmarEliminar'))
        modal.hide()
        mostrarMensajeExito('Categoría eliminada correctamente.')
      }
    })
    .catch(err => {
      console.error(err)
      alert('Error: ' + err.message)
    })
}

function mostrarMensajeExito(texto) {
  mensajeExito.value = texto
  setTimeout(() => {
    mensajeExito.value = ''
  }, 3000)
}
</script>

<template>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Gestión de Categorías</h2>

    <div v-if="mensajeExito" class="alert alert-success text-center" role="alert">
      {{ mensajeExito }}
    </div>

    <!-- Filtro de búsqueda -->
    <div class="mb-3">
      <input
        type="text"
        v-model="filtro"
        @input="paginaActual = 1"
        class="form-control"
        placeholder="Buscar por nombre de categoría"
      />
    </div>

    <!-- Formulario para crear nueva categoría -->
    <form @submit.prevent="crearCategoria" class="mb-4">
      <div class="input-group">
        <input
          v-model="nuevaCategoria"
          type="text"
          class="form-control"
          placeholder="Nueva categoría"
          required
        />
        <button type="submit" class="btn btn-success">Crear</button>
      </div>
    </form>

    <!-- Tabla -->
    <table class="table table-bordered table-striped">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="categoria in categoriasPaginadas" :key="categoria.id">
          <td>{{ categoria.id }}</td>
          <td>{{ categoria.nombre }}</td>
          <td>
            <button class="btn btn-sm btn-primary me-2" @click="abrirModalEditar(categoria)">
              Editar
            </button>
            <button class="btn btn-sm btn-danger" @click="confirmarEliminacion(categoria)">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Paginación siempre visible -->
    <nav class="mt-3 d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: paginaActual === 1 }">
          <button class="page-link" @click="cambiarPagina(paginaActual - 1)">Anterior</button>
        </li>
        <li
          v-for="n in totalPaginas"
          :key="n"
          class="page-item"
          :class="{ active: n === paginaActual }"
        >
          <button class="page-link" @click="cambiarPagina(n)">{{ n }}</button>
        </li>
        <li class="page-item" :class="{ disabled: paginaActual === totalPaginas }">
          <button class="page-link" @click="cambiarPagina(paginaActual + 1)">Siguiente</button>
        </li>
      </ul>
    </nav>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditarLabel">Editar Categoría</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <label for="nombreCategoria" class="form-label">Nuevo nombre:</label>
            <input
              type="text"
              id="nombreCategoria"
              v-model="nuevoNombre"
              class="form-control"
              placeholder="Introduce el nuevo nombre"
            />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success" @click="guardarCambios">Guardar cambios</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Confirmar Eliminación -->
    <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            ¿Estás seguro de que deseas eliminar la categoría "<strong>{{ categoriaAEliminar?.nombre }}</strong>"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" @click="eliminarCategoriaConfirmada">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
