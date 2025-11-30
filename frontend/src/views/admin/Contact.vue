<template>
  <div class="admin-leads">
    <div class="page-header">
      <div class="header-content">
        <h1 class="page-title">Leads - Formulario de Contacto</h1>
        <p class="page-description">Administra los contactos recibidos desde el formulario web</p>
      </div>
      <div class="header-actions">
        <button @click="refreshLeads" class="btn-refresh" :disabled="loading">
          <svg v-if="!loading" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
          </svg>
          <svg v-else class="spinner" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
            <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
          </svg>
          {{ loading ? 'Actualizando...' : 'Actualizar' }}
        </button>
        <button @click="exportToExcel" class="btn-export">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
          </svg>
          Exportar
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon total">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="stat-details">
          <div class="stat-value">{{ stats.total }}</div>
          <div class="stat-label">Total Leads</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon new">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 6v6l4 2"/>
          </svg>
        </div>
        <div class="stat-details">
          <div class="stat-value">{{ stats.new }}</div>
          <div class="stat-label">Nuevos</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon contacted">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
        </div>
        <div class="stat-details">
          <div class="stat-value">{{ stats.contacted }}</div>
          <div class="stat-label">Contactados</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon converted">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
        </div>
        <div class="stat-details">
          <div class="stat-value">{{ stats.converted }}</div>
          <div class="stat-label">Convertidos</div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="filters-bar">
      <div class="filter-group">
        <label>Buscar:</label>
        <input 
          v-model="filters.search" 
          type="text" 
          placeholder="Nombre, email o mensaje..."
          class="filter-input"
        />
      </div>
      <div class="filter-group">
        <label>Estado:</label>
        <select v-model="filters.status" class="filter-select">
          <option value="">Todos</option>
          <option value="new">Nuevos</option>
          <option value="contacted">Contactados</option>
          <option value="converted">Convertidos</option>
        </select>
      </div>
      <button v-if="filters.search || filters.status" @click="clearFilters" class="btn-clear">
        Limpiar filtros
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <svg class="spinner" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
        <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
      </svg>
      <p>Cargando leads...</p>
    </div>

    <!-- Table -->
    <div v-else-if="filteredLeads.length > 0" class="table-container">
      <table class="leads-table">
        <thead>
          <tr>
            <th>Estado</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Mensaje</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="lead in filteredLeads" :key="lead.id">
            <td>
              <span class="badge" :class="`badge-${lead.status}`">
                {{ statusLabels[lead.status] }}
              </span>
            </td>
            <td class="lead-name">{{ lead.name }}</td>
            <td>
              <a :href="`mailto:${lead.email}`" class="lead-email">{{ lead.email }}</a>
            </td>
            <td>
              <a v-if="lead.phone" :href="`tel:${lead.phone}`" class="lead-phone">{{ lead.phone }}</a>
              <span v-else class="text-muted">-</span>
            </td>
            <td class="lead-message">
              <div class="message-preview">{{ truncateMessage(lead.message) }}</div>
            </td>
            <td class="lead-date">{{ formatDate(lead.created_at) }}</td>
            <td class="lead-actions">
              <button @click="viewDetails(lead)" class="btn-action btn-view" title="Ver detalles">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
              </button>
              <button 
                v-if="lead.status === 'new'" 
                @click="markAsContacted(lead)" 
                class="btn-action btn-contact"
                title="Marcar como contactado"
              >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
              </button>
              <button 
                v-if="lead.status === 'contacted'" 
                @click="markAsConverted(lead)" 
                class="btn-action btn-convert"
                title="Marcar como convertido"
              >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
              </button>
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
        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      <h3>No hay leads disponibles</h3>
      <p>Los contactos recibidos desde el formulario aparecerán aquí</p>
    </div>

    <!-- Modal Details -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h2>Detalles del Lead</h2>
          <button @click="closeModal" class="btn-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </button>
        </div>
        <div class="modal-body" v-if="selectedLead">
          <div class="detail-group">
            <label>Estado:</label>
            <span class="badge" :class="`badge-${selectedLead.status}`">
              {{ statusLabels[selectedLead.status] }}
            </span>
          </div>
          <div class="detail-group">
            <label>Nombre:</label>
            <p>{{ selectedLead.name }}</p>
          </div>
          <div class="detail-group">
            <label>Email:</label>
            <p><a :href="`mailto:${selectedLead.email}`">{{ selectedLead.email }}</a></p>
          </div>
          <div class="detail-group" v-if="selectedLead.phone">
            <label>Teléfono:</label>
            <p><a :href="`tel:${selectedLead.phone}`">{{ selectedLead.phone }}</a></p>
          </div>
          <div class="detail-group">
            <label>Mensaje:</label>
            <p class="message-full">{{ selectedLead.message }}</p>
          </div>
          <div class="detail-group">
            <label>Fecha de contacto:</label>
            <p>{{ formatDateFull(selectedLead.created_at) }}</p>
          </div>
        </div>
        <div class="modal-footer">
          <button @click="closeModal" class="btn-secondary">Cerrar</button>
          <button 
            v-if="selectedLead?.status === 'new'" 
            @click="markAsContacted(selectedLead); closeModal()" 
            class="btn-primary"
          >
            Marcar como Contactado
          </button>
          <button 
            v-if="selectedLead?.status === 'contacted'" 
            @click="markAsConverted(selectedLead); closeModal()" 
            class="btn-primary"
          >
            Marcar como Convertido
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api.js'

