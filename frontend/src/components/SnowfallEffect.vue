<template>
  <div v-if="isActive" class="snowfall-container">
    <div 
      v-for="(snowflake, index) in snowflakes" 
      :key="index"
      class="snowflake"
      :style="snowflake.style"
    >
      {{ snowflake.char }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

interface Snowflake {
  char: string
  style: {
    left: string
    fontSize: string
    animationDuration: string
    animationDelay: string
    opacity: string
  }
}

const isActive = ref(false)
const snowflakes = ref<Snowflake[]>([])

const snowflakeChars = ['❄', '❅', '❆', '✻', '✼', '❉', '✺']

const generateSnowflakes = () => {
  const count = window.innerWidth < 768 ? 30 : 50
  const flakes: Snowflake[] = []
  
  for (let i = 0; i < count; i++) {
    const randomChar = snowflakeChars[Math.floor(Math.random() * snowflakeChars.length)] || '❄'
    flakes.push({
      char: randomChar,
      style: {
        left: `${Math.random() * 100}%`,
        fontSize: `${Math.random() * 15 + 10}px`,
        animationDuration: `${Math.random() * 10 + 8}s`,
        animationDelay: `${Math.random() * 5}s`,
        opacity: `${Math.random() * 0.6 + 0.4}`
      }
    })
  }
  
  snowflakes.value = flakes
}

const checkTheme = () => {
  const theme = document.documentElement.classList.contains('theme-christmas')
  isActive.value = theme
  
  if (theme && snowflakes.value.length === 0) {
    generateSnowflakes()
  }
}

onMounted(() => {
  checkTheme()
  
  // Escuchar cambios de tema
  window.addEventListener('theme-changed', (event: any) => {
    isActive.value = event.detail.theme === 'christmas'
    if (event.detail.theme === 'christmas' && snowflakes.value.length === 0) {
      generateSnowflakes()
    }
  })
  
  // Regenerar copos al cambiar tamaño de ventana
  window.addEventListener('resize', () => {
    if (isActive.value) {
      generateSnowflakes()
    }
  })
})

onUnmounted(() => {
  window.removeEventListener('theme-changed', checkTheme)
  window.removeEventListener('resize', generateSnowflakes)
})
</script>

<style scoped>
.snowfall-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 9999;
  overflow: hidden;
}

.snowflake {
  position: absolute;
  top: -20px;
  color: #fff;
  text-shadow: 0 0 5px rgba(255, 255, 255, 0.8);
  animation: fall linear infinite;
  user-select: none;
}

@keyframes fall {
  0% {
    transform: translateY(-20px) rotate(0deg);
  }
  100% {
    transform: translateY(100vh) rotate(360deg);
  }
}

/* Animación alternativa para variedad */
.snowflake:nth-child(2n) {
  animation-name: fall-swing;
}

@keyframes fall-swing {
  0% {
    transform: translateY(-20px) translateX(0) rotate(0deg);
  }
  25% {
    transform: translateY(25vh) translateX(30px) rotate(90deg);
  }
  50% {
    transform: translateY(50vh) translateX(0) rotate(180deg);
  }
  75% {
    transform: translateY(75vh) translateX(-30px) rotate(270deg);
  }
  100% {
    transform: translateY(100vh) translateX(0) rotate(360deg);
  }
}

/* Variación para copos más grandes */
.snowflake:nth-child(3n) {
  animation-name: fall-zigzag;
}

@keyframes fall-zigzag {
  0%, 100% {
    transform: translateY(-20px) translateX(0) rotate(0deg);
  }
  25% {
    transform: translateY(25vh) translateX(-20px) rotate(90deg);
  }
  50% {
    transform: translateY(50vh) translateX(20px) rotate(180deg);
  }
  75% {
    transform: translateY(75vh) translateX(-10px) rotate(270deg);
  }
}
</style>
