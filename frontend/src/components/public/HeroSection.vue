<template>
  <section id="inicio" class="hero">
    <div class="hero-slider">
      <div 
        v-for="(slide, index) in slides" 
        :key="index"
        class="slide"
        :class="{ active: currentSlide === index }"
        :style="{ backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), ${slide.gradient}` }"
      >
        <div class="slide-content">
          <h1 class="hero-title">{{ slide.title }}</h1>
          <p class="hero-subtitle">{{ slide.subtitle }}</p>
          <div class="hero-cta">
            <a href="#contacto" class="btn-primary">Solicitar cotización</a>
            <a href="#productos" class="btn-link">Ver productos →</a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="slider-indicators">
      <button 
        v-for="(slide, index) in slides" 
        :key="index"
        @click="goToSlide(index)"
        class="indicator"
        :class="{ active: currentSlide === index }"
        :aria-label="`Ir a slide ${index + 1}`"
      ></button>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const currentSlide = ref(0)
let intervalId = null

const slides = [
  {
    title: 'Tecnología LED de última generación',
    subtitle: 'Pantallas profesionales para transformar tu negocio',
    gradient: 'linear-gradient(135deg, #0066CC 0%, #003d7a 100%)'
  },
  {
    title: 'Soluciones para espacios interiores',
    subtitle: 'Alta resolución y calidad de imagen excepcional',
    gradient: 'linear-gradient(135deg, #4A90E2 0%, #2563eb 100%)'
  },
  {
    title: 'Pantallas LED para exteriores',
    subtitle: 'Resistentes y visibles bajo cualquier condición',
    gradient: 'linear-gradient(135deg, #1e40af 0%, #0066CC 100%)'
  }
]

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.length
}

const goToSlide = (index) => {
  currentSlide.value = index
  // Reiniciar el intervalo al cambiar manualmente
  if (intervalId) {
    clearInterval(intervalId)
    intervalId = setInterval(nextSlide, 5000)
  }
}

onMounted(() => {
  intervalId = setInterval(nextSlide, 5000)
})

onUnmounted(() => {
  if (intervalId) {
    clearInterval(intervalId)
  }
})
</script>

<style scoped>
.hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #000;
  color: #fff;
  position: relative;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(circle at 50% 50%, rgba(0, 102, 204, 0.15) 0%, transparent 70%);
  z-index: 0;
}

.hero-content {
  position: relative;
  z-index: 1;
  text-align: center;
  max-width: 980px;
  padding: 0 24px;
}

.hero-title {
  font-size: clamp(2.5rem, 7vw, 5rem);
  font-weight: 600;
  line-height: 1.08;
  margin-bottom: 24px;
  letter-spacing: -0.03em;
}

.hero-subtitle {
  font-size: clamp(1.25rem, 2.5vw, 1.75rem);
  font-weight: 400;
  color: rgba(255, 255, 255, 0.65);
  margin-bottom: 48px;
  line-height: 1.4;
}

.hero-cta {
  display: flex;
  gap: 24px;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}

.btn-primary {
  background: #0066CC;
  color: #fff;
  padding: 14px 28px;
  border-radius: 980px;
  font-size: 1.0625rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
  border: none;
}

.btn-primary:hover {
  background: #0052a3;
  transform: scale(1.02);
}

.btn-link {
  color: #0066CC;
  font-size: 1.0625rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
}

.btn-link:hover {
  color: #4A90E2;
}

@media (max-width: 768px) {
  .hero {
    min-height: 70vh;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .hero-subtitle {
    font-size: 1.125rem;
  }
}
</style>
