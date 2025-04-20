<script setup>
import { onMounted } from 'vue'
//Necesario para el tooltip: https://stackoverflow.com/questions/69053972/adding-bootstrap-5-tooltip-to-vue-3
  onMounted(() => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    tooltipTriggerList.forEach(element => {
      new bootstrap.Tooltip(element)
    })
  })

</script>

<template>
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <!-- Título -->
          <div class="text-center mb-4">
            <h1 class="display-5 fw-bold text-primary">Sobre Nosotros</h1>
            <p class="lead text-muted">Descubre quiénes somos y qué nos impulsa</p>
          </div>
            <!-- Imagen y texto -->
            <div class="row align-items-stretch mb-5">
              <!-- Imagen -->
            <div class="col-md-6 mb-4 mb-md-0 d-flex align-items-stretch">
                <img src="../images/logo.jpg" alt="Sobre Nosotros" class="img-fluid rounded shadow-sm w-100 object-fit-cover">
            </div>
              <!-- Texto -->
            <div class="col-md-6 d-flex align-items-stretch">
                <div class="bg-light p-4 rounded shadow-sm w-100">
                <p>Somos una revista científica dedicada a la divulgación del conocimiento, con el objetivo de conectar investigadores, estudiantes y lectores apasionados por la ciencia.</p>
                <p>Nuestro equipo está formado por profesionales de distintas disciplinas que comparten la misión de hacer accesible la ciencia a todos los públicos.</p>
                <p>Valoramos la calidad, la transparencia y el rigor académico, sin perder la cercanía con nuestra comunidad lectora.</p>
                <p>Somos producto de un proyecto final para el Grado Superior de Desarrollo de Aplicaciones WEB (DAW) en IES Virgen del Carmen (Jaén)</p>
                </div>
            </div>
        </div>
  
          <!-- Colaboradores -->
          <div>
            <h2 class="h4 fw-bold mb-4 text-center text-secondary">Nuestros Colaboradores</h2>
            <div class="d-flex flex-wrap justify-content-center gap-4">
              <!--1-->
              <div class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Universidad de Córdoba">
                <img src="../images/uco.png" class="rounded-circle shadow" alt="Universidad de Córdoba" width="100" height="100">
                <p class="small mt-2 text-muted">Universidad de Córdoba</p>
              </div>
              <!--2-->
              <div class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Revista Nature">
                <img src="../images/nature.webp" class="rounded-circle shadow" alt="Revista Nature" width="100" height="100">
                <p class="small mt-2 text-muted">Revista Nature</p>
              </div>
              <!--3-->
              <div class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="IES Virgen del Carmen">
                <img src="../images/vdc.jpeg" class="rounded-circle shadow" alt="Virgen del Carmen" width="100" height="100">
                <p class="small mt-2 text-muted">IES Virgen del Carmen</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

<style scoped>
</style>

