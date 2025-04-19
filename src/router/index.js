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
  ],
})

export default router