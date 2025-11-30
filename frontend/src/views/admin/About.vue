<template>
  <div class="admin-about">
    <h1>Acerca de la Empresa</h1>
    
    <form @submit.prevent="saveChanges" class="about-form">
      <div class="form-group">
        <label for="title">Título</label>
        <input
          id="title"
          v-model="form.title"
          type="text"
          required
          class="form-control"
        />
      </div>

      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea
          id="description"
          v-model="form.description"
          rows="5"
          required
          class="form-control"
        ></textarea>
      </div>

      <div class="form-group">
        <label for="highlighted_text">Texto Destacado</label>
        <textarea
          id="highlighted_text"
          v-model="form.highlighted_text"
          rows="3"
          required
          class="form-control"
          placeholder="Al adquirir nuestros productos, obtiene la más alta tecnología..."
        ></textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="years_experience">Años de Experiencia</label>
          <input
            id="years_experience"
            v-model.number="form.years_experience"
            type="number"
            min="0"
            required
            class="form-control"
          />
        </div>

        <div class="form-group">
          <label for="happy_clients">Clientes Satisfechos</label>
          <input
            id="happy_clients"
            v-model.number="form.happy_clients"
            type="number"
            min="0"
            required
            class="form-control"
          />
        </div>
      </div>

      <div class="form-group">
        <label for="current_image">URL de Imagen</label>
        <input
          id="current_image"
          v-model="form.current_image"
          type="url"
          class="form-control"
          placeholder="https://..."
        />
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary" :disabled="loading">
          {{ loading ? 'Guardando...' : 'Guardar Cambios' }}
        </button>
      </div>

      <div v-if="message" class="message" :class="messageType">
        {{ message }}
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../../services/api'

const form = ref({
  title: '',
  description: '',
  highlighted_text: '',
  years_experience: 0,
  happy_clients: 0,
  current_image: ''
})

const loading = ref(false)
const message = ref('')
const messageType = ref('')

const loadData = async () => {
  try {
    const response = await api.get('/about')
    form.value = response.data
  } catch (error) {
    console.error('Error al cargar datos:', error)
    message.value = 'Error al cargar los datos'
    messageType.value = 'error'
  }
}

const saveChanges = async () => {
  loading.value = true
  message.value = ''
  
  try {
    await api.put('/about', form.value)
    message.value = 'Cambios guardados exitosamente'
    messageType.value = 'success'
    
    setTimeout(() => {
      message.value = ''
    }, 3000)
  } catch (error) {
    console.error('Error al guardar:', error)
    message.value = 'Error al guardar los cambios'
    messageType.value = 'error'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadData()
})
</script>

<style scoped>
.admin-about {
  max-width: 800px;
}

.admin-about h1 {
  margin-bottom: 2rem;
  color: #2c3e50;
}

.about-form {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #2c3e50;
}

.form-control {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
  font-family: inherit;
}

.form-control:focus {
  outline: none;
  border-color: #0066CC;
  box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
}

textarea.form-control {
  resize: vertical;
  min-height: 100px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 2rem;
}

.btn {
  padding: 0.75rem 2rem;
  border: none;
  border-radius: 4px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-primary {
  background: #0066CC;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #0052A3;
  transform: translateY(-2px);
}

.btn-primary:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.message {
  margin-top: 1rem;
  padding: 1rem;
  border-radius: 4px;
  text-align: center;
}

.message.success {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.message.error {
  background: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>
