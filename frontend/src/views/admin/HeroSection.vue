<template>
  <div class="admin-hero">
    <div class="page-header">
      <h1 class="page-title">Sección Héroe</h1>
      <p class="page-description">Gestiona las secciones destacadas de tu página principal</p>
      <button @click="showCreateModal = true" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Nueva Sección
      </button>
    </div>

    <div v-if="loading" class="loading-state">
      <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"></circle>
      </svg>
      <p>Cargando secciones...</p>
    </div>

    <div v-else-if="heroSections.length === 0" class="empty-state">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12.01" y2="8"></line>
        <line x1="12" y1="12" x2="12" y2="16"></line>
      </svg>
      <p>No hay secciones héroe creadas</p>
      <button @click="showCreateModal = true" class="btn btn-primary">Crear Primera Sección</button>
    </div>

    <div v-else class="hero-grid">
      <div v-for="hero in heroSections" :key="hero.id" class="hero-card">
        <div class="hero-preview" :style="{ backgroundImage: hero.background_image ? `url(${hero.background_image})` : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }">
          <div class="hero-overlay">
            <span v-if="!hero.is_active" class="badge badge-inactive">Inactiva</span>
            <span class="badge badge-order">Orden: {{ hero.order }}</span>
          </div>
        </div>
        
        <div class="hero-content">
          <h3 class="hero-title">{{ hero.title }}</h3>
          <p v-if="hero.subtitle" class="hero-subtitle">{{ hero.subtitle }}</p>
          <p v-if="hero.description" class="hero-description">{{ truncate(hero.description, 100) }}</p>
          
          <div class="hero-actions">
            <button @click="editHero(hero)" class="btn btn-sm btn-secondary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
              </svg>
              Editar
            </button>
            <button @click="deleteHero(hero)" class="btn btn-sm btn-danger">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              </svg>
              Eliminar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Create/Edit -->
    <transition name="modal">
      <div v-if="showCreateModal || showEditModal" class="modal-backdrop" @click="closeModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h2>{{ editingHero ? 'Editar Sección' : 'Nueva Sección' }}</h2>
            <button @click="closeModal" class="btn-close">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>

          <form @submit.prevent="saveHero" class="modal-body">
            <div class="form-group">
              <label class="form-label">Título <span class="required">*</span></label>
              <input v-model="form.title" type="text" required class="form-control" placeholder="Título principal">
            </div>

            <div class="form-group">
              <label class="form-label">Subtítulo</label>
              <input v-model="form.subtitle" type="text" class="form-control" placeholder="Subtítulo opcional">
            </div>

            <div class="form-group">
              <label class="form-label">Descripción</label>
              <textarea v-model="form.description" rows="3" class="form-control" placeholder="Descripción detallada..."></textarea>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Texto del Botón</label>
                <input v-model="form.button_text" type="text" class="form-control" placeholder="Ej: Saber Más">
              </div>

              <div class="form-group">
                <label class="form-label">Enlace del Botón</label>
                <input v-model="form.button_link" type="text" class="form-control" placeholder="Ej: #servicios">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Imagen de Fondo (URL)</label>
              <input v-model="form.background_image" type="url" class="form-control" placeholder="https://...">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Orden <span class="required">*</span></label>
                <input v-model.number="form.order" type="number" required min="0" class="form-control">
              </div>

              <div class="form-group">
                <label class="form-label">Estado</label>
                <label class="toggle">
                  <input v-model="form.is_active" type="checkbox">
                  <span class="toggle-slider"></span>
                  <span class="toggle-label">{{ form.is_active ? 'Activa' : 'Inactiva' }}</span>
                </label>
              </div>
            </div>

            <div class="modal-actions">
              <button type="button" @click="closeModal" class="btn btn-secondary">Cancelar</button>
              <button type="submit" class="btn btn-primary" :disabled="saving">
                <svg v-if="!saving" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                  <polyline points="17 21 17 13 7 13 7 21"></polyline>
                  <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                <svg v-else class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"></circle>
                </svg>
                {{ saving ? 'Guardando...' : 'Guardar' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>

    <!-- Alert -->
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

const heroSections = ref([])
const loading = ref(true)
const saving = ref(false)
const message = ref('')
const messageType = ref('')
const showCreateModal = ref(false)
const showEditModal = ref(false)
const editingHero = ref(null)

const form = ref({
  title: '',
  subtitle: '',
  description: '',
  button_text: '',
  button_link: '',
  background_image: '',
  is_active: true,
  order: 0
})

const loadHeroSections = async () => {
  try {
    const response = await api.get('/hero-sections')
    heroSections.value = response.data
  } catch (error) {
    console.error('Error al cargar secciones:', error)
    showMessage('Error al cargar las secciones', 'error')
  } finally {
    loading.value = false
  }
}

const saveHero = async () => {
  saving.value = true
  try {
    if (editingHero.value) {
      await api.put(`/hero-sections/${editingHero.value.id}`, form.value)
      showMessage('Sección actualizada exitosamente', 'success')
    } else {
      await api.post('/hero-sections', form.value)
      showMessage('Sección creada exitosamente', 'success')
    }
    await loadHeroSections()
    closeModal()
  } catch (error) {
    console.error('Error al guardar:', error)
    showMessage(error.response?.data?.message || 'Error al guardar la sección', 'error')
  } finally {
    saving.value = false
  }
}

const editHero = (hero) => {
  editingHero.value = hero
  form.value = { ...hero }
  showEditModal.value = true
}

const deleteHero = async (hero) => {
  if (!confirm(`¿Estás seguro de eliminar la sección "${hero.title}"?`)) return
  
  try {
    await api.delete(`/hero-sections/${hero.id}`)
    showMessage('Sección eliminada exitosamente', 'success')
    await loadHeroSections()
  } catch (error) {
    console.error('Error al eliminar:', error)
    showMessage('Error al eliminar la sección', 'error')
  }
}

const closeModal = () => {
  showCreateModal.value = false
  showEditModal.value = false
  editingHero.value = null
  form.value = {
    title: '',
    subtitle: '',
    description: '',
    button_text: '',
    button_link: '',
    background_image: '',
    is_active: true,
    order: 0
  }
}

const truncate = (text, length) => {
  if (!text) return ''
  return text.length > length ? text.substring(0, length) + '...' : text
}

const showMessage = (msg, type) => {
  message.value = msg
  messageType.value = type
  setTimeout(() => {
    message.value = ''
  }, 3000)
}

onMounted(() => {
  loadHeroSections()
})
</script>

<style scoped>
.admin-hero {
  max-width: 100%;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.page-header {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 2rem;
}

.page-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.page-description {
  color: #64748b;
  font-size: 0.875rem;
  margin: 0;
}

.loading-state,
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem 2rem;
  text-align: center;
}

.loading-state svg,
.empty-state svg {
  width: 48px;
  height: 48px;
  color: #94a3b8;
  margin-bottom: 1rem;
}

.loading-state p,
.empty-state p {
  color: #64748b;
  margin-bottom: 1.5rem;
}

.hero-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

.hero-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
}

.hero-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.hero-preview {
  height: 200px;
  background-size: cover;
  background-position: center;
  position: relative;
}

.hero-overlay {
  position: absolute;
  top: 1rem;
  right: 1rem;
  display: flex;
  gap: 0.5rem;
}

.badge {
  padding: 0.375rem 0.75rem;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  backdrop-filter: blur(10px);
}

.badge-inactive {
  background: rgba(239, 68, 68, 0.9);
  color: white;
}

.badge-order {
  background: rgba(255, 255, 255, 0.9);
  color: #1e293b;
}

.hero-content {
  padding: 1.5rem;
}

.hero-title {
  font-size: 1.125rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 0.5rem 0;
}

.hero-subtitle {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0 0 0.75rem 0;
}

.hero-description {
  font-size: 0.875rem;
  color: #64748b;
  line-height: 1.6;
  margin: 0 0 1rem 0;
}

.hero-actions {
  display: flex;
  gap: 0.75rem;
}

/* Modal */
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 1rem;
  overflow-y: auto;
  backdrop-filter: blur(2px);
}

