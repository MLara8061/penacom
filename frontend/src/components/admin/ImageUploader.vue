<template>
  <div class="image-uploader">
    <div class="uploader-header">
      <label class="uploader-label">
        {{ label }}
        <span v-if="required" class="required">*</span>
      </label>
      <button v-if="currentImage" @click.prevent="removeImage" type="button" class="btn-remove">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="3 6 5 6 21 6"></polyline>
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        </svg>
        Eliminar
      </button>
    </div>

    <!-- Vista Previa Actual -->
    <div v-if="currentImage" class="current-preview">
      <img :src="currentImage" :alt="label" @error="imageError = true" />
      <div v-if="imageError" class="image-error">Error al cargar imagen</div>
    </div>

    <!-- Drag & Drop Zone -->
    <div v-else class="dropzone" :class="{ 'dragover': isDragging }" @dragenter.prevent="onDragEnter" @dragover.prevent="onDragOver" @dragleave.prevent="onDragLeave" @drop.prevent="onDrop">
      <input ref="fileInput" type="file" accept="image/*" @change="onFileSelect" class="file-input" :id="inputId" />
      
      <label :for="inputId" class="drop-label">
        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="17 8 12 3 7 8"></polyline>
          <line x1="12" y1="3" x2="12" y2="15"></line>
        </svg>
        <span class="drop-text">Arrastra una imagen aquí</span>
        <span class="drop-subtext">o haz clic para seleccionar</span>
        <span class="drop-hint">PNG, JPG hasta 5MB</span>
      </label>
    </div>

    <!-- Cargando -->
    <div v-if="uploading" class="uploading-state">
      <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"></circle>
      </svg>
      <span>Subiendo imagen...</span>
    </div>

    <!-- Historial de Imágenes -->
    <div v-if="showHistory && imageHistory.length > 0" class="image-history">
      <button @click="toggleHistory" type="button" class="history-toggle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
        {{ historyExpanded ? 'Ocultar' : 'Ver' }} historial ({{ imageHistory.length }})
      </button>

      <transition name="slide">
        <div v-if="historyExpanded" class="history-grid">
          <div v-for="(img, index) in imageHistory" :key="index" class="history-item" @click="selectFromHistory(img)" :class="{ 'selected': img === currentImage }">
            <img :src="img" :alt="`Histórico ${index + 1}`" />
            <div class="history-overlay">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  modelValue: String,
  label: {
    type: String,
    default: 'Imagen'
  },
  required: {
    type: Boolean,
    default: false
  },
  showHistory: {
    type: Boolean,
    default: true
  },
  history: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['update:modelValue', 'upload', 'remove'])

const fileInput = ref(null)
const isDragging = ref(false)
const uploading = ref(false)
const imageError = ref(false)
const historyExpanded = ref(false)
const dragCounter = ref(0)

const inputId = computed(() => `file-input-${Math.random().toString(36).substr(2, 9)}`)
const currentImage = computed(() => props.modelValue)
const imageHistory = computed(() => props.history || [])

watch(currentImage, () => {
  imageError.value = false
})

const onDragEnter = (e) => {
  dragCounter.value++
  isDragging.value = true
}

const onDragOver = (e) => {
  isDragging.value = true
}

const onDragLeave = (e) => {
  dragCounter.value--
  if (dragCounter.value === 0) {
    isDragging.value = false
  }
}

const onDrop = (e) => {
  isDragging.value = false
  dragCounter.value = 0
  
  const files = e.dataTransfer.files
  if (files.length > 0) {
    handleFile(files[0])
  }
}

const onFileSelect = (e) => {
  const files = e.target.files
  if (files.length > 0) {
    handleFile(files[0])
  }
}

const handleFile = async (file) => {
  if (!file.type.startsWith('image/')) {
    alert('Por favor selecciona un archivo de imagen')
    return
  }

  if (file.size > 5 * 1024 * 1024) {
    alert('La imagen no debe superar 5MB')
    return
  }

  uploading.value = true

  try {
    // Convertir a base64 o subir a servidor
    const reader = new FileReader()
    reader.onload = (e) => {
      const imageUrl = e.target.result
      emit('update:modelValue', imageUrl)
      emit('upload', imageUrl)
      uploading.value = false
    }
    reader.readAsDataURL(file)
  } catch (error) {
    console.error('Error al procesar imagen:', error)
    uploading.value = false
  }
}

