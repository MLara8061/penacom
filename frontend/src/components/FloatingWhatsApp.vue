<template>
  <a
    :href="`https://wa.me/${phoneNumber}?text=${encodedMessage}`"
    target="_blank"
    rel="noopener noreferrer"
    class="whatsapp-float"
    :class="{ 'pulse': showPulse, 'christmas': isChristmas }"
    @mouseenter="showPulse = false"
  >
    <!-- Gorro de Santa SVG (solo en tema navideño) -->
    <svg v-if="isChristmas" class="santa-hat" viewBox="0 0 64 64" fill="none">
      <!-- Gorro base rojo -->
      <path d="M32 8 C20 8, 12 16, 12 28 L52 28 C52 16, 44 8, 32 8" fill="#C41E3A" />
      <!-- Sombra del gorro -->
      <path d="M32 8 C20 8, 12 16, 12 28 L52 28 C52 16, 44 8, 32 8" fill="url(#shadowGradient)" opacity="0.3" />
      <!-- Borde blanco inferior -->
      <ellipse cx="32" cy="28" rx="22" ry="4" fill="#FFFFFF" />
      <!-- Pompón -->
      <circle cx="32" cy="6" r="5" fill="#FFFFFF" />
      <circle cx="32" cy="6" r="4" fill="#F0F0F0" />
      <!-- Gradiente para sombra -->
      <defs>
        <linearGradient id="shadowGradient" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" style="stop-color:#000;stop-opacity:0" />
          <stop offset="100%" style="stop-color:#000;stop-opacity:0.4" />
        </linearGradient>
      </defs>
    </svg>
    
    <svg viewBox="0 0 32 32" class="whatsapp-icon">
      <path fill="currentColor" d="M16 0C7.164 0 0 7.164 0 16c0 2.828.736 5.484 2.016 7.796L.68 30.32l6.72-1.76A15.914 15.914 0 0 0 16 32c8.836 0 16-7.164 16-16S24.836 0 16 0zm0 29.333c-2.444 0-4.76-.656-6.76-1.796l-.484-.292-5.016 1.316 1.336-4.888-.32-.504A13.252 13.252 0 0 1 2.667 16C2.667 8.636 8.636 2.667 16 2.667S29.333 8.636 29.333 16 23.364 29.333 16 29.333z"/>
      <path fill="currentColor" d="M22.928 19.204c-.348-.176-2.06-1.02-2.384-1.136-.32-.116-.556-.176-.788.176-.232.352-.896 1.136-1.096 1.368-.2.232-.404.26-.752.084-.348-.176-1.472-.544-2.804-1.732-1.036-.928-1.736-2.072-1.936-2.42-.2-.348-.02-.536.152-.712.156-.156.348-.408.52-.612.172-.204.232-.348.348-.58.116-.232.06-.436-.028-.612-.088-.176-.788-1.904-1.08-2.604-.288-.68-.58-.588-.788-.6-.204-.012-.44-.012-.672-.012s-.612.084-.932.42c-.32.336-1.22 1.196-1.22 2.916s1.248 3.38 1.42 3.612c.172.232 2.444 3.732 5.924 5.236.828.356 1.476.568 1.98.728.832.264 1.588.228 2.188.14.668-.1 2.06-.844 2.352-1.66.292-.816.292-1.516.204-1.66-.088-.144-.32-.232-.668-.408z"/>
    </svg>
    <span class="whatsapp-tooltip">¡Chatea con nosotros!</span>
  </a>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

interface Props {
  phoneNumber?: string
  message?: string
}

const props = withDefaults(defineProps<Props>(), {
  phoneNumber: '529985401540',
  message: 'Hola, me gustaría obtener más información sobre sus servicios.'
})

const showPulse = ref(true)
const isChristmas = ref(false)

const encodedMessage = encodeURIComponent(props.message)

// Detectar tema navideño
const checkChristmasTheme = () => {
  isChristmas.value = document.documentElement.classList.contains('theme-christmas')
}

// Mostrar pulso cada 10 segundos
onMounted(() => {
  // Check initial theme
  checkChristmasTheme()
  
  // Listen for theme changes
  window.addEventListener('theme-changed', checkChristmasTheme)
  
  setInterval(() => {
    showPulse.value = true
    setTimeout(() => {
      showPulse.value = false
    }, 3000)
  }, 10000)
})

onUnmounted(() => {
  window.removeEventListener('theme-changed', checkChristmasTheme)
})
</script>

<style scoped>
.whatsapp-float {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  z-index: 1000;
  text-decoration: none;
}

.whatsapp-float:hover {
  transform: scale(1.15) translateY(-5px);
  box-shadow: 0 8px 20px rgba(37, 211, 102, 0.6);
}

.whatsapp-float:active {
  transform: scale(1.05);
}

/* Gorro de Santa SVG */
.santa-hat {
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
  width: 40px;
  height: 40px;
  z-index: 1;
  filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
  animation: swing 2s ease-in-out infinite;
}

@keyframes swing {
  0%, 100% {
    transform: translateX(-50%) rotate(-5deg);
  }
  50% {
    transform: translateX(-50%) rotate(5deg);
  }
}

.whatsapp-icon {
  width: 32px;
  height: 32px;
  color: #fff;
  transition: transform 0.3s ease;
}

.whatsapp-float:hover .whatsapp-icon {
  transform: rotate(15deg);
}

/* Animación de pulso */
.whatsapp-float.pulse {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
  }
  50% {
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4), 0 0 0 15px rgba(37, 211, 102, 0.1);
  }
  100% {
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
  }
}

/* Tooltip */
.whatsapp-tooltip {
  position: absolute;
  right: 75px;
  background: #fff;
  color: #333;
  padding: 10px 16px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  white-space: nowrap;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  opacity: 0;
  visibility: hidden;
  transform: translateX(10px);
  transition: all 0.3s ease;
  pointer-events: none;
}

.whatsapp-tooltip::after {
  content: '';
  position: absolute;
  right: -8px;
  top: 50%;
  transform: translateY(-50%);
  border: 8px solid transparent;
  border-left-color: #fff;
}

.whatsapp-float:hover .whatsapp-tooltip {
  opacity: 1;
  visibility: visible;
  transform: translateX(0);
}

/* Responsive */
@media (max-width: 768px) {
  .whatsapp-float {
    width: 56px;
    height: 56px;
    bottom: 20px;
    right: 20px;
  }

  .whatsapp-icon {
    width: 28px;
    height: 28px;
  }

  .whatsapp-tooltip {
    display: none;
  }
}
</style>
