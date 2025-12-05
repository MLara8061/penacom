<template>
  <div class="landing-page">
    <!-- Mobile Menu Overlay -->
    <div
      class="mobile-overlay"
      :class="{ active: isMobileMenuOpen }"
      @click="closeMobileMenu"
    ></div>

    <!-- Navbar -->
    <nav class="navbar" :class="{ scrolled: isScrolled }">
      <div class="nav-container">
        <div class="nav-logo">
          <img src="/logo.png" alt="PenaCom Logo" class="logo-image" />
        </div>
        <ul class="nav-menu" :class="{ active: isMobileMenuOpen }">
          <li><a href="#inicio" @click="closeMobileMenu">Inicio</a></li>
          <li><a href="#servicios" @click="closeMobileMenu">Servicios</a></li>
          <li><a href="#nosotros" @click="closeMobileMenu">Nosotros</a></li>
          <li><a href="#portafolio" @click="closeMobileMenu">Portafolio</a></li>
          <li><a href="#testimonios" @click="closeMobileMenu">Testimonios</a></li>
        </ul>
        <div class="nav-actions">
          <ThemeSwitcher />
          <button class="btn-nav" @click="scrollToContact">Contáctanos</button>
        </div>
        <div class="hamburger" @click="toggleMobileMenu" :class="{ active: isMobileMenuOpen }">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </nav>

    <!-- Hero Slider Section -->
    <section class="hero-slider" id="inicio">
      <div class="slider-container">
        <div
          class="slide"
          v-for="(slide, index) in slides"
          :key="index"
          :class="{ active: currentSlide === index }"
          :style="{ backgroundImage: `url(${slide.image})` }"
        >
          <div class="slide-overlay"></div>
          <div class="slide-content">
            <div class="container">
              <h1 class="slide-title" v-html="slide.title"></h1>
              <p class="slide-subtitle">{{ slide.subtitle }}</p>
              <div class="slide-buttons">
                <button class="btn btn-primary">{{ slide.cta }}</button>
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
        <span
          v-for="(slide, index) in slides"
          :key="index"
          @click="goToSlide(index)"
          :class="{ active: currentSlide === index }"
        ></span>
      </div>
    </section>

    <!-- About Section -->
    <section class="about" id="nosotros">
      <div class="container">
        <div class="about-grid">
          <div class="about-image">
            <div
              class="image-placeholder"
              :style="{
                backgroundImage: `url(${aboutSection.current_image})`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
              }"
            >
              <div class="about-badge">
                <div class="badge-number">{{ aboutSection.years_experience }}+</div>
                <div class="badge-text">Años de<br />Experiencia</div>
              </div>
            </div>
          </div>
          <div class="about-content">
            <span class="section-label">¿Quiénes Somos?</span>
            <h2>{{ aboutSection.title }}</h2>
            <p style="white-space: pre-wrap">{{ aboutSection.description }}</p>
            <p
              class="about-highlight"
              v-if="aboutSection.highlighted_text"
              style="white-space: pre-wrap"
            >
              {{ aboutSection.highlighted_text }}
            </p>
            <div class="about-features">
              <div class="about-feature">
                <div class="feature-number">{{ aboutSection.happy_clients }}+</div>
                <div class="feature-label">Clientes Satisfechos</div>
              </div>
              <div class="about-feature">
                <div class="feature-number">{{ aboutSection.years_experience }}+</div>
                <div class="feature-label">Años de Experiencia</div>
              </div>
            </div>
            <button class="btn btn-primary btn-about">Solicitar Cotización</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="services" id="servicios">
      <div class="container">
        <div class="section-header">
          <span class="section-label">Conoce más sobre nosotros</span>
          <h2 class="products-title">Nuestros Productos y Servicios</h2>
        </div>

        <!-- Productos -->
        <div class="services-section">
          <h3 class="services-subtitle products-title">Nuestros Productos</h3>
          <div v-if="isLoadingProducts" class="loading-state">
            <p>Cargando productos...</p>
          </div>
          <div v-else-if="products.length === 0" class="empty-state">
            <p>No hay productos disponibles</p>
          </div>
          <div v-else class="services-grid">
            <div v-for="product in products" :key="product.id" class="service-card glass-card">
              <div
                class="service-image"
                :style="{
                  backgroundImage: product.image
                    ? `url(${product.image})`
                    : 'url(\'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80\')',
                }"
              >
                <div class="service-icon-wrapper">
                  <div class="service-icon-emoji">{{ product.icon || '📦' }}</div>
                </div>
              </div>
              <h3>{{ product.name }}</h3>
              <p style="white-space: pre-wrap">{{ product.description }}</p>
            </div>
          </div>
          <div class="section-cta">
            <button class="btn btn-primary">Solicitar Cotización</button>
          </div>
        </div>

        <!-- Servicios -->
        <div class="services-section" style="margin-top: 80px">
          <h3 class="services-subtitle products-title">Nuestros Servicios</h3>
          <div v-if="isLoadingServices" class="loading-state">
            <p>Cargando servicios...</p>
          </div>
          <div v-else-if="services.length === 0" class="empty-state">
            <p>No hay servicios disponibles</p>
          </div>
          <div v-else class="services-grid">
            <div v-for="service in services" :key="service.id" class="service-card glass-card">
              <div
                class="service-image"
                :style="{
                  backgroundImage: service.image
                    ? `url(${service.image})`
                    : 'url(\'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=600&q=80\')',
                }"
              >
                <div class="service-icon-wrapper">
                  <div class="service-icon-emoji">{{ service.icon || '⚙️' }}</div>
                </div>
              </div>
              <h3>{{ service.title }}</h3>
              <p style="white-space: pre-wrap">{{ service.description }}</p>
            </div>
          </div>
          <div class="section-cta">
            <button class="btn btn-primary">Solicitar Cotización</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Portfolio Section -->
    <section class="portfolio" id="portafolio">
      <div class="container-full">
        <div class="section-header">
          <span class="section-label">Conoce más</span>
          <h2>Señalización Digital LED</h2>
          <p>Descubre cómo la tecnología LED puede transformar tu negocio</p>
        </div>

        <div class="portfolio-slider">
          <div
            class="portfolio-slide"
            v-for="(slide, index) in portfolioSlides"
            :key="index"
            :class="{ active: currentPortfolioSlide === index }"
            :style="{ backgroundImage: `url(${slide.image})` }"
          >
            <div class="slide-overlay"></div>
            <div class="slide-content">
              <span class="slide-label">{{ slide.label }}</span>
              <h3 class="slide-title">{{ slide.title }}</h3>
              <p class="slide-description">{{ slide.description }}</p>
            </div>
          </div>

          <div class="portfolio-controls">
            <button class="nav-arrow prev" @click="prevPortfolioSlide">‹</button>
            <button class="nav-arrow next" @click="nextPortfolioSlide">›</button>
          </div>

          <div class="portfolio-dots">
            <span
              v-for="(slide, index) in portfolioSlides"
              :key="index"
              @click="goToPortfolioSlide(index)"
              :class="{ active: currentPortfolioSlide === index }"
            ></span>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
      <div class="container">
        <div class="stats-grid">
          <div class="stat-item" v-for="stat in stats" :key="stat.label">
            <div class="stat-icon-wrapper">
              <svg
                class="stat-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                v-html="stat.icon"
              ></svg>
            </div>
            <div class="stat-number">{{ stat.number }}</div>
            <div class="stat-label">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonios">
      <div class="container">
        <div class="testimonials-header">
          <div class="google-badge">
            <svg class="google-icon" viewBox="0 0 48 48">
              <path
                fill="#4285F4"
                d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"
              />
              <path
                fill="#34A853"
                d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"
              />
              <path
                fill="#FBBC05"
                d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24c0 3.55.85 6.91 2.34 9.88l7.35-5.7z"
              />
              <path
                fill="#EA4335"
                d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"
              />
            </svg>
            <div class="google-info">
              <h4>Peñacom</h4>
              <div class="google-rating">
                <span class="stars">★★★★★</span>
                <span class="rating-text">5.0 (300+ reseñas)</span>
              </div>
            </div>
          </div>
          <div class="section-header">
            <span class="section-label">Testimonios</span>
            <h2>Lo Que Dicen Nuestros Clientes</h2>
          </div>
        </div>

        <div class="testimonials-slider">
          <div
            class="testimonial-slide"
            v-for="(testimonial, index) in testimonials"
            :key="index"
            :class="{ active: currentTestimonial === index }"
          >
            <div class="testimonial-header">
              <img :src="testimonial.avatar" :alt="testimonial.name" class="testimonial-avatar" />
              <div class="testimonial-info">
                <h4 class="testimonial-name">{{ testimonial.name }}</h4>
                <div class="testimonial-stars">★★★★★</div>
              </div>
            </div>
            <p class="testimonial-text">"{{ testimonial.text }}"</p>
          </div>

          <div class="testimonial-controls">
            <button class="testimonial-arrow prev" @click="prevTestimonial">‹</button>
            <button class="testimonial-arrow next" @click="nextTestimonial">›</button>
          </div>

          <div class="testimonial-dots">
            <span
              v-for="(testimonial, index) in testimonials"
              :key="index"
              @click="goToTestimonial(index)"
              :class="{ active: currentTestimonial === index }"
            ></span>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contacto">
      <div class="container">
        <div class="cta-grid">
          <div class="cta-content">
            <div class="cta-badge">💡 Cotización Gratuita en 24h</div>
            <h2 class="hero-title">
              Transforma Tu Negocio Con Tecnología LED de Última Generación
            </h2>
            <p class="cta-subtitle">
              Únete a más de 100+ empresas que ya potenciaron su marca con nuestras soluciones
            </p>

            <div class="cta-benefits">
              <div class="benefit-item">
                <svg class="benefit-icon" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    stroke="currentColor"
                    stroke-width="2"
                  />
                </svg>
                <span>Instalación profesional incluida</span>
              </div>
              <div class="benefit-item">
                <svg class="benefit-icon" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    stroke="currentColor"
                    stroke-width="2"
                  />
                </svg>
                <span>Garantía extendida de 2 años</span>
              </div>
              <div class="benefit-item">
                <svg class="benefit-icon" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    stroke="currentColor"
                    stroke-width="2"
                  />
                </svg>
                <span>Soporte técnico 24/7</span>
              </div>
            </div>

            <div class="trust-indicators">
              <div class="trust-item">
                <span class="trust-number">12+</span>
                <span class="trust-label">Años de Experiencia</span>
              </div>
              <div class="trust-item">
                <span class="trust-number">5.0</span>
                <span class="trust-label">Calificación Google</span>
              </div>
              <div class="trust-item">
                <span class="trust-number">300+</span>
                <span class="trust-label">Proyectos Exitosos</span>
              </div>
            </div>
          </div>

          <div class="contact-form-wrapper">
            <form class="contact-form" @submit.prevent="handleSubmit">
              <h3>Solicita Tu Cotización</h3>
              <p class="form-subtitle">Respuesta en menos de 24 horas</p>

              <div class="form-group">
                <label for="name">Nombre Completo *</label>
                <input
                  type="text"
                  id="name"
                  v-model="formData.name"
                  placeholder="Juan Pérez"
                  required
                />
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="email">Email *</label>
                  <input
                    type="email"
                    id="email"
                    v-model="formData.email"
                    placeholder="juan@empresa.com"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="phone">Teléfono *</label>
                  <input
                    type="tel"
                    id="phone"
                    v-model="formData.phone"
                    placeholder="+52 998 123 4567"
                    required
                  />
                </div>
              </div>

              <div class="form-group">
                <label for="company">Empresa</label>
                <input
                  type="text"
                  id="company"
                  v-model="formData.company"
                  placeholder="Nombre de tu empresa (opcional)"
                />
              </div>

              <div class="form-group">
                <label for="service">Servicio de Interés *</label>
                <select id="service" v-model="formData.service" required>
                  <option value="">Selecciona un servicio</option>
                  <option value="pantallas-led">Pantallas LED</option>
                  <option value="video-wall">Video Wall</option>
                  <option value="senalizacion-digital">Señalización Digital</option>
                  <option value="renta-pantallas">Renta de Pantallas</option>
                  <option value="consultoria">Consultoría</option>
                  <option value="otro">Otro</option>
                </select>
              </div>

              <div class="form-group">
                <label for="message">Cuéntanos Sobre Tu Proyecto *</label>
                <textarea
                  id="message"
                  v-model="formData.message"
                  placeholder="Describe brevemente qué necesitas..."
                  rows="4"
                  required
                ></textarea>
              </div>

              <!-- Honeypot anti-bot field (invisible) -->
              <div class="honeypot" aria-hidden="true">
                <input
                  type="text"
                  id="website"
                  v-model="formData.honeypot"
                  tabindex="-1"
                  autocomplete="off"
                />
              </div>

              <button type="submit" class="btn-submit" :disabled="isSubmitting">
                <span v-if="!isSubmitting">Enviar</span>
                <span v-else>Enviando...</span>
                <svg
                  class="plane-icon"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <line x1="22" y1="2" x2="11" y2="13"></line>
                  <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
              </button>

              <p class="form-privacy">🔒 Tu información está segura y protegida</p>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-brand">
            <div class="footer-logo">
              <img :src="footerLogo" alt="PenaCom Logo" class="footer-logo-image" />
            </div>
            <p class="footer-tagline">{{ footerSlogan }}</p>
            <div class="social-links">
              <a
                v-for="(link, index) in footerSocialLinks"
                :key="`footer-social-${index}`"
                :href="link.url || '#'"
                class="social-link"
                :aria-label="link.label || 'Red social'"
                target="_blank"
                rel="noopener"
              >
                <span>{{ link.label || 'Síguenos' }}</span>
              </a>
            </div>
          </div>

          <div class="footer-section">
            <h4>Servicios</h4>
            <ul>
              <li><a href="#servicios">Pantallas LED</a></li>
              <li><a href="#servicios">Señalización Digital</a></li>
              <li><a href="#servicios">Instalación</a></li>
              <li><a href="#servicios">Mantenimiento</a></li>
            </ul>
          </div>

          <div class="footer-section">
            <h4>Empresa</h4>
            <ul>
              <li><a href="#nosotros">Sobre Nosotros</a></li>
              <li><a href="#portafolio">Portafolio</a></li>
              <li><a href="#testimonios">Testimonios</a></li>
              <li><a href="#contacto">Contacto</a></li>
            </ul>
          </div>

          <div class="footer-section">
            <h4>Contacto</h4>
            <ul class="contact-list">
              <li>
                <svg
                  class="contact-icon"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                  />
                </svg>
                <a :href="footerEmailHref" class="contact-link">{{ footerEmail }}</a>
              </li>
              <li>
                <svg
                  class="contact-icon"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                  />
                </svg>
                <a :href="footerPhoneHref" class="contact-link">{{ footerPhone }}</a>
              </li>
              <li>
                <svg
                  class="contact-icon"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                  />
                  <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ footerLocation }}</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="footer-bottom">
          <p>
            &copy; 2025 Peñacom. Todos los derechos reservados. | Powered by
            <a
              :href="whatsappContactLink"
              target="_blank"
              rel="noopener noreferrer"
              class="arla-link"
              >Arla</a
            >
          </p>
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
import ThemeSwitcher from '@/components/ThemeSwitcher.vue'
import { computed, onMounted, onUnmounted, ref } from 'vue'
// @ts-expect-error - useAlert está definido en JavaScript
import { useAlert } from '@/composables/useAlert'
import { footerSettingsDefaults, useFooterSettings } from '@/composables/useFooterSettings'
// @ts-expect-error - api está definido en JavaScript
import api from '@/services/api'

