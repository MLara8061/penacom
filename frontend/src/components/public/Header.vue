<template>
  <header class="header" :class="{ 'header-scrolled': scrolled }">
    <div class="container">
      <nav class="nav">
        <div class="nav-brand">
          <router-link to="/" class="logo">
            <span class="logo-icon">📺</span>
            <span class="logo-text">Peñacom</span>
          </router-link>
        </div>

        <!-- Mobile menu button -->
        <button class="mobile-menu-btn" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle menu">
          <span class="hamburger" :class="{ 'active': mobileMenuOpen }"></span>
        </button>

        <!-- Navigation links -->
        <div class="nav-links" :class="{ 'mobile-open': mobileMenuOpen }">
          <a href="#inicio" @click="closeMobileMenu" class="nav-link">Inicio</a>
          <a href="#nosotros" @click="closeMobileMenu" class="nav-link">Nosotros</a>
          <a href="#productos" @click="closeMobileMenu" class="nav-link">Productos</a>
          <a href="#servicios" @click="closeMobileMenu" class="nav-link">Servicios</a>
          <a href="#contacto" @click="closeMobileMenu" class="nav-link btn-nav-cta">Cotizar</a>
        </div>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const scrolled = ref(false)
const mobileMenuOpen = ref(false)

const handleScroll = () => {
  scrolled.value = window.scrollY > 50
}

const closeMobileMenu = () => {
  mobileMenuOpen.value = false
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: var(--z-fixed);
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  transition: var(--transition);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.header-scrolled {
  box-shadow: var(--shadow-md);
}

.nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 70px;
}

.nav-brand {
  z-index: var(--z-fixed);
}

.logo {
  display: flex;
  align-items: center;
  gap: var(--spacing-xs);
  font-size: var(--font-size-xl);
  font-weight: 700;
  color: var(--primary-blue);
  text-decoration: none;
  transition: var(--transition);
}

.logo:hover {
  transform: scale(1.05);
}

.logo-icon {
  font-size: var(--font-size-2xl);
}

.logo-text {
  background: var(--gradient-primary);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Mobile menu button */
.mobile-menu-btn {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  background: transparent;
  border: none;
  cursor: pointer;
  z-index: var(--z-fixed);
}

.hamburger {
  position: relative;
  width: 24px;
  height: 2px;
  background: var(--primary-blue);
  transition: var(--transition);
}

.hamburger::before,
.hamburger::after {
  content: '';
  position: absolute;
  width: 24px;
  height: 2px;
  background: var(--primary-blue);
  transition: var(--transition);
}

.hamburger::before {
  transform: translateY(-8px);
}

.hamburger::after {
  transform: translateY(8px);
}

.hamburger.active {
  background: transparent;
}

.hamburger.active::before {
  transform: rotate(45deg);
}

.hamburger.active::after {
  transform: rotate(-45deg);
}

/* Navigation links */
.nav-links {
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 70px;
  left: 0;
  right: 0;
  background: var(--white);
  padding: var(--spacing-lg);
  gap: var(--spacing-sm);
  transform: translateX(100%);
  transition: var(--transition);
  box-shadow: var(--shadow-lg);
  max-height: calc(100vh - 70px);
  overflow-y: auto;
}

.nav-links.mobile-open {
  transform: translateX(0);
}

.nav-link {
  padding: var(--spacing-sm) var(--spacing-md);
  color: var(--dark);
  font-weight: 500;
  border-radius: var(--radius);
  transition: var(--transition);
  text-align: center;
}

.nav-link:hover {
  background: var(--light-blue);
  color: var(--primary-blue);
}

.btn-nav-cta {
  background: var(--gradient-primary);
  color: var(--white);
  font-weight: 600;
  margin-top: var(--spacing-sm);
}

.btn-nav-cta:hover {
  transform: scale(1.05);
  box-shadow: var(--shadow-md);
}

/* Tablet and desktop */
@media (min-width: 768px) {
  .mobile-menu-btn {
    display: none;
  }

  .nav-links {
    position: static;
    flex-direction: row;
    padding: 0;
    gap: var(--spacing-md);
    transform: translateX(0);
    box-shadow: none;
    background: transparent;
    align-items: center;
  }

  .nav-link {
    padding: var(--spacing-xs) var(--spacing-md);
  }

  .btn-nav-cta {
    margin-top: 0;
    padding: var(--spacing-sm) var(--spacing-lg);
  }
}

@media (min-width: 1024px) {
  .nav {
    height: 80px;
  }

  .nav-links {
    gap: var(--spacing-lg);
  }
}
</style>
