// services/contactService.js
import api from './api';

export default {
  /**
   * Get contact information
   */
  async get() {
    const response = await api.get('/contact');
    return response.data;
  },

  /**
   * Update contact information
   */
  async update(data) {
    const response = await api.put('/contact', data);
    return response.data;
  }
};