const { success, error, warning } = useAlert()
const { footerSettings, fetchFooterSettings } = useFooterSettings()

const footerLogo = computed(
  () => footerSettings.value.logo || footerSettingsDefaults.logo || '/logo.png'
)
const footerSlogan = computed(() => footerSettings.value.slogan || footerSettingsDefaults.slogan)
const footerEmail = computed(() => footerSettings.value.email || footerSettingsDefaults.email)
const footerPhone = computed(() => footerSettings.value.phone || footerSettingsDefaults.phone)
const footerLocation = computed(
  () => footerSettings.value.location || footerSettingsDefaults.location
)
const footerEmailHref = computed(() => (footerEmail.value ? `mailto:${footerEmail.value}` : '#'))
const footerPhoneHref = computed(() => {
  const digits = footerPhone.value.replace(/[^0-9+]/g, '')
  return digits ? `tel:${digits}` : '#'
})
const footerSocialLinks = computed(() => {
  const links = footerSettings.value.social_links
  return Array.isArray(links) && links.length ? links : footerSettingsDefaults.social_links
})
const whatsappNumber = computed(
  () => footerSettings.value.whatsapp_number || footerSettingsDefaults.whatsapp_number
)
const whatsappMessage = computed(
  () => footerSettings.value.whatsapp_message || footerSettingsDefaults.whatsapp_message
)
const whatsappContactLink = computed(() => {
  const normalized = whatsappNumber.value.replace(/\D/g, '')
  const message = encodeURIComponent(whatsappMessage.value)
  return normalized ? `https://wa.me/${normalized}?text=${message}` : '#'
})

