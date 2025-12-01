<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="admin-form-config">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Configuración del Footer</h1>
        <p class="page-description">
          Personaliza el mensaje final, redes sociales y datos de contacto visibles en todo el sitio
        </p>
      </div>
      <button class="btn-save" :disabled="saving" @click="saveFooterSettings">
        <svg v-if="!saving" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
          <polyline points="17 21 17 13 7 13 7 21" />
          <polyline points="7 3 7 8 15 8" />
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

    <div v-if="loading" class="loading-state">
      <svg class="spinner" viewBox="0 0 24 24">
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
      <p>Cargando configuración...</p>
    </div>

    <div v-else class="config-section">
      <div class="section-header">
        <div class="section-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 21v-7" />
            <path d="M4 10V3" />
            <path d="M12 21v-9" />
            <path d="M12 8V3" />
            <path d="M20 21v-5" />
            <path d="M20 12V3" />
            <path d="M1 14h6" />
            <path d="M9 8h6" />
            <path d="M17 16h6" />
          </svg>
        </div>
        <div>
          <h2 class="section-title">Contenido del Footer</h2>
          <p class="section-description">Edita la información que se muestra en el pie de página</p>
        </div>
      </div>

      <div class="fields-grid">
        <!-- Slogan y Ubicación -->
        <div class="field-card">
          <div class="field-header">
            <div class="field-info">
              <div
                class="field-icon"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%)"
              >
                📝
              </div>
              <div>
                <h3 class="field-name">Información General</h3>
                <p class="field-type">Slogan y Ubicación</p>
              </div>
            </div>
          </div>
          <div class="field-config">
            <div class="config-row">
              <label class="config-label">Mensaje principal (Slogan)</label>
              <textarea
                v-model="footerData.slogan"
                class="config-input"
                rows="3"
                placeholder="Ej. Transformando ideas en realidad digital..."
              ></textarea>
            </div>
            <div class="config-row">
              <label class="config-label">Ubicación / Dirección</label>
              <textarea
                v-model="footerData.location"
                class="config-input"
                rows="3"
                placeholder="Describe tu ubicación"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Contacto Directo -->
        <div class="field-card">
          <div class="field-header">
            <div class="field-info">
              <div
                class="field-icon"
                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)"
              >
                📞
              </div>
              <div>
                <h3 class="field-name">Contacto Directo</h3>
                <p class="field-type">Email y Teléfono</p>
              </div>
            </div>
          </div>
          <div class="field-config">
            <div class="config-row">
              <label class="config-label">Correo electrónico</label>
              <input
                type="email"
                v-model="footerData.email"
                class="config-input"
                placeholder="contacto@ejemplo.com"
              />
            </div>
            <div class="config-row">
              <label class="config-label">Teléfono</label>
              <input
                type="text"
                v-model="footerData.phone"
                class="config-input"
                placeholder="+52 (998) 500 0000"
              />
            </div>
          </div>
        </div>

        <!-- WhatsApp -->
        <div class="field-card">
          <div class="field-header">
            <div class="field-info">
              <div
                class="field-icon"
                style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)"
              >
                💬
              </div>
              <div>
                <h3 class="field-name">WhatsApp</h3>
                <p class="field-type">Botón flotante</p>
              </div>
            </div>
          </div>
          <div class="field-config">
            <div class="config-row">
              <label class="config-label">Número (con lada)</label>
              <input
                type="text"
                v-model="footerData.whatsapp_number"
                class="config-input"
                placeholder="529985401540"
              />
            </div>
            <div class="config-row">
              <label class="config-label">Mensaje inicial</label>
              <input
                type="text"
                v-model="footerData.whatsapp_message"
                class="config-input"
                placeholder="Hola, quiero más información..."
              />
            </div>
          </div>
        </div>

        <!-- Redes Sociales -->
        <div class="field-card" style="grid-column: 1 / -1">
          <div class="field-header">
            <div class="field-info">
              <div
                class="field-icon"
                style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%)"
              >
                🌐
              </div>
              <div>
                <h3 class="field-name">Redes Sociales</h3>
                <p class="field-type">Enlaces a perfiles</p>
              </div>
            </div>
            <button class="btn-add-service" @click="addSocialLink">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Agregar Red
            </button>
          </div>
          <div class="field-config">
            <div class="services-list">
              <div v-for="(link, index) in socialLinks" :key="index" class="service-item">
                <div class="service-number">{{ index + 1 }}</div>
                <div class="config-row" style="flex: 1; margin-bottom: 0">
                  <input
                    v-model="link.label"
                    class="service-input"
                    placeholder="Nombre (Ej. Facebook)"
                    style="margin-bottom: 0.5rem"
                  />
                  <input v-model="link.url" class="service-input" placeholder="URL (https://...)" />
                </div>
                <button
                  class="btn-remove-service"
                  @click="removeSocialLink(index)"
                  :disabled="socialLinks.length === 1"
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
      </div>
    </div>

    <!-- Preview Section -->
    <div class="config-section">
      <div class="section-header">
        <div
          class="section-icon"
          style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%)"
        >
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
            <circle cx="12" cy="12" r="3" />
          </svg>
        </div>
        <div>
          <h2 class="section-title">Vista Previa</h2>
          <p class="section-description">Así se verá el footer en el sitio público</p>
        </div>
      </div>

      <div class="preview-container">
        <div class="preview-form" style="max-width: 800px">
          <div class="preview-brand" style="text-align: center; margin-bottom: 2rem">
            <h3 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem">
              Peñacom
            </h3>
            <p style="color: #64748b">{{ footerData.slogan || 'Tu slogan aquí' }}</p>
          </div>

          <div
            style="
              display: grid;
              grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
              gap: 2rem;
              margin-bottom: 2rem;
            "
          >
            <div>
              <h4 class="preview-label">Contacto</h4>
              <p style="font-size: 0.9rem; color: #1e293b; margin-bottom: 0.25rem">
                {{ footerData.email || 'email@ejemplo.com' }}
              </p>
              <p style="font-size: 0.9rem; color: #1e293b">
                {{ footerData.phone || '+00 000 0000' }}
              </p>
            </div>
            <div>
              <h4 class="preview-label">Ubicación</h4>
              <p style="font-size: 0.9rem; color: #1e293b">
                {{ footerData.location || 'Dirección de la empresa' }}
              </p>
            </div>
            <div>
              <h4 class="preview-label">Redes Sociales</h4>
              <div style="display: flex; gap: 0.5rem; flex-wrap: wrap">
                <span
                  v-for="(link, i) in previewSocialLinks"
                  :key="i"
                  style="
                    font-size: 0.8rem;
                    padding: 0.25rem 0.5rem;
                    background: #f1f5f9;
                    border-radius: 4px;
                    color: #475569;
                  "
                >
                  {{ link.label || 'Red Social' }}
                </span>
              </div>
            </div>
          </div>

          <div style="text-align: center; border-top: 1px solid #e2e8f0; padding-top: 1.5rem">
            <a
              :href="whatsappLink"
              target="_blank"
              style="
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                color: #10b981;
                font-weight: 600;
                text-decoration: none;
              "
            >
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                style="width: 20px; height: 20px"
              >
                <path d="M16.72 12.06A4.72 4.72 0 0 1 12 16.78a4.73 4.73 0 0 1-4.73-4.72" />
                <path
                  d="M5.44 5.44A9 9 0 0 1 20.49 9.72 9 9 0 0 1 9.72 20.49L3 22l1.51-6.72A9 9 0 0 1 5.44 5.44z"
                />
              </svg>
              Probar botón de WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import footerService, { type FooterSettingsPayload } from '@/services/footerService'
