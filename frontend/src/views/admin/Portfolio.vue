<template>
  <div class="admin-portfolio">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Portafolio</h1>
        <p class="page-description">Gestiona los proyectos y casos de éxito mostrados en el slider</p>
      </div>
      <button @click="openModal()" class="btn-new">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="12" y1="5" x2="12" y2="19"/>
          <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Nuevo Proyecto
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <svg class="spinner" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
        <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
      </svg>
      <p>Cargando proyectos...</p>
    </div>

    <!-- Portfolio Grid -->
    <div v-else-if="portfolioItems.length > 0" class="portfolio-grid">
      <div 
        v-for="item in portfolioItems" 
        :key="item.id" 
        class="portfolio-card"
      >
        <div class="card-image" :style="{ backgroundImage: `url(${item.image})` }">
          <div class="card-overlay">
            <span v-if="item.featured" class="badge badge-featured">Destacado</span>
            <span class="badge badge-order">#{item.order}</span>
          </div>
        </div>
        
        <div class="card-body">
          <span v-if="item.category" class="category-badge">{{ item.category }}</span>
          <h3 class="project-title">{{ item.title }}</h3>
          <p v-if="item.description" class="project-description">{{ truncateText(item.description, 120) }}</p>
          <div v-if="item.client" class="project-meta">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            <span>{{ item.client }}</span>
          </div>
          <div v-if="item.completed_date" class="project-meta">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span>{{ formatDate(item.completed_date) }}</span>
          </div>
        </div>

        <div class="card-footer">
          <button @click="openModal(item)" class="btn-icon btn-edit" title="Editar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
          </button>
          <button @click="confirmDelete(item)" class="btn-icon btn-delete" title="Eliminar">
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
        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
        <line x1="8" y1="21" x2="16" y2="21"/>
        <line x1="12" y1="17" x2="12" y2="21"/>
      </svg>
      <h3>No hay proyectos en el portafolio</h3>
      <p>Crea tu primer proyecto para comenzar</p>
      <button @click="openModal()" class="btn-empty">Crear Proyecto</button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h2>{{ isEditing ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</h2>
          <button @click="closeModal" class="btn-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="savePortfolio" class="modal-body">
          <div class="form-group">
            <label for="title" class="form-label">
              Título del Proyecto
              <span class="required">*</span>
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              class="form-control"
              placeholder="Ej: Señalización Digital Hotel Riviera"
            />
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="category" class="form-label">Categoría</label>
              <input
                id="category"
                v-model="form.category"
                type="text"
                class="form-control"
                placeholder="Ej: Señalización Digital"
              />
            </div>

            <div class="form-group">
              <label for="client" class="form-label">Cliente</label>
              <input
                id="client"
                v-model="form.client"
                type="text"
                class="form-control"
                placeholder="Nombre del cliente"
              />
            </div>
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
              placeholder="Descripción detallada del proyecto..."
            ></textarea>
            <div class="form-hint">{{ form.description.length }} caracteres</div>
          </div>

          <div class="form-group">
            <ImageUploader
              v-model="form.image"
              label="Imagen del Proyecto"
              :required="true"
              :show-history="true"
              :history="imageHistory"
              @upload="onImageUpload"
            />
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="link" class="form-label">Enlace (opcional)</label>
              <input
                id="link"
                v-model="form.link"
                type="url"
                class="form-control"
                placeholder="https://..."
              />
            </div>

            <div class="form-group">
              <label for="completed_date" class="form-label">Fecha de finalización</label>
              <input
                id="completed_date"
                v-model="form.completed_date"
                type="date"
                class="form-control"
              />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="order" class="form-label">
                Orden de visualización
                <span class="required">*</span>
              </label>
              <input
                id="order"
                v-model.number="form.order"
                type="number"
                required
                min="0"
                class="form-control"
                placeholder="1"
              />
            </div>

            <div class="form-group checkbox-group">
              <label class="checkbox-label">
                <input
                  v-model="form.featured"
                  type="checkbox"
                  class="form-checkbox"
                />
                <span>Proyecto destacado</span>
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
              {{ saving ? 'Guardando...' : 'Guardar Proyecto' }}
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
          <p>¿Estás seguro de que deseas eliminar el proyecto <strong>{{ itemToDelete?.title }}</strong>?</p>
          <p class="text-warning">Esta acción no se puede deshacer.</p>
        </div>
        <div class="form-actions">
          <button @click="showDeleteModal = false" class="btn-secondary">
            Cancelar
          </button>
          <button @click="deletePortfolio" class="btn-danger" :disabled="saving">
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
const portfolioItems = ref([])
const showModal = ref(false)
const showDeleteModal = ref(false)
const isEditing = ref(false)
const itemToDelete = ref(null)
const imageHistory = ref([])

const form = ref({
  title: '',
  description: '',
  category: '',
  client: '',
  image: '',
  link: '',
  completed_date: '',
  featured: false,
  order: 1
})

const fetchPortfolio = async () => {
  loading.value = true
  try {
    const response = await api.get('/portfolio')
    portfolioItems.value = response.data.sort((a, b) => a.order - b.order)
  } catch (error) {
    console.error('Error al cargar portafolio:', error)
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
      title: '',
      description: '',
      category: '',
      client: '',
      image: '',
      link: '',
      completed_date: '',
      featured: false,
      order: portfolioItems.value.length + 1
    }
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  isEditing.value = false
}

const savePortfolio = async () => {
  saving.value = true
  try {
    if (isEditing.value) {
      await api.put(`/portfolio/${form.value.id}`, form.value)
    } else {
      await api.post('/portfolio', form.value)
    }
    await fetchPortfolio()
    closeModal()
  } catch (error) {
    console.error('Error al guardar proyecto:', error)
    alert('Error al guardar el proyecto. Por favor intenta de nuevo.')
  } finally {
    saving.value = false
  }
}

const confirmDelete = (item) => {
  itemToDelete.value = item
  showDeleteModal.value = true
}

const deletePortfolio = async () => {
  saving.value = true
  try {
    await api.delete(`/portfolio/${itemToDelete.value.id}`)
    await fetchPortfolio()
    showDeleteModal.value = false
    itemToDelete.value = null
  } catch (error) {
    console.error('Error al eliminar proyecto:', error)
    alert('Error al eliminar el proyecto. Por favor intenta de nuevo.')
  } finally {
    saving.value = false
  }
}

const truncateText = (text, maxLength) => {
  return text && text.length > maxLength ? text.substring(0, maxLength) + '...' : text
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-MX', {
    year: 'numeric',
    month: 'long'
  })
}

