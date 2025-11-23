<template>
  <section id="nosotros" class="about-section section">
    <div class="container">
      <div class="section-header">
        <span class="section-badge">Desde 2013</span>
        <h2 class="section-title">Quiénes Somos</h2>
        <p class="section-subtitle">
          Líderes en soluciones LED en Cancún, Quintana Roo
        </p>
      </div>

      <div class="about-content">
        <div class="about-text">
          <p class="lead-text">
            Peñacom es una empresa fundada en 2013 en Cancún, Quintana Roo, especializada en la venta, instalación y mantenimiento de pantallas LED.
          </p>
          <p>
            Durante más de una década hemos acompañado a nuestros clientes con soluciones innovadoras, ofreciendo siempre la vanguardia en tecnología LED.
          </p>
          <p>
            Trabajamos con fabricantes internacionales de componentes de alta calidad, ensamblados por técnicos mexicanos altamente capacitados.
          </p>
          <p class="highlight-text">
            Hoy, más de 100 clientes satisfechos respaldan nuestra experiencia y compromiso.
          </p>
        </div>

        <div class="values-grid">
          <div class="value-card" v-for="(value, index) in values" :key="index">
            <div class="value-icon" v-html="value.icon"></div>
            <h3 class="value-title">{{ value.title }}</h3>
            <p class="value-description">{{ value.description }}</p>
          </div>
        </div>
      </div>

      <div class="mission-vision">
        <div class="mv-card mission">
          <div class="mv-icon">🎯</div>
          <h3>Nuestra Misión</h3>
          <p>
            Brindar soluciones integrales en pantallas LED que impulsen la comunicación, la publicidad y la experiencia visual de nuestros clientes, con tecnología de última generación y un servicio confiable.
          </p>
        </div>

        <div class="mv-card vision">
          <div class="mv-icon">👁️</div>
          <h3>Nuestra Visión</h3>
          <p>
            Ser líderes en México en soluciones de pantallas LED, reconocidos por la innovación, calidad y atención personalizada.
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const values = ref([
  {
    icon: '💡',
    title: 'Innovación',
    description: 'Siempre a la vanguardia en tecnología LED'
  },
  {
    icon: '🤝',
    title: 'Compromiso',
    description: 'Acompañamos a nuestros clientes en cada etapa del proyecto'
  },
  {
    icon: '⭐',
    title: 'Calidad',
    description: 'Componentes de primer nivel y procesos técnicos certificados'
  },
  {
    icon: '🔒',
    title: 'Confianza',
    description: 'Más de 100 clientes nos respaldan'
  }
])
</script>

<style scoped>
.about-section {
  background: var(--light-gray);
}

.section-header {
  text-align: center;
  margin-bottom: var(--spacing-2xl);
}

.section-badge {
  display: inline-block;
  padding: var(--spacing-xs) var(--spacing-md);
  background: var(--light-blue);
  color: var(--primary-blue);
  font-size: var(--font-size-sm);
  font-weight: 600;
  border-radius: var(--radius-full);
  margin-bottom: var(--spacing-md);
}

.section-title {
  font-size: var(--font-size-3xl);
  color: var(--dark);
  margin-bottom: var(--spacing-sm);
}

.section-subtitle {
  font-size: var(--font-size-lg);
  color: var(--gray);
  max-width: 600px;
  margin: 0 auto;
}

.about-content {
  display: grid;
  gap: var(--spacing-2xl);
  margin-bottom: var(--spacing-2xl);
}

.about-text {
  background: var(--white);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow);
}

.lead-text {
  font-size: var(--font-size-lg);
  font-weight: 500;
  color: var(--dark);
  margin-bottom: var(--spacing-lg);
}

.highlight-text {
  font-weight: 600;
  color: var(--primary-blue);
  font-size: var(--font-size-lg);
  margin-top: var(--spacing-lg);
}

.values-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--spacing-md);
}

.value-card {
  background: var(--white);
  padding: var(--spacing-lg);
  border-radius: var(--radius-lg);
  text-align: center;
  transition: var(--transition);
  box-shadow: var(--shadow-sm);
}

.value-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-md);
}

.value-icon {
  font-size: 3rem;
  margin-bottom: var(--spacing-md);
}

.value-title {
  font-size: var(--font-size-xl);
  color: var(--dark);
  margin-bottom: var(--spacing-sm);
}

.value-description {
  color: var(--gray);
  font-size: var(--font-size-base);
}

.mission-vision {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--spacing-lg);
}

.mv-card {
  background: var(--white);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow);
  border-left: 4px solid var(--primary-blue);
}

.mv-card.mission {
  border-left-color: var(--primary-blue);
}

.mv-card.vision {
  border-left-color: var(--secondary-blue);
}

.mv-icon {
  font-size: 3rem;
  margin-bottom: var(--spacing-md);
}

.mv-card h3 {
  font-size: var(--font-size-2xl);
  color: var(--dark);
  margin-bottom: var(--spacing-md);
}

.mv-card p {
  color: var(--gray);
  line-height: 1.7;
}

@media (min-width: 768px) {
  .about-content {
    grid-template-columns: 1fr;
  }

  .values-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .mission-vision {
    grid-template-columns: repeat(2, 1fr);
  }

  .section-title {
    font-size: var(--font-size-4xl);
  }
}

@media (min-width: 1024px) {
  .values-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}
</style>
