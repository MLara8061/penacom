<template>
  <section id="servicios" class="services">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Servicios integrales</h2>
        <p class="section-subtitle">Acompañamiento completo en tu proyecto LED</p>
      </div>
      
      <div v-if="loading" class="loading">
        <div class="spinner"></div>
      </div>
      
      <div v-else class="services-grid">
        <div 
          v-for="service in services" 
          :key="service.id"
          class="service-card"
        >
          <div class="icon-container" :style="{ background: getGradient(service.id) }">
            <component :is="getIconComponent(service.title)" class="service-icon" />
          </div>
          <div class="service-info">
            <h3 class="service-title">{{ service.title }}</h3>
            <p class="service-description">{{ service.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, h } from 'vue'
import api from '@/services/api'

const services = ref([])
const loading = ref(true)

// Iconos SVG como componentes funcionales
const DesignIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5s1.5.67 1.5 1.5S10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 9 17.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z' })
])

const LedIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7zm2.85 11.1l-.85.6V16h-4v-2.3l-.85-.6C7.8 12.16 7 10.63 7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.15 4.1z' })
])

const CorporateIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z' })
])

const VinylIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z' })
])

const MaintenanceIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z' })
])

const getIconComponent = (title) => {
  if (title.toLowerCase().includes('diseño') || title.toLowerCase().includes('rótulo')) return DesignIcon
  if (title.toLowerCase().includes('led') || title.toLowerCase().includes('luminoso')) return LedIcon
  if (title.toLowerCase().includes('corporativ') || title.toLowerCase().includes('señalización')) return CorporateIcon
  if (title.toLowerCase().includes('vinil') || title.toLowerCase().includes('adhesivo')) return VinylIcon
  if (title.toLowerCase().includes('mantenimiento') || title.toLowerCase().includes('reparación')) return MaintenanceIcon
  return DesignIcon
}

const getGradient = (id) => {
  const gradients = [
    'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
    'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
    'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
    'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
    'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'
  ]
  return gradients[(id - 1) % gradients.length]
}

const fetchServices = async () => {
  try {
    const response = await api.get('/services/active')
    services.value = response.data.sort((a, b) => a.order - b.order)
  } catch (error) {
    console.error('Error al cargar servicios:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchServices()
})
</script>

<style scoped>
.services {
  padding: 120px 0;
  background: #f5f5f7;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

.section-header {
  text-align: center;
  margin-bottom: 80px;
}

.section-title {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 16px;
  letter-spacing: -0.03em;
}

.section-subtitle {
  font-size: 1.25rem;
  color: #6e6e73;
  font-weight: 400;
}

.loading {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 400px;
}

.spinner {
  width: 48px;
  height: 48px;
  border: 4px solid #e5e7eb;
  border-top-color: #667eea;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 32px;
  margin-top: 48px;
}

.service-card {
  background: #fff;
  border-radius: 20px;
  padding: 32px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid #e5e7eb;
  cursor: pointer;
  display: flex;
  flex-direction: column;
}

.service-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
  border-color: transparent;
}

.icon-container {
  width: 80px;
  height: 80px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
  transition: all 0.3s ease;
}

.service-card:hover .icon-container {
  transform: scale(1.1) rotate(-5deg);
}

.service-icon {
  width: 40px;
  height: 40px;
  color: #fff;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.service-info {
  text-align: left;
  flex: 1;
}

.service-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 12px;
  line-height: 1.3;
}

.service-description {
  font-size: 1rem;
  color: #6e6e73;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .services {
    padding: 80px 0;
  }
  
  .section-header {
    margin-bottom: 48px;
  }
  
  .services-grid {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  
  .service-card {
    padding: 24px;
  }
  
  .icon-container {
    width: 64px;
    height: 64px;
  }
  
  .service-icon {
    width: 32px;
    height: 32px;
  }
}
</style>