import { computed, onMounted, reactive, ref } from 'vue'
// @ts-expect-error - useAlert está definido en JavaScript
import { useAlert } from '@/composables/useAlert'
import { footerSettingsDefaults, useFooterSettings } from '@/composables/useFooterSettings'

const { success, error: showError } = useAlert()
const { setFooterSettings } = useFooterSettings()

const loading = ref(true)
const saving = ref(false)

const footerData = reactive<FooterSettingsPayload>({
  slogan: '',
  email: '',
  phone: '',
  location: '',
  whatsapp_number: '',
  whatsapp_message: '',
})

const socialLinks = ref<Array<{ label: string; url: string }>>([{ label: 'Facebook', url: '' }])

const previewSocialLinks = computed(() => {
  const cleaned = socialLinks.value.filter(link => link.label || link.url)
  return cleaned.length ? cleaned : footerSettingsDefaults.social_links
})

const whatsappLink = computed(() => {
  if (!footerData.whatsapp_number) {
    return '#'
  }
  const sanitizedNumber = footerData.whatsapp_number.replace(/\D/g, '')
  const message = encodeURIComponent(
    footerData.whatsapp_message || footerSettingsDefaults.whatsapp_message
  )
  return `https://wa.me/${sanitizedNumber}?text=${message}`
})

