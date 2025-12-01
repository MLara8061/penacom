<template>
  <div class="admin-layout">
    <!-- Mobile Header -->
    <header class="mobile-header">
      <button class="mobile-menu-btn" @click="toggleSidebar" aria-label="Menú">
        <svg
          v-if="!sidebarOpen"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
        >
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
        <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>

      <div class="mobile-logo">
        <svg
          class="logo-icon"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
        >
          <rect x="3" y="3" width="7" height="7"></rect>
          <rect x="14" y="3" width="7" height="7"></rect>
          <rect x="14" y="14" width="7" height="7"></rect>
          <rect x="3" y="14" width="7" height="7"></rect>
        </svg>
        <span>Panel Admin</span>
      </div>

      <a href="/" class="mobile-home-btn" aria-label="Ver sitio">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
          <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
      </a>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" :class="{ 'sidebar-open': sidebarOpen }">
      <div class="sidebar-header">
        <div class="sidebar-logo">
          <svg
            class="logo-icon"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
          <h2>Panel Admin</h2>
        </div>
        <div class="user-info">
          <div class="user-avatar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>
          <div class="user-details">
            <p class="user-name">{{ userName }}</p>
            <p class="user-role">{{ userRole }}</p>
          </div>
        </div>
      </div>

      <nav class="sidebar-nav">
        <!-- 1. Dashboard -->
        <router-link to="/admin" class="nav-item" exact-active-class="active" @click="closeSidebar">
          <svg
            class="nav-icon"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
          <span>Dashboard</span>
        </router-link>

        <!-- 2. Leads -->
        <div class="nav-section">
          <div class="nav-section-title">
            <svg
              class="section-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Leads</span>
          </div>

          <router-link
            to="/admin/leads/formulario"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Formulario de Contacto</span>
          </router-link>

          <router-link
            to="/admin/leads/redes-sociales"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
            </svg>
            <span>Redes Sociales</span>
          </router-link>

          <router-link
            to="/admin/leads/google"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.35-4.35"></path>
            </svg>
            <span>Google</span>
          </router-link>
        </div>

        <!-- 3. Contenido del Sitio -->
        <div class="nav-section">
          <div class="nav-section-title">
            <svg
              class="section-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
              <path d="M2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span>Contenido del Sitio</span>
          </div>

          <router-link
            to="/admin/seccion-heroe"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
              <polyline points="2 17 12 22 22 17"></polyline>
              <polyline points="2 12 12 17 22 12"></polyline>
            </svg>
            <span>Sección Héroe</span>
          </router-link>

          <router-link
            to="/admin/informacion-empresa"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="16" x2="12" y2="12"></line>
              <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>Información de la Empresa</span>
          </router-link>

          <router-link
            to="/admin/productos"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"
              ></path>
              <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
              <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            <span>Nuestros Productos</span>
          </router-link>

          <router-link
            to="/admin/servicios"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span>Nuestros Servicios</span>
          </router-link>

          <router-link
            to="/admin/portafolio"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect>
              <polyline points="17 2 12 7 7 2"></polyline>
            </svg>
            <span>Portafolio</span>
          </router-link>

          <router-link
            to="/admin/resenas"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <polygon
                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
              ></polygon>
            </svg>
            <span>Reseñas</span>
          </router-link>
        </div>

        <!-- 4. Formulario de Contacto -->
        <router-link
          to="/admin/formulario-contacto"
          class="nav-item"
          active-class="active"
          @click="closeSidebar"
        >
          <svg
            class="nav-icon"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          <span>Formulario de Contacto</span>
        </router-link>

        <!-- 5. Footer -->
        <router-link
          to="/admin/footer"
          class="nav-item"
          active-class="active"
          @click="closeSidebar"
        >
          <svg
            class="nav-icon"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
          </svg>
          <span>Footer</span>
        </router-link>

        <!-- 6. Configuración (solo admin) -->
        <div v-if="isAdmin" class="nav-section">
          <div class="nav-section-title">
            <svg
              class="section-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <circle cx="12" cy="12" r="3"></circle>
              <path
                d="M12 1v6m0 6v6m8.66-15L15.5 8.34M8.5 15.66 3.34 20.66m17.32 0L15.5 15.66M8.5 8.34 3.34 3.34"
              ></path>
            </svg>
            <span>Configuración</span>
          </div>

          <router-link
            to="/admin/usuarios"
            class="nav-subitem"
            active-class="active"
            @click="closeSidebar"
          >
            <svg
              class="nav-icon"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Gestión de Usuarios</span>
          </router-link>
        </div>
      </nav>

      <div class="sidebar-footer">
        <button @click="logout" class="logout-btn">
          <svg
            class="nav-icon"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          <span>Cerrar Sesión</span>
        </button>
      </div>
    </aside>

    <!-- Overlay -->
    <div class="overlay" :class="{ 'overlay-active': sidebarOpen }" @click="closeSidebar"></div>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Desktop Topbar -->
      <div class="topbar">
        <h1 class="page-title">{{ pageTitle }}</h1>
        <a href="/" class="btn-preview">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
            <polyline points="15 3 21 3 21 9"></polyline>
            <line x1="10" y1="14" x2="21" y2="3"></line>
          </svg>
          <span>Ver Sitio</span>
        </a>
      </div>

      <!-- Content Area -->
      <div class="content-area">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import authService from '../services/authService'

