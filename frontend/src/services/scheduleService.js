// services/scheduleService.js
import api from './api';

export default {
  /**
   * Get all schedules
   */
  async getAll() {
    const response = await api.get('/schedules');
    return response.data;
  },

  /**
   * Get schedule by day
   */
  async getByDay(day) {
    const response = await api.get(`/schedules/${day}`);
    return response.data;
  },

  /**
   * Update schedule for a specific day
   */
  async update(day, data) {
    const response = await api.put(`/schedules/${day}`, data);
    return response.data;
  },

  /**
   * Bulk update schedules
   */
  async bulkUpdate(data) {
    const response = await api.put('/schedules/bulk', data);
    return response.data;
  }
};
