<template>
  <header class="header" :class="{ 'scrolled': isScrolled }">
    <div class="container">
      <div class="header-content">
        <a href="#inicio" class="logo">Peñacom</a>
        
        <nav class="nav" :class="{ 'active': menuOpen }">
          <a href="#productos" @click="closeMenu">Productos</a>
          <a href="#servicios" @click="closeMenu">Servicios</a>
          <a href="#nosotros" @click="closeMenu">Nosotros</a>
          <a href="#contacto" @click="closeMenu">Contacto</a>
        </nav>
        
        <button class="menu-toggle" @click="toggleMenu" aria-label="Menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const isScrolled = ref(false)
const menuOpen = ref(false)

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
}

const closeMenu = () => {
  menuOpen.value = false
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
  z-index: 1000;
  background: rgba(0, 0, 0, 0.8);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  transition: all 0.3s ease;
}

.header.scrolled {
  background: rgba(0, 0, 0, 0.95);
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 52px;
}

.logo {
  font-size: 1.25rem;
  font-weight: 600;
  color: #fff;
  text-decoration: none;
  letter-spacing: -0.02em;
}

.nav {
  display: flex;
  gap: 32px;
  align-items: center;
}

.nav a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 400;
  transition: color 0.2s ease;
}

.nav a:hover {
  color: #fff;
}

.menu-toggle {
  display: none;
  flex-direction: column;
  gap: 4px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 8px;
}

.menu-toggle span {
  display: block;
  width: 20px;
  height: 2px;
  background: #fff;
  transition: all 0.3s ease;
}

@media (max-width: 768px) {
  .nav {
    position: fixed;
    top: 52px;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.98);
    flex-direction: column;
    padding: 24px;
    gap: 24px;
    transform: translateY(-100%);
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s ease;
  }
  
  .nav.active {
    transform: translateY(0);
    opacity: 1;
    pointer-events: all;
  }
  
  .menu-toggle {
    display: flex;
  }
  
  .nav a {
    font-size: 1.125rem;
  }
}
</style>