const route = useRoute()
const router = useRouter()
const sidebarOpen = ref(false)
const currentUser = ref(null)

// Obtener usuario actual
onMounted(async () => {
  try {
    currentUser.value = await authService.me()
  } catch (error) {
    console.error('Error al obtener usuario:', error)
  }
})

// Verificar si el usuario es admin
const isAdmin = computed(() => currentUser.value?.role === 'admin')

const userName = computed(() => {
  if (!currentUser.value) return 'Usuario'
  return currentUser.value.name || currentUser.value.username || 'Usuario'
})

const userRole = computed(() => {
  if (!currentUser.value) return ''
  return currentUser.value.role === 'admin' ? 'Administrador' : 'Editor'
})

const pageTitle = computed(() => {
  const titles = {
    AdminDashboard: 'Dashboard',
    AdminLeadsFormulario: 'Leads - Formulario',
    AdminLeadsRedes: 'Leads - Redes Sociales',
    AdminLeadsGoogle: 'Leads - Google',
    AdminHeroSection: 'Sección Héroe',
    AdminInformacionEmpresa: 'Información de la Empresa',
    AdminProductos: 'Nuestros Productos',
    AdminServices: 'Nuestros Servicios',
    AdminPortafolio: 'Portafolio',
    AdminResenas: 'Reseñas',
    AdminFormularioContacto: 'Formulario de Contacto',
    AdminFooter: 'Footer',
  }
  return titles[route.name] || 'Panel Admin'
})

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value
}

const closeSidebar = () => {
  sidebarOpen.value = false
}

const logout = async () => {
  try {
    await authService.logout()
  } catch (error) {
    console.error('Error al cerrar sesión:', error)
  } finally {
    localStorage.removeItem('auth_token')
    router.push('/admin/login')
  }
}
</script>

<style scoped>
/* Base - Mobile First */
.admin-layout {
  min-height: 100vh;
  background: #f8fafc;
  padding-top: 64px; /* Height of mobile header */
}

/* Mobile Header */
.mobile-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 64px;
  background: white;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1rem;
  z-index: 100;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.mobile-menu-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border: none;
  background: transparent;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.mobile-menu-btn:hover {
  background: #f1f5f9;
}

.mobile-menu-btn svg {
  width: 24px;
  height: 24px;
  color: #1e293b;
}

.mobile-logo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 700;
  font-size: 1.125rem;
  color: #1e293b;
}

.mobile-logo .logo-icon {
  width: 24px;
  height: 24px;
  color: #0066cc;
}

.mobile-home-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 8px;
  background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
  transition: transform 0.2s ease;
}

.mobile-home-btn:hover {
  transform: scale(1.05);
}

.mobile-home-btn svg {
  width: 20px;
  height: 20px;
  color: white;
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 64px;
  left: 0;
  bottom: 0;
  width: 280px;
  background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
  transform: translateX(-100%);
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 90;
  overflow-y: auto;
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
}

.sidebar-open {
  transform: translateX(0);
}

.sidebar::-webkit-scrollbar {
  width: 6px;
}

