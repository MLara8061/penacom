// services/authService.js
import api from './api';

export default {
  /**
   * Login
   */
  async login(credentials) {
    const response = await api.post('/auth/login', credentials);
    if (response.data.token) {
      localStorage.setItem('auth_token', response.data.token);
    }
    return response.data;
  },

  /**
   * Logout
   */
  async logout() {
    await api.post('/auth/logout');
    localStorage.removeItem('auth_token');
  },

  /**
   * Get authenticated user
   */
  async me() {
    const response = await api.get('/auth/me');
    return response.data;
  },

  /**
   * Check if user is authenticated
   */
  isAuthenticated() {
    return !!localStorage.getItem('auth_token');
  }
};
