import { createRouter, createWebHistory } from 'vue-router'
import authService from '../services/authService'
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
      path: '/admin/login',
      name: 'admin-login',
      component: () => import('../views/admin/Login.vue'),
      meta: { requiresGuest: true },
    },
    {
      path: '/admin/footer',
      name: 'admin-footer',
      component: () => import('../views/admin/Footer.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/admin/formulario-contacto',
      name: 'admin-formulario-contacto',
      component: () => import('../views/admin/FormularioContacto.vue'),
      meta: { requiresAuth: true },
    },
  ],
})

// Guard de navegación para proteger rutas
router.beforeEach((to, from, next) => {
  const isAuthenticated = authService.isAuthenticated()

  if (to.meta.requiresAuth && !isAuthenticated) {
    // Si la ruta requiere autenticación y no está autenticado, redirigir al login
    next({ name: 'admin-login' })
  } else if (to.meta.requiresGuest && isAuthenticated) {
    // Si la ruta es para invitados (login) y ya está autenticado, redirigir al admin
    next({ name: 'admin-footer' })
  } else {
    next()
  }
})

export default router
