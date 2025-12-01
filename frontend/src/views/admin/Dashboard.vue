<template>
  <div class="admin-dashboard">
    <!-- Mensaje de Bienvenida -->
    <div class="welcome-header">
      <div class="welcome-content">
        <h1 class="welcome-title">¡Hola, {{ userName }}! 👋</h1>
        <p class="welcome-subtitle">Aquí está el resumen de tu negocio hoy</p>
      </div>
      <div class="welcome-date">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
          <line x1="16" y1="2" x2="16" y2="6"></line>
          <line x1="8" y1="2" x2="8" y2="6"></line>
          <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <span>{{ currentDate }}</span>
      </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon leads">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Total Leads</h3>
          <p class="stat-number">247</p>
          <span class="stat-change positive">+12% este mes</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon visits">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Visitas</h3>
          <p class="stat-number">12.5K</p>
          <span class="stat-change positive">+8% esta semana</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon conversions">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Conversiones</h3>
          <p class="stat-number">18%</p>
          <span class="stat-change negative">-2% esta semana</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon reviews">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon
              points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
            ></polygon>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Reseñas</h3>
          <p class="stat-number">4.8/5</p>
          <span class="stat-change positive">+0.2 este mes</span>
        </div>
      </div>
    </div>

    <!-- Tips y Sugerencias -->
    <div class="tips-section">
      <h2 class="section-title">💡 Tips y Sugerencias</h2>
      <div class="tips-grid">
        <div class="tip-card">
          <div class="tip-icon">🎨</div>
          <h3>Actualiza tu contenido</h3>
          <p>Mantén tu sección héroe actualizada con ofertas y promociones vigentes.</p>
        </div>
        <div class="tip-card">
          <div class="tip-icon">📸</div>
          <h3>Imágenes de calidad</h3>
          <p>Usa imágenes de alta resolución en tu portafolio para impresionar a los clientes.</p>
        </div>
        <div class="tip-card">
          <div class="tip-icon">⚡</div>
          <h3>Responde rápido</h3>
          <p>
            Los leads que respondes en menos de 5 minutos tienen 21x más probabilidad de conversión.
          </p>
        </div>
        <div class="tip-card">
          <div class="tip-icon">⭐</div>
          <h3>Pide reseñas</h3>
          <p>Solicita reseñas a clientes satisfechos para aumentar tu credibilidad.</p>
        </div>
      </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="quick-actions">
      <h2 class="section-title">⚡ Accesos Rápidos</h2>
      <div class="actions-grid">
        <router-link to="/admin/leads/formulario" class="action-card">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          </svg>
          <span>Ver Leads</span>
        </router-link>
        <router-link to="/admin/seccion-heroe" class="action-card">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
          </svg>
          <span>Editar Héroe</span>
        </router-link>
        <router-link to="/admin/portafolio" class="action-card">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect>
          </svg>
          <span>Gestionar Portafolio</span>
        </router-link>
        <router-link to="/admin/resenas" class="action-card">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon
              points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
            ></polygon>
          </svg>
          <span>Ver Reseñas</span>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import authService from '@/services/authService'
import { computed, onMounted, ref } from 'vue'

const currentUser = ref(null)

onMounted(async () => {
  try {
    currentUser.value = await authService.me()
  } catch (error) {
    console.error('Error al obtener usuario:', error)
  }
})

const userName = computed(() => {
  if (!currentUser.value) return 'Usuario'
  return currentUser.value.name || currentUser.value.username || 'Usuario'
})

const currentDate = computed(() => {
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
  return new Date().toLocaleDateString('es-ES', options)
})
</script>

<style scoped>
.admin-dashboard {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Welcome Header */
.welcome-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
  box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
  animation: slideDown 0.5s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.welcome-content {
  flex: 1;
}

.welcome-title {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 0.5rem 0;
  letter-spacing: -0.02em;
}

.welcome-subtitle {
  font-size: 1.1rem;
  margin: 0;
  opacity: 0.9;
  font-weight: 400;
}

.welcome-date {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  background: rgba(255, 255, 255, 0.2);
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  backdrop-filter: blur(10px);
}

.welcome-date svg {
  width: 20px;
  height: 20px;
}

.welcome-date span {
  font-size: 0.95rem;
  font-weight: 500;
  text-transform: capitalize;
}

@media (max-width: 768px) {
  .welcome-header {
    flex-direction: column;
    text-align: center;
    gap: 1.5rem;
  }

  .welcome-title {
    font-size: 1.5rem;
  }

  .welcome-subtitle {
    font-size: 1rem;
  }

  .welcome-date {
    width: 100%;
    justify-content: center;
  }
}

.stats-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
  margin-bottom: 2rem;
}

.stat-card {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  background: white;
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.stat-icon svg {
  width: 28px;
  height: 28px;
  color: white;
}

.stat-icon.leads {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-icon.visits {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-icon.conversions {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-icon.reviews {
  background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-content h3 {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0 0 0.25rem 0;
  font-weight: 500;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 0.25rem 0;
}

.stat-change {
  font-size: 0.75rem;
  font-weight: 600;
}

.stat-change.positive {
  color: #10b981;
}

.stat-change.negative {
  color: #ef4444;
}

.section-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 1.5rem 0;
}

.tips-section {
  margin-bottom: 2rem;
}

.tips-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

.tip-card {
  background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  padding: 1.5rem;
  transition: all 0.3s ease;
}

.tip-card:hover {
  border-color: #667eea;
  transform: translateY(-2px);
}

.tip-icon {
  font-size: 2rem;
  margin-bottom: 0.75rem;
}

.tip-card h3 {
  font-size: 1rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 0.5rem 0;
}

.tip-card p {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0;
  line-height: 1.6;
}

.quick-actions {
  margin-bottom: 2rem;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.action-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  padding: 1.5rem;
  background: white;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  text-decoration: none;
  color: #64748b;
  font-weight: 600;
  font-size: 0.875rem;
  transition: all 0.3s ease;
}

.action-card:hover {
  border-color: #0066cc;
  color: #0066cc;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 102, 204, 0.1);
}

.action-card svg {
  width: 32px;
  height: 32px;
}

@media (min-width: 640px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .tips-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .stats-grid {
    grid-template-columns: repeat(4, 1fr);
  }

  .tips-grid {
    grid-template-columns: repeat(4, 1fr);
  }

  .actions-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}
</style>
