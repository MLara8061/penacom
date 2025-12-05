<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="admin-form-config">
    <!-- Alert Notification -->
    <div class="alert-container">
      <AlertNotification
        v-model="alertState.show"
        :type="alertState.type"
        :title="alertState.title"
        :message="alertState.message"
        :duration="alertState.duration"
      />
    </div>

    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Configuración del Footer</h1>
        <p class="page-description">
          Personaliza el logotipo, slogan, redes sociales y datos de contacto del pie de página
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

    <template v-else>
      <!-- Debug Panel -->
      <div class="debug-panel">
        <div class="debug-header" @click="debugExpanded = !debugExpanded">
          <h3>🔍 Panel de Debugging</h3>
          <span class="debug-toggle">{{ debugExpanded ? '▼' : '▶' }}</span>
        </div>
        <div v-if="debugExpanded" class="debug-content">
          <div class="debug-section">
            <h4>📊 Estado Actual</h4>
            <div class="debug-info">
              <p><strong>Logo:</strong> {{ footerData.logo }}</p>
              <p><strong>Slogan:</strong> {{ footerData.slogan }}</p>
              <p><strong>Email:</strong> {{ footerData.email }}</p>
              <p><strong>Phone:</strong> {{ footerData.phone }}</p>
              <p><strong>Location:</strong> {{ footerData.location }}</p>
              <p>
                <strong>Social Links:</strong> {{ footerData.social_links?.length || 0 }} enlaces
              </p>
            </div>
          </div>
          <div class="debug-section">
            <h4>🔄 Última Actualización</h4>
            <p>{{ lastUpdateTime || 'Sin actualizaciones' }}</p>
          </div>
        </div>
      </div>

      <!-- Información General -->
      <div class="config-section">
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
            <h2 class="section-title">Información General</h2>
            <p class="section-description">Logo y mensaje principal del footer</p>
          </div>
        </div>

        <div class="fields-grid">
          <!-- Logo -->
          <div class="field-card">
            <div class="field-header">
              <div class="field-info">
                <div
                  class="field-icon"
                  style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%)"
                >
                  🖼️
                </div>
                <div>
                  <h3 class="field-name">Logo</h3>
                  <p class="field-type">Imagen del footer</p>
                </div>
              </div>
            </div>
            <div class="field-config">
              <div class="config-row">
                <label class="config-label">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                  </svg>
                  URL del Logo
                </label>
                <input
                  type="text"
                  v-model="footerData.logo"
                  class="config-input"
                  placeholder="/logo.png"
                />
              </div>
              <div v-if="footerData.logo" class="config-preview-image">
                <img :src="footerData.logo" alt="Logo Preview" @error="handleImageError" />
              </div>
            </div>
          </div>

          <!-- Slogan -->
          <div class="field-card">
            <div class="field-header">
              <div class="field-info">
                <div
                  class="field-icon"
                  style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)"
                >
                  💬
                </div>
                <div>
                  <h3 class="field-name">Slogan</h3>
                  <p class="field-type">Mensaje del footer</p>
                </div>
              </div>
            </div>
            <div class="field-config">
              <div class="config-row">
                <label class="config-label">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                  </svg>
                  Mensaje Principal
                </label>
                <textarea
                  v-model="footerData.slogan"
                  class="config-input"
                  rows="3"
                  placeholder="Transformando ideas en realidad digital..."
                ></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Redes Sociales -->
      <div class="config-section">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path
                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
              />
            </svg>
          </div>
          <div>
            <h2 class="section-title">Redes Sociales</h2>
            <p class="section-description">Gestiona los enlaces a tus redes sociales</p>
          </div>
        </div>

        <div class="services-section">
          <div class="services-header">
            <button @click="addSocialLink" class="btn-add-service">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Agregar Red Social
            </button>
          </div>

          <div class="services-list">
            <div v-for="(link, index) in footerData.social_links" :key="index" class="service-item">
              <div class="service-drag-handle">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="3" y1="12" x2="21" y2="12" />
                  <line x1="3" y1="6" x2="21" y2="6" />
                  <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
              </div>

              <div class="service-number">{{ index + 1 }}</div>

              <input
                type="text"
                v-model="link.label"
                class="service-input"
                placeholder="Nombre (ej. Facebook)"
                style="flex: 0 0 30%"
              />

              <input
                type="text"
                v-model="link.url"
                class="service-input"
                placeholder="URL completa"
                style="flex: 1"
              />

              <button
                @click="removeSocialLink(index)"
                class="btn-remove-service"
                :disabled="footerData.social_links.length <= 1"
              >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="18" y1="6" x2="6" y2="18" />
                  <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Datos de Contacto -->
      <div class="config-section">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
          </div>
          <div>
            <h2 class="section-title">Datos de Contacto</h2>
            <p class="section-description">Email, teléfono y ubicación física</p>
          </div>
        </div>

        <div class="fields-grid">
          <!-- Email -->
          <div class="field-card">
            <div class="field-header">
              <div class="field-info">
                <div
                  class="field-icon"
                  style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%)"
                >
                  📧
                </div>
                <div>
                  <h3 class="field-name">Email</h3>
                  <p class="field-type">Correo de contacto</p>
                </div>
              </div>
            </div>
            <div class="field-config">
              <div class="config-row">
                <label class="config-label">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                  </svg>
                  Dirección de Email
                </label>
                <input
                  type="email"
                  v-model="footerData.email"
                  class="config-input"
                  placeholder="contacto@ejemplo.com"
                />
              </div>
            </div>
          </div>

          <!-- Teléfono -->
          <div class="field-card">
            <div class="field-header">
              <div class="field-info">
                <div
                  class="field-icon"
                  style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%)"
                >
                  📞
                </div>
                <div>
                  <h3 class="field-name">Teléfono</h3>
                  <p class="field-type">Número de contacto</p>
                </div>
              </div>
            </div>
            <div class="field-config">
              <div class="config-row">
                <label class="config-label">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                    />
                  </svg>
                  Número Telefónico
                </label>
                <input
                  type="text"
                  v-model="footerData.phone"
                  class="config-input"
                  placeholder="+52 (998) 500 0000"
                />
              </div>
            </div>
          </div>

          <!-- Ubicación -->
          <div class="field-card" style="grid-column: 1 / -1">
            <div class="field-header">
              <div class="field-info">
                <div
                  class="field-icon"
                  style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)"
                >
                  📍
                </div>
                <div>
                  <h3 class="field-name">Ubicación</h3>
                  <p class="field-type">Dirección física</p>
                </div>
              </div>
            </div>
            <div class="field-config">
              <div class="config-row">
                <label class="config-label">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                    />
                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  Dirección / Ubicación
                </label>
                <textarea
                  v-model="footerData.location"
                  class="config-input"
                  rows="3"
                  placeholder="Cancún, Quintana Roo, México"
                ></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Vista Previa -->
      <div class="config-section preview-section">
        <div class="section-header">
          <div class="section-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
              <circle cx="12" cy="12" r="3" />
            </svg>
          </div>
          <div>
            <h2 class="section-title">Vista Previa en Tiempo Real</h2>
            <p class="section-description">Así se verá el footer en el sitio web</p>
          </div>
        </div>

        <div class="preview-container">
          <footer class="footer-preview">
            <div class="footer-content-preview">
              <div class="footer-brand-preview">
                <div class="footer-logo-preview">
                  <img
                    :src="footerData.logo || '/logo.png'"
                    alt="Logo"
                    class="footer-logo-image-preview"
                    @error="handleImageError"
                  />
                </div>
                <p class="footer-tagline-preview">
                  {{ footerData.slogan || 'Tu slogan aquí...' }}
                </p>
                <div class="social-links-preview">
                  <a
                    v-for="(link, index) in footerData.social_links"
                    :key="index"
                    :href="link.url || '#'"
                    class="social-link-preview"
                    target="_blank"
                    rel="noopener"
                  >
                    <span>{{ link.label || 'Red Social' }}</span>
                  </a>
                </div>
              </div>

              <div class="footer-section-preview">
                <h4>Servicios</h4>
                <ul>
                  <li><a href="#servicios">Pantallas LED</a></li>
                  <li><a href="#servicios">Señalización Digital</a></li>
                  <li><a href="#servicios">Instalación</a></li>
                  <li><a href="#servicios">Mantenimiento</a></li>
                </ul>
              </div>

              <div class="footer-section-preview">
                <h4>Empresa</h4>
                <ul>
                  <li><a href="#nosotros">Sobre Nosotros</a></li>
                  <li><a href="#portafolio">Portafolio</a></li>
                  <li><a href="#testimonios">Testimonios</a></li>
                  <li><a href="#contacto">Contacto</a></li>
                </ul>
              </div>

              <div class="footer-section-preview">
                <h4>Contacto</h4>
                <ul class="contact-list-preview">
                  <li>
                    <svg
                      class="contact-icon-preview"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                      />
                    </svg>
                    <a :href="`mailto:${footerData.email}`" class="contact-link-preview">
                      {{ footerData.email || 'email@ejemplo.com' }}
                    </a>
                  </li>
                  <li>
                    <svg
                      class="contact-icon-preview"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                      />
                    </svg>
                    <a :href="`tel:${footerData.phone}`" class="contact-link-preview">
                      {{ footerData.phone || '+52 (998) 000 0000' }}
                    </a>
                  </li>
                  <li>
                    <svg
                      class="contact-icon-preview"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                      />
                      <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ footerData.location || 'Tu ubicación aquí' }}</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="footer-bottom-preview">
              <p>&copy; 2025 Peñacom. Todos los derechos reservados.</p>
              <div class="footer-links-preview">
                <a href="#">Política de Privacidad</a>
                <a href="#">Términos de Servicio</a>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
