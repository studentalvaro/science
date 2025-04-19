<script setup>
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

    <!-- Mensaje sobre el video -->
    <div class="video-text position-absolute text-center text-white">
      <h1 class="fw-bold"> Para que la ciencia no te resulte lejana... <br> nosotros te la acercamos en <span class="highlight">The Science Hub</span></h1>
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
</style>