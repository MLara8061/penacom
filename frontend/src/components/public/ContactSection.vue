<template>
  <section id="contacto" class="contact">
    <div class="container">
      <div class="contact-content">
        <div class="contact-info">
          <h2 class="section-title">Conversemos<br />sobre tu proyecto</h2>
          <p class="contact-description">
            Nuestro equipo está listo para asesorarte y desarrollar la solución LED perfecta para tu
            negocio.
          </p>

          <div class="contact-details">
            <div class="detail-item">
              <div class="detail-label">Ubicación</div>
              <div class="detail-value">Cancún, Quintana Roo</div>
            </div>

            <div class="detail-item">
              <div class="detail-label">Teléfono</div>
              <div class="detail-value">(998) 123-4567</div>
            </div>

            <div class="detail-item">
              <div class="detail-label">Email</div>
              <div class="detail-value">contacto@penacom.mx</div>
            </div>
          </div>
        </div>

        <form class="contact-form" @submit.prevent="handleSubmit">
          <div class="form-group">
            <input type="text" v-model="form.name" placeholder="Nombre" required />
          </div>

          <div class="form-group">
            <input type="email" v-model="form.email" placeholder="Email" required />
          </div>

          <div class="form-group">
            <input type="tel" v-model="form.phone" placeholder="Teléfono" required />
          </div>

          <div class="form-group">
            <textarea
              v-model="form.message"
              placeholder="Cuéntanos sobre tu proyecto"
              rows="6"
              required
            ></textarea>
          </div>

          <button type="submit" class="btn-submit" :disabled="loading">
            {{ loading ? 'Enviando...' : 'Enviar mensaje' }}
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useAlert } from '@/composables/useAlert'
import { reactive, ref } from 'vue'

const { success } = useAlert()
const form = reactive({
  name: '',
  email: '',
  phone: '',
  message: '',
})

const loading = ref(false)

const handleSubmit = async () => {
  loading.value = true

  // Simular envío
  await new Promise(resolve => setTimeout(resolve, 1500))

  success('Gracias por tu mensaje. Te contactaremos pronto.', '¡Mensaje Enviado!')

  // Limpiar formulario
  form.name = ''
  form.email = ''
  form.phone = ''
  form.message = ''

  loading.value = false
}
</script>

<style scoped>
.contact {
  padding: 120px 0;
  background: #f5f5f7;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

.contact-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: start;
}

.section-title {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 24px;
  letter-spacing: -0.03em;
  line-height: 1.1;
}

.contact-description {
  font-size: 1.25rem;
  color: #6e6e73;
  line-height: 1.6;
  margin-bottom: 48px;
}

.contact-details {
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.detail-label {
  font-size: 0.875rem;
  color: #6e6e73;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  font-weight: 500;
}

.detail-value {
  font-size: 1.125rem;
  color: #1d1d1f;
  font-weight: 500;
}

.contact-form {
  background: #fff;
  padding: 48px;
  border-radius: 16px;
}

.form-group {
  margin-bottom: 24px;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 16px;
  font-size: 1rem;
  border: 1px solid #d2d2d7;
  border-radius: 8px;
  font-family: inherit;
  transition: all 0.2s ease;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #0066cc;
}

.form-group textarea {
  resize: vertical;
}

.btn-submit {
  width: 100%;
  padding: 16px;
  background: #0066cc;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-submit:hover:not(:disabled) {
  background: #0052a3;
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

@media (max-width: 1024px) {
  .contact-content {
    grid-template-columns: 1fr;
    gap: 48px;
  }
}

@media (max-width: 768px) {
  .contact {
    padding: 80px 0;
  }

  .contact-form {
    padding: 32px 24px;
  }
}
</style>