import AlertNotification from '@/components/AlertNotification.vue'
import { useAlert } from '@/composables/useAlert'
import { footerSettingsDefaults, useFooterSettings } from '@/composables/useFooterSettings'
import { onMounted, ref } from 'vue'

const { alertState, success, error } = useAlert()
const { footerSettings, fetchFooterSettings, saveFooterSettings: saveToApi } = useFooterSettings()

const loading = ref(true)
const saving = ref(false)
const debugExpanded = ref(true)
const lastUpdateTime = ref<string>('')

const footerData = ref({
  logo: '/logo.png',
  slogan: '',
  social_links: [] as Array<{ label: string; url: string }>,
  email: '',
  phone: '',
  location: '',
})

onMounted(async () => {
  loading.value = true
  try {
    console.log('🔄 [ADMIN FOOTER] Cargando configuración del footer...')
    await fetchFooterSettings(true) // Force refresh
    console.log('📦 [ADMIN FOOTER] Datos recibidos del servidor:', footerSettings.value)

    // Verificar que footerSettings sea un objeto válido
    if (!footerSettings.value || typeof footerSettings.value !== 'object') {
      console.warn('⚠️ [ADMIN FOOTER] Datos inválidos del servidor, usando defaults')
      throw new Error('Datos inválidos del servidor')
    }

    footerData.value = {
      logo: footerSettings.value.logo || footerSettingsDefaults.logo || '/logo.png',
      slogan: footerSettings.value.slogan || footerSettingsDefaults.slogan,
      social_links:
        footerSettings.value.social_links?.length > 0
          ? [...footerSettings.value.social_links]
          : [...footerSettingsDefaults.social_links],
      email: footerSettings.value.email || footerSettingsDefaults.email,
      phone: footerSettings.value.phone || footerSettingsDefaults.phone,
      location: footerSettings.value.location || footerSettingsDefaults.location,
    }
    console.log('✅ [ADMIN FOOTER] Configuración local inicializada:', footerData.value)
  } catch (err) {
    console.error('❌ [ADMIN FOOTER] Error al cargar:', err)
    // Usar valores por defecto en caso de error
    footerData.value = {
      logo: footerSettingsDefaults.logo || '/logo.png',
      slogan: footerSettingsDefaults.slogan,
      social_links: [...footerSettingsDefaults.social_links],
      email: footerSettingsDefaults.email,
      phone: footerSettingsDefaults.phone,
      location: footerSettingsDefaults.location,
    }
    console.log('⚠️ [ADMIN FOOTER] Usando configuración por defecto:', footerData.value)
    error('⚠️ No se pudo cargar la configuración guardada. Usando valores por defecto.')
  } finally {
    loading.value = false
  }
})

