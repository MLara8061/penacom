<template>
  <div class="landing-page">
    <!-- Navbar -->
    <nav class="navbar" :class="{ 'scrolled': isScrolled }">
      <div class="nav-container">
        <div class="nav-logo">
          <span class="logo-text">PenaCom</span>
        </div>
        <ul class="nav-menu" :class="{ 'active': isMobileMenuOpen }">
          <li><a href="#inicio" @click="closeMobileMenu">Inicio</a></li>
          <li><a href="#servicios" @click="closeMobileMenu">Servicios</a></li>
          <li><a href="#nosotros" @click="closeMobileMenu">Nosotros</a></li>
          <li><a href="#portafolio" @click="closeMobileMenu">Portafolio</a></li>
          <li><a href="#testimonios" @click="closeMobileMenu">Testimonios</a></li>
          <li><a href="#contacto" @click="closeMobileMenu">Contacto</a></li>
        </ul>
        <button class="btn-nav">Comenzar</button>
        <div class="hamburger" @click="toggleMobileMenu" :class="{ 'active': isMobileMenuOpen }">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </nav>

    <!-- Hero Slider Section -->
    <section class="hero-slider" id="inicio">
      <div class="slider-container">
        <div class="slide" v-for="(slide, index) in slides" :key="index" 
             :class="{ 'active': currentSlide === index }">
          <div class="slide-overlay"></div>
          <div class="slide-content">
            <div class="container">
              <h1 class="slide-title" v-html="slide.title"></h1>
              <p class="slide-subtitle">{{ slide.subtitle }}</p>
              <div class="slide-buttons">
                <button class="btn btn-primary">{{ slide.cta }}</button>
                <button class="btn btn-outline">Conocer Más</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Slider Controls -->
      <div class="slider-controls">
        <button class="slider-arrow prev" @click="prevSlide">‹</button>
        <button class="slider-arrow next" @click="nextSlide">›</button>
      </div>
      
      <!-- Slider Indicators -->
      <div class="slider-indicators">
        <span v-for="(slide, index) in slides" :key="index" 
              @click="goToSlide(index)"
              :class="{ 'active': currentSlide === index }"></span>
      </div>
    </section>

    <!-- Features Section -->
    <section class="services" id="servicios">
      <div class="container">
        <div class="section-header">
          <span class="section-label">Nuestros Servicios</span>
          <h2>Soluciones Completas Para Tu Negocio</h2>
          <p>Ofrecemos servicios especializados que impulsan el crecimiento de tu empresa</p>
        </div>
        <div class="services-grid">
          <div class="service-card" v-for="service in services" :key="service.id">
            <div class="service-icon" :style="{ background: service.color }">
              <span>{{ service.icon }}</span>
            </div>
            <h3>{{ service.title }}</h3>
            <p>{{ service.description }}</p>
            <a href="#" class="service-link">Leer más →</a>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about" id="nosotros">
      <div class="container">
        <div class="about-grid">
          <div class="about-image">
            <div class="image-placeholder">
              <div class="about-badge">
                <div class="badge-number">10+</div>
                <div class="badge-text">Años de<br>Experiencia</div>
              </div>
            </div>
          </div>
          <div class="about-content">
            <span class="section-label">Sobre Nosotros</span>
            <h2>Transformamos Ideas En Soluciones Digitales</h2>
            <p>Somos un equipo de profesionales dedicados a ofrecer soluciones tecnológicas de vanguardia. Nuestra misión es ayudar a las empresas a alcanzar su máximo potencial a través de la innovación digital.</p>
            <div class="about-features">
              <div class="about-feature">
                <div class="feature-number">500+</div>
                <div class="feature-label">Proyectos Completados</div>
              </div>
              <div class="about-feature">
                <div class="feature-number">98%</div>
                <div class="feature-label">Satisfacción del Cliente</div>
              </div>
            </div>
            <button class="btn btn-primary">Conocer Equipo</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Portfolio Section -->
    <section class="portfolio" id="portafolio">
      <div class="container">
        <div class="section-header">
          <span class="section-label">Portafolio</span>
          <h2>Proyectos Destacados</h2>
          <p>Algunos de nuestros trabajos más recientes</p>
        </div>
        <div class="portfolio-grid">
          <div class="portfolio-item" v-for="project in projects" :key="project.id">
            <div class="portfolio-image">
              <div class="portfolio-overlay">
                <h3>{{ project.title }}</h3>
                <p>{{ project.category }}</p>
                <a href="#" class="portfolio-btn">Ver Proyecto →</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
      <div class="container">
        <div class="stats-grid">
          <div class="stat-item" v-for="stat in stats" :key="stat.label">
            <div class="stat-icon">{{ stat.icon }}</div>
            <div class="stat-number">{{ stat.number }}</div>
            <div class="stat-label">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonios">
      <div class="container">
        <div class="section-header">
          <span class="section-label">Testimonios</span>
          <h2>Lo Que Dicen Nuestros Clientes</h2>
        </div>
        <div class="testimonials-grid">
          <div class="testimonial-card" v-for="testimonial in testimonials" :key="testimonial.id">
            <div class="testimonial-stars">★★★★★</div>
            <p class="testimonial-text">"{{ testimonial.text }}"</p>
            <div class="testimonial-author">
              <div class="author-avatar">{{ testimonial.avatar }}</div>
              <div class="author-info">
                <div class="author-name">{{ testimonial.name }}</div>
                <div class="author-position">{{ testimonial.position }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contacto">
      <div class="container">
        <div class="cta-content">
          <h2>¿Listo Para Comenzar Tu Proyecto?</h2>
          <p>Contáctanos hoy y descubre cómo podemos ayudarte a alcanzar tus objetivos</p>
          <div class="cta-buttons">
            <button class="btn btn-white">Contactar Ahora</button>
            <button class="btn btn-outline-white">Ver Planes</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-section">
            <h3 class="footer-logo">PenaCom</h3>
            <p>Transformando ideas en realidad digital desde 2015</p>
            <div class="social-links">
              <a href="#" aria-label="Facebook">f</a>
              <a href="#" aria-label="Twitter">t</a>
              <a href="#" aria-label="LinkedIn">in</a>
              <a href="#" aria-label="Instagram">ig</a>
            </div>
          </div>
          <div class="footer-section">
            <h4>Servicios</h4>
            <ul>
              <li><a href="#">Desarrollo Web</a></li>
              <li><a href="#">Apps Móviles</a></li>
              <li><a href="#">Consultoría</a></li>
              <li><a href="#">Marketing Digital</a></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>Empresa</h4>
            <ul>
              <li><a href="#">Sobre Nosotros</a></li>
              <li><a href="#">Equipo</a></li>
              <li><a href="#">Carreras</a></li>
              <li><a href="#">Blog</a></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>Contacto</h4>
            <ul>
              <li>📧 info@penacom.com</li>
              <li>📞 +1 (555) 123-4567</li>
              <li>📍 123 Business St, Suite 100</li>
              <li>Ciudad, País 12345</li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 PenaCom. Todos los derechos reservados.</p>
          <div class="footer-links">
            <a href="#">Política de Privacidad</a>
            <a href="#">Términos de Servicio</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

// Navbar scroll state
const isScrolled = ref(false)
const isMobileMenuOpen = ref(false)

// Hero Slider
const currentSlide = ref(0)
const slides = ref([
  {
    title: 'Soluciones <span class="text-highlight">Digitales</span> Innovadoras',
    subtitle: 'Transformamos tu visión en realidad con tecnología de vanguardia',
    cta: 'Comenzar Ahora'
  },
  {
    title: 'Desarrollo Web <span class="text-highlight">Profesional</span>',
    subtitle: 'Creamos experiencias digitales excepcionales que impulsan tu negocio',
    cta: 'Ver Servicios'
  },
  {
    title: 'Consultoría <span class="text-highlight">Estratégica</span>',
    subtitle: 'Optimiza tus procesos con nuestro equipo de expertos',
    cta: 'Agendar Consulta'
  }
])

// Services
const services = ref([
  {
    id: 1,
    icon: '💻',
    title: 'Desarrollo Web',
    description: 'Sitios web modernos, responsivos y optimizados para SEO que convierten visitantes en clientes.',
    color: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'
  },
  {
    id: 2,
    icon: '📱',
    title: 'Apps Móviles',
    description: 'Aplicaciones nativas y multiplataforma de alto rendimiento para iOS y Android.',
    color: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'
  },
  {
    id: 3,
    icon: '🎨',
    title: 'Diseño UI/UX',
    description: 'Interfaces intuitivas y atractivas centradas en la experiencia del usuario.',
    color: 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
  },
  {
    id: 4,
    icon: '🚀',
    title: 'Marketing Digital',
    description: 'Estrategias de marketing digital que aumentan tu presencia online y ventas.',
    color: 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'
  },
  {
    id: 5,
    icon: '🔒',
    title: 'Ciberseguridad',
    description: 'Protección integral de tus datos y sistemas contra amenazas digitales.',
    color: 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'
  },
  {
    id: 6,
    icon: '☁️',
    title: 'Cloud Solutions',
    description: 'Migración y gestión de infraestructura en la nube para escalabilidad.',
    color: 'linear-gradient(135deg, #30cfd0 0%, #330867 100%)'
  }
])

// Projects
const projects = ref([
  { id: 1, title: 'E-commerce Platform', category: 'Desarrollo Web' },
  { id: 2, title: 'Banking App', category: 'App Móvil' },
  { id: 3, title: 'Dashboard Analytics', category: 'UI/UX Design' },
  { id: 4, title: 'Corporate Website', category: 'Desarrollo Web' },
  { id: 5, title: 'Fitness App', category: 'App Móvil' },
  { id: 6, title: 'CRM System', category: 'Sistema Web' }
])

// Stats
const stats = ref([
  { icon: '👥', number: '500+', label: 'Clientes Satisfechos' },
  { icon: '🏆', number: '1,200+', label: 'Proyectos Completados' },
  { icon: '⭐', number: '98%', label: 'Satisfacción' },
  { icon: '🌍', number: '25+', label: 'Países' }
])

// Testimonials
const testimonials = ref([
  {
    id: 1,
    text: 'Excelente trabajo. El equipo de PenaCom superó nuestras expectativas y entregó un producto de calidad excepcional.',
    name: 'María González',
    position: 'CEO, TechStart',
    avatar: 'MG'
  },
  {
    id: 2,
    text: 'Profesionales, eficientes y creativos. Recomiendo ampliamente sus servicios de desarrollo.',
    name: 'Carlos Ramírez',
    position: 'Director, InnovateCo',
    avatar: 'CR'
  },
  {
    id: 3,
    text: 'La mejor inversión que hemos hecho. Nuestra app ha sido un éxito rotundo gracias a su trabajo.',
    name: 'Ana Martínez',
    position: 'Fundadora, HealthApp',
    avatar: 'AM'
  }
])

// Slider functions
const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.value.length
}

