<template>
  <Transition name="alert-slide">
    <div v-if="show" :class="['alert-notification', `alert-${type}`]" role="alert">
      <div class="alert-icon">
        <svg
          v-if="type === 'success'"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
        >
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
          <polyline points="22 4 12 14.01 9 11.01" />
        </svg>
        <svg
          v-else-if="type === 'error'"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
        >
          <circle cx="12" cy="12" r="10" />
          <line x1="15" y1="9" x2="9" y2="15" />
          <line x1="9" y1="9" x2="15" y2="15" />
        </svg>
        <svg
          v-else-if="type === 'warning'"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"
          />
          <line x1="12" y1="9" x2="12" y2="13" />
          <line x1="12" y1="17" x2="12.01" y2="17" />
        </svg>
        <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10" />
          <line x1="12" y1="16" x2="12" y2="12" />
          <line x1="12" y1="8" x2="12.01" y2="8" />
        </svg>
      </div>

      <div class="alert-content">
        <h4 v-if="title" class="alert-title">{{ title }}</h4>
        <p class="alert-message">{{ message }}</p>
      </div>

      <button class="alert-close" @click="close" aria-label="Cerrar">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>
    </div>
  </Transition>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'

interface Props {
  type?: 'success' | 'error' | 'warning' | 'info'
  title?: string
  message: string
  duration?: number
  modelValue?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  type: 'info',
  duration: 5000,
  modelValue: false,
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void
  (e: 'close'): void
}>()

const show = ref(props.modelValue)
let timeout: ReturnType<typeof setTimeout> | null = null

const close = () => {
  show.value = false
  emit('update:modelValue', false)
  emit('close')
}

const startTimer = () => {
  if (timeout) clearTimeout(timeout)
  if (props.duration > 0) {
    timeout = setTimeout(() => {
      close()
    }, props.duration)
  }
}

watch(
  () => props.modelValue,
  newVal => {
    show.value = newVal
    if (newVal) {
      startTimer()
    }
  }
)

onMounted(() => {
  if (show.value) {
    startTimer()
  }
})
</script>

<style scoped>
.alert-notification {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1rem 1.25rem;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
  margin-bottom: 1rem;
  max-width: 500px;
}

.alert-icon {
  flex-shrink: 0;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.alert-icon svg {
  width: 100%;
  height: 100%;
}

.alert-content {
  flex: 1;
  min-width: 0;
}

.alert-title {
  font-size: 0.95rem;
  font-weight: 600;
  margin: 0 0 0.25rem 0;
  line-height: 1.4;
}

.alert-message {
  font-size: 0.875rem;
  margin: 0;
  line-height: 1.5;
  opacity: 0.95;
}

.alert-close {
  flex-shrink: 0;
  width: 20px;
  height: 20px;
  padding: 0;
  border: none;
  background: transparent;
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.alert-close:hover {
  opacity: 1;
}

.alert-close svg {
  width: 100%;
  height: 100%;
}

/* Success */
.alert-success {
  background: linear-gradient(135deg, rgba(16, 185, 129, 0.95) 0%, rgba(5, 150, 105, 0.95) 100%);
  color: white;
}

.alert-success .alert-icon svg {
  stroke: white;
}

.alert-success .alert-close svg {
  stroke: white;
}

/* Error */
.alert-error {
  background: linear-gradient(135deg, rgba(239, 68, 68, 0.95) 0%, rgba(220, 38, 38, 0.95) 100%);
  color: white;
}

.alert-error .alert-icon svg {
  stroke: white;
}

.alert-error .alert-close svg {
  stroke: white;
}

/* Warning */
.alert-warning {
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.95) 0%, rgba(217, 119, 6, 0.95) 100%);
  color: white;
}

.alert-warning .alert-icon svg {
  stroke: white;
}

.alert-warning .alert-close svg {
  stroke: white;
}

/* Info */
.alert-info {
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.95) 0%, rgba(37, 99, 235, 0.95) 100%);
  color: white;
}

.alert-info .alert-icon svg {
  stroke: white;
}

.alert-info .alert-close svg {
  stroke: white;
}

/* Animations */
.alert-slide-enter-active {
  animation: alertSlideIn 0.3s ease-out;
}

.alert-slide-leave-active {
  animation: alertSlideOut 0.3s ease-in;
}

@keyframes alertSlideIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes alertSlideOut {
  from {
    opacity: 1;
    transform: translateY(0);
  }
  to {
    opacity: 0;
    transform: translateY(-20px);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .alert-notification {
    max-width: 100%;
    margin: 0 1rem 1rem;
  }

  .alert-title {
    font-size: 0.9rem;
  }

  .alert-message {
    font-size: 0.8125rem;
  }
}
</style>
