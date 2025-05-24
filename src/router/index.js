import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView,
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('../views/LoginView.vue'),
    },
    {
      path: '/registro',
      name: 'Registro',
      component: () => import('../views/RegistroView.vue'),
    },
    {
      path: '/gestionusuarios',
      name: 'Gestión de usuarios',
      component: () => import('../views/GestionUsuariosView.vue'),
    },
    {
      path: '/contacto',
      name: 'Contacto',
      component: () => import('../views/ContactoView.vue'),
    },
    {
      path: '/aboutus',
      name: 'Sobre Nosotros',
      component: () => import('../views/SobreNosotrosView.vue'),
    },
    {
      path: '/logout',
      name: 'Adios',
      component: () => import('../views/LogoutView.vue'),
    },
    {
      path: '/creararticulo',
      name: 'Crear Articulo',
      component: () => import('../views/PublicarArticuloView.vue'),
    },
    {
      path: '/gestionarcategorias',
      name: 'Gestionar Categorías',
      component: () => import('../views/GestionarCategoriasView.vue'),
    },
    {
      path: '/gestionararticulos',
      name: 'Gestionar Artículos',
      component: () => import('../views/GestionarArticulosView.vue'),
    },
    {
      path: '/articulos',
      name: 'Artículos',
      component: () => import('../views/ArticulosView.vue'),
    },
  ],
})

export default router