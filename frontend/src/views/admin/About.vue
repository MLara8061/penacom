<template>
  <div class="admin-about">
    <div class="page-header">
      <h1 class="page-title">Acerca de la Empresa</h1>
      <p class="page-description">Administra la información principal de tu empresa</p>
    </div>
    
    <form @submit.prevent="saveChanges" class="about-form">
      <div class="form-card">
        <div class="card-header">
          <svg class="card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
          </svg>
          <h2>Información Principal</h2>
        </div>

        <div class="form-group">
          <label for="title" class="form-label">
            Título
            <span class="required">*</span>
          </label>
          <input
            id="title"
            v-model="form.title"
            type="text"
            required
            class="form-control"
            placeholder="Ej: Líderes en Tecnología LED desde 2013"
          />
        </div>

        <div class="form-group">
          <label for="description" class="form-label">
            Descripción
            <span class="required">*</span>
          </label>
          <textarea
            id="description"
            v-model="form.description"
            rows="4"
            required
            class="form-control"
            placeholder="Descripción breve de tu empresa..."
          ></textarea>
          <div class="form-hint">{{ form.description.length }} caracteres</div>
        </div>

        <div class="form-group highlight-field">
          <label for="highlighted_text" class="form-label">
            <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            Texto Destacado
            <span class="required">*</span>
          </label>
          <textarea
            id="highlighted_text"
            v-model="form.highlighted_text"
            rows="3"
            required
            class="form-control"
            placeholder="Al adquirir nuestros productos, obtiene la más alta tecnología..."
          ></textarea>
          <div class="form-hint">Este texto se mostrará destacado en la sección Acerca de</div>
        </div>
      </div>

      <div class="form-card">
        <div class="card-header">
          <svg class="card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 11l3 3L22 4"></path>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
          </svg>
          <h2>Estadísticas</h2>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="years_experience" class="form-label">
              Años de Experiencia
              <span class="required">*</span>
            </label>
            <div class="input-with-icon">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
              </svg>
              <input
                id="years_experience"
                v-model.number="form.years_experience"
                type="number"
                min="0"
                required
                class="form-control with-icon"
              />
            </div>
          </div>

          <div class="form-group">
            <label for="happy_clients" class="form-label">
              Clientes Satisfechos
              <span class="required">*</span>
            </label>
            <div class="input-with-icon">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
              <input
                id="happy_clients"
                v-model.number="form.happy_clients"
                type="number"
                min="0"
                required
                class="form-control with-icon"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="form-card">
        <div class="card-header">
          <svg class="card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <circle cx="8.5" cy="8.5" r="1.5"></circle>
            <polyline points="21 15 16 10 5 21"></polyline>
          </svg>
          <h2>Imagen</h2>
        </div>

        <div class="form-group">
          <ImageUploader
            v-model="form.current_image"
            label="Imagen de la Empresa"
            :required="false"
            :show-history="true"
            :history="imageHistory"
            @upload="onImageUpload"
          />
          <div class="form-hint">Preferiblemente 800x600px o superior</div>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary" :disabled="loading">
          <svg v-if="!loading" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
          </svg>
          <svg v-else class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
          </svg>
          {{ loading ? 'Guardando...' : 'Guardar Cambios' }}
        </button>
      </div>
    </form>

    <transition name="fade">
      <div v-if="message" class="alert" :class="'alert-' + messageType">
        <svg v-if="messageType === 'success'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
          <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="15" y1="9" x2="9" y2="15"></line>
          <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <span>{{ message }}</span>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../../services/api'
import ImageUploader from '@/components/admin/ImageUploader.vue'

const form = ref({
  title: '',
  description: '',
  highlighted_text: '',
  years_experience: 0,
  happy_clients: 0,
  current_image: ''
})

const loading = ref(false)
const message = ref('')
const messageType = ref('')
const imageError = ref(false)
const imageHistory = ref([])

const loadData = async () => {
  try {
    const response = await api.get('/about')
    form.value = response.data
    imageError.value = false
  } catch (error) {
    console.error('Error al cargar datos:', error)
    message.value = 'Error al cargar los datos'
    messageType.value = 'error'
  }
}

