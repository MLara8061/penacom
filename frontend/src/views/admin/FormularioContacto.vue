<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="admin-form-config">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Configuración del Formulario de Contacto</h1>
        <p class="page-description">
          Personaliza los campos y opciones que aparecerán en el formulario del sitio web
        </p>
      </div>
      <button @click="saveConfiguration" class="btn-save" :disabled="saving">
        <svg v-if="!saving" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
          <polyline points="17 21 17 13 7 13 7 21"></polyline>
          <polyline points="7 3 7 8 15 8"></polyline>
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
        {{ saving ? 'Guardando...' : 'Guardar Cambios' }}
      </button>
    </div>

    <!-- Configuración de Campos -->
    <div class="config-section">
      <div class="section-header">
        <div class="section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
        </div>
        <div>
          <h2 class="section-title">Campos del Formulario</h2>
          <p class="section-description">Activa o desactiva los campos que deseas mostrar</p>
        </div>
      </div>

      <div class="fields-grid">
        <div
          v-for="field in formFields"
          :key="field.id"
          class="field-card"
          :class="{ 'field-disabled': !field.enabled }"
        >
          <div class="field-header">
            <div class="field-info">
              <div class="field-icon" :style="{ background: field.color }">
                {{ field.icon }}
              </div>
              <div>
                <h3 class="field-name">{{ field.label }}</h3>
                <p class="field-type">{{ field.type }}</p>
              </div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" v-model="field.enabled" :disabled="field.required" />
              <span class="toggle-slider"></span>
            </label>
          </div>

          <div v-if="field.enabled" class="field-config">
            <div class="config-row">
              <label class="config-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="4" y1="9" x2="20" y2="9"></line>
                  <line x1="4" y1="15" x2="20" y2="15"></line>
                  <line x1="10" y1="3" x2="8" y2="21"></line>
                  <line x1="16" y1="3" x2="14" y2="21"></line>
                </svg>
                Etiqueta
              </label>
              <input
                type="text"
                v-model="field.label"
                class="config-input"
                placeholder="Nombre del campo"
              />
            </div>

            <div class="config-row">
              <label class="config-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="9 11 12 14 22 4"></polyline>
                  <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                Placeholder
              </label>
              <input
                type="text"
                v-model="field.placeholder"
                class="config-input"
                placeholder="Texto de ejemplo"
              />
            </div>

            <div class="config-row checkbox-row">
              <label class="checkbox-label">
                <input type="checkbox" v-model="field.required" class="config-checkbox" />
                <span>Campo obligatorio</span>
              </label>
            </div>
          </div>

          <div v-if="field.required" class="field-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
              ></path>
            </svg>
            Requerido por el sistema
          </div>
        </div>
      </div>
    </div>

    <!-- Configuración de Servicios -->
    <div class="config-section">
      <div class="section-header">
        <div class="section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
        </div>
        <div>
          <h2 class="section-title">Servicios Disponibles</h2>
          <p class="section-description">Gestiona las opciones del selector de servicios</p>
        </div>
      </div>

      <div class="services-section">
        <div class="services-header">
          <button @click="addService" class="btn-add-service">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Agregar Servicio
          </button>
        </div>

        <div class="services-list">
          <div v-for="(service, index) in serviceOptions" :key="index" class="service-item">
            <div class="service-drag-handle">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
              </svg>
            </div>

            <div class="service-number">{{ index + 1 }}</div>

            <input
              type="text"
              v-model="service.value"
              class="service-input"
              placeholder="Nombre del servicio"
            />

            <button
              @click="removeService(index)"
              class="btn-remove-service"
              :disabled="serviceOptions.length <= 1"
            >
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Vista Previa -->
    <div class="config-section preview-section">
      <div class="section-header">
        <div class="section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </div>
        <div>
          <h2 class="section-title">Vista Previa</h2>
          <p class="section-description">Así se verá el formulario en el sitio web</p>
        </div>
      </div>

      <div class="preview-container">
        <div class="preview-form">
          <h3 class="preview-title">Formulario de Contacto</h3>

          <div v-for="field in enabledFields" :key="field.id" class="preview-field">
            <label class="preview-label">
              {{ field.label }}
              <span v-if="field.required" class="preview-required">*</span>
            </label>

            <input
              v-if="field.type === 'text' || field.type === 'email' || field.type === 'tel'"
              :type="field.type"
              :placeholder="field.placeholder"
              class="preview-input"
              disabled
            />

            <textarea
              v-else-if="field.type === 'textarea'"
              :placeholder="field.placeholder"
              class="preview-textarea"
              disabled
            ></textarea>

            <select v-else-if="field.type === 'select'" class="preview-select" disabled>
              <option value="">{{ field.placeholder }}</option>
              <option
                v-for="(service, index) in serviceOptions"
                :key="index"
                :value="service.value"
              >
                {{ service.value }}
              </option>
            </select>
          </div>

          <button class="preview-button" disabled>Enviar Mensaje</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
