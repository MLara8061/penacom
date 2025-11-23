# Guía de Instalación Rápida

## Paso 1: Backend (Laravel)

### 1.1 Instalar Laravel
```bash
cd c:\xampp\htdocs\peñacom\backend
composer create-project laravel/laravel .
```

### 1.2 Configurar .env
```env
APP_NAME="Peñacom Admin"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penacom
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost:5173
SESSION_DOMAIN=localhost
```

### 1.3 Instalar Sanctum
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 1.4 Configurar Sanctum en config/sanctum.php
```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost:5173')),
```

### 1.5 Copiar archivos creados
Copiar todos los archivos de:
- `app/Http/Controllers/`
- `app/Http/Requests/`
- `app/Services/`
- `app/Repositories/`
- `app/Models/`
- `app/Providers/RepositoryServiceProvider.php`
- `database/migrations/`
- `routes/api.php`

### 1.6 Registrar Service Provider
En `config/app.php`, agregar en el array `providers`:
```php
App\Providers\RepositoryServiceProvider::class,
```

### 1.7 Configurar CORS en config/cors.php
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['http://localhost:5173'],
'supports_credentials' => true,
```

### 1.8 Ejecutar migraciones
```bash
php artisan migrate
```

### 1.9 Crear usuario admin (opcional)
```bash
php artisan tinker
```
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@penacom.com';
$user->password = Hash::make('password123');
$user->save();
```

### 1.10 Iniciar servidor
```bash
php artisan serve
```

---

## Paso 2: Frontend (Vue)

### 2.1 Crear proyecto Vue
```bash
cd c:\xampp\htdocs\peñacom\frontend
npm create vue@latest .
```

Seleccionar:
- ✅ Vue Router
- ✅ Pinia (opcional para state management)
- ❌ TypeScript (opcional)
- ❌ JSX
- ❌ Vitest
- ❌ ESLint

### 2.2 Instalar dependencias
```bash
npm install
npm install axios
```

### 2.3 Copiar archivos creados
Copiar:
- `src/services/` (todos los archivos)
- `src/router/index.js`
- `src/components/admin/`
- `src/components/public/`

### 2.4 Crear archivo .env
```env
VITE_API_URL=http://localhost:8000/api
```

### 2.5 Crear layouts (crear estos archivos)

**src/layouts/PublicLayout.vue:**
```vue
<template>
  <div class="public-layout">
    <header>
      <nav>
        <router-link to="/">Inicio</router-link>
        <router-link to="/servicios">Servicios</router-link>
        <router-link to="/contacto">Contacto</router-link>
      </nav>
    </header>
    <main>
      <router-view />
    </main>
    <footer>
      <p>&copy; 2024 Peñacom. Todos los derechos reservados.</p>
    </footer>
  </div>
</template>

<style scoped>
header {
  background: #333;
  color: white;
  padding: 1rem;
}

nav a {
  color: white;
  margin: 0 1rem;
  text-decoration: none;
}

main {
  min-height: calc(100vh - 120px);
}

footer {
  background: #333;
  color: white;
  text-align: center;
  padding: 1rem;
}
</style>
```

**src/layouts/AdminLayout.vue:**
```vue
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
import { useRouter } from 'vue-router';
import authService from '../services/authService';

const router = useRouter();

const logout = async () => {
  await authService.logout();
  router.push('/admin/login');
};
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
}

.sidebar nav a:hover,
.sidebar nav button:hover {
  background: rgba(255, 255, 255, 0.1);
}

.content {
  flex: 1;
  padding: 2rem;
  background: #ecf0f1;
}
</style>
```

### 2.6 Crear vistas básicas

**src/views/public/Home.vue:**
```vue
<template>
  <div class="home">
    <h1>Bienvenido a Peñacom</h1>
    <ServicesSection />
  </div>
</template>

<script setup>
import ServicesSection from '../../components/public/ServicesSection.vue';
</script>
```

**src/views/admin/Services.vue:**
```vue
<template>
  <div>
    <ServicesManager />
  </div>
</template>

<script setup>
import ServicesManager from '../../components/admin/ServicesManager.vue';
</script>
```

### 2.7 Iniciar servidor de desarrollo
```bash
npm run dev
```

---

## Paso 3: Verificación

### Backend
- ✅ Servidor corriendo en http://localhost:8000
- ✅ API accesible en http://localhost:8000/api
- ✅ Base de datos creada y migrada

### Frontend
- ✅ Aplicación corriendo en http://localhost:5173
- ✅ Puede hacer requests a la API
- ✅ Rutas funcionando

---

## Comandos útiles

### Laravel
```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Ver rutas
php artisan route:list

# Crear nueva migración
php artisan make:migration create_tabla_name

# Rollback migraciones
php artisan migrate:rollback
```

### Vue
```bash
# Compilar para producción
npm run build

# Preview de producción
npm run preview
```

---

## Próximos pasos para completar

1. Implementar vistas faltantes (Dashboard, Schedules, Contact)
2. Agregar validaciones frontend
3. Implementar manejo de errores visual
4. Agregar sistema de notificaciones (toast)
5. Implementar upload de imágenes
6. Agregar paginación en tablas
7. Implementar búsqueda y filtros
8. Mejorar estilos con framework CSS (Tailwind, Bootstrap, etc.)

---

**¡El proyecto está listo para desarrollar!** 🎉
