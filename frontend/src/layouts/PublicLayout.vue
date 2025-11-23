<template>
  <div class="public-layout">
    <Header />
    <main>
      <router-view />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Header from '@/components/public/Header.vue'
import Footer from '@/components/public/Footer.vue'
</script>

<style scoped>
.public-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

main {
  flex: 1;
  padding-top: 70px; /* Compensar header fijo */
}
</style>
