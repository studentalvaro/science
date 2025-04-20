<script setup>
</script>

<template>
    <header class="bg-light py-3 shadow-sm">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
            <RouterLink to="/" class="d-flex align-items-center mb-2 mb-md-0 text-decoration-none">
                <img src="@/images/logo_resized.jpg" alt="TheScienceHub" width="80px">
                <h1 class="h2 text-primary text-decoration-none ps-4">The Science Hub</h1>
            </RouterLink>

            <div class="d-flex justify-content-center flex-wrap">
                <RouterLink to="/login" class="btn btn-primary btn-sm me-2 mb-2 mb-md-0">Iniciar sesión</RouterLink>
                <RouterLink to="/registro" class="btn btn-outline-primary btn-sm me-2 mb-2 mb-md-0">Registrarse</RouterLink>
            </div>
        </div>
    </header>
</template>

<style scoped>
img {
    width: 80px;
    height: auto;
    border-radius: 50%;
}
</style>

