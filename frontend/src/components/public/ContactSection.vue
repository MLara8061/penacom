<template>
  <section id="contacto" class="contact-section section">
    <div class="container">
      <div class="section-header">
        <span class="section-badge">Hablemos</span>
        <h2 class="section-title">Solicita tu Cotización</h2>
        <p class="section-subtitle">
          Descubre cómo nuestras soluciones LED pueden transformar tu negocio
        </p>
      </div>

      <div class="contact-content">
        <div class="contact-form-wrapper">
          <form @submit.prevent="handleSubmit" class="contact-form">
            <div class="form-row">
              <div class="form-group">
                <label for="name">Nombre completo *</label>
                <input 
                  type="text" 
                  id="name" 
                  v-model="form.name" 
                  required
                  placeholder="Tu nombre"
                />
              </div>

              <div class="form-group">
                <label for="email">Correo electrónico *</label>
                <input 
                  type="email" 
                  id="email" 
                  v-model="form.email" 
                  required
                  placeholder="tu@email.com"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="phone">Teléfono *</label>
                <input 
                  type="tel" 
                  id="phone" 
                  v-model="form.phone" 
                  required
                  placeholder="(998) 123-4567"
                />
              </div>

              <div class="form-group">
                <label for="company">Empresa</label>
                <input 
                  type="text" 
                  id="company" 
                  v-model="form.company" 
                  placeholder="Nombre de tu empresa"
                />
              </div>
            </div>

            <div class="form-group">
              <label for="sector">Sector</label>
              <select id="sector" v-model="form.sector">
                <option value="">Selecciona un sector</option>
                <option value="hotel">Hotelero</option>
                <option value="restaurant">Restaurantero</option>
                <option value="retail">Tiendas/Retail</option>
                <option value="corporate">Corporativo</option>
                <option value="entertainment">Entretenimiento</option>
                <option value="other">Otro</option>
              </select>
            </div>

            <div class="form-group">
              <label for="message">Cuéntanos sobre tu proyecto *</label>
              <textarea 
                id="message" 
                v-model="form.message" 
                rows="5"
                required
                placeholder="Describe tu proyecto, necesidades y cualquier detalle relevante..."
              ></textarea>
            </div>

            <div v-if="submitStatus.message" :class="['submit-message', submitStatus.type]">
              {{ submitStatus.message }}
            </div>

            <button type="submit" class="btn btn-primary btn-lg" :disabled="submitting">
              <span v-if="!submitting">Enviar Solicitud</span>
              <span v-else>Enviando...</span>
              <svg v-if="!submitting" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </button>
          </form>
        </div>

        <div class="contact-info">
          <div class="info-card">
            <h3>Información de Contacto</h3>
            
            <div class="info-item">
              <div class="info-icon">📍</div>
              <div>
                <h4>Ubicación</h4>
                <p>Cancún, Quintana Roo, México</p>
              </div>
            </div>

            <div class="info-item">
              <div class="info-icon">📞</div>
              <div>
                <h4>Teléfono</h4>
                <p>+52 (998) 123-4567</p>
              </div>
            </div>

            <div class="info-item">
              <div class="info-icon">✉️</div>
              <div>
                <h4>Email</h4>
                <p>contacto@penacom.mx</p>
              </div>
            </div>

            <div class="info-item">
              <div class="info-icon">⏰</div>
              <div>
                <h4>Horario</h4>
                <p>Lun - Vie: 9:00 AM - 6:00 PM</p>
                <p>Sábado: 9:00 AM - 2:00 PM</p>
              </div>
            </div>
          </div>

          <div class="trust-badges">
            <div class="badge-item">
              <div class="badge-icon">✓</div>
              <p>+10 años de experiencia</p>
            </div>
            <div class="badge-item">
              <div class="badge-icon">✓</div>
              <p>+100 clientes satisfechos</p>
            </div>
            <div class="badge-item">
              <div class="badge-icon">✓</div>
              <p>Soporte técnico 24/7</p>
            </div>
            <div class="badge-item">
              <div class="badge-icon">✓</div>
              <p>Garantía en instalaciones</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  sector: '',
  message: ''
})