const hydrateForm = (data: FooterSettingsPayload = {}) => {
  footerData.slogan = data.slogan ?? ''
  footerData.email = data.email ?? ''
  footerData.phone = data.phone ?? ''
  footerData.location = data.location ?? ''
  footerData.whatsapp_number = data.whatsapp_number ?? ''
  footerData.whatsapp_message = data.whatsapp_message ?? ''

  const links =
    Array.isArray(data.social_links) && data.social_links.length
      ? data.social_links
      : footerSettingsDefaults.social_links

  socialLinks.value = links.map(link => ({
    label: link?.label ?? '',
    url: link?.url ?? '',
  }))
}

const fetchFooterSettings = async () => {
  loading.value = true
  try {
    const data = await footerService.get()
    hydrateForm(data)
    setFooterSettings(data)
  } catch (error) {
    console.error(error)
    showError('No se pudo cargar la configuración del footer', 'Error')
  } finally {
    loading.value = false
  }
}

const addSocialLink = () => {
  socialLinks.value.push({ label: '', url: '' })
}

const removeSocialLink = (index: number) => {
  if (socialLinks.value.length === 1) return
  socialLinks.value.splice(index, 1)
}

const saveFooterSettings = async () => {
  saving.value = true
  try {
    const payload: FooterSettingsPayload = {
      ...footerData,
      social_links: socialLinks.value,
    }
    const response = await footerService.update(payload)
    const updated = response?.data ?? payload
    setFooterSettings(updated)
    success('Footer actualizado correctamente', 'Cambios guardados')
  } catch (error) {
    console.error(error)
    showError('No se pudo guardar la configuración', 'Error')
  } finally {
    saving.value = false
  }
}

onMounted(fetchFooterSettings)
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

.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #fff;
  border-radius: 20px;
  padding: 3rem;
  box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
  border: 1px solid #e2e8f0;
  color: #475569;
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

.config-input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.875rem;
  transition: all 0.2s ease;
  font-family: inherit;
}

.config-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.config-input {
  resize: vertical;
  min-height: 80px;
}

.btn-add-service {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 0.875rem;
}

.btn-add-service:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
}

.btn-add-service svg {
  width: 16px;
  height: 16px;
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
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  transition: all 0.2s ease;
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
  width: 100%;
  padding: 0.5rem 0.75rem;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  font-size: 0.875rem;
  transition: all 0.2s ease;
}

.service-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.btn-remove-service {
  width: 32px;
  height: 32px;
  background: #fee;
  border: 1px solid #fecaca;
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
  width: 100%;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.preview-label {
  display: block;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #94a3b8;
  margin-bottom: 0.25rem;
  letter-spacing: 0.05em;
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

  .service-item {
    flex-direction: column;
    align-items: stretch;
  }

  .service-number {
    width: 100%;
    height: 24px;
  }

  .btn-remove-service {
    width: 100%;
  }
}
</style>