const loading = ref(true)
const leads = ref([])
const showModal = ref(false)
const selectedLead = ref(null)
const filters = ref({
  search: '',
  status: ''
})

const statusLabels = {
  new: 'Nuevo',
  contacted: 'Contactado',
  converted: 'Convertido'
}

const stats = computed(() => ({
  total: leads.value.length,
  new: leads.value.filter(l => l.status === 'new').length,
  contacted: leads.value.filter(l => l.status === 'contacted').length,
  converted: leads.value.filter(l => l.status === 'converted').length
}))

const filteredLeads = computed(() => {
  let result = leads.value

  if (filters.value.search) {
    const search = filters.value.search.toLowerCase()
    result = result.filter(lead => 
      lead.name.toLowerCase().includes(search) ||
      lead.email.toLowerCase().includes(search) ||
      lead.message.toLowerCase().includes(search) ||
      (lead.phone && lead.phone.includes(search))
    )
  }

  if (filters.value.status) {
    result = result.filter(lead => lead.status === filters.value.status)
  }

  return result
})

const fetchLeads = async () => {
  loading.value = true
  try {
    const response = await api.get('/contacts')
    leads.value = response.data.map(lead => ({
      ...lead,
      status: lead.status || 'new'
    }))
  } catch (error) {
    console.error('Error al cargar leads:', error)
  } finally {
    loading.value = false
  }
}

const refreshLeads = () => {
  fetchLeads()
}

const clearFilters = () => {
  filters.value.search = ''
  filters.value.status = ''
}

const viewDetails = (lead) => {
  selectedLead.value = lead
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedLead.value = null
}

const markAsContacted = async (lead) => {
  try {
    await api.put(`/contacts/${lead.id}`, { ...lead, status: 'contacted' })
    lead.status = 'contacted'
  } catch (error) {
    console.error('Error al actualizar lead:', error)
  }
}

const markAsConverted = async (lead) => {
  try {
    await api.put(`/contacts/${lead.id}`, { ...lead, status: 'converted' })
    lead.status = 'converted'
  } catch (error) {
    console.error('Error al actualizar lead:', error)
  }
}

const truncateMessage = (message) => {
  return message.length > 50 ? message.substring(0, 50) + '...' : message
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-MX', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })
}

