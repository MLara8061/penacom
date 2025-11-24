<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-brand">
          <div class="logo">Peñacom</div>
          <p class="tagline">Tecnología LED desde 2013</p>
        </div>
        
        <div class="footer-links">
          <div class="link-column">
            <h4>Productos</h4>
            <a href="#productos">Pantallas Interior</a>
            <a href="#productos">Pantallas Exterior</a>
            <a href="#productos">Videowall LED</a>
            <a href="#productos">Pantallas Rental</a>
          </div>
          
          <div class="link-column">
            <h4>Servicios</h4>
            <a href="#servicios">Consultoría</a>
            <a href="#servicios">Instalación</a>
            <a href="#servicios">Mantenimiento</a>
            <a href="#servicios">Soporte</a>
          </div>
          
          <div class="link-column">
            <h4>Empresa</h4>
            <a href="#nosotros">Nosotros</a>
            <a href="#contacto">Contacto</a>
          </div>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p>&copy; {{ currentYear }} Peñacom. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'

const currentYear = computed(() => new Date().getFullYear())
</script>

<style scoped>
.footer {
  background: #1d1d1f;
  color: #f5f5f7;
  padding: 80px 0 32px;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

.footer-content {
  display: grid;
  grid-template-columns: 1.5fr 2fr;
  gap: 80px;
  padding-bottom: 48px;
  border-bottom: 1px solid rgba(245, 245, 247, 0.1);
  margin-bottom: 32px;
}

.logo {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 12px;
  letter-spacing: -0.02em;
}

.tagline {
  font-size: 0.875rem;
  color: rgba(245, 245, 247, 0.6);
}

.footer-links {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 48px;
}

.link-column h4 {
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 16px;
  color: #f5f5f7;
}

.link-column a {
  display: block;
  font-size: 0.875rem;
  color: rgba(245, 245, 247, 0.6);
  text-decoration: none;
  margin-bottom: 12px;
  transition: color 0.2s ease;
}

.link-column a:hover {
  color: #f5f5f7;
}

.footer-bottom {
  text-align: center;
}

.footer-bottom p {
  font-size: 0.875rem;
  color: rgba(245, 245, 247, 0.6);
}

@media (max-width: 768px) {
  .footer {
    padding: 48px 0 24px;
  }
  
  .footer-content {
    grid-template-columns: 1fr;
    gap: 48px;
  }
  
  .footer-links {
    grid-template-columns: 1fr;
    gap: 32px;
  }
}
</style>
