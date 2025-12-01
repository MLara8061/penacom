<script setup>
import Alert from '@/components/Alert.vue'
import FloatingWhatsApp from '@/components/FloatingWhatsApp.vue'
import SnowfallEffect from '@/components/SnowfallEffect.vue'
import { useAlert } from '@/composables/useAlert'
import { footerSettingsDefaults, useFooterSettings } from '@/composables/useFooterSettings'
import { computed, onMounted } from 'vue'
import { RouterView, useRoute } from 'vue-router'

const route = useRoute()
const showWhatsApp = computed(() => !route.path.startsWith('/admin'))
const { alertState, close } = useAlert()
const { footerSettings, fetchFooterSettings } = useFooterSettings()

const whatsappNumber = computed(
  () => footerSettings.value.whatsapp_number || footerSettingsDefaults.whatsapp_number
)
const whatsappMessage = computed(
  () => footerSettings.value.whatsapp_message || footerSettingsDefaults.whatsapp_message
)

onMounted(() => {
  fetchFooterSettings().catch(() => {
    // Silenciar errores en el layout principal, ya se reportan en vistas específicas
  })
})
</script>

<template>
  <RouterView />
  <FloatingWhatsApp v-if="showWhatsApp" :phone-number="whatsappNumber" :message="whatsappMessage" />
  <SnowfallEffect />
  <Alert
    :show="alertState.show"
    :type="alertState.type"
    :title="alertState.title"
    :message="alertState.message"
    :auto-close="alertState.autoClose"
    :duration="alertState.duration"
    :confirm-action="alertState.confirmAction"
    :confirm-text="alertState.confirmText"
    :cancel-text="alertState.cancelText"
    @close="close"
    @confirm="alertState.confirmAction"
  />
</template>

<style>
/* Los estilos globales están en assets/styles.css */
</style>