const onImageUpload = (url) => {
  console.log('Imagen subida:', url)
}

onMounted(() => {
  fetchPortfolio()
})
</script>

<style scoped>
.admin-portfolio {
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

/* Portfolio Grid */
.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.5rem;
}

.portfolio-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: all 0.2s;
  display: flex;
  flex-direction: column;
}

.portfolio-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.card-image {
  width: 100%;
  height: 200px;
  background-size: cover;
  background-position: center;
  position: relative;
}

.card-overlay {
  position: absolute;
  top: 0;
  right: 0;
  padding: 1rem;
  display: flex;
  gap: 0.5rem;
  flex-direction: column;
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

.badge-order {
  background: rgba(255, 255, 255, 0.9);
  color: #495057;
}

.card-body {
  padding: 1.5rem;
  flex: 1;
}

.category-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background: #e9ecef;
  color: #667eea;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  margin-bottom: 0.75rem;
}

.project-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.75rem 0;
}

.project-description {
  color: #6c757d;
  font-size: 0.875rem;
  line-height: 1.6;
  margin-bottom: 1rem;
}

.project-meta {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #6c757d;
  font-size: 0.875rem;
  margin-bottom: 0.5rem;
}

.project-meta svg {
  width: 16px;
  height: 16px;
}

.card-footer {
  display: flex;
  gap: 0.5rem;
  padding: 1rem 1.5rem;
  border-top: 1px solid #e9ecef;
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
  .admin-portfolio {
    padding: 1rem;
  }

  .page-header {
    flex-direction: column;
  }

  .btn-new {
    width: 100%;
    justify-content: center;
  }

  .portfolio-grid {
    grid-template-columns: 1fr;
  }

  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>
