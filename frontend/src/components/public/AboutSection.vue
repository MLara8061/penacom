<template>
  <section id="nosotros" class="about">
    <div class="container">
      <div class="about-content" v-if="aboutData">
        <div class="about-text">
          <h2 class="section-title">{{ aboutData.title }}</h2>
          <p class="about-description" style="white-space: pre-wrap;">{{ aboutData.description }}</p>
          <p class="about-description highlighted" v-if="aboutData.highlighted_text" style="white-space: pre-wrap;">
            {{ aboutData.highlighted_text }}
          </p>
        </div>
        
        <div class="about-stats">
          <div class="stat">
            <div class="stat-number">{{ aboutData.years_experience }}+</div>
            <div class="stat-label">Años de experiencia</div>
          </div>
          <div class="stat">
            <div class="stat-number">{{ aboutData.projects_completed }}+</div>
            <div class="stat-label">Proyectos completados</div>
          </div>
          <div class="stat">
            <div class="stat-number">{{ aboutData.support_hours }}</div>
            <div class="stat-label">Soporte técnico</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../services/api';

const aboutData = ref(null);

const loadAbout = async () => {
  try {
    const response = await api.get('/about');
    if (response.data && response.data.length > 0) {
      aboutData.value = response.data[0];
    }
  } catch (error) {
    console.error('Error loading about data:', error);
  }
};

onMounted(() => {
  loadAbout();
});
</script>

<style scoped>
.about {
  padding: 120px 0;
  background: #fff;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}

.about-content {
  max-width: 900px;
  margin: 0 auto;
}

.about-text {
  margin-bottom: 80px;
}

.section-title {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 32px;
  letter-spacing: -0.03em;
  line-height: 1.1;
}

.about-description {
  font-size: 1.25rem;
  color: #6e6e73;
  line-height: 1.6;
  margin-bottom: 24px;
}

.about-description.highlighted {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-weight: 600;
}

.about-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 48px;
  text-align: center;
}

.stat {
  padding: 32px 0;
}

.stat-number {
  font-size: 3.5rem;
  font-weight: 600;
  color: #0066CC;
  margin-bottom: 8px;
  letter-spacing: -0.02em;
}

.stat-label {
  font-size: 1rem;
  color: #6e6e73;
  font-weight: 400;
}

@media (max-width: 768px) {
  .about {
    padding: 80px 0;
  }
  
  .about-text {
    margin-bottom: 48px;
  }
  
  .about-description {
    font-size: 1.125rem;
  }
  
  .about-stats {
    gap: 32px;
  }
  
  .stat-number {
    font-size: 2.5rem;
  }
}
</style>
