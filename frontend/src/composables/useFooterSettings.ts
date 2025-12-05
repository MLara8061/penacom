import footerService, { type FooterSettingsPayload } from '@/services/footerService'
import { ref } from 'vue'

export const footerSettingsDefaults = Object.freeze({
  logo: '/logo.png',
  slogan: 'Transformando ideas en realidad digital desde 2013',
  email: 'info@penacom.com',
  phone: '+1 (555) 123-4567',
  location: 'Ciudad, País 12345',
  whatsapp_number: '529985401540',
  whatsapp_message: 'Hola, me gustaría obtener más información sobre sus servicios.',
  social_links: [
    { label: 'Facebook', url: 'https://facebook.com/penacom' },
    { label: 'Twitter', url: 'https://twitter.com/penacom' },
    { label: 'LinkedIn', url: 'https://linkedin.com/company/penacom' },
    { label: 'Instagram', url: 'https://instagram.com/penacom' },
  ],
})

const cloneDefaults = () => JSON.parse(JSON.stringify(footerSettingsDefaults))

const footerSettings = ref(cloneDefaults())
const footerSettingsLoaded = ref(false)
const loadingFooterSettings = ref(false)
let pendingRequest: Promise<typeof footerSettings.value> | null = null

const setFooterSettings = (payload: FooterSettingsPayload = {}) => {
  const defaults = cloneDefaults()

  // Validar que payload sea un objeto y no un array
  if (Array.isArray(payload) || payload === null || typeof payload !== 'object') {
    console.warn('⚠️ [COMPOSABLE] Payload inválido recibido del API, usando defaults:', payload)
    footerSettings.value = defaults
    return
  }

  const merged = {
    ...defaults,
    ...payload,
    social_links: Array.isArray(payload?.social_links)
      ? payload.social_links.map(link => ({
          label: link?.label ?? '',
          url: link?.url ?? '',
        }))
      : defaults.social_links,
  }

  footerSettings.value = merged
}

const fetchFooterSettings = async (force = false) => {
  console.log(
    `🔍 [COMPOSABLE] fetchFooterSettings llamado con force=${force}, loaded=${footerSettingsLoaded.value}`
  )

  if (footerSettingsLoaded.value && !force) {
    console.log('📌 [COMPOSABLE] Usando caché existente:', footerSettings.value)
    return footerSettings.value
  }

  if (pendingRequest) {
    console.log('⏳ [COMPOSABLE] Request pendiente, esperando...')
    return pendingRequest
  }

  pendingRequest = (async () => {
    loadingFooterSettings.value = true
    try {
      console.log('🌐 [COMPOSABLE] Llamando al API /settings/footer...')
      const data = await footerService.get()
      console.log('📥 [COMPOSABLE] Datos recibidos del API:', data)
      setFooterSettings(data)
      footerSettingsLoaded.value = true
      console.log('✅ [COMPOSABLE] Estado actualizado:', footerSettings.value)
      return footerSettings.value
    } catch (error) {
      console.error('❌ [COMPOSABLE] Error al cargar:', error)
      throw error
    } finally {
      loadingFooterSettings.value = false
      pendingRequest = null
    }
  })()

  return pendingRequest
}

const saveFooterSettings = async (payload: FooterSettingsPayload) => {
  try {
    console.log('💾 [COMPOSABLE] Enviando datos al API:', payload)
    const response = await footerService.update(payload)
    console.log('📥 [COMPOSABLE] Respuesta del API:', response)
    setFooterSettings(response.data)
    footerSettingsLoaded.value = true
    console.log('✅ [COMPOSABLE] Estado actualizado después de guardar:', footerSettings.value)
    return response.data
  } catch (error) {
    console.error('❌ [COMPOSABLE] Error al guardar:', error)
    throw error
  }
}

export function useFooterSettings() {
  return {
    footerSettings,
    footerSettingsLoaded,
    loadingFooterSettings,
    fetchFooterSettings,
    setFooterSettings,
    saveFooterSettings,
  }
}
