// services/serviceService.js v2
import api from './api';

export default {
  /**
   * Get all active services
   */
  async getAll() {
    const response = await api.get('/services/active');
    return response.data;
  },

  /**
   * Get active services (Public)
   */
  async getActive() {
    const response = await api.get('/services/active');
    return response.data;
  },

  /**
   * Get single service
   */
  async getById(id) {
    const response = await api.get(`/services/${id}`);
    return response.data;
  },

  /**
   * Create service
   */
  async create(data) {
    const response = await api.post('/services', data);
    return response.data;
  },

  /**
   * Update service
   */
  async update(id, data) {
    const response = await api.put(`/services/${id}`, data);
    return response.data;
  },

  /**
   * Delete service
   */
  async delete(id) {
    const response = await api.delete(`/services/${id}`);
    return response.data;
  },

  /**
   * Toggle service status
   */
  async toggleStatus(id) {
    const response = await api.patch(`/services/${id}/toggle-status`);
    return response.data;
  }
};