// @ts-expect-error - useAlert is JavaScript
import { useAlert } from '@/composables/useAlert'

const { success, error: showError } = useAlert()
const saving = ref(false)

const formFields = ref([
  {
    id: 'name',
    label: 'Nombre completo',
    placeholder: 'Tu nombre',
    type: 'text',
    enabled: true,
    required: true,
    color: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
    icon: '👤',
  },
  {
    id: 'email',
    label: 'Correo electrónico',
    placeholder: 'tu@email.com',
    type: 'email',
    enabled: true,
    required: true,
    color: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
    icon: '📧',
  },
  {
    id: 'phone',
    label: 'Teléfono',
    placeholder: '+52 123 456 7890',
    type: 'tel',
    enabled: true,
    required: false,
    color: 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
    icon: '📱',
  },
  {
    id: 'service',
    label: 'Servicio de interés',
    placeholder: 'Selecciona un servicio',
    type: 'select',
    enabled: true,
    required: false,
    color: 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
    icon: '⚙️',
  },
  {
    id: 'company',
    label: 'Empresa',
    placeholder: 'Nombre de tu empresa',
    type: 'text',
    enabled: false,
    required: false,
    color: 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
    icon: '🏢',
  },
  {
    id: 'message',
    label: 'Mensaje',
    placeholder: 'Cuéntanos sobre tu proyecto...',
    type: 'textarea',
    enabled: true,
    required: true,
    color: 'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
    icon: '💬',
  },
])

const serviceOptions = ref([
  { value: 'Desarrollo Web' },
  { value: 'Marketing Digital' },
  { value: 'Diseño Gráfico' },
  { value: 'SEO y Posicionamiento' },
  { value: 'Consultoría' },
])

const enabledFields = computed(() => {
  return formFields.value.filter(field => field.enabled)
})

const addService = () => {
  serviceOptions.value.push({ value: '' })
}

const removeService = (index: number) => {
  if (serviceOptions.value.length > 1) {
    serviceOptions.value.splice(index, 1)
  }
}

const saveConfiguration = async () => {
  saving.value = true
  try {
    await new Promise(resolve => setTimeout(resolve, 1000))
    success('Configuración guardada exitosamente', '¡Éxito!')
  } catch (err) {
    console.error('Error al guardar:', err)
    showError('Error al guardar la configuración', 'Error')
  } finally {
    saving.value = false
  }
}
</script>

<style scoped>
.admin-form-config {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 2rem;
  gap: 1.5rem;
}

.header-content {
  flex: 1;
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 0.5rem 0;
}

.page-description {
  font-size: 1rem;
  color: #64748b;
  margin: 0;
}

.btn-save {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.875rem 1.5rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-save:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-save:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-save svg {
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

.config-section {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.section-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 2rem;
  padding-bottom: 1.5rem;
  border-bottom: 2px solid #f1f5f9;
}

.section-icon {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.section-icon svg {
  width: 24px;
  height: 24px;
  color: white;
}

.section-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 0.25rem 0;
}

.section-description {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0;
}

.fields-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
}

.field-card {
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  padding: 1.5rem;
  transition: all 0.3s ease;
}

.field-card:hover {
  border-color: #cbd5e1;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.field-disabled {
  opacity: 0.5;
}

.field-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.field-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.field-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.25rem;
}