.sidebar::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
}

.sidebar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
}

.sidebar-header {
  padding: 1.5rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  display: none; /* Hidden on mobile, shown on desktop */
}

.sidebar-logo {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1rem;
}

.sidebar-logo .logo-icon {
  width: 32px;
  height: 32px;
  color: #60a5fa;
}

.sidebar-logo h2 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 700;
  background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem;
  background: rgba(96, 165, 250, 0.1);
  border-radius: 12px;
  border: 1px solid rgba(96, 165, 250, 0.2);
}

.user-avatar {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.user-avatar svg {
  width: 20px;
  height: 20px;
  color: white;
}

.user-details {
  flex: 1;
  min-width: 0;
}

.user-name {
  margin: 0;
  font-size: 0.875rem;
  font-weight: 600;
  color: white;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-role {
  margin: 0;
  font-size: 0.75rem;
  color: rgba(255, 255, 255, 0.6);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.sidebar-nav {
  flex: 1;
  padding: 1rem;
}

.nav-item,
.nav-subitem {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem 1rem;
  margin-bottom: 0.5rem;
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  border-radius: 8px;
  transition: all 0.2s ease;
  position: relative;
  font-size: 0.875rem;
  font-weight: 500;
}

.nav-item:hover,
.nav-subitem:hover {
  background: rgba(96, 165, 250, 0.1);
  color: white;
}

.nav-item.active,
.nav-subitem.active {
  background: rgba(96, 165, 250, 0.15);
  color: white;
}

.nav-item.active::before,
.nav-subitem.active::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 4px;
  background: linear-gradient(180deg, #60a5fa 0%, #3b82f6 100%);
  border-radius: 0 4px 4px 0;
  animation: slideIn 0.3s ease;
}

@keyframes slideIn {
  from {
    height: 0;
    top: 50%;
  }
  to {
    height: 100%;
    top: 0;
  }
}

.nav-icon {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}

.nav-section {
  margin: 1.5rem 0;
}

.nav-section-title {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  color: rgba(255, 255, 255, 0.5);
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 0.5rem;
}

.section-icon {
  width: 16px;
  height: 16px;
}

.nav-subitem {
  padding-left: 2.5rem;
  font-size: 0.8125rem;
}

.sidebar-footer {
  padding: 1rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.logout-btn {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  width: 100%;
  padding: 0.875rem 1rem;
  background: transparent;
  border: 1px solid rgba(239, 68, 68, 0.3);
  border-radius: 8px;
  color: rgba(255, 255, 255, 0.7);
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 0.875rem;
  font-weight: 500;
  font-family: inherit;
}

.logout-btn:hover {
  background: rgba(239, 68, 68, 0.1);
  border-color: rgba(239, 68, 68, 0.5);
  color: #fca5a5;
}

/* Overlay */
.overlay {
  position: fixed;
  top: 64px;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 80;
  backdrop-filter: blur(2px);
}

.overlay-active {
  opacity: 1;
  visibility: visible;
}

/* Main Content */
.main-content {
  padding: 0;
}

.topbar {
  display: none; /* Hidden on mobile */
}

.content-area {
  padding: 1.5rem 1rem;
  min-height: calc(100vh - 64px);
}

/* Tablet */
@media (min-width: 640px) {
  .content-area {
    padding: 2rem 1.5rem;
  }
}

/* Desktop */
@media (min-width: 1024px) {
  .admin-layout {
    padding-top: 0;
    padding-left: 280px;
  }

  .mobile-header {
    display: none;
  }

  .sidebar {
    top: 0;
    transform: translateX(0);
  }

  .sidebar-header {
    display: block;
  }

  .overlay {
    display: none;
  }

  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 2rem;
    background: white;
    border-bottom: 1px solid #e2e8f0;
    position: sticky;
    top: 0;
    z-index: 50;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  }

  .page-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
  }

  .btn-preview {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.2);
  }

  .btn-preview:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
  }

  .btn-preview svg {
    width: 18px;
    height: 18px;
  }

  .content-area {
    padding: 2.5rem;
    max-width: 1400px;
  }
}

/* Large Desktop */
@media (min-width: 1280px) {
  .content-area {
    padding: 3rem;
  }
}
</style>