// Interfaces
interface HeroSlide {
  title: string
  subtitle: string
  cta: string
  image: string
}

interface Service {
  id: number
  icon: string
  title: string
  description: string
  color: string
  image?: string
}

interface Product {
  id: number
  name: string
  description: string
  category: string
  icon: string
  image?: string
  is_active: boolean
  order: number
}

interface PortfolioSlide {
  label: string
  title: string
  description: string
  image: string
}

interface Testimonial {
  name: string
  text: string
  avatar: string
  company?: string
  position?: string
  rating?: number
}

// Navbar scroll state
const isScrolled = ref(false)
const isMobileMenuOpen = ref(false)

// Hero Slider
const currentSlide = ref(0)
const slides = ref<HeroSlide[]>([])
const isLoadingHero = ref(true)

// Cargar hero sections del API
const loadHeroSections = async () => {
  try {
    const response = await api.get('/hero-sections')
    slides.value = response.data.map(
      (section: {
        title: string
        subtitle: string
        button_text?: string
        background_image?: string
      }) => ({
        title: section.title,
        subtitle: section.subtitle,
        cta: section.button_text || 'Ver más',
        image:
          section.background_image ||
          'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=80',
      })
    )
  } catch (error) {
    console.error('Error loading hero sections:', error)
    // Fallback a datos estáticos si falla
    slides.value = [
      {
        title: 'Soluciones <span class="text-highlight">Digitales</span> Innovadoras',
        subtitle: 'Transformamos tu visión en realidad con tecnología de vanguardia',
        cta: 'Comenzar Ahora',
        image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=80',
      },
    ]
  } finally {
    isLoadingHero.value = false
  }
}

// Contact Form
const formData = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  service: '',
  message: '',
  honeypot: '', // Campo anti-bot
})

const isSubmitting = ref(false)
const formStartTime = ref<number>(0)

// Registrar tiempo cuando el componente se monta
onMounted(() => {
  formStartTime.value = Date.now()
})

const handleSubmit = async () => {
  // Protección 1: Verificar honeypot (campo invisible)
  if (formData.value.honeypot !== '') {
    console.warn('Bot detectado: honeypot field filled')
    return // Rechazar silenciosamente
  }

  // Protección 2: Verificar tiempo mínimo de llenado (3 segundos)
  const timeSpent = Date.now() - formStartTime.value
  if (timeSpent < 3000) {
    warning('Por favor, tómate un momento para revisar tu información.')
    return
  }

  // Protección 3: Validación básica de email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailRegex.test(formData.value.email)) {
    warning('Por favor, ingresa un email válido.')
    return
  }

  isSubmitting.value = true

  try {
    // Enviar a la API
    const response = await api.post('/leads', {
      name: formData.value.name,
      email: formData.value.email,
      phone: formData.value.phone,
      company: formData.value.company || null,
      service: formData.value.service,
      message: formData.value.message,
    })

    if (response.data.success) {
      success(response.data.message, '¡Mensaje Enviado!')
      // Resetear formulario
      formData.value = {
        name: '',
        email: '',
        phone: '',
        company: '',
        service: '',
        message: '',
        honeypot: '',
      }
      formStartTime.value = Date.now()
    }
  } catch (err) {
    console.error('Error al enviar formulario:', err)
    error('Hubo un error al enviar tu solicitud. Por favor, intenta nuevamente.', 'Error')
  } finally {
    isSubmitting.value = false
  }
}

// Services
const services = ref<Service[]>([])
const isLoadingServices = ref(true)

// Products
const products = ref<Product[]>([])
const isLoadingProducts = ref(true)

// About Section
const aboutSection = ref({
  current_image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=80',
  title: 'Cargando...',
  description: '',
  highlighted_text: '',
  years_experience: 0,
  happy_clients: 0,
})

// Cargar About Section del API
const loadAboutSection = async () => {
  try {
    const response = await api.get('/about')
    aboutSection.value = response.data
  } catch (error) {
    console.error('Error loading about section:', error)
    // Mantiene los valores por defecto
  }
}

// Cargar productos del API
const loadProducts = async () => {
  try {
    const response = await api.get('/products/active')
    products.value = response.data
  } catch (error) {
    console.error('Error loading products:', error)
    // Fallback a productos por defecto
    products.value = []
  } finally {
    isLoadingProducts.value = false
  }
}

// Cargar servicios del API
const loadServices = async () => {
  try {
    const response = await api.get('/services/active')
    services.value = response.data.map(
      (service: {
        id: number
        icon?: string
        title: string
        description: string
        color?: string
      }) => ({
        id: service.id,
        icon: service.icon || '💻',
        title: service.title,
        description: service.description,
        color: service.color || 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
      })
    )
  } catch (error) {
    console.error('Error loading services:', error)
    // Fallback a datos estáticos
    services.value = [
      {
        id: 1,
        icon: '💻',
        title: 'Desarrollo Web',
        description:
          'Sitios web modernos, responsivos y optimizados para SEO que convierten visitantes en clientes.',
        color: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
      },
    ]
  } finally {
    isLoadingServices.value = false
  }
}

