<template>
  <section id="inicio" class="hero">
    <div class="hero-background">
      <div class="hero-overlay"></div>
    </div>
    
    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title fade-in">
          Soluciones LED de
          <span class="gradient-text">Vanguardia</span>
        </h1>
        <p class="hero-subtitle fade-in">
          Más de 10 años transformando espacios con tecnología LED de última generación
        </p>
        <div class="hero-cta fade-in">
          <a href="#contacto" class="btn btn-primary btn-lg">
            <span>Cotizar Proyecto</span>
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </a>
          <a href="#nosotros" class="btn btn-secondary btn-lg">
            Conocer Más
          </a>
        </div>
        
        <div class="hero-stats">
          <div class="stat-item">
            <div class="stat-number">10+</div>
            <div class="stat-label">Años de experiencia</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">100+</div>
            <div class="stat-label">Clientes satisfechos</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Soporte técnico</div>
          </div>
        </div>
      </div>
    </div>

    <div class="scroll-indicator">
      <div class="scroll-arrow"></div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding-top: 70px;
  overflow: hidden;
}

.hero-background {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, #0066CC 0%, #4A90E2 100%);
  z-index: -2;
}

.hero-background::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: 
    radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
  animation: float 20s ease-in-out infinite;
}

@keyframes float {
  0%, 100% {
    transform: translate(0, 0);
  }
  50% {
    transform: translate(20px, 20px);
  }
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.2);
  z-index: -1;
}

.hero-content {
  text-align: center;
  color: var(--white);
  max-width: 900px;
  margin: 0 auto;
  padding: var(--spacing-2xl) 0;
}

.hero-title {
  font-size: 2.5rem;
  font-weight: 800;
  line-height: 1.1;
  margin-bottom: var(--spacing-lg);
  color: var(--white);
  animation-delay: 0.1s;
}

.gradient-text {
  display: block;
  background: linear-gradient(90deg, #FFFFFF 0%, #E8F4FF 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-subtitle {
  font-size: var(--font-size-lg);
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: var(--spacing-xl);
  line-height: 1.6;
  animation-delay: 0.2s;
}

.hero-cta {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-md);
  margin-bottom: var(--spacing-2xl);
  animation-delay: 0.3s;
}

.hero-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: var(--spacing-lg);
  margin-top: var(--spacing-2xl);
  padding-top: var(--spacing-2xl);
  border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-item {
  text-align: center;
}

.stat-number {
  font-size: var(--font-size-3xl);
  font-weight: 800;
  color: var(--white);
  margin-bottom: var(--spacing-xs);
}

.stat-label {
  font-size: var(--font-size-sm);
  color: rgba(255, 255, 255, 0.8);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.scroll-indicator {
  position: absolute;
  bottom: var(--spacing-xl);
  left: 50%;
  transform: translateX(-50%);
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translate(-50%, 0);
  }
  40% {
    transform: translate(-50%, -10px);
  }
  60% {
    transform: translate(-50%, -5px);
  }
}

.scroll-arrow {
  width: 24px;
  height: 24px;
  border-bottom: 2px solid var(--white);
  border-right: 2px solid var(--white);
  transform: rotate(45deg);
  opacity: 0.7;
}

/* Tablet */
@media (min-width: 768px) {
  .hero {
    padding-top: 80px;
  }

  .hero-title {
    font-size: 3.5rem;
  }

  .hero-subtitle {
    font-size: var(--font-size-xl);
  }

  .hero-cta {
    flex-direction: row;
    justify-content: center;
  }

  .hero-stats {
    grid-template-columns: repeat(3, 1fr);
  }
}

/* Desktop */
@media (min-width: 1024px) {
  .hero-title {
    font-size: 4.5rem;
  }

  .hero-subtitle {
    font-size: var(--font-size-2xl);
  }

  .stat-number {
    font-size: var(--font-size-4xl);
  }
}
</style>
