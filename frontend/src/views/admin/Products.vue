<template>
  <div class="admin-products">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Nuestros Productos</h1>
        <p class="page-description">Administra los productos y sectores que atiendes</p>
      </div>
      <button @click="openModal()" class="btn-new">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="12" y1="5" x2="12" y2="19"/>
          <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Nuevo Producto
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <svg class="spinner" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
        <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
      </svg>
      <p>Cargando productos...</p>
    </div>

    <!-- Products Grid -->
    <div v-else-if="products.length > 0" class="products-grid">
      <div 
        v-for="product in products" 
        :key="product.id" 
        class="product-card"
        :class="{ inactive: !product.is_active }"
      >
        <!-- Imagen del producto -->
        <div v-if="product.image" class="card-image" :style="{ backgroundImage: `url(${product.image})` }">
          <div class="card-overlay">
            <div class="badges">
              <span class="badge badge-order">#{product.order}</span>
              <span class="badge" :class="product.is_active ? 'badge-active' : 'badge-inactive'">
                {{ product.is_active ? 'Activo' : 'Inactivo' }}
              </span>
            </div>
          </div>
        </div>

        <!-- Fallback si no hay imagen -->
        <div v-else class="card-header">
          <div class="icon-badge">{{ product.icon || '📦' }}</div>
          <div class="badges">
            <span class="badge badge-order">#{product.order}</span>
            <span class="badge" :class="product.is_active ? 'badge-active' : 'badge-inactive'">
              {{ product.is_active ? 'Activo' : 'Inactivo' }}
            </span>
          </div>
        </div>
        
        <div class="card-body">
          <h3 class="product-name">{{ product.name }}</h3>
          <p class="product-category">{{ product.category }}</p>
          <p class="product-description">{{ truncateText(product.description, 100) }}</p>
        </div>

        <div class="card-footer">
          <button @click="openModal(product)" class="btn-icon btn-edit" title="Editar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
          </button>
          <button @click="confirmDelete(product)" class="btn-icon btn-delete" title="Eliminar">
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
        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
      </svg>
      <h3>No hay productos</h3>
      <p>Crea tu primer producto para comenzar</p>
      <button @click="openModal()" class="btn-empty">Crear Producto</button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h2>{{ isEditing ? 'Editar Producto' : 'Nuevo Producto' }}</h2>
          <button @click="closeModal" class="btn-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="saveProduct" class="modal-body">
          <div class="form-row">
            <div class="form-group">
              <label for="name" class="form-label">
                Nombre del Producto
                <span class="required">*</span>
              </label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                required
                class="form-control"
                placeholder="Ej: Sector Hotelero"
              />
            </div>

            <div class="form-group">
              <label for="category" class="form-label">
                Categoría
                <span class="required">*</span>
              </label>
              <input
                id="category"
                v-model="form.category"
                type="text"
                required
                class="form-control"
                placeholder="Ej: Hospitalidad"
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
              placeholder="Descripción detallada del producto o sector..."
            ></textarea>
            <div class="form-hint">{{ form.description.length }} caracteres</div>
          </div>

          <div class="form-group">
            <ImageUploader
              v-model="form.image"
              label="Imagen del Producto"
              :required="true"
              :show-history="true"
              :history="imageHistory"
              @upload="onImageUpload"
            />
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="icon" class="form-label">
                Icono (emoji)
              </label>
              <input
                id="icon"
                v-model="form.icon"
                type="text"
                class="form-control"
                placeholder="🏨"
                maxlength="2"
              />
              <div class="form-hint">Un emoji representativo del sector</div>
            </div>

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
          </div>

          <div class="form-group">
            <label class="checkbox-label">
              <input
                v-model="form.is_active"
                type="checkbox"
                class="form-checkbox"
              />
              <span>Producto activo (visible en la página)</span>
            </label>
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
              {{ saving ? 'Guardando...' : 'Guardar Producto' }}
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
          <p>¿Estás seguro de que deseas eliminar el producto <strong>{{ productToDelete?.name }}</strong>?</p>
          <p class="text-warning">Esta acción no se puede deshacer.</p>
        </div>
        <div class="form-actions">
          <button @click="showDeleteModal = false" class="btn-secondary">
            Cancelar
          </button>
          <button @click="deleteProduct" class="btn-danger" :disabled="saving">
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
const products = ref([])
const showModal = ref(false)
const showDeleteModal = ref(false)
const isEditing = ref(false)
const productToDelete = ref(null)
const imageError = ref(false)
const imageHistory = ref([])

