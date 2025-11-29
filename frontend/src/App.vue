<script setup>
import { RouterView } from 'vue-router'
import FloatingWhatsApp from '@/components/FloatingWhatsApp.vue'
import SnowfallEffect from '@/components/SnowfallEffect.vue'
</script>

<template>
  <RouterView />
  <FloatingWhatsApp phone-number="529985401540" />
  <SnowfallEffect />
</template>

<style>
/* Los estilos globales están en assets/styles.css */
</style>