const addSocialLink = () => {
  footerData.value.social_links.push({ label: '', url: '' })
}

const removeSocialLink = (index: number) => {
  footerData.value.social_links.splice(index, 1)
}

const handleImageError = (e: Event) => {
  const target = e.target as HTMLImageElement
  target.src = '/logo.png'
}

const saveFooterSettings = async () => {
  saving.value = true
  try {
    console.log('💾 [ADMIN FOOTER] Guardando configuración:', footerData.value)
    const result = await saveToApi(footerData.value)
    console.log('✅ [ADMIN FOOTER] Respuesta del servidor:', result)
    console.log('🔄 [ADMIN FOOTER] Estado del composable después de guardar:', footerSettings.value)
    lastUpdateTime.value = new Date().toLocaleString('es-MX', {
      dateStyle: 'short',
      timeStyle: 'medium',
    })
    success('✅ Configuración del footer guardada correctamente')
  } catch (err) {
    console.error('❌ [ADMIN FOOTER] Error al guardar:', err)
    error('❌ Error al guardar la configuración')
  } finally {
    saving.value = false
  }
}
</script>

<style scoped>
/* Alert Container */
.alert-container {
  position: fixed;
  top: 2rem;
  right: 2rem;
  z-index: 9999;
  pointer-events: none;
}

