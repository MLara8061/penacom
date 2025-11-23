<template>
  <div class="admin-layout">
    <aside class="sidebar">
      <h2>Panel Admin</h2>
      <nav>
        <router-link to="/admin">Dashboard</router-link>
        <router-link to="/admin/servicios">Servicios</router-link>
        <router-link to="/admin/horarios">Horarios</router-link>
        <router-link to="/admin/contacto">Contacto</router-link>
        <button @click="logout">Cerrar Sesión</button>
      </nav>
    </aside>
    <main class="content">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import authService from '../services/authService'

const router = useRouter()

const logout = async () => {
  try {
    await authService.logout()
  } catch (error) {
    console.error('Error al cerrar sesión:', error)
  } finally {
    router.push('/admin/login')
  }
}
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 250px;
  background: #2c3e50;
  color: white;
  padding: 2rem 1rem;
}

.sidebar h2 {
  margin-bottom: 2rem;
}

.sidebar nav {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.sidebar nav a,
.sidebar nav button {
  color: white;
  text-decoration: none;
  padding: 0.5rem;
  border-radius: 4px;
  background: transparent;
  border: none;
  text-align: left;
  cursor: pointer;
  font-size: 1rem;
}

.sidebar nav a:hover,
.sidebar nav button:hover {
  background: rgba(255, 255, 255, 0.1);
}

.sidebar nav a.router-link-active {
  background: rgba(255, 255, 255, 0.2);
}

.content {
  flex: 1;
  padding: 2rem;
  background: #ecf0f1;
}
</style>
