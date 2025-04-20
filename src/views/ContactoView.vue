<script setup>
</script>

<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1 class="mb-4 text-center">Contáctanos</h1>
                <form action="http://localhost/science/api/contacto.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="ejemplo@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5"
                            placeholder="Escribe tu mensaje aquí..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar mensaje</button>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
::placeholder {
    color: #adb5bd;
    opacity: 1;
}
</style>
