<template>
  <section id="servicios" class="services-section section">
    <div class="container">
      <div class="section-header">
        <span class="section-badge">Soluciones Completas</span>
        <h2 class="section-title">Nuestros Servicios</h2>
        <p class="section-subtitle">
          Experiencia integral desde el diseño hasta el mantenimiento
        </p>
      </div>

      <div class="services-grid">
        <div class="service-card" v-for="(service, index) in services" :key="index">
          <div class="service-number">{{ String(index + 1).padStart(2, '0') }}</div>
          <div class="service-icon" v-html="service.icon"></div>
          <h3 class="service-title">{{ service.title }}</h3>
          <p class="service-description">{{ service.description }}</p>
        </div>
      </div>

      <div class="digital-signage">
        <div class="ds-content">
          <div class="ds-text">
            <h2>📡 Señalización Digital</h2>
            <p class="ds-intro">
              La señalización digital es una red de pantallas programables y administradas de forma centralizada, diseñada para mostrar información segmentada, entretenimiento, publicidad y comunicación corporativa.
            </p>

            <h3>¿Para qué sirve?</h3>
            <ul class="ds-list">
              <li>
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><strong>Información y orientación:</strong> servicios, eventos, promociones</span>
              </li>
              <li>
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><strong>Comunicación interna:</strong> anuncios, formación, alertas de emergencia</span>
              </li>
              <li>
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><strong>Seguridad:</strong> mensajes educativos e instrucciones en situaciones críticas</span>
              </li>
              <li>
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><strong>Entretenimiento:</strong> música, videos promocionales, menús digitales</span>
              </li>
            </ul>

            <h3>Ventajas</h3>
            <div class="advantages-grid">
              <div class="advantage-item">
                <div class="advantage-icon">🎯</div>
                <p>Mayor impacto visual frente a imágenes estáticas</p>
              </div>
              <div class="advantage-item">
                <div class="advantage-icon">🏆</div>
                <p>Refuerza el reconocimiento de marca</p>
              </div>
              <div class="advantage-item">
                <div class="advantage-icon">🤝</div>
                <p>Incrementa la interacción con clientes</p>
              </div>
              <div class="advantage-item">
                <div class="advantage-icon">⚡</div>
                <p>Actualización en tiempo real</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const services = ref([
  {
    icon: '🔧',
    title: 'Ingeniería Técnica',
    description: 'Análisis y diseño de soluciones LED personalizadas según las necesidades específicas de cada proyecto'
  },
  {
    icon: '💡',
    title: 'Asesoría Especializada',
    description: 'Consultoría experta para nuevos proyectos, ayudándote a elegir la mejor tecnología LED'
  },
  {
    icon: '🛒',
    title: 'Venta de Equipos',
    description: 'Comercialización de pantallas LED de alta calidad con componentes certificados internacionalmente'
  },
  {
    icon: '⚙️',
    title: 'Instalación Profesional',
    description: 'Montaje y puesta en marcha realizada por técnicos certificados con garantía de funcionamiento'
  },
  {
    icon: '🔍',
    title: 'Mantenimiento Preventivo',
    description: 'Programa de mantenimiento para asegurar el óptimo funcionamiento de tus pantallas LED'
  },
  {
    icon: '🛠️',
    title: 'Soporte Correctivo',
    description: 'Servicio técnico especializado para reparación y resolución de problemas 24/7'
  }
])
</script>

<style scoped>
.services-section {
  background: var(--light-gray);
}

.services-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--spacing-lg);
  margin-bottom: var(--spacing-3xl);
}

.service-card {
  position: relative;
  background: var(--white);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
  transition: var(--transition);
  overflow: hidden;
}

.service-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background: var(--gradient-primary);
  transform: scaleY(0);
  transition: var(--transition);
}

.service-card:hover::before {
  transform: scaleY(1);
}

.service-card:hover {
  transform: translateX(4px);
  box-shadow: var(--shadow-lg);
}

.service-number {
  position: absolute;
  top: var(--spacing-md);
  right: var(--spacing-md);
  font-size: var(--font-size-3xl);
  font-weight: 800;
  color: var(--light-blue);
}

.service-icon {
  font-size: 3rem;
  margin-bottom: var(--spacing-md);
}

.service-title {
  font-size: var(--font-size-xl);
  color: var(--dark);
  margin-bottom: var(--spacing-sm);
}

.service-description {
  color: var(--gray);
  line-height: 1.7;
}

.digital-signage {
  background: var(--white);
  border-radius: var(--radius-xl);
  padding: var(--spacing-xl);
  box-shadow: var(--shadow);
}

.ds-content {
  max-width: 900px;
  margin: 0 auto;
}

.ds-text h2 {
  font-size: var(--font-size-2xl);
  color: var(--primary-blue);
  margin-bottom: var(--spacing-lg);
}

.ds-intro {
  font-size: var(--font-size-lg);
  color: var(--gray);
  margin-bottom: var(--spacing-xl);
  line-height: 1.7;
}

.ds-text h3 {
  font-size: var(--font-size-xl);
  color: var(--dark);
  margin-top: var(--spacing-xl);
  margin-bottom: var(--spacing-md);
}

.ds-list {
  list-style: none;
  padding: 0;
  margin-bottom: var(--spacing-xl);
}

.ds-list li {
  display: flex;
  align-items: flex-start;
  gap: var(--spacing-md);
  padding: var(--spacing-sm) 0;
  color: var(--gray);
}

.ds-list svg {
  color: var(--primary-blue);
  flex-shrink: 0;
  margin-top: 2px;
}

.advantages-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--spacing-md);
  margin-top: var(--spacing-lg);
}

.advantage-item {
  display: flex;
  align-items: center;
  gap: var(--spacing-md);
  padding: var(--spacing-md);
  background: var(--light-blue);
  border-radius: var(--radius-lg);
  transition: var(--transition);
}

.advantage-item:hover {
  transform: scale(1.02);
}

.advantage-icon {
  font-size: 2rem;
  flex-shrink: 0;
}

.advantage-item p {
  color: var(--dark);
  margin: 0;
  font-weight: 500;
}

@media (min-width: 768px) {
  .services-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .advantages-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .ds-text h2 {
    font-size: var(--font-size-3xl);
  }
}

@media (min-width: 1024px) {
  .services-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-xl);
  }

  .digital-signage {
    padding: var(--spacing-3xl);
  }
}
</style>
