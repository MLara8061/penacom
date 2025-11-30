<script setup>
import { RouterView, useRoute } from 'vue-router'
import { computed } from 'vue'
import FloatingWhatsApp from '@/components/FloatingWhatsApp.vue'
import SnowfallEffect from '@/components/SnowfallEffect.vue'

const route = useRoute()
const showWhatsApp = computed(() => !route.path.startsWith('/admin'))
</script>

<template>
  <RouterView />
  <FloatingWhatsApp v-if="showWhatsApp" phone-number="529985401540" />
  <SnowfallEffect />
</template>

<style>
/* Los estilos globales están en assets/styles.css */
</style>
