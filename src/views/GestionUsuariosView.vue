<script setup>
import { ref, computed, onMounted } from 'vue'

const usuarios = ref([])
const error = ref('')
const paginaActual = ref(1)
const porPagina = 10
const busqueda = ref('')

const roles = ['lector', 'suscriptor', 'admin', 'autor']
const token = localStorage.getItem('token')

// Filtrar usuarios por nombre o email
const usuariosFiltrados = computed(() => {
  if (!busqueda.value.trim()) return usuarios.value
  return usuarios.value.filter(usuario =>
    usuario.nombre.toLowerCase().includes(busqueda.value.toLowerCase()) ||
    usuario.email.toLowerCase().includes(busqueda.value.toLowerCase())
  )
})

const totalPaginas = computed(() => Math.ceil(usuariosFiltrados.value.length / porPagina))

const usuariosPaginados = computed(() => {
  const inicio = (paginaActual.value - 1) * porPagina
  return usuariosFiltrados.value.slice(inicio, inicio + porPagina)
})

function cambiarPagina(nuevaPagina) {
  if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas.value) {
    paginaActual.value = nuevaPagina
  }
}

function cambiarRol(usuarioId, nuevoRol) {
  fetch('http://localhost/science/api/usuarios/update_usuario.php', {
    method: 'PUT',
    headers: {
      'Authorization': 'Bearer ' + token,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ id: usuarioId, rol: nuevoRol })
  })
    .then(async res => {
      if (!res.ok) throw new Error('Error al actualizar el rol. Código: ' + res.status)
      const data = await res.json()
      if (!data.success) throw new Error(data.message || 'Error al actualizar el rol.')

      const usuario = usuarios.value.find(u => u.id === usuarioId)
      if (usuario) usuario.rol = nuevoRol
    })
    .catch(err => {
      error.value = err.message
    })
}

onMounted(() => {
  if (!token) {
    error.value = 'No hay token de autenticación. Por favor, inicia sesión.'
    return
  }

  fetch('http://localhost/science/api/usuarios/get_all_usuario.php', {
    headers: { 'Authorization': 'Bearer ' + token }
  })
    .then(async res => {
      if (!res.ok) throw new Error('Error al obtener los usuarios. Código: ' + res.status)
      return res.json()
    })
    .then(data => {
      usuarios.value = data
    })
    .catch(err => {
      error.value = err.message || 'No se pudieron cargar los usuarios.'
    })
})
</script>

<template>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Gestión de Usuarios</h2>

    <div v-if="error" class="alert alert-danger text-center">{{ error }}</div>

    <div class="mb-3">
      <input
        v-model="busqueda"
        type="text"
        class="form-control"
        placeholder="Buscar por nombre o email"
        @input="paginaActual = 1"
      />
    </div>

    <div v-if="usuariosFiltrados.length">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
          <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="usuario in usuariosPaginados" :key="usuario.id">
            <td>{{ usuario.nombre }}</td>
            <td>{{ usuario.email }}</td>
            <td>
              <select
                :value="usuario.rol"
                @change="cambiarRol(usuario.id, $event.target.value)"
                class="form-select"
              >
                <option v-for="rol in roles" :key="rol" :value="rol">
                  {{ rol }}
                </option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginación -->
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
    </div>

    <p v-else class="text-center text-muted fst-italic">No hay usuarios que coincidan con la búsqueda.</p>
  </div>
</template>
