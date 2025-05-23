import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// Importa Bootstrap CSS y JS
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'


const app = createApp(App);

app.use(router);

app.mount('#app');