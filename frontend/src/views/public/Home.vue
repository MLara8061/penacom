<template>
  <div class="home">
    <HeroSection />
    <ProductsSection />
    <ServicesSection />
    <AboutSection />
    <ContactSection />
  </div>
</template>

<script setup>
import HeroSection from '@/components/public/HeroSection.vue'
import ProductsSection from '@/components/public/ProductsSection.vue'
import ServicesSection from '@/components/public/ServicesSection.vue'
import AboutSection from '@/components/public/AboutSection.vue'
import ContactSection from '@/components/public/ContactSection.vue'
</script>

<style scoped>
.home {
  width: 100%;
}
</style>