const prevSlide = () => {
  currentSlide.value = currentSlide.value === 0 ? slides.value.length - 1 : currentSlide.value - 1
}

const goToSlide = (index: number) => {
  currentSlide.value = index
}

// Auto-play slider
let sliderInterval: number | undefined

const startSlider = () => {
  sliderInterval = window.setInterval(() => {
    nextSlide()
  }, 5000)
}

const stopSlider = () => {
  if (sliderInterval) {
    clearInterval(sliderInterval)
  }
}

// Scroll handler
const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

// Mobile menu
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

// Lifecycle
onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  startSlider()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  stopSlider()
})
</script>

<style scoped>
<style scoped>
/* Variables de Color - Paleta Azul */
:root {
  --primary-blue: #0066CC;
  --light-blue: #4A90E2;
  --dark-blue: #003D82;
  --white: #FFFFFF;
  --light-gray: #F5F7FA;
  --gray: #8B95A5;
  --dark-gray: #2C3E50;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.landing-page {
  width: 100%;
  overflow-x: hidden;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  color: var(--dark-gray);
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

/* ===== NAVBAR ===== */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  background: transparent;
  padding: 20px 0;
  transition: all 0.3s ease;
}

.navbar.scrolled {
  background: var(--white);
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
  padding: 15px 0;
}