.alert-container > * {
  pointer-events: all;
}

/* Estilos base idénticos a FormularioContacto.vue */
.admin-form-config {
  min-height: 100vh;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  padding: 2rem;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.header-content {
  flex: 1;
}

.page-title {
  font-size: 2rem;
  font-weight: 800;
  color: #1e293b;
  margin: 0 0 0.5rem 0;
}

.page-description {
  color: #64748b;
  font-size: 0.95rem;
  margin: 0;
}

.btn-save {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.875rem 1.75rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-save:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
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
  padding: 4rem;
  color: #64748b;
}

.loading-state svg {
  width: 48px;
  height: 48px;
  margin-bottom: 1rem;
}

/* Debug Panel */
.debug-panel {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  color: white;
  box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.debug-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  user-select: none;
}

.debug-header h3 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 700;
}

.debug-toggle {
  font-size: 1.5rem;
  transition: transform 0.3s ease;
}

.debug-content {
  margin-top: 1.5rem;
  display: grid;
  gap: 1rem;
}

.debug-section {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 12px;
  padding: 1.25rem;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.debug-section h4 {
  margin: 0 0 1rem 0;
  font-size: 1rem;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.9);
}

.debug-info p {
  margin: 0.5rem 0;
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.6;
}

.debug-info strong {
  color: #fff;
  font-weight: 600;
}

.debug-section pre {
  background: rgba(0, 0, 0, 0.3);
  border-radius: 8px;
  padding: 1rem;
  overflow-x: auto;
  font-size: 0.85rem;
  line-height: 1.6;
  margin: 0;
  color: #e2e8f0;
}

.debug-section p {
  margin: 0;
  font-size: 0.95rem;
  color: rgba(255, 255, 255, 0.9);
}

.config-section {
  background: white;
  border-radius: 20px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.section-header {
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
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
  margin: 0 0 0.5rem 0;
}

.section-description {
  color: #64748b;
  font-size: 0.95rem;
  margin: 0;
}

.fields-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 1.5rem;
}

.field-card {
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 16px;
  padding: 1.5rem;
  transition: all 0.3s ease;
}

.field-card:hover {
  border-color: #cbd5e1;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.field-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.25rem;
}

.field-info {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.field-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  flex-shrink: 0;
}

.field-name {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 0.25rem 0;
}

.field-type {
  font-size: 0.85rem;
  color: #64748b;
  margin: 0;
}

.field-config {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.config-row {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.config-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: #475569;
}

.config-label svg {
  width: 16px;
  height: 16px;
  color: #94a3b8;
}

.config-input {
  padding: 0.875rem;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  font-size: 0.95rem;
  color: #1e293b;
  background: white;
  transition: all 0.2s ease;
  font-family: inherit;
}

.config-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.config-input::placeholder {
  color: #cbd5e1;
}

textarea.config-input {
  resize: vertical;
  min-height: 80px;
}

.config-preview-image {
  margin-top: 1rem;
  padding: 1rem;
  background: white;
  border: 2px dashed #e2e8f0;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.config-preview-image img {
  max-width: 100%;
  max-height: 80px;
  object-fit: contain;
}

/* Redes Sociales */
.services-section {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.services-header {
  display: flex;
  justify-content: flex-start;
}

.btn-add-service {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(67, 233, 123, 0.3);
}

.btn-add-service:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(67, 233, 123, 0.4);
}

.btn-add-service svg {
  width: 20px;
  height: 20px;
}

.services-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.service-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem;
  background: white;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  transition: all 0.2s ease;
}

