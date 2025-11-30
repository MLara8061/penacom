<template>
  <section id="productos" class="products">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Nuestros productos</h2>
        <p class="section-subtitle">Soluciones LED para cada necesidad</p>
      </div>
      
      <div v-if="loading" class="loading">
        <div class="spinner"></div>
      </div>
      
      <div v-else class="products-grid">
        <div 
          v-for="product in products" 
          :key="product.id"
          class="product-card"
        >
          <div class="icon-container" :style="{ background: getGradient(product.id) }">
            <component :is="getIconComponent(product.category)" class="product-icon" />
          </div>
          <div class="product-info">
            <h3 class="product-name">{{ product.name }}</h3>
            <p class="product-category">{{ product.category }}</p>
            <p class="product-description">{{ product.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, h } from 'vue'
import api from '@/services/api'

const products = ref([])
const loading = ref(true)

// Iconos SVG como componentes funcionales
const HotelIcon = () => h('svg', { 
  xmlns: 'http://www.w3.org/2000/svg', 
  viewBox: '0 0 24 24', 
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V6H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z' })
])

const RestaurantIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z' })
])

const HomeIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z' })
])

const BusinessIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z' })
])

const FactoryIcon = () => h('svg', {
  xmlns: 'http://www.w3.org/2000/svg',
  viewBox: '0 0 24 24',
  fill: 'currentColor',
  width: '100%',
  height: '100%'
}, [
  h('path', { d: 'M22 22H2V10l7-3v2l5-2v3h8v12zm-3-5h-2v-3h2v3zm-4 0h-2v-3h2v3zm-4 0H9v-3h2v3z' })
])

const getIconComponent = (category) => {
  const iconMap = {
    'Hospitalidad': HotelIcon,
    'Alimentos y Bebidas': RestaurantIcon,
    'Residencial': HomeIcon,
    'Comercial': BusinessIcon,
    'Industrial': FactoryIcon
  }
  return iconMap[category] || BusinessIcon
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

const fetchProducts = async () => {
  try {
    const response = await api.get('/products/active')
    products.value = response.data.sort((a, b) => a.order - b.order)
  } catch (error) {
    console.error('Error al cargar productos:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchProducts()
})
</script>

<style scoped>
.products {
  padding: 120px 0;
  background: #fff;
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
  border: 4px solid #f3f4f6;
  border-top-color: #667eea;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 32px;
  margin-top: 48px;
}

.product-card {
  background: #fff;
  border-radius: 20px;
  padding: 32px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid #e5e7eb;
  cursor: pointer;
}

.product-card:hover {
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

.product-card:hover .icon-container {
  transform: scale(1.1) rotate(5deg);
}

.product-icon {
  width: 40px;
  height: 40px;
  color: #fff;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.product-info {
  text-align: left;
}

.product-name {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 8px;
  line-height: 1.3;
}

.product-category {
  font-size: 0.875rem;
  color: #667eea;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 12px;
}

.product-description {
  font-size: 1rem;
  color: #6e6e73;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .products {
    padding: 80px 0;
  }
  
  .section-header {
    margin-bottom: 48px;
  }
  
  .products-grid {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  
  .product-card {
    padding: 24px;
  }
  
  .icon-container {
    width: 64px;
    height: 64px;
  }
  
  .product-icon {
    width: 32px;
    height: 32px;
  }
}
</style>

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

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 40px;
}

.product-card {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.product-card:hover {
  transform: translateY(-4px);
}

.product-image {
  aspect-ratio: 4/3;
  background: #f5f5f7;
  position: relative;
  overflow: hidden;
}

.image-placeholder {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #f5f5f7 0%, #e8e8ed 100%);
}

.product-info {
  padding: 24px 0;
}

.product-name {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 8px;
  letter-spacing: -0.02em;
}

.product-description {
  font-size: 1rem;
  color: #6e6e73;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .products {
    padding: 80px 0;
  }
  
  .section-header {
    margin-bottom: 48px;
  }
  
  .products-grid {
    gap: 32px;
  }
}
</style>
