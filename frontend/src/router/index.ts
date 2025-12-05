import { createRouter, createWebHistory } from 'vue-router'
import LandingPage from '../views/LandingPage.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'landing',
      component: LandingPage,
    },
    {
      path: '/home',
      name: 'home',
      component: () => import('../views/HomeView.vue'),
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
    {
      path: '/admin/footer',
      name: 'admin-footer',
      component: () => import('../views/admin/Footer.vue'),
    },
    {
      path: '/admin/formulario-contacto',
      name: 'admin-formulario-contacto',
      component: () => import('../views/admin/FormularioContacto.vue'),
    },
  ],
})

export default router
