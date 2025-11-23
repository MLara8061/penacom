# Ejemplo de componente Vue - Vista pública de servicios

<template>
  <div class="services-section">
    <h2>Nuestros Servicios</h2>
    
    <div v-if="loading" class="loading">
      Cargando servicios...
    </div>

    <div v-else-if="error" class="error">
      {{ error }}
    </div>

    <div v-else class="services-grid">
      <div 
        v-for="service in services" 
        :key="service.id" 
        class="service-card"
      >
        <div v-if="service.image" class="service-image">
          <img :src="service.image" :alt="service.title">
        </div>
        
        <div v-else-if="service.icon" class="service-icon">
          <i :class="service.icon"></i>
        </div>

        <h3>{{ service.title }}</h3>
        <p>{{ service.description }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import serviceService from '../../services/serviceService';

const services = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchServices = async () => {
  try {
    loading.value = true;
    services.value = await serviceService.getActive();
  } catch (err) {
    error.value = 'Error al cargar los servicios';
    console.error(err);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchServices();
});
</script>

<style scoped>
.services-section {
  padding: 2rem;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.service-card {
  padding: 1.5rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  text-align: center;
}

.service-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 4px;
}

.service-icon i {
  font-size: 3rem;
  color: #007bff;
}

.loading, .error {
  text-align: center;
  padding: 2rem;
}

.error {
  color: red;
}
</style>
