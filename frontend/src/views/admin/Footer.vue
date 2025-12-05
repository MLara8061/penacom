<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <div class="admin-footer-config">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">⚙️ Configuración del Footer</h1>
        <p class="page-description">
          Edita los campos dinámicos del pie de página. Los cambios se reflejan en tiempo real
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

    <div v-else class="content-wrapper">
      <!-- Panel de Edición -->
      <div class="edit-panel">
        <div class="section-card">
          <h2 class="section-title">
            <span class="icon">🖼️</span>
            Logo
          </h2>
          <div class="form-group">
            <label class="form-label">URL del Logo</label>
            <input
              type="text"
              v-model="footerData.logo"
              class="form-input"
              placeholder="/logo.png"
            />
            <small class="form-hint">Ruta o URL de la imagen del logo</small>
          </div>
        </div>

        <div class="section-card">
          <h2 class="section-title">
            <span class="icon">💬</span>
            Slogan
          </h2>
          <div class="form-group">
            <label class="form-label">Mensaje del Footer</label>
            <textarea
              v-model="footerData.slogan"
              class="form-textarea"
              rows="3"
              placeholder="Transformando ideas en realidad digital..."
            ></textarea>
          </div>
        </div>

        <div class="section-card">
          <h2 class="section-title">
            <span class="icon">📱</span>
            Redes Sociales
          </h2>
          <div class="social-list">
            <div v-for="(link, index) in footerData.social_links" :key="index" class="social-item">
              <div class="social-fields">
                <input
                  type="text"
                  v-model="link.label"
                  class="form-input"
                  placeholder="Nombre (ej. Facebook)"
                />
                <input
                  type="text"
                  v-model="link.url"
                  class="form-input"
                  placeholder="URL completa"
                />
                <button class="btn-remove" @click="removeSocialLink(index)">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </button>
              </div>
            </div>
            <button class="btn-add" @click="addSocialLink">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
              Agregar Red Social
            </button>
          </div>
        </div>

        <div class="section-card">
          <h2 class="section-title">
            <span class="icon">📧</span>
            Correo Electrónico
          </h2>
          <div class="form-group">
            <label class="form-label">Email de Contacto</label>
            <input
              type="email"
              v-model="footerData.email"
              class="form-input"
              placeholder="contacto@ejemplo.com"
            />
          </div>
        </div>

        <div class="section-card">
          <h2 class="section-title">
            <span class="icon">📞</span>
            Teléfono
          </h2>
          <div class="form-group">
            <label class="form-label">Número de Teléfono</label>
            <input
              type="text"
              v-model="footerData.phone"
              class="form-input"
              placeholder="+52 (998) 500 0000"
            />
          </div>
        </div>

        <div class="section-card">
          <h2 class="section-title">
            <span class="icon">📍</span>
            Ubicación
          </h2>
          <div class="form-group">
            <label class="form-label">Dirección / Ubicación</label>
            <textarea
              v-model="footerData.location"
              class="form-textarea"
              rows="3"
              placeholder="Cancún, Quintana Roo, México"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Vista Previa -->
      <div class="preview-panel">
        <div class="preview-header">
          <h3>Vista Previa en Tiempo Real</h3>
          <span class="preview-badge">Live Preview</span>
        </div>
        <div class="preview-container">
          <footer class="footer-preview">
            <div class="footer-content">
              <div class="footer-brand">
                <div class="footer-logo">
                  <img
                    :src="footerData.logo || '/logo.png'"
                    alt="Logo"
                    class="footer-logo-image"
                    @error="handleImageError"
                  />
                </div>
                <p class="footer-tagline">{{ footerData.slogan || 'Tu slogan aquí...' }}</p>
                <div class="social-links">
                  <a
                    v-for="(link, index) in footerData.social_links"
                    :key="index"
                    :href="link.url || '#'"
                    class="social-link"
                    target="_blank"
                    rel="noopener"
                  >
                    <span>{{ link.label || 'Red Social' }}</span>
                  </a>
                </div>
              </div>

              <div class="footer-section">
                <h4>Servicios</h4>
                <ul>
                  <li><a href="#servicios">Pantallas LED</a></li>
                  <li><a href="#servicios">Señalización Digital</a></li>
                  <li><a href="#servicios">Instalación</a></li>
                  <li><a href="#servicios">Mantenimiento</a></li>
                </ul>
              </div>

              <div class="footer-section">
                <h4>Empresa</h4>
                <ul>
                  <li><a href="#nosotros">Sobre Nosotros</a></li>
                  <li><a href="#portafolio">Portafolio</a></li>
                  <li><a href="#testimonios">Testimonios</a></li>
                  <li><a href="#contacto">Contacto</a></li>
                </ul>
              </div>

              <div class="footer-section">
                <h4>Contacto</h4>
                <ul class="contact-list">
                  <li>
                    <svg
                      class="contact-icon"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                      />
                    </svg>
                    <a :href="`mailto:${footerData.email}`" class="contact-link">
                      {{ footerData.email || 'email@ejemplo.com' }}
                    </a>
                  </li>
                  <li>
                    <svg
                      class="contact-icon"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                      />
                    </svg>
                    <a :href="`tel:${footerData.phone}`" class="contact-link">
                      {{ footerData.phone || '+52 (998) 000 0000' }}
                    </a>
                  </li>
                  <li>
                    <svg
                      class="contact-icon"
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

            <div class="footer-bottom">
              <p>&copy; 2025 Peñacom. Todos los derechos reservados.</p>
              <div class="footer-links">
                <a href="#">Política de Privacidad</a>
                <a href="#">Términos de Servicio</a>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