.nav-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.nav-logo .logo-text {
  font-size: 24px;
  font-weight: 700;
  color: var(--white);
  letter-spacing: -0.5px;
}

.navbar.scrolled .logo-text {
  color: var(--primary-blue);
}

.nav-menu {
  display: flex;
  list-style: none;
  gap: 40px;
  align-items: center;
}

.nav-menu li a {
  color: var(--white);
  text-decoration: none;
  font-weight: 500;
  font-size: 15px;
  transition: color 0.3s ease;
}

.navbar.scrolled .nav-menu li a {
  color: var(--dark-gray);
}

.nav-menu li a:hover {
  color: var(--light-blue);
}

.btn-nav {
  background: var(--white);
  color: var(--primary-blue);
  padding: 10px 25px;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.navbar.scrolled .btn-nav {
  background: var(--primary-blue);
  color: var(--white);
}

.btn-nav:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
}

.hamburger {
  display: none;
  flex-direction: column;
  cursor: pointer;
  gap: 5px;
}

.hamburger span {
  width: 25px;
  height: 3px;
  background: var(--white);
  transition: all 0.3s ease;
}

.navbar.scrolled .hamburger span {
  background: var(--primary-blue);
}

/* ===== HERO SLIDER ===== */
.hero-slider {
  position: relative;
  height: 100vh;
  overflow: hidden;
}

