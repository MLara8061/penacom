<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <Teleport to="body">
    <Transition name="alert-fade">
      <div v-if="show" class="alert-overlay">
        <div class="alert-container" :class="`alert-${type}`">
          <div class="alert-icon">
            <!-- Success -->
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
            <!-- Error -->
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
            <!-- Warning -->
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
            <!-- Info -->
            <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <line x1="12" y1="16" x2="12" y2="12" />
              <line x1="12" y1="8" x2="12.01" y2="8" />
            </svg>
          </div>

          <div class="alert-content">
            <h3 v-if="title" class="alert-title">{{ title }}</h3>
            <p class="alert-message">{{ message }}</p>
          </div>

          <button v-if="!autoClose" @click="close" class="alert-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </button>

          <div v-if="confirmAction" class="alert-actions">
            <button @click="close" class="btn-cancel">{{ cancelText }}</button>
            <button @click="confirm" class="btn-confirm">{{ confirmText }}</button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { onMounted, watch } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  type: {
    type: String,
    default: 'info', // success, error, warning, info
    validator: (value: string) => ['success', 'error', 'warning', 'info'].includes(value),
  },
  title: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    required: true,
  },
  autoClose: {
    type: Boolean,
    default: true,
  },
  duration: {
    type: Number,
    default: 3000,
  },
  confirmAction: {
    type: Function,
    default: null,
  },
  confirmText: {
    type: String,
    default: 'Confirmar',
  },
  cancelText: {
    type: String,
    default: 'Cancelar',
  },
})

const emit = defineEmits(['close', 'confirm'])

let timeoutId: ReturnType<typeof setTimeout> | null = null

const close = () => {
  if (timeoutId) clearTimeout(timeoutId)
  emit('close')
}

const confirm = () => {
  emit('confirm')
  close()
}

watch(
  () => props.show,
  newVal => {
    if (newVal && props.autoClose && !props.confirmAction) {
      timeoutId = setTimeout(() => {
        close()
      }, props.duration)
    }
  }
)

onMounted(() => {
  if (props.show && props.autoClose && !props.confirmAction) {
    timeoutId = setTimeout(() => {
      close()
    }, props.duration)
  }
})
</script>

<style scoped>
.alert-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  padding: 1rem;
}

.alert-container {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  max-width: 500px;
  width: 100%;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  display: flex;
  gap: 1.5rem;
  position: relative;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.alert-icon {
  flex-shrink: 0;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.alert-icon svg {
  width: 28px;
  height: 28px;
}

.alert-success .alert-icon {
  background: #d1fae5;
  color: #065f46;
}

.alert-error .alert-icon {
  background: #fee;
  color: #c53030;
}

.alert-warning .alert-icon {
  background: #fef3c7;
  color: #92400e;
}

.alert-info .alert-icon {
  background: #dbeafe;
  color: #1e40af;
}

.alert-content {
  flex: 1;
}

.alert-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.5rem 0;
}

.alert-message {
  font-size: 1rem;
  color: #6c757d;
  margin: 0;
  line-height: 1.5;
}

.alert-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #6c757d;
  transition: all 0.2s;
}

.alert-close:hover {
  background: #f8f9fa;
  color: #1a1a2e;
}

.alert-close svg {
  width: 18px;
  height: 18px;
}

.alert-actions {
  display: flex;
  gap: 0.75rem;
  margin-top: 1.5rem;
  width: 100%;
}

.btn-cancel,
.btn-confirm {
  flex: 1;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-cancel {
  background: #f8f9fa;
  color: #495057;
}

.btn-cancel:hover {
  background: #e9ecef;
}

.btn-confirm {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-confirm:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.alert-fade-enter-active,
.alert-fade-leave-active {
  transition: opacity 0.3s ease;
}

.alert-fade-enter-from,
.alert-fade-leave-to {
  opacity: 0;
}

@media (max-width: 640px) {
  .alert-container {
    padding: 1.5rem;
  }

  .alert-icon {
    width: 40px;
    height: 40px;
  }

  .alert-icon svg {
    width: 24px;
    height: 24px;
  }

  .alert-title {
    font-size: 1.1rem;
  }

  .alert-message {
    font-size: 0.95rem;
  }
}
</style>
