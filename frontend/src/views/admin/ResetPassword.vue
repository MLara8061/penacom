<template>
  <div class="auth-container">
    <!-- Alert Notification -->
    <div class="alert-container">
      <AlertNotification
        v-model="alertState.show"
        :type="alertState.type"
        :title="alertState.title"
        :message="alertState.message"
        :duration="alertState.duration"
      />
    </div>

    <div class="auth-card">
      <div class="auth-header">
        <div class="logo-section">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
          </svg>
        </div>
        <h1>Nueva Contraseña</h1>
        <p>Ingresa tu nueva contraseña para acceder al panel administrativo</p>
      </div>

      <form @submit.prevent="handleSubmit" class="auth-form">
        <div class="form-group">
          <label for="email">Correo Electrónico</label>
          <div class="input-with-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path
                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
              />
              <polyline points="22,6 12,13 2,6" />
            </svg>
            <input
              id="email"
              v-model="email"
              type="email"
              placeholder="tu@correo.com"
              required
              autocomplete="email"
              :disabled="loading"
            />
          </div>
        </div>

        <div class="form-group">
          <label for="password">Nueva Contraseña</label>
          <div class="input-with-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
            <input
              id="password"
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Mínimo 8 caracteres"
              required
              minlength="8"
              autocomplete="new-password"
              :disabled="loading"
            />
            <button
              type="button"
              class="toggle-password"
              @click="showPassword = !showPassword"
              :disabled="loading"
            >
              <svg
                v-if="showPassword"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"
                />
                <line x1="1" y1="1" x2="23" y2="23" />
              </svg>
              <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmar Contraseña</label>
          <div class="input-with-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
            <input
              id="password_confirmation"
              v-model="passwordConfirmation"
              :type="showPasswordConfirmation ? 'text' : 'password'"
              placeholder="Confirma tu contraseña"
              required
              minlength="8"
              autocomplete="new-password"
              :disabled="loading"
            />
            <button
              type="button"
              class="toggle-password"
              @click="showPasswordConfirmation = !showPasswordConfirmation"
              :disabled="loading"
            >
              <svg
                v-if="showPasswordConfirmation"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"
                />
                <line x1="1" y1="1" x2="23" y2="23" />
              </svg>
              <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>
          </div>
        </div>

        <div
          v-if="password && passwordConfirmation && password !== passwordConfirmation"
          class="password-mismatch"
        >
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
          </svg>
          Las contraseñas no coinciden
        </div>

        <button
          type="submit"
          class="btn-submit"
          :disabled="loading || password !== passwordConfirmation"
        >
          <svg
            v-if="!loading"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
          >
            <polyline points="20 6 9 17 4 12" />
          </svg>
          <svg v-else class="spinner" viewBox="0 0 24 24">
            <circle
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
              fill="none"
              opacity="0.25"
            />
            <path
              d="M12 2a10 10 0 0 1 10 10"
              stroke="currentColor"
              stroke-width="4"
              fill="none"
              stroke-linecap="round"
            />
          </svg>
          {{ loading ? 'Actualizando...' : 'Restablecer Contraseña' }}
        </button>

        <div class="auth-footer">
          <router-link to="/admin/login" class="link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Volver al inicio de sesión
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import AlertNotification from '@/components/AlertNotification.vue'
import { useAlert } from '@/composables/useAlert'
// @ts-expect-error - api module is JavaScript
import api from '@/services/api'
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const showPassword = ref(false)
const showPasswordConfirmation = ref(false)
const loading = ref(false)
const token = ref('')

const { alertState, success, error: showError } = useAlert()

onMounted(() => {
  token.value = route.query.token as string
  email.value = route.query.email as string

  if (!token.value || !email.value) {
    showError('El enlace de recuperación es inválido o ha expirado', 'Error')
    setTimeout(() => {
      router.push('/admin/login')
    }, 3000)
  }
})

const handleSubmit = async () => {
  if (password.value !== passwordConfirmation.value) {
    showError('Las contraseñas no coinciden')
    return
  }

  if (password.value.length < 8) {
    showError('La contraseña debe tener al menos 8 caracteres')
    return
  }

  loading.value = true

  try {
    const response = await api.post('/auth/reset-password', {
      token: token.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value,
    })

    success(response.data.message || 'Contraseña actualizada correctamente', 'Éxito')

    setTimeout(() => {
      router.push('/admin/login')
    }, 2000)
  } catch (err) {
    const error = err as { response?: { data?: { message?: string } } }
    showError(error.response?.data?.message || 'El token es inválido o ha expirado', 'Error')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.auth-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 2rem;
  position: relative;
}

.alert-container {
  position: fixed;
  top: 2rem;
  right: 2rem;
  z-index: 9999;
  pointer-events: none;
}

.alert-container > * {
  pointer-events: auto;
}

.auth-card {
  background: white;
  border-radius: 24px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  width: 100%;
  max-width: 450px;
  padding: 3rem;
  animation: slideUp 0.4s ease-out;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.auth-header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.logo-section {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 20px;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.logo-section svg {
  width: 40px;
  height: 40px;
  color: white;
}

.auth-header h1 {
  font-size: 2rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 0.5rem;
}

.auth-header p {
  color: #718096;
  font-size: 0.95rem;
  line-height: 1.5;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group label {
  font-weight: 600;
  color: #2d3748;
  font-size: 0.9rem;
}

.input-with-icon {
  position: relative;
  display: flex;
  align-items: center;
}

.input-with-icon > svg {
  position: absolute;
  left: 1rem;
  width: 20px;
  height: 20px;
  color: #a0aec0;
  pointer-events: none;
  z-index: 1;
}

.input-with-icon input {
  width: 100%;
  padding: 0.875rem 3rem 0.875rem 3rem;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  background: #f7fafc;
}

.input-with-icon input:focus {
  outline: none;
  border-color: #667eea;
  background: white;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.input-with-icon input:disabled {
  background: #edf2f7;
  cursor: not-allowed;
  opacity: 0.6;
}

.toggle-password {
  position: absolute;
  right: 1rem;
  background: none;
  border: none;
  padding: 0.25rem;
  cursor: pointer;
  color: #a0aec0;
  transition: color 0.3s ease;
  z-index: 2;
}

.toggle-password:hover:not(:disabled) {
  color: #667eea;
}

.toggle-password:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

.toggle-password svg {
  width: 20px;
  height: 20px;
  display: block;
}

.password-mismatch {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  background: #fff5f5;
  border: 1px solid #fc8181;
  border-radius: 8px;
  color: #c53030;
  font-size: 0.875rem;
  font-weight: 500;
}

.password-mismatch svg {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
}

.btn-submit {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  width: 100%;
  padding: 1rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 0.5rem;
}

.btn-submit:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.btn-submit:active:not(:disabled) {
  transform: translateY(0);
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-submit svg {
  width: 20px;
  height: 20px;
}

.spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.auth-footer {
  text-align: center;
  padding-top: 1rem;
  border-top: 1px solid #e2e8f0;
}

.link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: #667eea;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.9rem;
  transition: all 0.3s ease;
}

.link svg {
  width: 18px;
  height: 18px;
}

.link:hover {
  color: #764ba2;
  gap: 0.75rem;
}

@media (max-width: 640px) {
  .auth-card {
    padding: 2rem;
  }

  .auth-header h1 {
    font-size: 1.75rem;
  }

  .logo-section {
    width: 70px;
    height: 70px;
  }

  .logo-section svg {
    width: 35px;
    height: 35px;
  }
}
</style>
