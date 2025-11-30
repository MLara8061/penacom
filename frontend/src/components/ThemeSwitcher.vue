<template>
  <div class="theme-switcher">
    <button 
      @click="toggleDropdown" 
      class="theme-button"
      :class="{ 'active': showDropdown }"
    >
      <!-- Icono Sol -->
      <svg v-if="currentTheme === 'light'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="5"></circle>
        <line x1="12" y1="1" x2="12" y2="3"></line>
        <line x1="12" y1="21" x2="12" y2="23"></line>
        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
        <line x1="1" y1="12" x2="3" y2="12"></line>
        <line x1="21" y1="12" x2="23" y2="12"></line>
        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
      </svg>
      
      <!-- Icono Luna -->
      <svg v-else-if="currentTheme === 'dark'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
      </svg>
      
      <!-- Icono Copo de Nieve -->
      <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="2" x2="12" y2="22"></line>
        <path d="M12 2 6 8m6-6 6 6M12 22l-6-6m6 6 6-6M2 12h20M2 12l6-6m-6 6 6 6m14-6-6-6m6 6-6 6"></path>
      </svg>
    </button>
    
    <transition name="dropdown">
      <div v-if="showDropdown" class="theme-dropdown">
        <button 
          @click="selectTheme('light')"
          class="theme-option"
          :class="{ 'selected': currentTheme === 'light' }"
        >
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
          </svg>
          <span>Claro</span>
        </button>
        
        <button 
          @click="selectTheme('dark')"
          class="theme-option"
          :class="{ 'selected': currentTheme === 'dark' }"
        >
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
          </svg>
          <span>Oscuro</span>
        </button>
        
        <button 
          @click="selectTheme('christmas')"
          class="theme-option"
          :class="{ 'selected': currentTheme === 'christmas' }"
        >
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="2" x2="12" y2="22"></line>
            <path d="M12 2 6 8m6-6 6 6M12 22l-6-6m6 6 6-6M2 12h20M2 12l6-6m-6 6 6 6m14-6-6-6m6 6-6 6"></path>
          </svg>
          <span>Navidad</span>
        </button>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'

const currentTheme = ref<'light' | 'dark' | 'christmas'>('light')
const showDropdown = ref(false)

type ThemeValue = 'light' | 'dark' | 'christmas'

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
}

const selectTheme = (theme: 'light' | 'dark' | 'christmas') => {
  currentTheme.value = theme
  showDropdown.value = false
  applyTheme(theme)
  localStorage.setItem('theme', theme)
  
  // Reproducir sonido navideño si se selecciona tema Christmas
  // Nota: Necesitas agregar un archivo jingle-bells.mp3 en la carpeta public/
  if (theme === 'christmas') {
    try {
      const audio = new Audio('/jingle-bells.mp3')
      audio.volume = 0.3
      audio.play().catch(() => {
        // Audio not available or autoplay blocked
      })
    } catch (e) {
      // Audio file not found - skip silently
    }
  }
}

const applyTheme = (theme: string) => {
  // Remover todas las clases de tema
  document.documentElement.classList.remove('theme-light', 'theme-dark', 'theme-christmas')
  // Agregar la clase del tema seleccionado
  document.documentElement.classList.add(`theme-${theme}`)
  
  // Emitir evento para componentes que necesiten reaccionar al cambio de tema
  window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }))
}

// Cargar tema guardado
onMounted(() => {
  const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | 'christmas' || 'light'
  currentTheme.value = savedTheme
  applyTheme(savedTheme)
})

// Cerrar dropdown al hacer click fuera
const handleClickOutside = (event: MouseEvent) => {
  const target = event.target as HTMLElement
  if (!target.closest('.theme-switcher')) {
    showDropdown.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

watch(() => showDropdown.value, (isOpen) => {
  if (!isOpen) {
    document.removeEventListener('click', handleClickOutside)
  }
})
</script>

<style>
.theme-switcher {
  position: relative;
  z-index: 1001;
  display: block !important;
  visibility: visible !important;
}

.theme-button {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 2px solid rgba(255, 255, 255, 0.2);
  display: flex !important;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  color: #FFFFFF;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Color de icono siempre blanco */
.theme-light .theme-button {
  color: #FFFFFF;
  background: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.2);
}

/* Color de icono en tema oscuro */
.theme-dark .theme-button {
  color: #FFFFFF;
  background: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.2);
}

/* Estilos para navbar en tema navideño */
.theme-christmas .theme-button {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(255, 255, 255, 0.3);
  color: #FFFFFF;
}

.theme-button:hover,
.theme-button.active {
  background: rgba(255, 255, 255, 0.25);
  border-color: rgba(255, 255, 255, 0.4);
  transform: scale(1.05);
}

.theme-christmas .theme-button:hover,
.theme-christmas .theme-button.active {
  background: rgba(255, 255, 255, 0.3);
  border-color: rgba(255, 255, 255, 0.5);
}

.theme-button svg {
  width: 24px;
  height: 24px;
  stroke-width: 2.5;
  stroke: currentColor;
  fill: none;
}

.theme-dropdown {
  position: absolute;
  top: calc(100% + 10px);
  right: 0;
  background: #FFFFFF;
  border-radius: 12px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
  padding: 8px;
  min-width: 160px;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

.theme-christmas .theme-dropdown {
  background: #2C1810;
  border-color: rgba(196, 30, 58, 0.3);
}

.theme-option {
  width: 100%;
  padding: 12px 16px;
  border: none;
  background: transparent;
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  border-radius: 8px;
  transition: all 0.2s ease;
  color: #333;
  font-size: 14px;
  font-weight: 500;
}

.theme-option:hover {
  background: rgba(0, 102, 204, 0.08);
}

.theme-option.selected {
  background: rgba(0, 102, 204, 0.15);
  color: #0066CC;
}

.theme-christmas .theme-option {
  color: #E8E8E8;
}

.theme-christmas .theme-option:hover {
  background: rgba(196, 30, 58, 0.15);
}

.theme-christmas .theme-option.selected {
  background: rgba(196, 30, 58, 0.25);
  color: #FF6B6B;
}

.theme-option svg {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
}

/* Animación del dropdown */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.dropdown-enter-from {
  opacity: 0;
  transform: translateY(-10px) scale(0.95);
}

.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-5px) scale(0.98);
}

/* Responsive */
@media (max-width: 768px) {
  .theme-button {
    width: 40px;
    height: 40px;
  }
  
  .theme-button svg {
    width: 18px;
    height: 18px;
  }
}
</style>
