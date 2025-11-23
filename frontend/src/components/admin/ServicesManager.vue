# Ejemplo de componente Vue - Panel admin de servicios

<template>
  <div class="admin-services">
    <div class="header">
      <h2>Gestión de Servicios</h2>
      <button @click="showCreateModal = true" class="btn-primary">
        Agregar Servicio
      </button>
    </div>

    <div v-if="loading" class="loading">Cargando...</div>

    <table v-else class="services-table">
      <thead>
        <tr>
          <th>Título</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Orden</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="service in services" :key="service.id">
          <td>{{ service.title }}</td>
          <td>{{ truncate(service.description, 50) }}</td>
          <td>
            <span :class="['badge', service.is_active ? 'active' : 'inactive']">
              {{ service.is_active ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td>{{ service.order }}</td>
          <td class="actions">
            <button @click="toggleStatus(service.id)" class="btn-sm">
              {{ service.is_active ? 'Desactivar' : 'Activar' }}
            </button>
            <button @click="editService(service)" class="btn-sm">
              Editar
            </button>
            <button @click="deleteService(service.id)" class="btn-sm btn-danger">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal para crear/editar servicio -->
    <div v-if="showCreateModal" class="modal">
      <div class="modal-content">
        <h3>{{ editingService ? 'Editar' : 'Nuevo' }} Servicio</h3>
        <form @submit.prevent="saveService">
          <input 
            v-model="form.title" 
            type="text" 
            placeholder="Título" 
            required
          >
          <textarea 
            v-model="form.description" 
            placeholder="Descripción" 
            required
          ></textarea>
          <input 
            v-model="form.icon" 
            type="text" 
            placeholder="Clase de icono (ej: fa fa-star)"
          >
          <input 
            v-model="form.order" 
            type="number" 
            placeholder="Orden"
          >
          
          <div class="modal-actions">
            <button type="button" @click="closeModal">Cancelar</button>
            <button type="submit" class="btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import serviceService from '../../services/serviceService';

const services = ref([]);
const loading = ref(false);
const showCreateModal = ref(false);
const editingService = ref(null);

const form = ref({
  title: '',
  description: '',
  icon: '',
  order: 0,
  is_active: true
});

const fetchServices = async () => {
  loading.value = true;
  try {
    services.value = await serviceService.getAll();
  } catch (error) {
    console.error('Error al cargar servicios:', error);
  } finally {
    loading.value = false;
  }
};

const saveService = async () => {
  try {
    if (editingService.value) {
      await serviceService.update(editingService.value.id, form.value);
    } else {
      await serviceService.create(form.value);
    }
    await fetchServices();
    closeModal();
  } catch (error) {
    console.error('Error al guardar:', error);
  }
};

const editService = (service) => {
  editingService.value = service;
  form.value = { ...service };
  showCreateModal.value = true;
};

const deleteService = async (id) => {
  if (confirm('¿Estás seguro de eliminar este servicio?')) {
    try {
      await serviceService.delete(id);
      await fetchServices();
    } catch (error) {
      console.error('Error al eliminar:', error);
    }
  }
};

const toggleStatus = async (id) => {
  try {
    await serviceService.toggleStatus(id);
    await fetchServices();
  } catch (error) {
    console.error('Error al cambiar estado:', error);
  }
};

const closeModal = () => {
  showCreateModal.value = false;
  editingService.value = null;
  form.value = {
    title: '',
    description: '',
    icon: '',
    order: 0,
    is_active: true
  };
};

const truncate = (text, length) => {
  return text.length > length ? text.substring(0, length) + '...' : text;
};

onMounted(() => {
  fetchServices();
});
</script>

<style scoped>
.admin-services {
  padding: 2rem;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.services-table {
  width: 100%;
  border-collapse: collapse;
}

.services-table th,
.services-table td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.badge {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.875rem;
}

.badge.active {
  background: #28a745;
  color: white;
}

.badge.inactive {
  background: #dc3545;
  color: white;
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.btn-primary {
  background: #007bff;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
}

.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  border: 1px solid #ddd;
  background: white;
  cursor: pointer;
  border-radius: 4px;
}

.btn-danger {
  background: #dc3545;
  color: white;
  border-color: #dc3545;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
}

.modal-content input,
.modal-content textarea {
  width: 100%;
  padding: 0.5rem;
  margin: 0.5rem 0;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.modal-content textarea {
  min-height: 100px;
  resize: vertical;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
  margin-top: 1rem;
}
</style>
