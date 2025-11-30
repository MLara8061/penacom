<template>
  <div class="admin-testimonials">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Reseñas y Testimonios</h1>
        <p class="page-description">Gestiona las opiniones de clientes mostradas en la landing</p>
      </div>
      <button @click="openModal()" class="btn-new">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="12" y1="5" x2="12" y2="19"/>
          <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Nueva Reseña
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <svg class="spinner" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
        <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
      </svg>
      <p>Cargando reseñas...</p>
    </div>

    <!-- Testimonials Grid -->
    <div v-else-if="testimonials.length > 0" class="testimonials-grid">
      <div 
        v-for="testimonial in testimonials" 
        :key="testimonial.id" 
        class="testimonial-card"
      >
        <div class="card-header">
          <div class="client-info">
            <div class="avatar" :style="{ backgroundImage: `url(${testimonial.client_photo || 'https://i.pravatar.cc/150?img=' + testimonial.id})` }"></div>
            <div class="client-details">
              <h3 class="client-name">{{ testimonial.client_name }}</h3>
              <p v-if="testimonial.client_position || testimonial.client_company" class="client-meta">
                <span v-if="testimonial.client_position">{{ testimonial.client_position }}</span>
                <span v-if="testimonial.client_position && testimonial.client_company"> • </span>
                <span v-if="testimonial.client_company">{{ testimonial.client_company }}</span>
              </p>
            </div>
          </div>
          <div class="card-badges">
            <span v-if="testimonial.is_featured" class="badge badge-featured">Destacado</span>
            <span :class="['badge', testimonial.is_active ? 'badge-active' : 'badge-inactive']">
              {{ testimonial.is_active ? 'Activo' : 'Inactivo' }}
            </span>
          </div>
        </div>

        <div class="card-body">
          <div class="rating">
            <svg 
              v-for="star in 5" 
              :key="star"
              :class="['star', { filled: star <= testimonial.rating }]"
              viewBox="0 0 24 24" 
              fill="currentColor"
            >
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
          </div>
          <p class="testimonial-text">{{ truncateText(testimonial.testimonial, 150) }}</p>
        </div>

        <div class="card-footer">
          <button @click="openModal(testimonial)" class="btn-icon btn-edit" title="Editar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
          </button>
          <button @click="confirmDelete(testimonial)" class="btn-icon btn-delete" title="Eliminar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="3 6 5 6 21 6"/>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="empty-state">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
      <h3>No hay reseñas registradas</h3>
      <p>Crea tu primera reseña para comenzar</p>
      <button @click="openModal()" class="btn-empty">Crear Reseña</button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h2>{{ isEditing ? 'Editar Reseña' : 'Nueva Reseña' }}</h2>
          <button @click="closeModal" class="btn-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="saveTestimonial" class="modal-body">
          <div class="form-row">
            <div class="form-group">
              <label for="client_name" class="form-label">
                Nombre del Cliente
                <span class="required">*</span>
              </label>
              <input
                id="client_name"
                v-model="form.client_name"
                type="text"
                required
                class="form-control"
                placeholder="Ej: Juan Pérez"
              />
            </div>

            <div class="form-group">
              <label for="rating" class="form-label">
                Calificación
                <span class="required">*</span>
              </label>
              <select
                id="rating"
                v-model.number="form.rating"
                required
                class="form-control"
              >
                <option :value="5">⭐⭐⭐⭐⭐ (5)</option>
                <option :value="4">⭐⭐⭐⭐ (4)</option>
                <option :value="3">⭐⭐⭐ (3)</option>
                <option :value="2">⭐⭐ (2)</option>
                <option :value="1">⭐ (1)</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="client_position" class="form-label">Cargo/Puesto</label>
              <input
                id="client_position"
                v-model="form.client_position"
                type="text"
                class="form-control"
                placeholder="Ej: Gerente de Operaciones"
              />
            </div>

            <div class="form-group">
              <label for="client_company" class="form-label">Empresa</label>
              <input
                id="client_company"
                v-model="form.client_company"
                type="text"
                class="form-control"
                placeholder="Ej: Hotel Riviera"
              />
            </div>
          </div>

          <div class="form-group">
            <label for="testimonial" class="form-label">
              Testimonial
              <span class="required">*</span>
            </label>
            <textarea
              id="testimonial"
              v-model="form.testimonial"
              rows="5"
              required
              class="form-control"
              placeholder="Escribe aquí la opinión del cliente..."
            ></textarea>
            <div class="form-hint">{{ form.testimonial.length }} caracteres</div>
          </div>

          <div class="form-group">
            <ImageUploader
              v-model="form.client_photo"
              label="Foto del Cliente"
              :required="false"
              :show-history="true"
              :history="imageHistory"
              @upload="onImageUpload"
            />
            <div class="form-hint">Si no se proporciona, se usará un avatar genérico</div>
          </div>

          <div class="form-row">
            <div class="form-group checkbox-group">
              <label class="checkbox-label">
                <input
                  v-model="form.is_featured"
                  type="checkbox"
                  class="form-checkbox"
                />
                <span>Reseña destacada</span>
              </label>
            </div>

            <div class="form-group checkbox-group">
              <label class="checkbox-label">
                <input
                  v-model="form.is_active"
                  type="checkbox"
                  class="form-checkbox"
                />
                <span>Visible en la página</span>
              </label>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" @click="closeModal" class="btn-secondary">
              Cancelar
            </button>
            <button type="submit" class="btn-primary" :disabled="saving">
              <svg v-if="saving" class="spinner" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
                <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
              </svg>
              <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
              </svg>
              {{ saving ? 'Guardando...' : 'Guardar Reseña' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="modal-overlay" @click="showDeleteModal = false">
      <div class="modal-content modal-small" @click.stop>
        <div class="modal-header">
          <h2>Confirmar Eliminación</h2>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro de que deseas eliminar la reseña de <strong>{{ itemToDelete?.client_name }}</strong>?</p>
          <p class="text-warning">Esta acción no se puede deshacer.</p>
        </div>
        <div class="form-actions">
          <button @click="showDeleteModal = false" class="btn-secondary">
            Cancelar
          </button>
          <button @click="deleteTestimonial" class="btn-danger" :disabled="saving">
            {{ saving ? 'Eliminando...' : 'Eliminar' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api.js'
import ImageUploader from '@/components/admin/ImageUploader.vue'

const loading = ref(true)
const saving = ref(false)
const testimonials = ref([])
const showModal = ref(false)
const showDeleteModal = ref(false)
const isEditing = ref(false)
const itemToDelete = ref(null)
const imageHistory = ref([])

const form = ref({
  client_name: '',
  client_position: '',
  client_company: '',
  client_photo: '',
  testimonial: '',
  rating: 5,
  is_featured: false,
  is_active: true
})

const fetchTestimonials = async () => {
  loading.value = true
  try {
    const response = await api.get('/testimonials')
    testimonials.value = response.data
  } catch (error) {
    console.error('Error al cargar testimonios:', error)
  } finally {
    loading.value = false
  }
}

const openModal = (item = null) => {
  if (item) {
    isEditing.value = true
    form.value = { ...item }
  } else {
    isEditing.value = false
    form.value = {
      client_name: '',
      client_position: '',
      client_company: '',
      client_photo: '',
      testimonial: '',
      rating: 5,
      is_featured: false,
      is_active: true
    }
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  isEditing.value = false
}

const saveTestimonial = async () => {
  saving.value = true
  try {
    if (isEditing.value) {
      await api.put(`/testimonials/${form.value.id}`, form.value)
    } else {
      await api.post('/testimonials', form.value)
    }
    await fetchTestimonials()
    closeModal()
  } catch (error) {
    console.error('Error al guardar reseña:', error)
    alert('Error al guardar la reseña. Por favor intenta de nuevo.')
  } finally {
    saving.value = false
  }
}

const confirmDelete = (item) => {
  itemToDelete.value = item
  showDeleteModal.value = true
}

const deleteTestimonial = async () => {
  saving.value = true
  try {
    await api.delete(`/testimonials/${itemToDelete.value.id}`)
    await fetchTestimonials()
    showDeleteModal.value = false
    itemToDelete.value = null
  } catch (error) {
    console.error('Error al eliminar reseña:', error)
    alert('Error al eliminar la reseña. Por favor intenta de nuevo.')
  } finally {
    saving.value = false
  }
}

const truncateText = (text, maxLength) => {
  return text && text.length > maxLength ? text.substring(0, maxLength) + '...' : text
}

const onImageUpload = (url) => {
  console.log('Imagen subida:', url)
}

onMounted(() => {
  fetchTestimonials()
})
</script>

<style scoped>
.admin-testimonials {
  padding: 2rem;
  max-width: 1400px;
  margin: 0 auto;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 2rem;
  gap: 2rem;
}

.header-content {
  flex: 1;
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.5rem 0;
}

.page-description {
  color: #6c757d;
  margin: 0;
}

.btn-new {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-new:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-new svg {
  width: 18px;
  height: 18px;
}

/* Testimonials Grid */
.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
}

.testimonial-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: all 0.2s;
  display: flex;
  flex-direction: column;
}

.testimonial-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.card-header {
  padding: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  border-bottom: 1px solid #f8f9fa;
}

.client-info {
  display: flex;
  gap: 1rem;
  flex: 1;
}

.avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background-size: cover;
  background-position: center;
  flex-shrink: 0;
}

.client-details {
  flex: 1;
  min-width: 0;
}

.client-name {
  font-size: 1.125rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.25rem 0;
}

.client-meta {
  font-size: 0.875rem;
  color: #6c757d;
  margin: 0;
}

.card-badges {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  align-items: flex-end;
}

.badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
}

.badge-featured {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.badge-active {
  background: #d1fae5;
  color: #065f46;
}

.badge-inactive {
  background: #fee2e2;
  color: #991b1b;
}

.card-body {
  padding: 1.5rem;
  flex: 1;
}

.rating {
  display: flex;
  gap: 0.25rem;
  margin-bottom: 1rem;
}

.star {
  width: 20px;
  height: 20px;
  color: #e5e7eb;
  transition: color 0.2s;
}

.star.filled {
  color: #fbbf24;
}

.testimonial-text {
  color: #495057;
  font-size: 0.875rem;
  line-height: 1.6;
  font-style: italic;
  margin: 0;
}

.card-footer {
  display: flex;
  gap: 0.5rem;
  padding: 1rem 1.5rem;
  border-top: 1px solid #f8f9fa;
}

.btn-icon {
  width: 36px;
  height: 36px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.btn-icon svg {
  width: 18px;
  height: 18px;
}

.btn-edit {
  background: #e9ecef;
  color: #495057;
}

.btn-edit:hover {
  background: #dee2e6;
}

.btn-delete {
  background: #fee2e2;
  color: #991b1b;
}

.btn-delete:hover {
  background: #fecaca;
}

/* States */
.loading-state,
.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.loading-state svg,
.empty-state svg {
  width: 64px;
  height: 64px;
  color: #667eea;
  margin-bottom: 1rem;
}

.empty-state h3 {
  margin: 1rem 0 0.5rem;
  color: #1a1a2e;
}

.empty-state p {
  color: #6c757d;
  margin-bottom: 1.5rem;
}

.btn-empty {
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
}

.spinner {
  width: 18px;
  height: 18px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Modal */
.modal-overlay {
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
}

.modal-content {
  background: white;
  border-radius: 16px;
  max-width: 700px;
  width: 100%;
  max-height: 90vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.modal-small {
  max-width: 400px;
}

.modal-header {
  padding: 1.5rem;
  border-bottom: 1px solid #dee2e6;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h2 {
  margin: 0;
  font-size: 1.5rem;
  color: #1a1a2e;
}

.btn-close {
  width: 32px;
  height: 32px;
  border: none;
  background: #f8f9fa;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-close:hover {
  background: #e9ecef;
}

.btn-close svg {
  width: 18px;
  height: 18px;
  stroke: #495057;
}

.modal-body {
  padding: 1.5rem;
  overflow-y: auto;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #495057;
  margin-bottom: 0.5rem;
  font-size: 0.875rem;
}

.required {
  color: #dc3545;
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #dee2e6;
  border-radius: 8px;
  font-size: 0.875rem;
  transition: border-color 0.2s;
}

.form-control:focus {
  outline: none;
  border-color: #667eea;
}

.form-hint {
  font-size: 0.75rem;
  color: #6c757d;
  margin-top: 0.25rem;
}

.checkbox-group {
  display: flex;
  align-items: center;
  height: 100%;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  user-select: none;
}

.form-checkbox {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
  padding: 1.5rem;
  border-top: 1px solid #dee2e6;
}

.btn-secondary,
.btn-primary,
.btn-danger {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-secondary {
  background: #f8f9fa;
  color: #495057;
}

.btn-secondary:hover {
  background: #e9ecef;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-danger {
  background: #dc3545;
  color: white;
}

.btn-danger:hover:not(:disabled) {
  background: #c82333;
}

.btn-danger:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-primary svg,
.btn-danger svg {
  width: 18px;
  height: 18px;
}

.text-warning {
  color: #dc3545;
  font-size: 0.875rem;
}

/* Responsive */
@media (max-width: 768px) {
  .admin-testimonials {
    padding: 1rem;
  }

  .page-header {
    flex-direction: column;
  }

  .btn-new {
    width: 100%;
    justify-content: center;
  }

  .testimonials-grid {
    grid-template-columns: 1fr;
  }

  .form-row {
    grid-template-columns: 1fr;
  }

  .card-header {
    flex-direction: column;
  }

  .card-badges {
    flex-direction: row;
    width: 100%;
  }
}
</style>