.field-name {
  font-size: 1rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0;
}

.field-type {
  font-size: 0.75rem;
  color: #64748b;
  margin: 0.25rem 0 0 0;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.toggle-switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
}

.toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.toggle-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cbd5e1;
  transition: 0.3s;
  border-radius: 26px;
}

.toggle-slider:before {
  position: absolute;
  content: '';
  height: 20px;
  width: 20px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.3s;
  border-radius: 50%;
}

input:checked + .toggle-slider {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

input:checked + .toggle-slider:before {
  transform: translateX(24px);
}

input:disabled + .toggle-slider {
  opacity: 0.5;
  cursor: not-allowed;
}

.field-config {
  padding-top: 1rem;
  border-top: 1px solid #e2e8f0;
}

.config-row {
  margin-bottom: 1rem;
}

.config-row:last-child {
  margin-bottom: 0;
}

.config-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: #475569;
  margin-bottom: 0.5rem;
}

.config-label svg {
  width: 16px;
  height: 16px;
  color: #94a3b8;
}

.config-input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.875rem;
  transition: all 0.2s ease;
}

.config-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.checkbox-row {
  padding-top: 0.5rem;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  font-size: 0.875rem;
  color: #475569;
}

.config-checkbox {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.field-badge {
  margin-top: 1rem;
  padding: 0.75rem;
  background: #fef3c7;
  border: 1px solid #fcd34d;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.75rem;
  font-weight: 600;
  color: #92400e;
}

.field-badge svg {
  width: 16px;
  height: 16px;
}

.services-header {
  margin-bottom: 1.5rem;
}

.btn-add-service {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.25rem;
  background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-add-service:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
}

.btn-add-service svg {
  width: 18px;
  height: 18px;
}

.services-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.service-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  transition: all 0.2s ease;
}

.service-item:hover {
  border-color: #cbd5e1;
}

.service-drag-handle {
  cursor: grab;
  color: #94a3b8;
}

.service-drag-handle:active {
  cursor: grabbing;
}

.service-drag-handle svg {
  width: 20px;
  height: 20px;
}

.service-number {
  width: 32px;
  height: 32px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.875rem;
  flex-shrink: 0;
}

.service-input {
  flex: 1;
  padding: 0.75rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.875rem;
  transition: all 0.2s ease;
}

.service-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-remove-service {
  width: 36px;
  height: 36px;
  background: #fee;
  border: 2px solid #fecaca;
  border-radius: 8px;
  color: #dc2626;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.btn-remove-service:hover:not(:disabled) {
  background: #fecaca;
  border-color: #dc2626;
}

.btn-remove-service:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

.btn-remove-service svg {
  width: 18px;
  height: 18px;
}

.preview-container {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 12px;
  padding: 3rem;
  display: flex;
  justify-content: center;
}

.preview-form {
  background: white;
  border-radius: 12px;
  padding: 2rem;
  max-width: 500px;
  width: 100%;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.preview-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 1.5rem 0;
  text-align: center;
}

.preview-field {
  margin-bottom: 1.25rem;
}

.preview-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 600;
  color: #475569;
  margin-bottom: 0.5rem;
}

.preview-required {
  color: #dc2626;
}

.preview-input,
.preview-textarea,
.preview-select {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.875rem;
  font-family: inherit;
  transition: all 0.2s ease;
}

.preview-textarea {
  min-height: 100px;
  resize: vertical;
}

.preview-button {
  width: 100%;
  padding: 1rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: not-allowed;
  opacity: 0.7;
}

@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
  }

  .btn-save {
    width: 100%;
    justify-content: center;
  }

  .fields-grid {
    grid-template-columns: 1fr;
  }

  .preview-container {
    padding: 1.5rem;
  }

  .preview-form {
    padding: 1.5rem;
  }
}
</style>
