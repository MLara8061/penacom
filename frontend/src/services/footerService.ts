// @ts-expect-error - api is js
import api from '@/services/api'

export interface FooterSettingsPayload {
  logo?: string
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
    console.log('🌐 [API SERVICE] GET /settings/footer')
    const response = await api.get('/settings/footer')
    console.log('📥 [API SERVICE] Respuesta recibida:', response.data)
    return response.data as FooterSettingsPayload
  },

  async update(payload: FooterSettingsPayload) {
    console.log('🌐 [API SERVICE] PUT /settings/footer con payload:', payload)
    const response = await api.put('/settings/footer', payload)
    console.log('📥 [API SERVICE] Respuesta de actualización:', response.data)
    return response.data as { message: string; data: FooterSettingsPayload }
  },
}

export default footerService
