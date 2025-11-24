<template>
  <section id="nosotros" class="about">
    <div class="container">
      <div class="about-content">
        <div class="about-text">
          <h2 class="section-title">Innovación LED<br>desde 2013</h2>
          <p class="about-description">
            En Peñacom, transformamos espacios con tecnología LED de última generación. 
            Con más de una década de experiencia en Cancún y la Riviera Maya, nos especializamos 
            en ofrecer soluciones profesionales que impulsan la comunicación visual de nuestros clientes.
          </p>
          <p class="about-description">
            Nuestra experiencia abarca desde pequeños comercios hasta grandes proyectos corporativos, 
            siempre con el compromiso de ofrecer calidad, innovación y soporte excepcional.
          </p>
        </div>
        
        <div class="about-stats">
          <div class="stat">
            <div class="stat-number">10+</div>
            <div class="stat-label">Años de experiencia</div>
          </div>
          <div class="stat">
            <div class="stat-number">100+</div>
            <div class="stat-label">Proyectos completados</div>
          </div>
          <div class="stat">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Soporte técnico</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.about {
  padding: 120px 0;
  background: #fff;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

.about-content {
  max-width: 900px;
  margin: 0 auto;
}

.about-text {
  margin-bottom: 80px;
}

.section-title {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 32px;
  letter-spacing: -0.03em;
  line-height: 1.1;
}

.about-description {
  font-size: 1.25rem;
  color: #6e6e73;
  line-height: 1.6;
  margin-bottom: 24px;
}

.about-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 48px;
  text-align: center;
}

.stat {
  padding: 32px 0;
}

.stat-number {
  font-size: 3.5rem;
  font-weight: 600;
  color: #0066CC;
  margin-bottom: 8px;
  letter-spacing: -0.02em;
}

.stat-label {
  font-size: 1rem;
  color: #6e6e73;
  font-weight: 400;
}

@media (max-width: 768px) {
  .about {
    padding: 80px 0;
  }
  
  .about-text {
    margin-bottom: 48px;
  }
  
  .about-description {
    font-size: 1.125rem;
  }
  
  .about-stats {
    gap: 32px;
  }
  
  .stat-number {
    font-size: 2.5rem;
  }
}
</style>