.service-item:hover {
  border-color: #cbd5e1;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.service-drag-handle {
  cursor: grab;
  color: #94a3b8;
  display: flex;
  align-items: center;
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
  font-size: 0.95rem;
  transition: all 0.2s ease;
}

.service-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-remove-service {
  padding: 0.5rem;
  background: #fee2e2;
  border: none;
  border-radius: 8px;
  color: #dc2626;
  cursor: pointer;
  transition: all 0.2s ease;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-remove-service:hover:not(:disabled) {
  background: #fecaca;
}

.btn-remove-service:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.btn-remove-service svg {
  width: 20px;
  height: 20px;
}

/* Vista Previa */
.preview-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.preview-section .section-header {
  border-bottom-color: rgba(255, 255, 255, 0.2);
}

.preview-section .section-icon {
  background: rgba(255, 255, 255, 0.2);
}

.preview-section .section-title {
  color: white;
}

.preview-section .section-description {
  color: rgba(255, 255, 255, 0.8);
}

.preview-container {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

/* Estilos del Footer Preview */
.footer-preview {
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: white;
  padding: 3rem 2rem 1.5rem;
  font-size: 0.9rem;
}

.footer-content-preview {
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
  gap: 2rem;
  margin-bottom: 2rem;
}

.footer-brand-preview {
  max-width: 280px;
}

.footer-logo-preview {
  margin-bottom: 1rem;
}

.footer-logo-image-preview {
  height: 45px;
  width: auto;
  object-fit: contain;
}

.footer-tagline-preview {
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.6;
  margin-bottom: 1.5rem;
  font-size: 0.9rem;
}

.footer-section-preview h4 {
  color: #ffffff;
  font-size: 1rem;
  font-weight: 700;
  margin-bottom: 1rem;
  position: relative;
  padding-bottom: 0.5rem;
}

.footer-section-preview h4::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 30px;
  height: 2px;
  background: linear-gradient(90deg, #0066cc, #4a90e2);
  border-radius: 2px;
}

.footer-section-preview ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-section-preview li {
  margin-bottom: 0.6rem;
}

.footer-section-preview a {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  transition: all 0.3s ease;
  display: inline-block;
  font-size: 0.9rem;
}

.footer-section-preview a:hover {
  color: #4a90e2;
  transform: translateX(3px);
}

.contact-list-preview li {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.9rem;
}

.contact-icon-preview {
  width: 18px;
  height: 18px;
  color: #4a90e2;
  flex-shrink: 0;
}

.contact-link-preview {
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  transition: color 0.2s ease;
}

.contact-link-preview:hover {
  color: #4a90e2;
}

.social-links-preview {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.social-link-preview {
  min-width: 40px;
  padding: 0.5rem 0.85rem;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(10px);
  border-radius: 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 0.85rem;
  color: rgba(255, 255, 255, 0.9);
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.1);
  text-decoration: none;
}

.social-link-preview:hover {
  background: #0066cc;
  border-color: #0066cc;
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0, 102, 204, 0.3);
}

.footer-bottom-preview {
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
  font-size: 0.85rem;
}

.footer-bottom-preview p {
  color: rgba(255, 255, 255, 0.5);
  margin: 0;
}

.footer-links-preview {
  display: flex;
  gap: 1.5rem;
}

.footer-links-preview a {
  color: rgba(255, 255, 255, 0.5);
  text-decoration: none;
  transition: color 0.3s ease;
  font-size: 0.85rem;
}

.footer-links-preview a:hover {
  color: #4a90e2;
}

/* Responsive */
@media (max-width: 1024px) {
  .footer-content-preview {
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
}

@media (max-width: 768px) {
  .admin-form-config {
    padding: 1rem;
  }

  .page-header {
    flex-direction: column;
    align-items: stretch;
  }

  .btn-save {
    width: 100%;
    justify-content: center;
  }

  .config-section {
    padding: 1.5rem;
  }

  .fields-grid {
    grid-template-columns: 1fr;
  }

  .footer-content-preview {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  .footer-brand-preview {
    max-width: 100%;
  }

  .service-item {
    flex-wrap: wrap;
  }

  .service-input {
    flex: 1 1 100%;
  }
}
</style>
