<template>
  <section id="productos" class="products-section section">
    <div class="container">
      <div class="section-header">
        <span class="section-badge">Tecnología LED</span>
        <h2 class="section-title">Nuestros Productos</h2>
        <p class="section-subtitle">
          Pantallas LED para interiores y exteriores, adaptadas a diferentes sectores
        </p>
      </div>

      <div class="products-grid">
        <div class="product-card" v-for="(product, index) in products" :key="index">
          <div class="product-icon">{{ product.icon }}</div>
          <h3 class="product-title">{{ product.title }}</h3>
          <p class="product-description">{{ product.description }}</p>
          <ul class="product-features">
            <li v-for="(feature, idx) in product.features" :key="idx">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
              {{ feature }}
            </li>
          </ul>
        </div>
      </div>

      <div class="sectors-section">
        <h3 class="sectors-title">Sectores que atendemos</h3>
        <div class="sectors-grid">
          <div class="sector-chip" v-for="(sector, index) in sectors" :key="index">
            <span class="sector-icon">{{ sector.icon }}</span>
            <span class="sector-name">{{ sector.name }}</span>
          </div>
        </div>
      </div>

      <div class="cta-box">
        <h3>¿Necesitas una solución personalizada?</h3>
        <p>Nuestros expertos te ayudarán a encontrar la pantalla LED perfecta para tu proyecto</p>
        <a href="#contacto" class="btn btn-primary btn-lg">
          Solicitar Asesoría
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const products = ref([
  {
    icon: '🏢',
    title: 'Pantallas LED Interiores',
    description: 'Perfectas para espacios corporativos, centros comerciales y eventos',
    features: [
      'Alta resolución',
      'Brillo ajustable',
      'Instalación modular',
      'Bajo consumo energético'
    ]
  },
  {
    icon: '🌆',
    title: 'Pantallas LED Exteriores',
    description: 'Resistentes a condiciones climáticas extremas y alta visibilidad',
    features: [
      'Resistente al agua IP65',
      'Alto brillo para luz solar',
      'Estructura reforzada',
      'Protección UV'
    ]
  },
  {
    icon: '📺',
    title: 'Videowall LED',
    description: 'Impresionantes muros de video para máximo impacto visual',
    features: [
      'Sin bordes visibles',
      'Configuración flexible',
      'Control centralizado',
      'Contenido 4K/8K'
    ]
  },
  {
    icon: '🎪',
    title: 'Pantallas LED Rental',
    description: 'Soluciones temporales para eventos, conciertos y ferias',
    features: [
      'Montaje rápido',
      'Transporte incluido',
      'Soporte técnico en sitio',
      'Paquetes personalizados'
    ]
  }
])

const sectors = ref([
  { icon: '🏨', name: 'Hotelero' },
  { icon: '🍽️', name: 'Restaurantero' },
  { icon: '🎨', name: 'Salas de Exhibición' },
  { icon: '🛍️', name: 'Tiendas Departamentales' },
  { icon: '🏢', name: 'Corporativo' },
  { icon: '🎬', name: 'Entretenimiento' }
])
</script>

<style scoped>
.products-section {
  background: var(--white);
}

.products-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--spacing-lg);
  margin-bottom: var(--spacing-3xl);
}

.product-card {
  background: var(--light-gray);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
  transition: var(--transition);
  border: 2px solid transparent;
}

.product-card:hover {
  border-color: var(--primary-blue);
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}

.product-icon {
  font-size: 4rem;
  margin-bottom: var(--spacing-md);
}

.product-title {
  font-size: var(--font-size-2xl);
  color: var(--dark);
  margin-bottom: var(--spacing-sm);
}

.product-description {
  color: var(--gray);
  margin-bottom: var(--spacing-lg);
  line-height: 1.6;
}

.product-features {
  list-style: none;
  padding: 0;
}

.product-features li {
  display: flex;
  align-items: center;
  gap: var(--spacing-sm);
  padding: var(--spacing-xs) 0;
  color: var(--gray);
}

.product-features svg {
  color: var(--primary-blue);
  flex-shrink: 0;
}

.sectors-section {
  margin-bottom: var(--spacing-3xl);
  padding: var(--spacing-2xl);
  background: var(--light-blue);
  border-radius: var(--radius-xl);
}

.sectors-title {
  text-align: center;
  font-size: var(--font-size-2xl);
  color: var(--dark);
  margin-bottom: var(--spacing-xl);
}

.sectors-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: var(--spacing-md);
}

.sector-chip {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--spacing-xs);
  padding: var(--spacing-md);
  background: var(--white);
  border-radius: var(--radius-lg);
  transition: var(--transition);
  text-align: center;
}

.sector-chip:hover {
  transform: scale(1.05);
  box-shadow: var(--shadow-md);
}

.sector-icon {
  font-size: 2rem;
}

.sector-name {
  font-size: var(--font-size-sm);
  font-weight: 600;
  color: var(--dark);
}

.cta-box {
  text-align: center;
  padding: var(--spacing-3xl) var(--spacing-xl);
  background: var(--gradient-primary);
  border-radius: var(--radius-xl);
  color: var(--white);
}

.cta-box h3 {
  font-size: var(--font-size-2xl);
  color: var(--white);
  margin-bottom: var(--spacing-md);
}

.cta-box p {
  font-size: var(--font-size-lg);
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: var(--spacing-xl);
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.cta-box .btn {
  background: var(--white);
  color: var(--primary-blue);
}

.cta-box .btn:hover {
  transform: scale(1.05);
  box-shadow: var(--shadow-xl);
}

@media (min-width: 768px) {
  .products-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .products-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: var(--spacing-xl);
  }

  .cta-box h3 {
    font-size: var(--font-size-3xl);
  }
}
</style>