const formatDateFull = (date) => {
  return new Date(date).toLocaleString('es-MX', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const exportToExcel = () => {
  const data = filteredLeads.value.map(lead => ({
    Estado: statusLabels[lead.status],
    Nombre: lead.name,
    Email: lead.email,
    Teléfono: lead.phone || '',
    Mensaje: lead.message,
    Fecha: formatDateFull(lead.created_at)
  }))

  const csv = [
    Object.keys(data[0]).join(','),
    ...data.map(row => Object.values(row).map(v => `"${v}"`).join(','))
  ].join('\n')

  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' })
  const link = document.createElement('a')
  link.href = URL.createObjectURL(blob)
  link.download = `leads-${new Date().toISOString().split('T')[0]}.csv`
  link.click()
}

onMounted(() => {
  fetchLeads()
})
</script>

<style scoped>
.admin-leads {
  padding: 2rem;
  max-width: 1400px;
  margin: 0 auto;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 2rem;
  gap: 2rem;
}

.header-content {
  flex: 1;
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 0.5rem 0;
}

.page-description {
  color: #6c757d;
  margin: 0;
}

.header-actions {
  display: flex;
  gap: 1rem;
}

.btn-refresh,
.btn-export {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-refresh {
  background: #f8f9fa;
  color: #495057;
}

.btn-refresh:hover:not(:disabled) {
  background: #e9ecef;
}

.btn-refresh:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-export {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-export:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-refresh svg,
.btn-export svg {
  width: 18px;
  height: 18px;
}

.spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  display: flex;
  gap: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: transform 0.2s;
}

.stat-card:hover {
  transform: translateY(-4px);
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-icon svg {
  width: 24px;
  height: 24px;
  stroke: white;
}

.stat-icon.total {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-icon.new {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-icon.contacted {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-icon.converted {
  background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-details {
  flex: 1;
}

.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: #1a1a2e;
  line-height: 1;
  margin-bottom: 0.25rem;
}

.stat-label {
  color: #6c757d;
  font-size: 0.875rem;
}

/* Filters */
.filters-bar {
  background: white;
  padding: 1.5rem;
  border-radius: 12px;
  display: flex;
  gap: 1rem;
  align-items: flex-end;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  flex: 1;
}

.filter-group label {
  font-weight: 600;
  color: #495057;
  font-size: 0.875rem;
}

.filter-input,
.filter-select {
  padding: 0.75rem;
  border: 1px solid #dee2e6;
  border-radius: 8px;
  font-size: 0.875rem;
}

.filter-input:focus,
.filter-select:focus {
  outline: none;
  border-color: #667eea;
}

.btn-clear {
  padding: 0.75rem 1.5rem;
  background: #f8f9fa;
  border: none;
  border-radius: 8px;
  color: #495057;
  font-weight: 600;
  cursor: pointer;
  white-space: nowrap;
}

.btn-clear:hover {
  background: #e9ecef;
}

/* Table */
.table-container {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.leads-table {
  width: 100%;
  border-collapse: collapse;
}

.leads-table thead {
  background: #f8f9fa;
}

.leads-table th {
  padding: 1rem;
  text-align: left;
  font-weight: 600;
  color: #495057;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.leads-table td {
  padding: 1rem;
  border-top: 1px solid #dee2e6;
}

.leads-table tbody tr:hover {
  background: #f8f9fa;
}

.badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
}

.badge-new {
  background: #fef3c7;
  color: #92400e;
}

.badge-contacted {
  background: #dbeafe;
  color: #1e40af;
}

.badge-converted {
  background: #d1fae5;
  color: #065f46;
}

.lead-name {
  font-weight: 600;
  color: #1a1a2e;
}

.lead-email,
.lead-phone {
  color: #667eea;
  text-decoration: none;
}

.lead-email:hover,
.lead-phone:hover {
  text-decoration: underline;
}

.lead-message {
  max-width: 300px;
}

.message-preview {
  color: #6c757d;
  font-size: 0.875rem;
}

.lead-date {
  color: #6c757d;
  font-size: 0.875rem;
  white-space: nowrap;
}

.lead-actions {
  display: flex;
  gap: 0.5rem;
}

.btn-action {
  width: 32px;
  height: 32px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.btn-action svg {
  width: 16px;
  height: 16px;
}

.btn-view {
  background: #e9ecef;
  color: #495057;
}

.btn-view:hover {
  background: #dee2e6;
}

.btn-contact {
  background: #dbeafe;
  color: #1e40af;
}

.btn-contact:hover {
  background: #bfdbfe;
}

.btn-convert {
  background: #d1fae5;
  color: #065f46;
}

.btn-convert:hover {
  background: #a7f3d0;
}

/* States */
.loading-state,
.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.loading-state svg,
.empty-state svg {
  width: 64px;
  height: 64px;
  color: #667eea;
  margin-bottom: 1rem;
}

.empty-state h3 {
  margin: 1rem 0 0.5rem;
  color: #1a1a2e;
}

.empty-state p {
  color: #6c757d;
}

/* Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 1rem;
}

.modal-content {
  background: white;
  border-radius: 16px;
  max-width: 600px;
  width: 100%;
  max-height: 90vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.modal-header {
  padding: 1.5rem;
  border-bottom: 1px solid #dee2e6;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h2 {
  margin: 0;
  font-size: 1.5rem;
  color: #1a1a2e;
}

.btn-close {
  width: 32px;
  height: 32px;
  border: none;
  background: #f8f9fa;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-close:hover {
  background: #e9ecef;
}

.btn-close svg {
  width: 18px;
  height: 18px;
  stroke: #495057;
}

.modal-body {
  padding: 1.5rem;
  overflow-y: auto;
}

.detail-group {
  margin-bottom: 1.5rem;
}

.detail-group label {
  display: block;
  font-weight: 600;
  color: #495057;
  margin-bottom: 0.5rem;
  font-size: 0.875rem;
}

.detail-group p {
  margin: 0;
  color: #1a1a2e;
}

.message-full {
  white-space: pre-wrap;
  line-height: 1.6;
}

.modal-footer {
  padding: 1.5rem;
  border-top: 1px solid #dee2e6;
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

.btn-secondary,
.btn-primary {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-secondary {
  background: #f8f9fa;
  color: #495057;
}

.btn-secondary:hover {
  background: #e9ecef;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.text-muted {
  color: #6c757d;
}

/* Responsive */
@media (max-width: 768px) {
  .admin-leads {
    padding: 1rem;
  }

  .page-header {
    flex-direction: column;
  }

  .header-actions {
    width: 100%;
  }

  .btn-refresh,
  .btn-export {
    flex: 1;
  }

  .filters-bar {
    flex-direction: column;
    align-items: stretch;
  }

  .table-container {
    overflow-x: auto;
  }

  .leads-table {
    min-width: 800px;
  }
}
</style>
