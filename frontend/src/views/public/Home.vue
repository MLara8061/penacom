<template>
  <div class="home">
    <HeroSection />
    <AboutSection />
    <ProductsSection />
    <ServicesSection2 />
    <ContactSection />
  </div>
</template>

<script setup>
import HeroSection from '@/components/public/HeroSection.vue'
import AboutSection from '@/components/public/AboutSection.vue'
import ProductsSection from '@/components/public/ProductsSection.vue'
import ServicesSection2 from '@/components/public/ServicesSection2.vue'
import ContactSection from '@/components/public/ContactSection.vue'
</script>

<style scoped>
.home {
  width: 100%;
  overflow-x: hidden;
}
</style>