const removeImage = () => {
  if (confirm('¿Estás seguro de eliminar esta imagen?')) {
    emit('update:modelValue', '')
    emit('remove')
    if (fileInput.value) {
      fileInput.value.value = ''
    }
  }
}

const toggleHistory = () => {
  historyExpanded.value = !historyExpanded.value
}

const selectFromHistory = (imageUrl) => {
  emit('update:modelValue', imageUrl)
}
</script>

<style scoped>
.image-uploader {
  width: 100%;
}

.uploader-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.75rem;
}

.uploader-label {
  font-weight: 600;
  color: #334155;
  font-size: 0.875rem;
  margin: 0;
}

.required {
  color: #ef4444;
  margin-left: 0.25rem;
}

.btn-remove {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.375rem 0.75rem;
  background: #fee2e2;
  color: #991b1b;
  border: none;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-remove:hover {
  background: #fecaca;
}

.btn-remove svg {
  width: 14px;
  height: 14px;
}

.current-preview {
  position: relative;
  width: 100%;
  max-width: 400px;
  border-radius: 12px;
  overflow: hidden;
  border: 2px solid #e2e8f0;
  margin-bottom: 1rem;
}

.current-preview img {
  width: 100%;
  height: auto;
  display: block;
}

.image-error {
  padding: 3rem;
  text-align: center;
  background: #fef2f2;
  color: #ef4444;
  font-size: 0.875rem;
}

.dropzone {
  position: relative;
  border: 2px dashed #cbd5e1;
  border-radius: 12px;
  padding: 3rem 2rem;
  text-align: center;
  transition: all 0.3s ease;
  background: #f8fafc;
  cursor: pointer;
}

.dropzone:hover {
  border-color: #0066CC;
  background: #eff6ff;
}

.dropzone.dragover {
  border-color: #0066CC;
  background: #dbeafe;
  transform: scale(1.02);
}

.file-input {
  position: absolute;
  width: 0;
  height: 0;
  opacity: 0;
  pointer-events: none;
}

.drop-label {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
}

.upload-icon {
  width: 48px;
  height: 48px;
  color: #0066CC;
  margin-bottom: 0.5rem;
}

.drop-text {
  font-size: 1rem;
  font-weight: 600;
  color: #1e293b;
}

.drop-subtext {
  font-size: 0.875rem;
  color: #64748b;
}

.drop-hint {
  font-size: 0.75rem;
  color: #94a3b8;
  margin-top: 0.5rem;
}

.uploading-state {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  padding: 2rem;
  background: #f1f5f9;
  border-radius: 12px;
  color: #64748b;
  font-size: 0.875rem;
  font-weight: 500;
}

.uploading-state svg {
  width: 24px;
  height: 24px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.image-history {
  margin-top: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e2e8f0;
}

.history-toggle {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.625rem 1rem;
  background: white;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  color: #64748b;
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  width: 100%;
  justify-content: center;
}

.history-toggle:hover {
  border-color: #0066CC;
  color: #0066CC;
}

.history-toggle svg {
  width: 18px;
  height: 18px;
}

.history-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  gap: 0.75rem;
  margin-top: 1rem;
}

.history-item {
  position: relative;
  aspect-ratio: 1;
  border-radius: 8px;
  overflow: hidden;
  border: 2px solid #e2e8f0;
  cursor: pointer;
  transition: all 0.2s;
}

.history-item:hover {
  border-color: #0066CC;
  transform: scale(1.05);
}

.history-item.selected {
  border-color: #0066CC;
  box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.2);
}

.history-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.history-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 102, 204, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.2s;
}

.history-item.selected .history-overlay {
  opacity: 1;
}

.history-overlay svg {
  width: 32px;
  height: 32px;
  color: white;
}

/* Transitions */
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
  max-height: 500px;
  overflow: hidden;
}

.slide-enter-from,
.slide-leave-to {
  max-height: 0;
  opacity: 0;
}

/* Responsive */
@media (min-width: 640px) {
  .history-grid {
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  }
}
</style>