// Portfolio Slides
const currentPortfolioSlide = ref(0)
const portfolioSlides = ref<PortfolioSlide[]>([])
const isLoadingPortfolio = ref(true)

// Cargar portfolio del API
const loadPortfolio = async () => {
  try {
    const response = await api.get('/portfolio')
    portfolioSlides.value = response.data.map(
      (item: { category?: string; title: string; description: string; image?: string }) => ({
        label: item.category || 'Portfolio',
        title: item.title,
        description: item.description,
        image:
          item.image || 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&q=80',
      })
    )
  } catch (error) {
    console.error('Error loading portfolio:', error)
    // Fallback a datos estáticos
    portfolioSlides.value = [
      {
        label: '¿Para qué sirve?',
        title: 'Señalización Digital Versátil',
        description:
          'Contenido informativo, direccional y publicitario. Comunicación interna, alertas de emergencia, entretenimiento en tienda y menús digitales.',
        image: 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&q=80',
      },
    ]
  } finally {
    isLoadingPortfolio.value = false
  }
}

const nextPortfolioSlide = () => {
  currentPortfolioSlide.value = (currentPortfolioSlide.value + 1) % portfolioSlides.value.length
}

const prevPortfolioSlide = () => {
  currentPortfolioSlide.value =
    currentPortfolioSlide.value === 0
      ? portfolioSlides.value.length - 1
      : currentPortfolioSlide.value - 1
}

const goToPortfolioSlide = (index: number) => {
  currentPortfolioSlide.value = index
}

// Stats
const stats = ref([
  {
    icon: '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
    number: '100+',
    label: 'Clientes Satisfechos',
  },
  {
    icon: '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>',
    number: '12+',
    label: 'Años de Experiencia',
  },
  {
    icon: '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
    number: '300+',
    label: 'Proyectos Completados',
  },
  {
    icon: '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>',
    number: '5.0',
    label: 'Calificación Google',
  },
])

// Testimonials
const currentTestimonial = ref(0)
const testimonials = ref<Testimonial[]>([])
const isLoadingTestimonials = ref(true)

// Cargar testimonials del API
const loadTestimonials = async () => {
  try {
    const response = await api.get('/testimonials')
    testimonials.value = response.data
      .filter((t: { is_active: boolean }) => t.is_active)
      .map(
        (t: {
          client_name: string
          testimonial: string
          client_photo?: string
          client_company?: string
          client_position?: string
          rating?: number
        }) => ({
          name: t.client_name,
          text: t.testimonial,
          avatar:
            t.client_photo || `https://i.pravatar.cc/150?img=${Math.floor(Math.random() * 70)}`,
          company: t.client_company,
          position: t.client_position,
          rating: t.rating,
        })
      )
  } catch (error) {
    console.error('Error loading testimonials:', error)
    // Fallback a datos estáticos
    testimonials.value = [
      {
        name: 'María González',
        text: 'Excelente servicio y productos de alta calidad. La instalación de nuestras pantallas LED en el hotel fue impecable y el equipo muy profesional. Totalmente recomendados.',
        avatar: 'https://i.pravatar.cc/150?img=1',
      },
      {
        name: 'Carlos Ramírez',
        text: 'Llevamos años trabajando con Peñacom y siempre superan nuestras expectativas. Sus pantallas LED han transformado nuestro restaurante. Muy satisfechos con el servicio.',
        avatar: 'https://i.pravatar.cc/150?img=12',
      },
    ]
  } finally {
    isLoadingTestimonials.value = false
  }
}

const nextTestimonial = () => {
  currentTestimonial.value = (currentTestimonial.value + 1) % testimonials.value.length
}

const prevTestimonial = () => {
  currentTestimonial.value =
    currentTestimonial.value === 0 ? testimonials.value.length - 1 : currentTestimonial.value - 1
}

const goToTestimonial = (index: number) => {
  currentTestimonial.value = index
}

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
  // Prevenir scroll del body cuando el menú está abierto
  if (isMobileMenuOpen.value) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
  document.body.style.overflow = ''
}

const scrollToContact = () => {
  const contactSection = document.getElementById('contacto')
  if (contactSection) {
    contactSection.scrollIntoView({ behavior: 'smooth' })
  }
  closeMobileMenu()
}

// Lifecycle
onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  startSlider()

  // Forzar la carga del footer desde el servidor (force = true) para obtener cambios recientes
  fetchFooterSettings(true).catch(() => {
    console.warn('No se pudo sincronizar la configuración del footer')
  })

  // Cargar datos del API
  loadHeroSections()
  loadAboutSection()
  loadProducts()
  loadServices()
  loadPortfolio()
  loadTestimonials()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  stopSlider()
})
</script>

<style scoped>
/* Variables de Color - Paleta Azul */
:root {
  --primary-blue: #0066cc;
  --light-blue: #4a90e2;
  --dark-blue: #003d82;
  --secondary-bg: #e6f0fa;
  --white: #ffffff;
  --light-gray: #f5f7fa;
  --gray: #8b95a5;
  --dark-gray: #2c3e50;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.landing-page {
  width: 100%;
  overflow-x: hidden;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial,
    sans-serif;
  color: var(--dark-gray);
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

/* ===== MOBILE OVERLAY ===== */
.mobile-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 998;
  display: none;
}