.slider-container {
  position: relative;
  width: 100%;
  height: 100%;
}

.slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  transition: opacity 1s ease-in-out;
  background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 50%, var(--light-blue) 100%);
}

.slide.active {
  opacity: 1;
}

.slide-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.3);
}

.slide-content {
  position: relative;
  height: 100%;
  display: flex;
  align-items: center;
  z-index: 2;
}

.slide-title {
  font-size: 4rem;
  font-weight: 800;
  color: var(--white);
  line-height: 1.2;
  margin-bottom: 20px;
  letter-spacing: -1px;
}

.text-highlight {
  color: var(--light-blue);
}

.slide-subtitle {
  font-size: 1.3rem;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 40px;
  max-width: 600px;
}

.slide-buttons {
  display: flex;
  gap: 20px;
}

.btn {
  padding: 15px 35px;
  font-size: 16px;
  font-weight: 600;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-primary {
  background: var(--white);
  color: var(--primary-blue);
}

.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
}

.btn-outline {
  background: transparent;
  color: var(--white);
  border: 2px solid var(--white);
}

.btn-outline:hover {
  background: var(--white);
  color: var(--primary-blue);
}

/* Slider Controls */
.slider-controls {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  padding: 0 30px;
  z-index: 10;
}

.slider-arrow {
  width: 50px;
  height: 50px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  color: var(--white);
  font-size: 24px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.slider-arrow:hover {
  background: rgba(255, 255, 255, 0.4);
  transform: scale(1.1);
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

.slider-indicators span {
  width: 12px;
  height: 12px;
  background: rgba(255, 255, 255, 0.5);
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.3s ease;
}

.slider-indicators span.active {
  background: var(--white);
  width: 40px;
  border-radius: 6px;
}

/* ===== SECTIONS ===== */
.section-header {
  text-align: center;
  margin-bottom: 60px;
}

.section-label {
  display: inline-block;
  color: var(--primary-blue);
  font-weight: 600;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 15px;
}

.section-header h2 {
  font-size: 2.5rem;
  color: var(--dark-gray);
  margin-bottom: 15px;
  font-weight: 700;
}

.section-header p {
  font-size: 1.1rem;
  color: var(--gray);
  max-width: 600px;
  margin: 0 auto;
}

/* ===== SERVICES ===== */
.services {
  padding: 100px 20px;
  background: var(--light-gray);
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 30px;
}

.service-card {
  background: var(--white);
  padding: 40px;
  border-radius: 12px;
  transition: all 0.3s ease;
  border: 1px solid #E2E8F0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.service-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 102, 204, 0.1);
  border-color: var(--light-blue);
}

.service-icon {
  width: 70px;
  height: 70px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  margin-bottom: 25px;
}

.service-card h3 {
  font-size: 1.5rem;
  color: var(--dark-gray);
  margin-bottom: 15px;
}

.service-card p {
  color: var(--gray);
  line-height: 1.7;
  margin-bottom: 20px;
}

.service-link {
  color: var(--primary-blue);
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.service-link:hover {
  color: var(--light-blue);
}

/* ===== ABOUT ===== */
.about {
  padding: 100px 20px;
  background: var(--white);
}

.about-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}

.about-image {
  position: relative;
}

.image-placeholder {
  width: 100%;
  height: 500px;
  background: linear-gradient(135deg, var(--light-blue) 0%, var(--primary-blue) 100%);
  border-radius: 12px;
  position: relative;
  box-shadow: 0 10px 40px rgba(0, 102, 204, 0.2);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.about-badge {
  position: absolute;
  bottom: -30px;
  right: -30px;
  background: var(--white);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  text-align: center;
}

.badge-number {
  font-size: 3rem;
  font-weight: 800;
  color: var(--primary-blue);
  line-height: 1;
}

.badge-text {
  font-size: 0.9rem;
  color: var(--gray);
  margin-top: 10px;
}

.about-content h2 {
  font-size: 2.5rem;
  color: var(--dark-gray);
  margin-bottom: 20px;
  line-height: 1.3;
}

.about-content > p {
  color: var(--gray);
  line-height: 1.8;
  margin-bottom: 30px;
}

.about-features {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
  margin-bottom: 40px;
}

.about-feature {
  text-align: center;
  padding: 20px;
  background: var(--white);
  border-radius: 8px;
  border: 1px solid #E2E8F0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.feature-number {
  font-size: 2.5rem;
  font-weight: 800;
  color: var(--primary-blue);
}

.feature-label {
  color: var(--gray);
  margin-top: 10px;
  font-size: 0.9rem;
}

/* ===== PORTFOLIO ===== */
.portfolio {
  padding: 100px 20px;
  background: var(--white);
}

.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
}

.portfolio-item {
  border-radius: 12px;
  overflow: hidden;
  cursor: pointer;
  border: 1px solid #E2E8F0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.portfolio-item:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  transform: translateY(-5px);
}

.portfolio-image {
  width: 100%;
  height: 350px;
  background: linear-gradient(135deg, var(--dark-blue) 0%, var(--light-blue) 100%);
  position: relative;
  border-radius: 12px;
  overflow: hidden;
}

.portfolio-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 61, 130, 0.95);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
  padding: 30px;
  text-align: center;
}