// @ts-expect-error - useAlert está definido en JavaScript
import { useAlert } from '@/composables/useAlert'
import { footerSettingsDefaults, useFooterSettings } from '@/composables/useFooterSettings'

const { success, error } = useAlert()
const { footerSettings, fetchFooterSettings, saveFooterSettings: saveToApi } = useFooterSettings()

const loading = ref(true)
const saving = ref(false)

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
    await fetchFooterSettings()
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
  } catch (err) {
    error('Error al cargar la configuración del footer')
    console.error(err)
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
    await saveToApi(footerData.value)
    success('✅ Configuración del footer guardada correctamente')
  } catch (err) {
    error('❌ Error al guardar la configuración')
    console.error(err)
  } finally {
    saving.value = false
  }
}
</script>

<style scoped>
.admin-footer-config {
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

.header-content h1 {
  font-size: 2rem;
  font-weight: 800;
  color: #1e293b;
  margin: 0;
}

.page-description {
  color: #64748b;
  margin-top: 0.5rem;
}

.btn-save {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 600;
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

.content-wrapper {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
  align-items: start;
}

.edit-panel {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.section-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.section-title {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.1rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 1rem;
}

.icon {
  font-size: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #475569;
}

.form-input,
.form-textarea {
  padding: 0.75rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.95rem;
  transition: all 0.2s ease;
  font-family: inherit;
}

.form-input:focus,
.form-textarea:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-hint {
  font-size: 0.8rem;
  color: #94a3b8;
}

.social-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.social-item {
  display: flex;
  gap: 0.5rem;
}

.social-fields {
  display: flex;
  gap: 0.5rem;
  width: 100%;
}

.btn-remove {
  padding: 0.5rem;
  background: #fee2e2;
  border: none;
  border-radius: 8px;
  color: #dc2626;
  cursor: pointer;
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.btn-remove:hover {
  background: #fecaca;
}

.btn-remove svg {
  width: 20px;
  height: 20px;
}

.btn-add {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem;
  background: #f0f9ff;
  border: 2px dashed #0ea5e9;
  border-radius: 8px;
  color: #0ea5e9;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-add:hover {
  background: #e0f2fe;
  border-color: #0284c7;
  color: #0284c7;
}

.btn-add svg {
  width: 20px;
  height: 20px;
}

/* Vista Previa */
.preview-panel {
  position: sticky;
  top: 2rem;
}

.preview-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0 0.5rem;
}

.preview-header h3 {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1e293b;
}

.preview-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  border-radius: 999px;
  font-size: 0.75rem;
  font-weight: 600;
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

.preview-container {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  max-height: calc(100vh - 8rem);
  overflow-y: auto;
}

/* Estilos del Footer Preview (idénticos al footer público) */
.footer-preview {
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: white;
  padding: 3rem 2rem 1.5rem;
  position: relative;
  overflow: hidden;
  font-size: 0.85rem;
}

.footer-preview::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(0, 102, 204, 0.5), transparent);
}

.footer-content {
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
  gap: 2rem;
  margin-bottom: 2rem;
}

.footer-brand {
  max-width: 280px;
}

.footer-logo {
  margin-bottom: 1rem;
}

.footer-logo-image {
  height: 40px;
  width: auto;
  object-fit: contain;
}

.footer-tagline {
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.6;
  margin-bottom: 1.5rem;
  font-size: 0.85rem;
}

.footer-section h4 {
  color: #ffffff;
  font-size: 0.95rem;
  font-weight: 700;
  margin-bottom: 1rem;
  position: relative;
  padding-bottom: 0.5rem;
}

.footer-section h4::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 30px;
  height: 2px;
  background: linear-gradient(90deg, #0066cc, #4a90e2);
  border-radius: 2px;
}

.footer-section ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-section li {
  margin-bottom: 0.6rem;
}

.footer-section a {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  transition: all 0.3s ease;
  display: inline-block;
  font-size: 0.85rem;
}

.footer-section a:hover {
  color: #4a90e2;
  transform: translateX(3px);
}

.contact-list li {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.85rem;
}

.contact-icon {
  width: 18px;
  height: 18px;
  color: #4a90e2;
  flex-shrink: 0;
}

.contact-link {
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  transition: color 0.2s ease;
}

.contact-link:hover {
  color: #4a90e2;
}

.social-links {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.social-link {
  min-width: 40px;
  padding: 0.5rem 0.75rem;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(10px);
  border-radius: 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 0.8rem;
  color: rgba(255, 255, 255, 0.9);
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.1);
  text-decoration: none;
}

.social-link:hover {
  background: #0066cc;
  border-color: #0066cc;
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0, 102, 204, 0.3);
}

.footer-bottom {
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
  font-size: 0.8rem;
}

.footer-bottom p {
  color: rgba(255, 255, 255, 0.5);
  margin: 0;
}

.footer-links {
  display: flex;
  gap: 1.5rem;
}

.footer-links a {
  color: rgba(255, 255, 255, 0.5);
  text-decoration: none;
  transition: color 0.3s ease;
  font-size: 0.8rem;
}

.footer-links a:hover {
  color: #4a90e2;
}

@media (max-width: 1024px) {
  .content-wrapper {
    grid-template-columns: 1fr;
  }

  .preview-panel {
    position: relative;
    top: 0;
  }

  .footer-content {
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
  }
}

@media (max-width: 768px) {
  .admin-footer-config {
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

  .footer-content {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  .footer-brand {
    max-width: 100%;
  }

  .social-fields {
    flex-direction: column;
  }
}
</style>
