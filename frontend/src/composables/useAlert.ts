// composables/useAlert.ts
import { ref } from 'vue'

interface AlertOptions {
  type?: 'success' | 'error' | 'warning' | 'info'
  title?: string
  message: string
  duration?: number
}

const alertState = ref({
  show: false,
  type: 'info' as 'success' | 'error' | 'warning' | 'info',
  title: '',
  message: '',
  duration: 5000,
})

export function useAlert() {
  const showAlert = (options: AlertOptions) => {
    alertState.value = {
      show: true,
      type: options.type || 'info',
      title: options.title || '',
      message: options.message,
      duration: options.duration || 5000,
    }
  }

  const success = (message: string, title?: string, duration?: number) => {
    showAlert({ type: 'success', message, title, duration })
  }

  const error = (message: string, title?: string, duration?: number) => {
    showAlert({ type: 'error', message, title, duration })
  }

  const warning = (message: string, title?: string, duration?: number) => {
    showAlert({ type: 'warning', message, title, duration })
  }

  const info = (message: string, title?: string, duration?: number) => {
    showAlert({ type: 'info', message, title, duration })
  }

  const hideAlert = () => {
    alertState.value.show = false
  }

  return {
    alertState,
    showAlert,
    success,
    error,
    warning,
    info,
    hideAlert,
  }
}