const saveChanges = async () => {
  loading.value = true
  message.value = ''
  
  try {
    await api.put('/about', form.value)
    message.value = 'Cambios guardados exitosamente'
    messageType.value = 'success'
    
    setTimeout(() => {
      message.value = ''
    }, 3000)
  } catch (error) {
    console.error('Error al guardar:', error)
    message.value = error.response?.data?.message || 'Error al guardar los cambios'
    messageType.value = 'error'
  } finally {
    loading.value = false
  }
}

const onImageUpload = (url) => {
  console.log('Imagen subida:', url)
}

onMounted(() => {
  loadData()
})
</script>

<style scoped>
.admin-about {
  max-width: 100%;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.page-header {
  margin-bottom: 2rem;
}

.page-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 0.5rem;
}

.page-description {
  color: #64748b;
  font-size: 0.875rem;
}

.about-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: box-shadow 0.3s ease;
}

.form-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1.25rem 1.5rem;
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-bottom: 1px solid #e2e8f0;
}

.card-icon {
  width: 20px;
  height: 20px;
  color: #0066CC;
  flex-shrink: 0;
}

.card-header h2 {
  font-size: 1rem;
  font-weight: 600;
  color: #334155;
  margin: 0;
}

.form-group {
  padding: 1.5rem;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: #334155;
  margin-bottom: 0.5rem;
  font-size: 0.875rem;
}

.label-icon {
  width: 16px;
  height: 16px;
  color: #f59e0b;
}

.required {
  color: #ef4444;
}

.form-control {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.875rem;
  font-family: inherit;
  transition: all 0.3s ease;
  background: white;
}

.form-control:focus {
  outline: none;
  border-color: #0066CC;
  box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
}

.form-control::placeholder {
  color: #94a3b8;
}

textarea.form-control {
  resize: vertical;
  min-height: 100px;
  line-height: 1.6;
}

.form-hint {
  margin-top: 0.5rem;
  font-size: 0.75rem;
  color: #64748b;
}

.highlight-field {
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  border-radius: 8px;
  margin: 0 1.5rem 1.5rem;
  padding: 1.5rem !important;
}

.highlight-field .form-control {
  background: white;
  border-color: #fbbf24;
}

.highlight-field .form-control:focus {
  border-color: #f59e0b;
  box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.form-row {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  padding: 1.5rem;
}

.input-with-icon {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 18px;
  height: 18px;
  color: #64748b;
  pointer-events: none;
}

.form-control.with-icon {
  padding-left: 3rem;
}

.image-preview {
  margin-top: 1rem;
  border-radius: 8px;
  overflow: hidden;
  border: 2px solid #e2e8f0;
  max-width: 400px;
}

.image-preview img {
  width: 100%;
  height: auto;
  display: block;
}

.image-error {
  padding: 2rem;
  text-align: center;
  color: #ef4444;
  background: #fef2f2;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.875rem 2rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: inherit;
}

.btn svg {
  width: 18px;
  height: 18px;
}

.btn-primary {
  background: linear-gradient(135deg, #0066CC 0%, #0052A3 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(0, 102, 204, 0.2);
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.btn-primary:disabled {
  background: #cbd5e1;
  cursor: not-allowed;
  transform: none;
}

.spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.alert {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  font-weight: 500;
  font-size: 0.875rem;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  z-index: 1000;
  max-width: 400px;
}

.alert svg {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}

.alert-success {
  background: #d1fae5;
  color: #065f46;
  border: 1px solid #6ee7b7;
}

.alert-error {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fca5a5;
}

.fade-enter-active, .fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Mobile First - Tablet */
@media (min-width: 640px) {
  .page-title {
    font-size: 2rem;
  }

  .form-row {
    grid-template-columns: 1fr 1fr;
  }

  .card-header {
    padding: 1.5rem 2rem;
  }

  .form-group {
    padding: 1.5rem 2rem;
  }

  .highlight-field {
    margin: 0 2rem 1.5rem;
  }

  .form-row {
    padding: 1.5rem 2rem;
  }
}

/* Desktop */
@media (min-width: 1024px) {
  .admin-about {
    max-width: 900px;
  }

  .alert {
    bottom: 3rem;
    right: 3rem;
  }
}
</style>