.modal-content {
  background: white;
  border-radius: 12px;
  width: 100%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.5rem;
  border-bottom: 1px solid #e2e8f0;
}

.modal-header h2 {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.btn-close {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  background: transparent;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-close:hover {
  background: #f1f5f9;
}

.btn-close svg {
  width: 20px;
  height: 20px;
  color: #64748b;
}

.modal-body {
  padding: 1.5rem;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  margin-top: 1.5rem;
}

/* Forms */
.form-group {
  margin-bottom: 1.25rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #334155;
  margin-bottom: 0.5rem;
  font-size: 0.875rem;
}

.required {
  color: #ef4444;
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.875rem;
  font-family: inherit;
  transition: all 0.3s ease;
}

.form-control:focus {
  outline: none;
  border-color: #0066CC;
  box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
}

textarea.form-control {
  resize: vertical;
  min-height: 80px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
}

.toggle {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
}

.toggle input {
  position: absolute;
  opacity: 0;
}

.toggle-slider {
  position: relative;
  width: 44px;
  height: 24px;
  background: #cbd5e1;
  border-radius: 12px;
  transition: background 0.3s;
}

.toggle-slider::before {
  content: '';
  position: absolute;
  width: 18px;
  height: 18px;
  background: white;
  border-radius: 50%;
  top: 3px;
  left: 3px;
  transition: transform 0.3s;
}

.toggle input:checked + .toggle-slider {
  background: #0066CC;
}

.toggle input:checked + .toggle-slider::before {
  transform: translateX(20px);
}

.toggle-label {
  font-size: 0.875rem;
  color: #64748b;
  font-weight: 500;
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
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

.btn-sm {
  padding: 0.5rem 1rem;
  font-size: 0.8125rem;
}

.btn-sm svg {
  width: 16px;
  height: 16px;
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

.btn-secondary {
  background: #f1f5f9;
  color: #475569;
}

.btn-secondary:hover {
  background: #e2e8f0;
}

.btn-danger {
  background: #fee2e2;
  color: #991b1b;
}

.btn-danger:hover {
  background: #fecaca;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none !important;
}

.spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

/* Alert */
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

/* Transitions */
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
  opacity: 0;
}

.modal-enter-active .modal-content,
.modal-leave-active .modal-content {
  transition: transform 0.3s ease;
}

.modal-enter-from .modal-content {
  transform: scale(0.95) translateY(20px);
}

.modal-leave-to .modal-content {
  transform: scale(0.95) translateY(20px);
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

/* Responsive */
@media (min-width: 640px) {
  .page-header {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }

  .page-title {
    font-size: 2rem;
  }

  .hero-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .form-row {
    grid-template-columns: 1fr 1fr;
  }

  .modal-body {
    padding: 2rem;
  }
}

@media (min-width: 1024px) {
  .hero-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}
</style>
