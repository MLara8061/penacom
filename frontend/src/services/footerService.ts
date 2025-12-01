// @ts-expect-error - api is js
import api from '@/services/api'

export interface FooterSettingsPayload {
  slogan?: string
  email?: string
  phone?: string
  location?: string
  whatsapp_number?: string
  whatsapp_message?: string
  social_links?: Array<{
    label?: string
    url?: string
  }>
}

const footerService = {
  async get() {
    const response = await api.get('/settings/footer')
    return response.data as FooterSettingsPayload
  },

  async update(payload: FooterSettingsPayload) {
    const response = await api.put('/settings/footer', payload)
    return response.data as { message: string; data: FooterSettingsPayload }
  },
}

export default footerService
