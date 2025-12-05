<template>
  <div class="coming-soon">
    <div class="coming-soon-card">
      <div class="icon-container">
        <svg
          class="icon-main"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
        >
          <circle cx="12" cy="12" r="10" />
          <polyline points="12 6 12 12 16 14" />
        </svg>
        <div class="icon-decoration icon-decoration-1"></div>
        <div class="icon-decoration icon-decoration-2"></div>
        <div class="icon-decoration icon-decoration-3"></div>
      </div>

      <h1 class="title">{{ title }}</h1>
      <p class="subtitle">{{ subtitle }}</p>

      <div class="features">
        <div class="feature-item" v-for="(feature, index) in features" :key="index">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12" />
          </svg>
          <span>{{ feature }}</span>
        </div>
      </div>

      <div class="timeline">
        <svg class="timeline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
          <line x1="16" y1="2" x2="16" y2="6" />
          <line x1="8" y1="2" x2="8" y2="6" />
          <line x1="3" y1="10" x2="21" y2="10" />
        </svg>
        <span>Disponible pronto</span>
      </div>

      <div class="cta-section">
        <p class="cta-text">Mientras tanto, puedes explorar otras secciones del panel</p>
        <router-link to="/admin" class="btn-dashboard">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" />
            <rect x="14" y="3" width="7" height="7" />
            <rect x="14" y="14" width="7" height="7" />
            <rect x="3" y="14" width="7" height="7" />
          </svg>
          <span>Volver al Dashboard</span>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  title?: string
  subtitle?: string
  features?: string[]
}

withDefaults(defineProps<Props>(), {
  title: 'Próximamente',
  subtitle: 'Estamos trabajando en esta funcionalidad para ofrecerte la mejor experiencia',
  features: () => [
    'Interfaz intuitiva y fácil de usar',
    'Análisis detallados y reportes',
    'Integración completa con tu sistema',
  ],
})
</script>

<style scoped>
.coming-soon {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 2rem;
  position: relative;
  overflow: hidden;
}

.coming-soon::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
  animation: float 20s infinite ease-in-out;
}

.coming-soon::after {
  content: '';
  position: absolute;
  bottom: -50%;
  left: -50%;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
  animation: float 25s infinite ease-in-out reverse;
}

@keyframes float {
  0%,
  100% {
    transform: translate(0, 0);
  }
  50% {
    transform: translate(50px, 50px);
  }
}

.coming-soon-card {
  position: relative;
  z-index: 1;
  background: white;
  border-radius: 24px;
  padding: 3rem;
  max-width: 600px;
  width: 100%;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  text-align: center;
  animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.icon-container {
  position: relative;
  width: 120px;
  height: 120px;
  margin: 0 auto 2rem;
}

.icon-main {
  width: 120px;
  height: 120px;
  color: #667eea;
  stroke-width: 1.5;
  animation: pulse 2s infinite ease-in-out;
}

@keyframes pulse {
  0%,
  100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.05);
    opacity: 0.8;
  }
}

.icon-decoration {
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea, #764ba2);
}

.icon-decoration-1 {
  top: 10%;
  right: 10%;
  animation: float-decoration 3s infinite ease-in-out;
}

.icon-decoration-2 {
  bottom: 15%;
  left: 5%;
  animation: float-decoration 4s infinite ease-in-out 0.5s;
}

.icon-decoration-3 {
  top: 50%;
  right: -10%;
  animation: float-decoration 3.5s infinite ease-in-out 1s;
}

@keyframes float-decoration {
  0%,
  100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.title {
  font-size: 2.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin: 0 0 1rem 0;
}

.subtitle {
  font-size: 1.125rem;
  color: #64748b;
  line-height: 1.6;
  margin: 0 0 2.5rem 0;
}

.features {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 2.5rem;
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem;
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
  border-radius: 12px;
  border: 1px solid rgba(102, 126, 234, 0.1);
  transition: all 0.3s ease;
}

.feature-item:hover {
  transform: translateX(5px);
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
  border-color: rgba(102, 126, 234, 0.2);
}

.feature-item svg {
  width: 24px;
  height: 24px;
  color: #667eea;
  flex-shrink: 0;
}

.feature-item span {
  font-size: 0.95rem;
  color: #475569;
  text-align: left;
}

.timeline {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  padding: 1rem;
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  border-radius: 12px;
  margin-bottom: 2rem;
}

.timeline-icon {
  width: 20px;
  height: 20px;
  color: #d97706;
  stroke-width: 2;
}

.timeline span {
  font-size: 0.95rem;
  font-weight: 600;
  color: #92400e;
}

.cta-section {
  border-top: 1px solid #e2e8f0;
  padding-top: 2rem;
}

.cta-text {
  font-size: 0.95rem;
  color: #64748b;
  margin: 0 0 1.5rem 0;
}

.btn-dashboard {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 2rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-dashboard:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}

.btn-dashboard svg {
  width: 20px;
  height: 20px;
}

/* Responsive */
@media (max-width: 768px) {
  .coming-soon {
    padding: 1rem;
  }

  .coming-soon-card {
    padding: 2rem 1.5rem;
  }

  .title {
    font-size: 2rem;
  }

  .subtitle {
    font-size: 1rem;
  }

  .icon-container {
    width: 100px;
    height: 100px;
  }

  .icon-main {
    width: 100px;
    height: 100px;
  }
}
</style>