.portfolio-item:hover .portfolio-overlay {
  opacity: 1;
}

.portfolio-overlay h3 {
  color: var(--white);
  font-size: 1.8rem;
  margin-bottom: 10px;
}

.portfolio-overlay p {
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 20px;
}

.portfolio-btn {
  color: var(--white);
  text-decoration: none;
  font-weight: 600;
  border: 2px solid var(--white);
  padding: 10px 25px;
  border-radius: 6px;
  transition: all 0.3s ease;
}

.portfolio-btn:hover {
  background: var(--white);
  color: var(--primary-blue);
}

/* ===== STATS ===== */
.stats {
  padding: 80px 20px;
  background: var(--primary-blue);
  color: var(--white);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
}

.stat-item {
  text-align: center;
}

.stat-icon {
  font-size: 3rem;
  margin-bottom: 15px;
}

.stat-number {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 10px;
}

.stat-label {
  font-size: 1.1rem;
  opacity: 0.9;
}

/* ===== TESTIMONIALS ===== */
.testimonials {
  padding: 100px 20px;
  background: var(--light-gray);
}

.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 30px;
}

.testimonial-card {
  background: var(--white);
  padding: 40px;
  border-radius: 12px;
  transition: all 0.3s ease;
  border: 1px solid #E2E8F0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.testimonial-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.testimonial-stars {
  color: #FFB800;
  font-size: 1.2rem;
  margin-bottom: 20px;
}