@media (max-width: 968px) {
  .mobile-overlay {
    display: block;
  }

  .mobile-overlay.active {
    opacity: 1;
    visibility: visible;
  }
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
  background: rgba(43, 46, 131, 0.95);
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

.nav-logo {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo-image {
  height: 35px;
  width: auto;
}

.nav-logo .logo-text {
  font-size: 24px;
  font-weight: 700;
  color: var(--white);
  letter-spacing: -0.5px;
}

.navbar.scrolled .logo-text {
  color: var(--white);
}

.nav-menu {
  display: flex;
  list-style: none;
  gap: 40px;
  align-items: center;
}

.nav-menu li a {
  color: #ffffff !important;
  text-decoration: none;
  font-weight: 500;
  font-size: 15px;
  transition: color 0.3s ease;
}

.navbar .nav-menu li a {
  color: #ffffff !important;
}

.navbar.scrolled .nav-menu li a {
  color: #ffffff !important;
}

.nav-menu li a:hover {
  color: #ffffff !important;
  opacity: 0.8;
}

.nav-menu.active li a {
  color: #ffffff !important;
}

.nav-actions {
  display: flex;
  align-items: center;
  gap: 15px;
}

.btn-nav {
  background: rgba(255, 255, 255, 0.95);
  color: #2b2e83;
  padding: 10px 25px;
  border: 2px solid transparent;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.navbar.scrolled .btn-nav {
  background: #4a90e2;
  color: #ffffff;
  border: 2px solid #4a90e2;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.btn-nav:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
  background: #ffffff;
  color: #2b2e83;
}

.navbar.scrolled .btn-nav:hover {
  background: #ffffff;
  color: #2b2e83;
  border-color: #ffffff;
}

.hamburger {
  display: none;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 44px;
  height: 44px;
  cursor: pointer;
  position: relative;
  z-index: 1001;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  transition: all 0.3s ease;
}

.hamburger:hover {
  background: rgba(255, 255, 255, 0.2);
}

.hamburger span {
  width: 24px;
  height: 2.5px;
  background: #ffffff !important;
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  border-radius: 3px;
  position: absolute;
}

.hamburger span:nth-child(1) {
  top: 12px;
}

.hamburger span:nth-child(2) {
  top: 20px;
}

.hamburger span:nth-child(3) {
  top: 28px;
}

.hamburger.active span:nth-child(1) {
  top: 20px;
  transform: rotate(45deg);
}

.hamburger.active span:nth-child(2) {
  opacity: 0;
  transform: translateX(-20px);
}

.hamburger.active span:nth-child(3) {
  top: 20px;
  transform: rotate(-45deg);
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
  background: linear-gradient(
    135deg,
    var(--dark-blue) 0%,
    var(--primary-blue) 50%,
    var(--light-blue) 100%
  );
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
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
  background: rgba(0, 0, 0, 0.5);
}

.slide-content {
  position: relative;
  height: 100%;
  display: flex;
  align-items: center;
  z-index: 2;
}

.slide-title {
  font-size: 3.5rem;
  font-weight: 700;
  color: #ffffff;
  line-height: 1.2;
  margin-bottom: 20px;
  letter-spacing: -0.5px;
  position: relative;
  z-index: 3;
  text-shadow: 2px 2px 12px rgba(0, 0, 0, 0.4);
}

.text-highlight {
  color: #ffffff;
  font-weight: 800;
}

.slide-subtitle {
  font-size: 1.3rem;
  color: rgba(255, 255, 255, 0.95);
  margin-bottom: 40px;
  max-width: 600px;
  position: relative;
  z-index: 3;
  text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
}

.slide-buttons {
  display: flex;
  gap: 20px;
  position: relative;
  z-index: 3;
  align-items: center;
  justify-content: flex-start;
}

.btn {
  padding: 12px 32px;
  font-size: 15px;
  font-weight: 500;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  letter-spacing: 0.3px;
}

.btn-primary {
  background: rgba(255, 255, 255, 0.95);
  color: #2b2e83;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(74, 144, 226, 0.5);
  background: #4a90e2;
  color: #ffffff;
}

.btn-outline {
  background: rgba(0, 0, 0, 0.3);
  color: var(--white);
  border: 2px solid rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(5px);
}

.btn-outline:hover {
  background: var(--white);
  color: #2b2e83;
  border-color: var(--white);
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
  gap: 10px;
  z-index: 10;
}

.slider-indicators span {
  width: 10px;
  height: 10px;
  background: rgba(255, 255, 255, 0.4);
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.3s ease;
}

.slider-indicators span.active {
  background: var(--white);
  width: 30px;
  border-radius: 5px;
}

.slider-indicators span:hover {
  background: rgba(255, 255, 255, 0.7);
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
  background: linear-gradient(135deg, #e6f0fa 0%, #f5f9fc 50%, #ffffff 100%);
  position: relative;
}

.services-section {
  margin-bottom: 60px;
}

.services-subtitle {
  font-size: 2rem;
  color: var(--dark-gray);
  margin-bottom: 40px;
  text-align: center;
  font-weight: 700;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  margin-bottom: 40px;
}

.glass-card {
  background: rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  padding: 0;
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.6);
  box-shadow: 0 8px 32px rgba(0, 102, 204, 0.12);
  transition: all 0.3s ease;
  overflow: hidden;
}

.glass-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 16px 48px rgba(0, 102, 204, 0.2);
  background: rgba(255, 255, 255, 0.65);
  border-color: rgba(74, 144, 226, 0.3);
}

.service-image {
  width: 100%;
  height: 180px;
  background-size: cover;
  background-position: center;
  position: relative;
  overflow: hidden;
}

.service-image::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(180deg, rgba(0, 102, 204, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%);
}

.service-image .service-icon-wrapper {
  position: absolute;
  bottom: 15px;
  right: 15px;
  margin: 0;
}

.service-card h3 {
  font-size: 1.4rem;
  color: var(--dark-gray);
  margin-bottom: 15px;
  font-weight: 700;
  padding: 25px 30px 0 30px;
}

.service-card p {
  color: var(--gray);
  line-height: 1.7;
  margin-bottom: 0;
  padding: 0 30px 30px 30px;
}

.service-icon-wrapper {
  width: 60px;
  height: 60px;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 25px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.glass-card:hover .service-icon-wrapper {
  transform: scale(1.1) rotate(5deg);
  box-shadow: 0 6px 20px rgba(0, 102, 204, 0.25);
}

.service-icon {
  width: 30px;
  height: 30px;
  color: #0066cc;
  stroke-width: 2.5;
}

.service-icon-emoji {
  font-size: 2rem;
  color: #0066cc;
}

.section-cta {
  text-align: center;
  margin-top: 40px;
}

.section-cta .btn-primary {
  background: #0066cc;
  color: #ffffff;
  box-shadow: 0 4px 16px rgba(0, 102, 204, 0.3);
  border: 2px solid #0066cc;
  padding: 14px 36px;
  font-size: 16px;
  font-weight: 600;
}

.section-cta .btn-primary:hover {
  background: #4a90e2;
  border-color: #4a90e2;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 102, 204, 0.4);
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
  bottom: 20px;
  right: 20px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  padding: 30px;
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  text-align: center;
  z-index: 10;
}

.badge-number {
  font-size: 3rem;
  font-weight: 800;
  color: #ffffff;
  line-height: 1;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.badge-text {
  font-size: 0.9rem;
  color: #ffffff;
  margin-top: 10px;
  font-weight: 600;
  text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
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

.about-highlight {
  background: linear-gradient(135deg, rgba(74, 144, 226, 0.1), rgba(0, 102, 204, 0.1));
  padding: 20px;
  border-left: 4px solid var(--primary-blue);
  border-radius: 8px;
  font-weight: 500;
  color: var(--dark-gray) !important;
}

.btn-about {
  background: #0066cc !important;
  color: #ffffff !important;
  box-shadow: 0 4px 16px rgba(0, 102, 204, 0.3) !important;
  border: 2px solid #0066cc !important;
}

.btn-about:hover {
  background: #4a90e2 !important;
  border-color: #4a90e2 !important;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 102, 204, 0.4) !important;
  color: #ffffff !important;
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
  border: 1px solid #e2e8f0;
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
  padding: 100px 0;
  background: var(--white);
}

.container-full {
  width: 100%;
  max-width: 100%;
  padding: 0 40px;
}

.container-full .section-header {
  text-align: center;
  margin-bottom: 60px;
  padding: 0 20px;
}

.portfolio-slider {
  position: relative;
  width: 100%;
  height: 600px;
  overflow: hidden;
  border-radius: 24px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.portfolio-slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  transform: scale(1.1);
  transition: all 0.8s ease;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.portfolio-slide.active {
  opacity: 1;
  transform: scale(1);
}

.slide-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 102, 204, 0.5) 100%);
  z-index: 1;
}

.slide-content {
  position: relative;
  z-index: 2;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  padding: 0 80px;
  max-width: 1200px;
  margin: 0 auto;
}

.slide-label {
  font-size: 1rem;
  color: #4a90e2;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-weight: 600;
  margin-bottom: 15px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  padding: 8px 20px;
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.slide-title {
  font-size: 2.2rem;
  color: #ffffff;
  margin-bottom: 20px;
  font-weight: 800;
  line-height: 1.3;
  text-shadow: 2px 4px 12px rgba(0, 0, 0, 0.3);
  max-width: 800px;
}

.slide-description {
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.95);
  line-height: 1.7;
  max-width: 700px;
  text-shadow: 1px 2px 8px rgba(0, 0, 0, 0.3);
}

.portfolio-controls {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  z-index: 3;
  pointer-events: none;
  padding: 0 5px;
}

.portfolio-controls .nav-arrow {
  pointer-events: all;
  width: 48px;
  height: 48px;
  border: none;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  color: #0066cc;
  border-radius: 50%;
  font-size: 1.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.portfolio-controls .nav-arrow:hover {
  background: rgba(255, 255, 255, 1);
  color: #0066cc;
  transform: scale(1.1);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.portfolio-dots {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 12px;
  z-index: 3;
}

.portfolio-dots span {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.4);
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid rgba(255, 255, 255, 0.6);
}

.portfolio-dots span.active {
  background: #ffffff;
  width: 40px;
  border-radius: 6px;
}

.portfolio-dots span:hover {
  background: rgba(255, 255, 255, 0.8);
}

/* ===== STATS ===== */
.stats {
  padding: 80px 20px;
  background: linear-gradient(135deg, #e6f0fa 0%, #f5f9fc 100%);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
}

.stat-item {
  text-align: center;
}

.stat-icon-wrapper {
  width: 80px;
  height: 80px;
  background: rgba(230, 240, 250, 0.8);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  transition: all 0.3s ease;
  box-shadow: 0 8px 24px rgba(0, 102, 204, 0.12);
}

.stat-icon {
  width: 40px;
  height: 40px;
  stroke: #0066cc;
  stroke-width: 2.5;
}

.stat-item:hover .stat-icon-wrapper {
  transform: translateY(-5px) scale(1.05);
  box-shadow: 0 12px 32px rgba(0, 102, 204, 0.2);
}

.stat-number {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 10px;
  color: #2c3e50;
}

.stat-label {
  font-size: 1.1rem;
  color: #5a6c7d;
  font-weight: 500;
}

/* ===== TESTIMONIALS ===== */
.testimonials {
  padding: 100px 20px;
  background: var(--white);
}

.testimonials-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 60px;
  gap: 40px;
  flex-wrap: wrap;
}

.google-badge {
  display: flex;
  align-items: center;
  gap: 15px;
  background: var(--white);
  padding: 20px 30px;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  border: 1px solid #e8eaed;
}

.google-icon {
  width: 48px;
  height: 48px;
  flex-shrink: 0;
}

.google-info h4 {
  font-size: 1.3rem;
  color: #2c3e50;
  margin-bottom: 5px;
  font-weight: 700;
}

.google-rating {
  display: flex;
  align-items: center;
  gap: 8px;
}

.google-rating .stars {
  color: #fbbc04;
  font-size: 1.1rem;
}

.google-rating .rating-text {
  color: #5f6368;
  font-size: 0.95rem;
}

.testimonials-slider {
  position: relative;
  max-width: 900px;
  margin: 0 auto;
  height: 350px;
}

.testimonial-slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  opacity: 0;
  transform: translateX(100%);
  transition: all 0.5s ease;
  background: rgba(255, 255, 255, 0.6);
  backdrop-filter: blur(20px);
  padding: 50px;
  border-radius: 20px;
  border: 1px solid rgba(0, 102, 204, 0.1);
  box-shadow: 0 8px 32px rgba(0, 102, 204, 0.1);
}

.testimonial-slide.active {
  opacity: 1;
  transform: translateX(0);
}

.testimonial-header {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 25px;
}

.testimonial-avatar {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #e6f0fa;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.testimonial-info {
  flex: 1;
}

.testimonial-name {
  font-size: 1.3rem;
  color: #2c3e50;
  margin-bottom: 5px;
  font-weight: 700;
}

.testimonial-stars {
  color: #fbbc04;
  font-size: 1.2rem;
  letter-spacing: 2px;
}

.testimonial-text {
  font-size: 1.2rem;
  color: #5a6c7d;
  line-height: 1.8;
  font-style: italic;
}

.testimonial-controls {
  position: absolute;
  top: 45%;
  left: -70px;
  right: -70px;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  pointer-events: none;
  z-index: 10;
}

.testimonial-arrow {
  pointer-events: all;
  width: 48px;
  height: 48px;
  border: none;
  background: rgba(0, 102, 204, 0.1);
  color: #0066cc;
  border-radius: 50%;
  font-size: 1.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.testimonial-arrow:hover {
  background: #0066cc;
  color: white;
  transform: scale(1.1);
}

.testimonial-dots {
  position: absolute;
  bottom: -40px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
}

.testimonial-dots span {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: rgba(0, 102, 204, 0.2);
  cursor: pointer;
  transition: all 0.3s ease;
}

.testimonial-dots span.active {
  background: #0066cc;
  width: 30px;
  border-radius: 5px;
}

.testimonial-dots span:hover {
  background: #4a90e2;
}

/* ===== CONTACT ===== */
.contact {
  padding: 100px 20px;
  background: linear-gradient(135deg, #e6f0fa 0%, #f5f9fc 100%);
}

/* ===== CTA ===== */
.cta {
  padding: 120px 20px;
  background: linear-gradient(135deg, #f8fafc 0%, #e6f0fa 100%);
  position: relative;
  overflow: hidden;
}

.cta::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg width="80" height="80" xmlns="http://www.w3.org/2000/svg"><circle cx="40" cy="40" r="1.5" fill="rgba(0,102,204,0.08)"/></svg>');
  opacity: 1;
}

.cta-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
  position: relative;
  z-index: 1;
}

.cta-content {
  color: #2c3e50;
}

.cta-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background: linear-gradient(135deg, #fff7e6 0%, #fff 100%);
  color: #d97706;
  padding: 12px 24px;
  border-radius: 50px;
  font-size: 0.95rem;
  font-weight: 700;
  margin-bottom: 30px;
  border: 2px solid #fcd34d;
  box-shadow: 0 4px 12px rgba(217, 119, 6, 0.15);
}

.cta-content h2 {
  font-size: 3rem;
  line-height: 1.25;
  margin-bottom: 20px;
  font-weight: 800;
  color: #1e293b;
}

.cta-subtitle {
  font-size: 1.25rem;
  margin-bottom: 40px;
  color: #475569;
  line-height: 1.7;
  font-weight: 500;
}

.cta-benefits {
  margin-bottom: 40px;
}

.benefit-item {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 18px;
  font-size: 1.05rem;
  color: #334155;
  font-weight: 500;
}

.benefit-icon {
  width: 28px;
  height: 28px;
  color: #10b981;
  flex-shrink: 0;
  stroke-width: 2.5;
}

.trust-indicators {
  display: flex;
  gap: 50px;
  margin-top: 50px;
}

.trust-item {
  text-align: center;
  padding: 20px;
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(10px);
  border-radius: 16px;
  border: 1px solid rgba(0, 102, 204, 0.1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  flex: 1;
}

.trust-number {
  display: block;
  font-size: 2.5rem;
  font-weight: 800;
  color: #0066cc;
  margin-bottom: 8px;
}

.trust-label {
  display: block;
  font-size: 0.9rem;
  color: #64748b;
  font-weight: 600;
}

/* Contact Form */
.contact-form-wrapper {
  background: var(--white);
  padding: 50px;
  border-radius: 24px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
  border: 1px solid #e5e7eb;
}

.contact-form h3 {
  font-size: 2rem;
  color: #1e293b;
  margin-bottom: 10px;
  font-weight: 800;
}

.form-subtitle {
  color: #0066cc;
  font-size: 1rem;
  margin-bottom: 35px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-subtitle::before {
  content: '⚡';
  font-size: 1.2rem;
}

.form-group {
  margin-bottom: 24px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group label {
  display: block;
  font-weight: 600;
  color: #334155;
  margin-bottom: 10px;
  font-size: 0.95rem;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 16px 18px;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.3s ease;
  font-family: inherit;
  background: #fafbfc;
  color: #1e293b;
}

.form-group input:hover,
.form-group select:hover,
.form-group textarea:hover {
  border-color: #cbd5e1;
  background: var(--white);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #0066cc;
  background: var(--white);
  box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.08);
}

.form-group textarea {
  resize: vertical;
  min-height: 120px;
  line-height: 1.6;
}

.form-group select {
  cursor: pointer;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 16px center;
  background-size: 18px;
  padding-right: 48px;
}

.btn-submit {
  width: 100%;
  padding: 14px 28px;
  background: #0066cc;
  color: #ffffff;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 14px rgba(0, 102, 204, 0.15);
  margin-top: 10px;
  position: relative;
  overflow: hidden;
}

.plane-icon {
  width: 20px;
  height: 20px;
  position: absolute;
  right: -30px;
  top: 50%;
  transform: translateY(-50%) rotate(-45deg);
  opacity: 0;
  transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.btn-submit:hover {
  background: #0052a3;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 102, 204, 0.25);
  padding-right: 45px;
}

.btn-submit:hover .plane-icon {
  right: 20px;
  opacity: 1;
}

.btn-submit:active {
  transform: translateY(0);
  box-shadow: 0 2px 8px rgba(0, 102, 204, 0.3);
}

.form-privacy {
  text-align: center;
  font-size: 0.875rem;
  color: #64748b;
  margin-top: 20px;
  font-weight: 500;
}

/* Honeypot - Campo invisible anti-bot */
.honeypot {
  position: absolute;
  left: -9999px;
  width: 1px;
  height: 1px;
  opacity: 0;
  pointer-events: none;
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* ===== RESPONSIVE MOBILE-FIRST ===== */

/* Tablet y móviles grandes */
@media (max-width: 968px) {
  /* Navbar */
  .hamburger {
    display: flex;
  }

  .nav-menu {
    position: fixed;
    top: 0;
    right: -100%;
    width: 280px;
    height: 100vh;
    background: rgba(43, 46, 131, 0.98);
    backdrop-filter: blur(20px);
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 100px 40px 40px;
    gap: 0;
    transition: right 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    box-shadow: -5px 0 25px rgba(0, 0, 0, 0.3);
    z-index: 999;
  }

  /* Background del menú según tema */
  .theme-light .nav-menu {
    background: rgba(255, 255, 255, 0.98);
  }

  .theme-christmas .nav-menu {
    background: rgba(44, 24, 16, 0.98);
  }

  .nav-menu.active {
    right: 0;
  }

  .nav-menu li {
    width: 100%;
    margin-bottom: 8px;
  }

  .nav-menu li a {
    display: block;
    padding: 16px 20px;
    font-size: 1.1rem;
    color: #ffffff !important;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .nav-menu li a:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(8px);
    color: #ffffff !important;
  }

  /* Colores de texto según tema */
  .theme-light .nav-menu li a {
    color: #0066cc !important;
  }

  .theme-light .nav-menu li a:hover {
    background: rgba(0, 102, 204, 0.1);
    color: #0052a3 !important;
  }

  .theme-christmas .nav-menu li a {
    color: #dc2626 !important;
  }

  .theme-christmas .nav-menu li a:hover {
    background: rgba(220, 38, 38, 0.1);
    color: #b91c1c !important;
  }

  .btn-nav {
    display: none;
  }

  .nav-actions {
    gap: 4px;
  }

  /* Hero */
  .slider-controls {
    left: 5px;
    right: 5px;
    padding: 0;
  }

  .slider-arrow {
    width: 44px;
    height: 44px;
    background: transparent;
    backdrop-filter: none;
    border: none;
    font-size: 2rem;
    font-weight: 300;
  }

  .slider-arrow:hover {
    background: rgba(255, 255, 255, 0.1);
  }

  .slide-content {
    align-items: center;
    text-align: center;
    padding: 0 20px;
  }

  .slide-title {
    font-size: 1.5rem;
    line-height: 1.1;
    margin-bottom: 10px;
    white-space: normal;
    overflow: visible;
    text-overflow: clip;
    max-width: 90%;
  }

  .slide-subtitle {
    font-size: 0.9rem;
    line-height: 1.2;
    margin-bottom: 20px;
    white-space: normal;
    overflow: visible;
    text-overflow: clip;
    max-width: 90%;
  }

  .slide-buttons {
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 12px;
  }

  .btn {
    padding: 10px 20px;
    font-size: 0.9rem;
    width: auto;
    max-width: none;
  }

  /* About */
  .about-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .about-content {
    order: 2;
    text-align: center;
  }

  .about-content .btn {
    margin: 0 auto;
  }

  .about-image-wrapper {
    order: 1;
  }

  /* Services */
  .services-grid {
    grid-template-columns: 1fr;
    gap: 25px;
  }

  /* Portfolio */
  .portfolio-slider {
    height: 450px;
  }

  .portfolio-controls {
    left: 5px;
    right: 5px;
  }

  .portfolio-controls .nav-arrow {
    width: 44px;
    height: 44px;
    font-size: 1.8rem;
    background: transparent;
    color: #ffffff;
    box-shadow: none;
    border: none;
    font-weight: 300;
  }

  .portfolio-controls .nav-arrow:hover {
    background: rgba(255, 255, 255, 0.1);
  }

  .slide-title {
    font-size: 1.6rem;
    line-height: 1.2;
  }

  .slide-description {
    font-size: 0.95rem;
    line-height: 1.5;
  }

  /* Stats */
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
  }

  /* Testimonials */
  .testimonials-header {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 25px;
  }

  .testimonials-slider {
    height: 400px;
  }

  .testimonial-slide {
    padding: 35px 25px;
    height: auto;
  }

  .testimonial-controls {
    left: -50px;
    right: -50px;
    top: 45%;
  }

  .testimonial-arrow {
    width: 44px;
    height: 44px;
    font-size: 1.8rem;
    background: transparent;
    color: #0066cc;
    box-shadow: none;
    border: none;
    font-weight: 300;
  }

  .testimonial-arrow:hover {
    background: rgba(0, 102, 204, 0.1);
    transform: scale(1);
  }

  /* CTA */
  .cta-grid {
    grid-template-columns: 1fr;
    gap: 50px;
  }

  .cta-content {
    text-align: center;
  }

  .cta-badge {
    margin-left: auto;
    margin-right: auto;
  }

  .cta-content h2 {
    font-size: 2.2rem;
  }

  .trust-indicators {
    flex-wrap: wrap;
    gap: 15px;
  }

  .trust-item {
    flex: 1 1 calc(50% - 8px);
    min-width: 140px;
  }

  .contact-form-wrapper {
    padding: 35px 25px;
  }

  .form-row {
    grid-template-columns: 1fr;
    gap: 0;
  }

  /* Footer */
  .footer-content {
    grid-template-columns: 1fr 1fr;
    gap: 40px;
  }

  .footer-brand {
    grid-column: 1 / -1;
    max-width: 100%;
  }

  /* Footer */
  .footer-content {
    grid-template-columns: 1fr;
    gap: 40px;
    text-align: center;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 20px;
    text-align: center;
  }
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
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: var(--white);
  padding: 80px 20px 30px;
  position: relative;
  overflow: hidden;
}

.footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(0, 102, 204, 0.5), transparent);
}

.footer-content {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1.5fr;
  gap: 60px;
  margin-bottom: 60px;
}

.footer-brand {
  max-width: 350px;
}

.footer-logo {
  margin-bottom: 20px;
}

.footer-logo-image {
  height: 45px;
  width: auto;
}

.footer-tagline {
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.7;
  margin-bottom: 30px;
  font-size: 0.95rem;
}

.footer-section h4 {
  color: #ffffff;
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 25px;
  position: relative;
  padding-bottom: 12px;
}

.footer-section h4::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 40px;
  height: 3px;
  background: linear-gradient(90deg, #0066cc, #4a90e2);
  border-radius: 2px;
}

.footer-section ul {
  list-style: none;
}

.footer-section li {
  margin-bottom: 12px;
}

.footer-section a {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  transition: all 0.3s ease;
  display: inline-block;
  font-size: 0.95rem;
}

.footer-section a:hover {
  color: #4a90e2;
  transform: translateX(5px);
}

.contact-list li {
  display: flex;
  align-items: center;
  gap: 12px;
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.95rem;
}

.contact-icon {
  width: 20px;
  height: 20px;
  color: #4a90e2;
  flex-shrink: 0;
}

.contact-link {
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  transition: color 0.2s ease;
}

.contact-link:hover {
  color: #4a90e2;
}

.social-links {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.social-link {
  min-width: 44px;
  padding: 0.65rem 1rem;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(10px);
  border-radius: 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.1);
  text-decoration: none;
}

.social-link:hover {
  background: #0066cc;
  border-color: #0066cc;
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 102, 204, 0.3);
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
  font-size: 0.9rem;
}

.arla-link {
  color: #4a90e2;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

.arla-link:hover {
  color: #0066cc;
  text-decoration: underline;
}

.footer-links {
  display: flex;
  gap: 30px;
}

.footer-links a {
  color: rgba(255, 255, 255, 0.5);
  text-decoration: none;
  transition: color 0.3s ease;
  font-size: 0.9rem;
}

.footer-links a:hover {
  color: #4a90e2;
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

/* Móviles pequeños */
@media (max-width: 640px) {
  .container {
    padding: 0 15px;
  }

  /* Navbar */
  .nav-menu {
    width: 100%;
    right: -100%;
    padding: 90px 25px 40px;
  }

  .logo-image {
    height: 28px;
  }

  /* Hero */
  .hero-slider {
    height: 100svh;
  }

  .slider-controls {
    left: 0;
    right: 0;
    padding: 0;
  }

  .slider-arrow {
    width: 40px;
    height: 40px;
    background: transparent;
    backdrop-filter: none;
    border: none;
    font-size: 1.8rem;
    font-weight: 300;
  }

  .slide-content {
    align-items: center;
    text-align: center;
    padding: 0 15px;
  }

  .slide-title {
    font-size: 1.2rem;
    line-height: 1.1;
    margin-bottom: 8px;
    white-space: normal;
    overflow: visible;
    text-overflow: clip;
    max-width: 95%;
  }

  .slide-subtitle {
    font-size: 0.8rem;
    line-height: 1.2;
    margin-bottom: 18px;
    white-space: normal;
    overflow: visible;
    text-overflow: clip;
    max-width: 95%;
  }

  .slide-buttons {
    flex-direction: row;
    justify-content: center;
    gap: 10px;
  }

  .btn {
    padding: 9px 18px;
    font-size: 0.85rem;
    width: auto;
  }

  /* About */
  .about-badge {
    font-size: 0.9rem;
    padding: 8px 18px;
  }

  section h2 {
    font-size: 2rem;
  }

  /* Services */
  .service-card h3 {
    font-size: 1.3rem;
  }

  /* Portfolio */
  .portfolio-slider {
    height: 380px;
  }

  .portfolio-slide {
    padding: 30px 15px;
  }

  .portfolio-controls {
    left: 0;
    right: 0;
  }

  .portfolio-controls .nav-arrow {
    width: 40px;
    height: 40px;
    font-size: 1.6rem;
    background: transparent;
    color: #ffffff;
    box-shadow: none;
    font-weight: 300;
  }

  .portfolio-label {
    font-size: 0.75rem;
    padding: 6px 14px;
  }

  .slide-title {
    font-size: 1.3rem;
    line-height: 1.2;
  }

  .slide-description {
    font-size: 0.9rem;
    line-height: 1.4;
  }

  /* Stats */
  .stats-grid {
    grid-template-columns: 1fr;
    gap: 25px;
  }

  .stat-number {
    font-size: 2.5rem;
  }

  /* Testimonials */
  .testimonials-slider {
    height: 450px;
  }

  .testimonial-slide {
    padding: 30px 20px;
    height: auto;
  }

  .testimonial-controls {
    left: -10px;
    right: -10px;
    top: 45%;
  }

  .testimonial-name {
    font-size: 1.1rem;
  }

  .testimonial-text {
    font-size: 1rem;
  }

  .testimonial-arrow {
    width: 40px;
    height: 40px;
    font-size: 1.6rem;
    background: transparent;
    color: #0066cc;
    box-shadow: none;
    font-weight: 300;
  }

  .google-badge {
    padding: 15px 20px;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    max-width: 320px;
    margin: 0 auto;
  }

  .google-icon {
    width: 36px;
    height: 36px;
  }

  /* CTA */
  .cta {
    padding: 80px 15px;
  }

  .cta-content {
    text-align: center;
  }

  .cta-badge {
    margin-left: auto;
    margin-right: auto;
  }

  .cta-content h2 {
    font-size: 1.8rem;
  }

  .cta-subtitle {
    font-size: 1.1rem;
  }

  .trust-indicators {
    flex-direction: column;
    gap: 15px;
  }

  .trust-item {
    width: 100%;
  }

  .trust-number {
    font-size: 2rem;
  }

  .contact-form-wrapper {
    padding: 25px 20px;
  }

  .contact-form h3 {
    font-size: 1.6rem;
  }

  /* Footer */
  .footer {
    padding: 60px 15px 30px;
  }

  .footer-content {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .footer-brand {
    text-align: center;
  }

  .social-links {
    justify-content: center;
  }

  .footer-section h4 {
    text-align: center;
  }

  .footer-section h4::after {
    left: 50%;
    transform: translateX(-50%);
  }

  .footer-section ul {
    text-align: center;
  }

  .contact-list li {
    justify-content: center;
  }

  .footer-bottom {
    flex-direction: column;
    text-align: center;
  }

  .social-link {
    width: auto;
    min-width: unset;
    padding: 0.5rem 0.85rem;
  }
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
</style>
