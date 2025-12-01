import footerService, { type FooterSettingsPayload } from '@/services/footerService'
import { ref } from 'vue'

export const footerSettingsDefaults = Object.freeze({
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
  if (footerSettingsLoaded.value && !force) {
    return footerSettings.value
  }

  if (pendingRequest) {
    return pendingRequest
  }

  pendingRequest = (async () => {
    loadingFooterSettings.value = true
    try {
      const data = await footerService.get()
      setFooterSettings(data)
      footerSettingsLoaded.value = true
      return footerSettings.value
    } catch (error) {
      console.error('No se pudo cargar la configuración del footer', error)
      throw error
    } finally {
      loadingFooterSettings.value = false
      pendingRequest = null
    }
  })()

  return pendingRequest
}

export function useFooterSettings() {
  return {
    footerSettings,
    footerSettingsLoaded,
    loadingFooterSettings,
    fetchFooterSettings,
    setFooterSettings,
  }
}
