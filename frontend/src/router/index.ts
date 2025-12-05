import { createRouter, createWebHistory } from 'vue-router'
import AdminLayout from '../layouts/AdminLayout.vue'
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
      component: () => import('../views/AboutView.vue'),
    },
    // Admin Login (sin layout)
    {
      path: '/admin/login',
      name: 'admin-login',
      component: () => import('../views/admin/Login.vue'),
      meta: { requiresGuest: true },
    },
    // Panel Admin (con layout y protección)
    {
      path: '/admin',
      component: AdminLayout,
      meta: { requiresAuth: true },
      children: [
        {
          path: '',
          name: 'AdminDashboard',
          component: () => import('../views/admin/Dashboard.vue'),
        },
        // Leads
        {
          path: 'leads/formulario',
          name: 'AdminLeadsFormulario',
          component: () => import('../views/admin/Contact.vue'),
        },
        {
          path: 'leads/redes-sociales',
          name: 'AdminLeadsRedes',
          component: () => import('../views/admin/Contact.vue'),
        },
        {
          path: 'leads/google',
          name: 'AdminLeadsGoogle',
          component: () => import('../views/admin/Contact.vue'),
        },
        // Contenido del Sitio
        {
          path: 'seccion-heroe',
          name: 'AdminHeroSection',
          component: () => import('../views/admin/HeroSection.vue'),
        },
        {
          path: 'informacion-empresa',
          name: 'AdminInformacionEmpresa',
          component: () => import('../views/admin/About.vue'),
        },
        {
          path: 'productos',
          name: 'AdminProductos',
          component: () => import('../views/admin/Products.vue'),
        },
        {
          path: 'servicios',
          name: 'AdminServices',
          component: () => import('../views/admin/Services.vue'),
        },
        {
          path: 'portafolio',
          name: 'AdminPortafolio',
          component: () => import('../views/admin/Portfolio.vue'),
        },
        {
          path: 'resenas',
          name: 'AdminResenas',
          component: () => import('../views/admin/Testimonials.vue'),
        },
        // Formulario de Contacto
        {
          path: 'formulario-contacto',
          name: 'AdminFormularioContacto',
          component: () => import('../views/admin/FormularioContacto.vue'),
        },
        // Footer
        {
          path: 'footer',
          name: 'AdminFooter',
          component: () => import('../views/admin/Footer.vue'),
        },
        // Configuración (solo admin)
        {
          path: 'usuarios',
          name: 'AdminUsuarios',
          component: () => import('../views/admin/Users.vue'),
          meta: { requiresAdmin: true },
        },
      ],
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