const form = ref({
  name: '',
  description: '',
  category: '',
  icon: '',
  image: '',
  is_active: true,
  order: 1
})

const fetchProducts = async () => {
  loading.value = true
  try {
    const response = await api.get('/products')
    products.value = response.data.sort((a, b) => a.order - b.order)
  } catch (error) {
    console.error('Error al cargar productos:', error)
  } finally {
    loading.value = false
  }
}

const openModal = (product = null) => {
  if (product) {
    isEditing.value = true
    form.value = { ...product }
  } else {
    isEditing.value = false
    form.value = {
      name: '',
      description: '',
      category: '',
      icon: '',
      image: '',
      is_active: true,
      order: products.value.length + 1
    }
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  isEditing.value = false
}

const saveProduct = async () => {
  saving.value = true
  try {
    if (isEditing.value) {
      await api.put(`/products/${form.value.id}`, form.value)
    } else {
      await api.post('/products', form.value)
    }
    await fetchProducts()
    closeModal()
  } catch (error) {
    console.error('Error al guardar producto:', error)
    alert('Error al guardar el producto. Por favor intenta de nuevo.')
  } finally {
    saving.value = false
  }
}

const confirmDelete = (product) => {
  productToDelete.value = product
  showDeleteModal.value = true
}

const deleteProduct = async () => {
  saving.value = true
  try {
    await api.delete(`/products/${productToDelete.value.id}`)
    await fetchProducts()
    showDeleteModal.value = false
    productToDelete.value = null
  } catch (error) {
    console.error('Error al eliminar producto:', error)
    alert('Error al eliminar el producto. Por favor intenta de nuevo.')
  } finally {
    saving.value = false
  }
}

const onImageUpload = (imageUrl) => {
  // Agregar al historial si no existe
  if (!imageHistory.value.includes(imageUrl)) {
    imageHistory.value.unshift(imageUrl)
    // Limitar el historial a 10 imágenes
    if (imageHistory.value.length > 10) {
      imageHistory.value = imageHistory.value.slice(0, 10)
    }
  }
}

const truncateText = (text, maxLength) => {
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text
}

onMounted(() => {
  fetchProducts()
  // Cargar historial de imágenes desde productos existentes
  products.value.forEach(product => {
    if (product.image && !imageHistory.value.includes(product.image)) {
      imageHistory.value.push(product.image)
    }
  })
})
</script>

<style scoped>
.admin-products {
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

/* Products Grid */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.product-card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: all 0.2s;
  display: flex;
  flex-direction: column;
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.product-card.inactive {
  opacity: 0.6;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.icon-badge {
  font-size: 2.5rem;
  width: 64px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  border-radius: 12px;
}

/* Imagen de la tarjeta */
.card-image {
  width: calc(100% + 3rem);
  height: 200px;
  margin: -1.5rem -1.5rem 1rem -1.5rem;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  border-radius: 12px 12px 0 0;
  position: relative;
}

.card-overlay {
  position: absolute;
  top: 0;
  right: 0;
  padding: 1rem;
  background: linear-gradient(to bottom, rgba(0,0,0,0.4), transparent);
  border-radius: 12px 12px 0 0;
  width: 100%;
  display: flex;
  justify-content: flex-end;
}

.card-overlay .badges {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  align-items: flex-end;
}

.badges {
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

.badge-order {
  background: #e9ecef;
  color: #495057;
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
  flex: 1;
  margin-bottom: 1rem;
}

.product-name {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.5rem 0;
}

.product-category {
  color: #667eea;
  font-weight: 600;
  font-size: 0.875rem;
  margin: 0 0 0.75rem 0;
}

.product-description {
  color: #6c757d;
  font-size: 0.875rem;
  line-height: 1.6;
  margin: 0;
}

.card-footer {
  display: flex;
  gap: 0.5rem;
  padding-top: 1rem;
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
  max-width: 600px;
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

/* Vista previa de imagen */
.image-preview {
  margin-top: 1rem;
  border-radius: 8px;
  overflow: hidden;
  border: 1px solid #dee2e6;
  position: relative;
  max-width: 400px;
}

.image-preview img {
  width: 100%;
  height: auto;
  display: block;
}

.image-error {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 2rem;
  background: #f8f9fa;
  color: #dc3545;
  font-size: 0.875rem;
}

.image-error svg {
  width: 24px;
  height: 24px;
  stroke: #dc3545;
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
  .admin-products {
    padding: 1rem;
  }

  .page-header {
    flex-direction: column;
  }

  .btn-new {
    width: 100%;
    justify-content: center;
  }

  .products-grid {
    grid-template-columns: 1fr;
  }

  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>