.testimonial-text {
  color: var(--dark-gray);
  line-height: 1.7;
  margin-bottom: 25px;
  font-style: italic;
}

.testimonial-author {
  display: flex;
  align-items: center;
  gap: 15px;
}

.author-avatar {
  width: 50px;
  height: 50px;
  background: var(--primary-blue);
  color: var(--white);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

.author-name {
  font-weight: 600;
  color: var(--dark-gray);
}

.author-position {
  font-size: 0.9rem;
  color: var(--gray);
}

/* ===== CTA ===== */
.cta {
  padding: 100px 20px;
  background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
  color: var(--white);
  text-align: center;
}

.cta-content h2 {
  font-size: 2.8rem;
  margin-bottom: 20px;
}

.cta-content p {
  font-size: 1.2rem;
  margin-bottom: 40px;
  opacity: 0.9;
}

.cta-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-white {
  background: var(--white);
  color: var(--primary-blue);
}

.btn-white:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
}

.btn-outline-white {
  background: transparent;
  color: var(--white);
  border: 2px solid var(--white);
}

.btn-outline-white:hover {
  background: var(--white);
  color: var(--primary-blue);
}

/* ===== FOOTER ===== */
.footer {
  background: #1a2332;
  color: var(--white);
  padding: 60px 20px 20px;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
  margin-bottom: 40px;
}

.footer-logo {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 15px;
  color: var(--light-blue);
}

.footer-section p {
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.7;
  margin-bottom: 20px;
}

.footer-section h4 {
  margin-bottom: 20px;
  font-size: 1.1rem;
}

.footer-section ul {
  list-style: none;
}

.footer-section li {
  margin-bottom: 12px;
  color: rgba(255, 255, 255, 0.7);
}

.footer-section a {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-section a:hover {
  color: var(--light-blue);
}

.social-links {
  display: flex;
  gap: 15px;
}

.social-links a {
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.social-links a:hover {
  background: var(--primary-blue);
  transform: translateY(-3px);
}

.footer-bottom {
  padding-top: 30px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 20px;
}

.footer-bottom p {
  color: rgba(255, 255, 255, 0.5);
}

.footer-links {
  display: flex;
  gap: 30px;
}

.footer-links a {
  color: rgba(255, 255, 255, 0.5);
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: var(--light-blue);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 968px) {
  .nav-menu {
    position: fixed;
    left: -100%;
    top: 70px;
    flex-direction: column;
    background: var(--white);
    width: 100%;
    text-align: center;
    transition: 0.3s;
    box-shadow: 0 10px 27px rgba(0, 0, 0, 0.05);
    padding: 30px 0;
  }

  .nav-menu.active {
    left: 0;
  }

  .nav-menu li a {
    color: var(--dark-gray) !important;
  }

  .hamburger {
    display: flex;
  }

  .btn-nav {
    display: none;
  }

  .slide-title {
    font-size: 2.5rem;
  }

  .slide-subtitle {
    font-size: 1.1rem;
  }

  .about-grid {
    grid-template-columns: 1fr;
  }

  .section-header h2 {
    font-size: 2rem;
  }

  .footer-bottom {
    flex-direction: column;
    text-align: center;
  }
}

@media (max-width: 640px) {
  .slide-buttons {
    flex-direction: column;
  }

  .btn {
    width: 100%;
  }

  .slider-controls {
    padding: 0 10px;
  }

  .slider-arrow {
    width: 40px;
    height: 40px;
    font-size: 18px;
  }

  .about-badge {
    right: 10px;
    bottom: -20px;
  }
}
</style>