const submitting = ref(false)
const submitStatus = ref({ type: '', message: '' })

const handleSubmit = async () => {
  submitting.value = true
  submitStatus.value = { type: '', message: '' }

  try {
    // Simular envío (aquí conectarías con tu backend)
    await new Promise(resolve => setTimeout(resolve, 1500))
    
    submitStatus.value = {
      type: 'success',
      message: '¡Gracias! Hemos recibido tu solicitud. Te contactaremos pronto.'
    }

    // Limpiar formulario
    form.value = {
      name: '',
      email: '',
      phone: '',
      company: '',
      sector: '',
      message: ''
    }
  } catch (error) {
    submitStatus.value = {
      type: 'error',
      message: 'Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.'
    }
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.contact-section {
  background: var(--white);
}

.contact-content {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--spacing-2xl);
}

.contact-form-wrapper {
  background: var(--light-gray);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
}

.contact-form {
  max-width: 100%;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--spacing-md);
}

.form-group {
  margin-bottom: var(--spacing-md);
}

.form-group label {
  display: block;
  margin-bottom: var(--spacing-xs);
  font-weight: 600;
  color: var(--dark);
  font-size: var(--font-size-sm);
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: var(--spacing-md);
  border: 2px solid #E5E7EB;
  border-radius: var(--radius);
  font-size: var(--font-size-base);
  font-family: var(--font-primary);
  transition: var(--transition);
  background: var(--white);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
}

.form-group textarea {
  resize: vertical;
  min-height: 120px;
}

.submit-message {
  padding: var(--spacing-md);
  border-radius: var(--radius);
  margin-bottom: var(--spacing-md);
  font-weight: 500;
}

.submit-message.success {
  background: #D1FAE5;
  color: #065F46;
  border: 1px solid #A7F3D0;
}

.submit-message.error {
  background: #FEE2E2;
  color: #991B1B;
  border: 1px solid #FECACA;
}

.contact-info {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-lg);
}

.info-card {
  background: var(--light-blue);
  padding: var(--spacing-xl);
  border-radius: var(--radius-xl);
}

.info-card h3 {
  font-size: var(--font-size-2xl);
  color: var(--dark);
  margin-bottom: var(--spacing-lg);
}

.info-item {
  display: flex;
  gap: var(--spacing-md);
  margin-bottom: var(--spacing-lg);
}

.info-item:last-child {
  margin-bottom: 0;
}

.info-icon {
  font-size: 1.5rem;
  flex-shrink: 0;
}

.info-item h4 {
  font-size: var(--font-size-base);
  color: var(--primary-blue);
  margin-bottom: var(--spacing-xs);
  font-weight: 600;
}

.info-item p {
  color: var(--gray);
  font-size: var(--font-size-sm);
  margin: 0;
}

.trust-badges {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--spacing-md);
}

.badge-item {
  display: flex;
  align-items: center;
  gap: var(--spacing-sm);
  padding: var(--spacing-md);
  background: var(--white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
}

.badge-icon {
  width: 24px;
  height: 24px;
  background: var(--primary-blue);
  color: var(--white);
  border-radius: var(--radius-full);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  flex-shrink: 0;
  font-size: var(--font-size-sm);
}

.badge-item p {
  font-size: var(--font-size-xs);
  color: var(--dark);
  font-weight: 500;
  margin: 0;
}

@media (min-width: 768px) {
  .contact-content {
    grid-template-columns: 1.5fr 1fr;
  }

  .form-row {
    grid-template-columns: repeat(2, 1fr);
  }

  .trust-badges {
    grid-template-columns: 1fr;
  }
}

@media (min-width: 1024px) {
  .contact-form-wrapper {
    padding: var(--spacing-2xl);
  }
}
</style>
