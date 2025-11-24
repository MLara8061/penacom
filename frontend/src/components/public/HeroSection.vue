<template>
  <section id="inicio" class="hero">
    <div class="hero-slider">
      <transition name="fade" mode="out-in">
        <div 
          :key="currentSlide"
          class="slide"
          :style="{ background: slides[currentSlide].gradient }"
        >
          <div class="slide-overlay"></div>
          <div class="slide-content">
            <h1 class="hero-title">{{ slides[currentSlide].title }}</h1>
            <p class="hero-subtitle">{{ slides[currentSlide].subtitle }}</p>
            <div class="hero-cta">
              <a href="#contacto" class="btn-primary">Solicitar cotización</a>
              <a href="#productos" class="btn-link">Ver productos →</a>
            </div>
          </div>
        </div>
      </transition>
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
  width: 100%;
  height: 100vh;
  position: relative;
  overflow: hidden;
  margin: 0;
  padding: 0;
}

.hero-slider {
  width: 100%;
  height: 100%;
  position: relative;
}

.slide {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 0;
  left: 0;
}

.slide-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3);
  z-index: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.8s ease;
}

.fade-enter-from {
  opacity: 0;
}

.fade-leave-to {
  opacity: 0;
}

.slide-content {
  position: relative;
  z-index: 1;
  text-align: center;
  max-width: 980px;
  padding: 0 24px;
  color: #fff;
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
  color: rgba(255, 255, 255, 0.9);
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
  background: #fff;
  color: #0066CC;
  padding: 14px 28px;
  border-radius: 980px;
  font-size: 1.0625rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
  border: none;
}

.btn-primary:hover {
  background: rgba(255, 255, 255, 0.9);
  transform: scale(1.02);
}

.btn-link {
  color: #fff;
  font-size: 1.0625rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
}

.btn-link:hover {
  color: rgba(255, 255, 255, 0.8);
}

.slider-indicators {
  position: absolute;
  bottom: 40px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 12px;
  z-index: 10;
}

.indicator {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.4);
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  padding: 0;
}

.indicator:hover {
  background: rgba(255, 255, 255, 0.6);
}

.indicator.active {
  background: #fff;
  width: 32px;
  border-radius: 5px;
}

@media (max-width: 768px) {
  .hero {
    height: 70vh;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .hero-subtitle {
    font-size: 1.125rem;
  }
  
  .slider-indicators {
    bottom: 24px;
  }
}
</style>
