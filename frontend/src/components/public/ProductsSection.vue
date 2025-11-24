<template>
  <section id="productos" class="products">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Nuestros productos</h2>
        <p class="section-subtitle">Soluciones LED para cada necesidad</p>
      </div>
      
      <div class="products-grid">
        <div class="product-card">
          <div class="product-image">
            <div class="image-placeholder"></div>
          </div>
          <div class="product-info">
            <h3 class="product-name">Pantallas LED Interior</h3>
            <p class="product-description">Alta resolución para espacios comerciales, corporativos y eventos indoor</p>
          </div>
        </div>
        
        <div class="product-card">
          <div class="product-image">
            <div class="image-placeholder"></div>
          </div>
          <div class="product-info">
            <h3 class="product-name">Pantallas LED Exterior</h3>
            <p class="product-description">Resistentes a condiciones climáticas extremas con máxima visibilidad</p>
          </div>
        </div>
        
        <div class="product-card">
          <div class="product-image">
            <div class="image-placeholder"></div>
          </div>
          <div class="product-info">
            <h3 class="product-name">Videowall LED</h3>
            <p class="product-description">Soluciones modulares para crear pantallas de gran formato</p>
          </div>
        </div>
        
        <div class="product-card">
          <div class="product-image">
            <div class="image-placeholder"></div>
          </div>
          <div class="product-info">
            <h3 class="product-name">Pantallas Rental</h3>
            <p class="product-description">Ligeras y rápidas de instalar, ideales para eventos temporales</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

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
