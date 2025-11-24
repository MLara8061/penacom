<template>
  <section id="servicios" class="services">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Servicios integrales</h2>
        <p class="section-subtitle">Acompañamiento completo en tu proyecto LED</p>
      </div>
      
      <div class="services-grid">
        <div class="service-item">
          <h3>Consultoría</h3>
          <p>Asesoría especializada para seleccionar la solución perfecta</p>
        </div>
        
        <div class="service-item">
          <h3>Diseño e ingeniería</h3>
          <p>Desarrollo técnico adaptado a tu espacio y necesidades</p>
        </div>
        
        <div class="service-item">
          <h3>Instalación profesional</h3>
          <p>Montaje certificado por técnicos especializados</p>
        </div>
        
        <div class="service-item">
          <h3>Mantenimiento</h3>
          <p>Soporte preventivo y correctivo para máxima disponibilidad</p>
        </div>
        
        <div class="service-item">
          <h3>Capacitación</h3>
          <p>Entrenamiento completo en operación y gestión de contenido</p>
        </div>
        
        <div class="service-item">
          <h3>Soporte 24/7</h3>
          <p>Asistencia técnica continua para garantizar operación sin interrupciones</p>
        </div>
      </div>
    </div>
  </section>
</template>

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

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 32px;
}

.service-item {
  background: #fff;
  padding: 40px 32px;
  border-radius: 16px;
  transition: all 0.3s ease;
}

.service-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
}

.service-item h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 12px;
  letter-spacing: -0.02em;
}

.service-item p {
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
  
  .service-item {
    padding: 32px 24px;
  }
}
</style>
