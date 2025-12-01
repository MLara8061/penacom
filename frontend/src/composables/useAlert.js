import { ref } from 'vue'

const alertState = ref({
  show: false,
  type: 'info',
  title: '',
  message: '',
  autoClose: true,
  duration: 3000,
  confirmAction: null,
  confirmText: 'Confirmar',
  cancelText: 'Cancelar',
})

export function useAlert() {
  const showAlert = options => {
    alertState.value = {
      show: true,
      type: options.type || 'info',
      title: options.title || '',
      message: options.message,
      autoClose: options.autoClose !== undefined ? options.autoClose : true,
      duration: options.duration || 3000,
      confirmAction: options.confirmAction || null,
      confirmText: options.confirmText || 'Confirmar',
      cancelText: options.cancelText || 'Cancelar',
    }
  }

  const success = (message, title = '') => {
    showAlert({
      type: 'success',
      title,
      message,
      autoClose: true,
      duration: 3000,
    })
  }

  const error = (message, title = '') => {
    showAlert({
      type: 'error',
      title,
      message,
      autoClose: true,
      duration: 4000,
    })
  }

  const warning = (message, title = '') => {
    showAlert({
      type: 'warning',
      title,
      message,
      autoClose: true,
      duration: 3500,
    })
  }

  const info = (message, title = '') => {
    showAlert({
      type: 'info',
      title,
      message,
      autoClose: true,
      duration: 3000,
    })
  }

  const confirm = (message, title = '', confirmAction) => {
    return new Promise(resolve => {
      showAlert({
        type: 'warning',
        title: title || '¿Estás seguro?',
        message,
        autoClose: false,
        confirmAction: () => {
          resolve(true)
          if (confirmAction) confirmAction()
        },
      })
    })
  }

  const close = () => {
    alertState.value.show = false
  }

  return {
    alertState,
    showAlert,
    success,
    error,
    warning,
    info,
    confirm,
    close,
  }
}
