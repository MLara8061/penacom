<template>
  <div class="admin-users">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Gestión de Usuarios</h1>
        <p class="page-description">Administra los usuarios del sistema</p>
      </div>
      <button @click="openModal()" class="btn-new">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="12" y1="5" x2="12" y2="19"/>
          <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Nuevo Usuario
      </button>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon admin">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
            <path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Administradores</h3>
          <p class="stat-number">{{ stats.admins }}</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon users">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Usuarios</h3>
          <p class="stat-number">{{ stats.users }}</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Activos</h3>
          <p class="stat-number">{{ stats.active }}</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon total">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="stat-content">
          <h3>Total</h3>
          <p class="stat-number">{{ stats.total }}</p>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <svg class="spinner" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
        <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
      </svg>
      <p>Cargando usuarios...</p>
    </div>

    <!-- Users Table -->
    <div v-else-if="users.length > 0" class="table-container">
      <table class="users-table">
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" :class="{ inactive: !user.is_active }">
            <td>
              <div class="user-info">
                <div class="user-avatar">
                  {{ user.name.charAt(0).toUpperCase() }}
                </div>
                <div class="user-name">{{ user.name }}</div>
              </div>
            </td>
            <td>{{ user.email }}</td>
            <td>
              <span class="badge" :class="user.role === 'admin' ? 'badge-admin' : 'badge-user'">
                {{ user.role === 'admin' ? 'Administrador' : 'Usuario' }}
              </span>
            </td>
            <td>
              <span class="badge" :class="user.is_active ? 'badge-active' : 'badge-inactive'">
                {{ user.is_active ? 'Activo' : 'Inactivo' }}
              </span>
            </td>
            <td>{{ formatDate(user.created_at) }}</td>
            <td>
              <div class="actions">
                <button 
                  @click="toggleStatus(user)" 
                  class="btn-icon btn-toggle"
                  :title="user.is_active ? 'Desactivar' : 'Activar'"
                  :disabled="isCurrentUser(user.id)"
                >
                  <svg v-if="user.is_active" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                  </svg>
                  <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                  </svg>
                </button>
                <button @click="openModal(user)" class="btn-icon btn-edit" title="Editar">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </button>
                <button 
                  @click="confirmDelete(user)" 
                  class="btn-icon btn-delete" 
                  title="Eliminar"
                  :disabled="isCurrentUser(user.id)"
                >
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Empty State -->
    <div v-else class="empty-state">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
      </svg>
      <h3>No hay usuarios</h3>
      <p>Crea el primer usuario para comenzar</p>
      <button @click="openModal()" class="btn-empty">Crear Usuario</button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h2>{{ isEditing ? 'Editar Usuario' : 'Nuevo Usuario' }}</h2>
          <button @click="closeModal" class="btn-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="saveUser" class="modal-body">
          <div class="form-group">
            <label for="name" class="form-label">
              Nombre completo <span class="required">*</span>
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="form-control"
              placeholder="Juan Pérez"
            />
          </div>

          <div class="form-group">
            <label for="email" class="form-label">
              Email <span class="required">*</span>
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="form-control"
              placeholder="juan@ejemplo.com"
            />
          </div>

          <div class="form-group">
            <label for="password" class="form-label">
              Contraseña {{ isEditing ? '(dejar en blanco para mantener)' : '' }} 
              <span v-if="!isEditing" class="required">*</span>
            </label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              :required="!isEditing"
              minlength="8"
              class="form-control"
              placeholder="Mínimo 8 caracteres"
            />
            <div class="form-hint">Mínimo 8 caracteres</div>
          </div>

          <div class="form-group">
            <label for="role" class="form-label">
              Rol <span class="required">*</span>
            </label>
            <select
              id="role"
              v-model="form.role"
              required
              class="form-control"
            >
              <option value="">Seleccionar rol</option>
              <option value="admin">Administrador</option>
              <option value="user">Usuario</option>
            </select>
            <div class="form-hint">
              Los usuarios solo pueden ver contenido, los administradores pueden editar todo
            </div>
          </div>

          <div class="form-group">
            <label class="checkbox-label">
              <input
                v-model="form.is_active"
                type="checkbox"
                class="form-checkbox"
              />
              <span>Usuario activo</span>
            </label>
          </div>

          <div class="form-actions">
            <button type="button" @click="closeModal" class="btn-secondary">
              Cancelar
            </button>
            <button type="submit" class="btn-primary" :disabled="saving">
              <svg v-if="saving" class="spinner" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
                <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
              </svg>
              <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
              </svg>
              {{ saving ? 'Guardando...' : 'Guardar Usuario' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="modal-overlay" @click="showDeleteModal = false">
      <div class="modal-content modal-small" @click.stop>
        <div class="modal-header">
          <h2>Confirmar Eliminación</h2>
        </div>

        <div class="modal-body">
          <p>¿Estás seguro de que deseas eliminar al usuario <strong>{{ userToDelete?.name }}</strong>?</p>
          <p class="text-warning">Esta acción no se puede deshacer.</p>
        </div>

        <div class="form-actions">
          <button @click="showDeleteModal = false" class="btn-secondary">
            Cancelar
          </button>
          <button @click="deleteUser" class="btn-danger" :disabled="saving">
            {{ saving ? 'Eliminando...' : 'Eliminar' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Alert -->
    <transition name="fade">
      <div v-if="alertMessage" :class="['alert', `alert-${alertType}`]">
        <svg v-if="alertType === 'success'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="15" y1="9" x2="9" y2="15"/>
          <line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
        <span>{{ alertMessage }}</span>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'

const users = ref([])
const loading = ref(true)
const saving = ref(false)
const showModal = ref(false)
const showDeleteModal = ref(false)
const isEditing = ref(false)
const userToDelete = ref(null)
const currentUserId = ref(null)
const alertMessage = ref('')
const alertType = ref('success')

const form = ref({
  name: '',
  email: '',
  password: '',
  role: '',
  is_active: true
})

const stats = computed(() => ({
  total: users.value.length,
  admins: users.value.filter(u => u.role === 'admin').length,
  users: users.value.filter(u => u.role === 'user').length,
  active: users.value.filter(u => u.is_active).length
}))

const fetchUsers = async () => {
  loading.value = true
  try {
    const response = await api.get('/users')
    users.value = response.data
  } catch (error) {
    console.error('Error al cargar usuarios:', error)
    showAlert('Error al cargar los usuarios', 'error')
  } finally {
    loading.value = false
  }
}

const getCurrentUser = async () => {
  try {
    const response = await api.get('/auth/me')
    currentUserId.value = response.data.id
  } catch (error) {
    console.error('Error al obtener usuario actual:', error)
  }
}

const isCurrentUser = (userId) => {
  return currentUserId.value === userId
}

const openModal = (user = null) => {
  if (user) {
    isEditing.value = true
    form.value = {
      id: user.id,
      name: user.name,
      email: user.email,
      password: '',
      role: user.role,
      is_active: user.is_active
    }
  } else {
    isEditing.value = false
    form.value = {
      name: '',
      email: '',
      password: '',
      role: '',
      is_active: true
    }
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  isEditing.value = false
}

const saveUser = async () => {
  saving.value = true
  try {
    const payload = { ...form.value }
    
    // Si estamos editando y no hay password, no enviarlo
    if (isEditing.value && !payload.password) {
      delete payload.password
    }

    if (isEditing.value) {
      await api.put(`/users/${form.value.id}`, payload)
      showAlert('Usuario actualizado exitosamente', 'success')
    } else {
      await api.post('/users', payload)
      showAlert('Usuario creado exitosamente', 'success')
    }

    await fetchUsers()
    closeModal()
  } catch (error) {
    console.error('Error al guardar usuario:', error)
    const message = error.response?.data?.message || 'Error al guardar el usuario'
    showAlert(message, 'error')
  } finally {
    saving.value = false
  }
}

const confirmDelete = (user) => {
  userToDelete.value = user
  showDeleteModal.value = true
}

const deleteUser = async () => {
  saving.value = true
  try {
    await api.delete(`/users/${userToDelete.value.id}`)
    showAlert('Usuario eliminado exitosamente', 'success')
    await fetchUsers()
    showDeleteModal.value = false
  } catch (error) {
    console.error('Error al eliminar usuario:', error)
    const message = error.response?.data?.message || 'Error al eliminar el usuario'
    showAlert(message, 'error')
  } finally {
    saving.value = false
  }
}

const toggleStatus = async (user) => {
  try {
    await api.patch(`/users/${user.id}/toggle-status`)
    showAlert('Estado actualizado exitosamente', 'success')
    await fetchUsers()
  } catch (error) {
    console.error('Error al cambiar estado:', error)
    const message = error.response?.data?.message || 'Error al cambiar el estado'
    showAlert(message, 'error')
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-MX', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })
}

const showAlert = (message, type) => {
  alertMessage.value = message
  alertType.value = type
  setTimeout(() => {
    alertMessage.value = ''
  }, 3000)
}

onMounted(() => {
  fetchUsers()
  getCurrentUser()
})
</script>

<style scoped>
.admin-users {
  padding: 24px;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 32px;
  gap: 24px;
}

.header-content {
  flex: 1;
}

.page-title {
  font-size: 2rem;
  font-weight: 600;
  color: #1d1d1f;
  margin-bottom: 8px;
}

.page-description {
  font-size: 1rem;
  color: #6e6e73;
}

.btn-new {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: #667eea;
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-new:hover {
  background: #5568d3;
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
}

.btn-new svg {
  width: 20px;
  height: 20px;
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 32px;
}

.stat-card {
  background: white;
  border-radius: 16px;
  padding: 24px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.stat-icon svg {
  width: 28px;
  height: 28px;
  color: white;
}

.stat-icon.admin {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-icon.users {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-icon.active {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-icon.total {
  background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-content h3 {
  font-size: 0.875rem;
  color: #6e6e73;
  margin-bottom: 4px;
}

.stat-number {
  font-size: 2rem;
  font-weight: 600;
  color: #1d1d1f;
  margin: 0;
}

/* Loading State */
.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 24px;
  gap: 16px;
}

.spinner {
  width: 48px;
  height: 48px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.loading-state p {
  color: #6e6e73;
  font-size: 1rem;
}

/* Table */
.table-container {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.users-table {
  width: 100%;
  border-collapse: collapse;
}

.users-table thead {
  background: #f5f5f7;
}

.users-table th {
  padding: 16px;
  text-align: left;
  font-weight: 600;
  color: #1d1d1f;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.users-table tbody tr {
  border-bottom: 1px solid #f0f0f0;
  transition: background 0.2s;
}

.users-table tbody tr:hover {
  background: #f9f9f9;
}

.users-table tbody tr.inactive {
  opacity: 0.6;
}

.users-table td {
  padding: 16px;
  color: #1d1d1f;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 1.125rem;
}

.user-name {
  font-weight: 500;
}

.badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.badge-admin {
  background: #eef2ff;
  color: #667eea;
}

.badge-user {
  background: #f0fdf4;
  color: #22c55e;
}

.badge-active {
  background: #dcfce7;
  color: #16a34a;
}

.badge-inactive {
  background: #fee2e2;
  color: #dc2626;
}

.actions {
  display: flex;
  gap: 8px;
}

.btn-icon {
  width: 36px;
  height: 36px;
  border: none;
  background: transparent;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
  padding: 0;
}

.btn-icon svg {
  width: 18px;
  height: 18px;
}

.btn-icon.btn-toggle {
  color: #667eea;
}

.btn-icon.btn-toggle:hover {
  background: #eef2ff;
}

.btn-icon.btn-edit {
  color: #f59e0b;
}

.btn-icon.btn-edit:hover {
  background: #fef3c7;
}

.btn-icon.btn-delete {
  color: #ef4444;
}

.btn-icon.btn-delete:hover {
  background: #fee2e2;
}

.btn-icon:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Empty State */
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 24px;
  gap: 16px;
  background: white;
  border-radius: 16px;
}

.empty-state svg {
  width: 64px;
  height: 64px;
  color: #d1d5db;
  margin-bottom: 8px;
}

.empty-state h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1d1d1f;
  margin: 0;
}

.empty-state p {
  color: #6e6e73;
  margin: 0;
}

.btn-empty {
  margin-top: 16px;
  padding: 12px 24px;
  background: #667eea;
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-empty:hover {
  background: #5568d3;
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 24px;
}

.modal-content {
  background: white;
  border-radius: 20px;
  width: 100%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-content.modal-small {
  max-width: 400px;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 24px;
  border-bottom: 1px solid #f0f0f0;
}

.modal-header h2 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1d1d1f;
  margin: 0;
}

.btn-close {
  width: 36px;
  height: 36px;
  border: none;
  background: #f5f5f7;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-close:hover {
  background: #e8e8ed;
}

.btn-close svg {
  width: 20px;
  height: 20px;
  color: #1d1d1f;
}

.modal-body {
  padding: 24px;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #1d1d1f;
  font-size: 0.875rem;
}

.required {
  color: #ef4444;
}

.form-control {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid #d1d5db;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.2s;
  background: white;
  color: #1d1d1f;
}

.form-control:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-hint {
  margin-top: 6px;
  font-size: 0.75rem;
  color: #6e6e73;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.form-checkbox {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.form-actions {
  display: flex;
  gap: 12px;
  padding: 24px;
  border-top: 1px solid #f0f0f0;
}

.btn-secondary,
.btn-primary,
.btn-danger {
  flex: 1;
  padding: 12px 24px;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.btn-secondary {
  background: #f5f5f7;
  color: #1d1d1f;
}

.btn-secondary:hover {
  background: #e8e8ed;
}

.btn-primary {
  background: #667eea;
  color: white;
}

.btn-primary:hover {
  background: #5568d3;
}

.btn-danger {
  background: #ef4444;
  color: white;
}

.btn-danger:hover {
  background: #dc2626;
}

.btn-primary:disabled,
.btn-danger:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-primary svg,
.btn-danger svg {
  width: 20px;
  height: 20px;
}

.text-warning {
  color: #f59e0b;
  font-weight: 500;
}

/* Alert */
.alert {
  position: fixed;
  bottom: 24px;
  right: 24px;
  padding: 16px 24px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 12px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
  z-index: 1001;
  max-width: 400px;
}

.alert svg {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}

.alert-success {
  background: #dcfce7;
  color: #16a34a;
}

.alert-error {
  background: #fee2e2;
  color: #dc2626;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}

@media (max-width: 768px) {
  .admin-users {
    padding: 16px;
  }

  .page-header {
    flex-direction: column;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }

  .table-container {
    overflow-x: auto;
  }

  .users-table {
    min-width: 800px;
  }

  .modal-content {
    max-width: 100%;
  }
}
</style>
