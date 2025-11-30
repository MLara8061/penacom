// router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import authService from '../services/authService';

// Layouts
import PublicLayout from '../layouts/PublicLayout.vue';
import AdminLayout from '../layouts/AdminLayout.vue';

// Public Views
import LandingPage from '../views/LandingPage.vue';
import Home from '../views/public/Home.vue';
import Services from '../views/public/Services.vue';
import Contact from '../views/public/Contact.vue';

// Admin Views
import AdminLogin from '../views/admin/Login.vue';
import AdminDashboard from '../views/admin/Dashboard.vue';
import AdminHeroSection from '../views/admin/HeroSection.vue';
import AdminServices from '../views/admin/Services.vue';
import AdminSchedules from '../views/admin/Schedules.vue';
import AdminContact from '../views/admin/Contact.vue';
import AdminAbout from '../views/admin/About.vue';
import AdminProducts from '../views/admin/Products.vue';

const routes = [
  // Landing Page
  {
    path: '/',
    name: 'Landing',
    component: LandingPage
  },
  
  // Public Routes
  {
    path: '/public',
    component: PublicLayout,
    children: [
      { path: '', name: 'Home', component: Home },
      { path: 'servicios', name: 'Services', component: Services },
      { path: 'contacto', name: 'Contact', component: Contact }
    ]
  },

  // Admin Login (sin layout)
  {
    path: '/admin/login',
    name: 'AdminLogin',
    component: AdminLogin,
    meta: { requiresGuest: true }
  },

  // Admin Routes
  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      { path: '', name: 'AdminDashboard', component: AdminDashboard },
      { path: 'seccion-heroe', name: 'AdminHeroSection', component: AdminHeroSection },
      { path: 'informacion-empresa', name: 'AdminInformacionEmpresa', component: AdminAbout },
      { path: 'productos', name: 'AdminProductos', component: AdminProducts },
      { path: 'servicios', name: 'AdminServices', component: AdminServices },
      { path: 'horarios', name: 'AdminSchedules', component: AdminSchedules },
      { path: 'leads/formulario', name: 'AdminLeadsFormulario', component: AdminContact }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation Guard
router.beforeEach((to, from, next) => {
  const isAuthenticated = authService.isAuthenticated();

  // Solo aplicar guard a rutas que explícitamente lo requieren
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/admin/login');
  } else if (to.meta.requiresGuest && isAuthenticated) {
    next('/admin');
  } else {
    next();
  }
});

export default router;
