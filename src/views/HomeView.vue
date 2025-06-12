<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'

const articulos = ref([])
const mensaje = ref('')
const colorMensaje = ref('')

const articulosRecientes = computed(() => articulos.value.slice(0, 6))

const router = useRouter()

const token = ref(localStorage.getItem('token'))

function obtenerArticulos() {
  fetch('http://localhost/science/api/articulos/obtener_articulos.php')
    .then(res => {
      if (!res.ok) throw new Error('Error al obtener artículos. Código: ' + res.status)
      return res.json()
    })
    .then(data => {
      if (!Array.isArray(data)) throw new Error('Respuesta inválida')
      articulos.value = data.sort((a, b) => new Date(b.fecha_publicacion) - new Date(a.fecha_publicacion))
    })
    .catch(err => {
      mensaje.value = err.message
      colorMensaje.value = 'red'
    })
}

onMounted(() => {
  obtenerArticulos()
})
</script>

<template>
  <!-- Sección Video -->
  <div class="video-container position-relative">
    <video autoplay loop muted class="w-100">
      <source src="../images/home_video.mp4" type="video/mp4">
      <source src="../images/home_video.ogg" type="video/ogg">
      <source src="../images/home_video.webm" type="video/webm">
      Tu navegador no soporta el formato de video
    </video>
    <div class="video-text position-absolute text-center text-white">
      <h1 class="fw-bold">
        Para que la ciencia no te resulte lejana... <br />
        nosotros te la acercamos en <span class="highlight">The Science Hub</span>
      </h1>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="container-fluid mt-5 px-4">
    <div class="row gx-4 gy-4">
      <!-- Columna principal: artículos -->
      <div class="col-12 col-lg-8">
        <h3 class="mb-3 text-primary">Artículos recientes</h3>
        <div v-if="mensaje" class="alert text-center" :class="{ 'alert-danger': colorMensaje === 'red' }">
          {{ mensaje }}
        </div>
        <div v-else class="row row-cols-1 row-cols-md-2 g-4">
          <div class="col d-flex" v-for="articulo in articulosRecientes" :key="articulo.id">
            <div class="card h-100 shadow-sm border-0 rounded-4 minimal-card flex-fill d-flex flex-column">
              <div class="card-body d-flex flex-column justify-content-between p-4">
                <div>
                  <h5 class="card-title titulo-limitado mb-2 fw-semibold">{{ articulo.titular }}</h5>
                  <p class="card-text small text-muted mb-1"><strong>Autor:</strong> {{ articulo.autor }}</p>
                  <p class="card-text small text-muted mb-1"><strong>Fecha:</strong> {{ articulo.fecha_publicacion }}</p>
                  <p class="card-text small text-muted mb-1"><strong>Categoría:</strong> {{ articulo.categoria || 'Sin categoría' }}</p>
                  <p class="card-text small text-secondary descripcion-limitada mb-2">
                    {{ articulo.descripcion || 'Sin descripción disponible.' }}
                  </p>
                </div>
                <div class="d-flex justify-content-end align-items-end mt-auto">
                  <template v-if="token">
                    <a :href="'http://localhost/science/' + articulo.archivo_pdf"
                      target="_blank"
                      class="btn btn-outline-primary btn-sm rounded-pill px-4">
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
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Columna secundaria: eventos -->
      <div class="col-12 col-lg-4">
        <h4 class="mb-3 text-primary">Eventos científicos 2025</h4>
        <div class="card mb-3">
          <div class="card-header bg-info text-white">Próximos eventos</div>
          <ul class="list-group list-group-flush">
            <!-- Recientes -->
            <li class="list-group-item list-group-item-secondary fw-semibold text-center">Recientes</li>
            <li class="list-group-item"><a href="https://www.biovalia.com/biotech-summit-2025" target="_blank">Biotech Summit – 5-7 junio – Barcelona</a></li>
            <li class="list-group-item"><a href="https://www.nanospainconf.org/2025/" target="_blank">NanoSpain Conference – 10-13 junio – Valencia</a></li>
            <li class="list-group-item"><a href="https://www.euroscience-open-forum.org/" target="_blank">EuroScience Open Forum – 17-21 junio – Estocolmo</a></li>

            <!-- Próximos -->
            <li class="list-group-item list-group-item-primary fw-semibold text-center mt-2">Próximos</li>
            <li class="list-group-item"><a href="https://www.esa.int/Enabling_Support/Space_Engineering_Technology/Space_Conference_2025" target="_blank">European Space Conference – 10-12 julio – Bruselas</a></li>
            <li class="list-group-item"><a href="https://www.icgeb.org/meetings-2025/" target="_blank">Congress on Genetic Engineering – 15-18 julio – Viena</a></li>
            <li class="list-group-item"><a href="https://www.chemistrycongress.com/" target="_blank">World Chemistry Congress – 22-26 julio – Praga</a></li>
            <li class="list-group-item"><a href="https://www.isme-microbes.org/events/isme19" target="_blank">ISME Microbiology Symposium – 4-8 agosto – Ciudad del Cabo</a></li>
            <li class="list-group-item"><a href="https://www.neuroscience2025.org/" target="_blank">International Neuroscience Meeting – 12-16 agosto – Tokio</a></li>
            <li class="list-group-item"><a href="https://www.escardio.org/Congresses-&-Events/ESC-Congress" target="_blank">ESC Congress – 29 ago-2 sep – Londres</a></li>
            <li class="list-group-item"><a href="https://www.esaform.org/conference/esaform2025" target="_blank">ESAFORM 2025 – 10-12 sep – París</a></li>
            <li class="list-group-item"><a href="https://www.ise-online.org/ise-conferences/annual-conference.php" target="_blank">ISE Annual Meeting – 21-26 sep – Montreal</a></li>
            <li class="list-group-item"><a href="https://www.astrobiology2025.org/" target="_blank">Astrobiology Conference – 6-10 oct – Berlín</a></li>
            <li class="list-group-item"><a href="https://www.cern.ch/events" target="_blank">CERN Open Days – 18-19 oct – Ginebra</a></li>
            <li class="list-group-item"><a href="https://www.neurips.cc/" target="_blank">NeurIPS – 1-6 diciembre – Vancouver</a></li>
            <li class="list-group-item"><a href="https://ineustar.com/eventos/big-science-industry-forum-spain-2025/" target="_blank">Big Science Forum – 3-4 diciembre – Madrid</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.video-container {
  height: 400px;
  overflow: hidden;
}

.video-container video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.video-text {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.highlight {
  color: #0d6efd;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
}

.titulo-limitado {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.descripcion-limitada {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.minimal-card {
  min-height: 320px;
  max-height: 340px;
  background: #fff;
  transition: box-shadow 0.2s;
  width: 100%;
}

.minimal-card:hover {
  box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}
</style>
