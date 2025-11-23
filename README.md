# 🖥️ Peñacom - Sistema de Gestión y Landing Page

Sistema completo de gestión administrativa con landing page moderna para Peñacom, empresa líder en pantallas LED en Cancún, México.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=flat&logo=vue.js&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![TypeScript](https://img.shields.io/badge/TypeScript-5-3178C6?style=flat&logo=typescript&logoColor=white)

## 📋 Descripción

Proyecto full-stack que combina:
- **Landing Page Moderna**: Diseño mobile-first con identidad corporativa de Peñacom
- **Panel Administrativo**: Gestión de servicios, horarios y contactos
- **API RESTful**: Backend robusto con autenticación y patrones de diseño

## 🏗️ Arquitectura

### Backend (Laravel 12)
- **Patrón de Diseño**: Repository Pattern + Service Layer
- **Autenticación**: Laravel Sanctum (API Tokens)
- **Base de Datos**: SQLite (desarrollo) / MySQL (producción)
- **API**: RESTful con validación de requests

### Frontend (Vue 3)
- **Composition API** con `<script setup>`
- **Router**: Vue Router con guards de autenticación
- **State Management**: Pinia
- **HTTP Client**: Axios con interceptores
- **Diseño**: Mobile First, responsive, CSS variables

## 🚀 Características

### Landing Page Pública
✅ Hero section con gradientes y animaciones  
✅ Sección "Nosotros" con misión, visión y valores  
✅ Showcase de productos LED (interior, exterior, videowall, rental)  
✅ Catálogo de 6 servicios principales  
✅ Formulario de contacto con validación  
✅ Footer completo con redes sociales  
✅ Botón flotante de WhatsApp  
✅ Diseño 100% responsive (móvil → tablet → desktop)

### Panel Administrativo
🔐 Login seguro con Sanctum  
📊 Dashboard con estadísticas  
🛠️ CRUD de servicios  
📅 Gestión de horarios  
📬 Administración de contactos  
🔄 Actualización en tiempo real

## 📁 Estructura del Proyecto

```
peñacom/
├── backend/                          # API Laravel
│   ├── app/
│   │   ├── Http/Controllers/         # Controladores API
│   │   ├── Models/                   # Modelos Eloquent
│   │   ├── Repositories/             # Repository Pattern
│   │   │   ├── Contracts/            # Interfaces
│   │   │   └── Eloquent/             # Implementaciones
│   │   └── Services/                 # Lógica de negocio
│   ├── database/migrations/          # Migraciones
│   └── routes/api.php                # Rutas API
│
└── frontend/                         # SPA Vue 3
    ├── src/
    │   ├── assets/styles.css         # Sistema de diseño
    │   ├── components/
    │   │   ├── public/               # Componentes landing
    │   │   │   ├── Header.vue
    │   │   │   ├── HeroSection.vue
    │   │   │   ├── AboutSection.vue
    │   │   │   ├── ProductsSection.vue
    │   │   │   ├── ServicesSection2.vue
    │   │   │   ├── ContactSection.vue
    │   │   │   └── Footer.vue
    │   │   └── admin/                # Componentes admin
    │   ├── layouts/                  # Layouts
    │   ├── router/                   # Vue Router
    │   ├── services/                 # API services
    │   └── views/                    # Vistas/páginas
    └── index.html
```

## 🛠️ Instalación

### Requisitos Previos
- PHP 8.2+
- Composer
- Node.js 18+
- SQLite (dev) / MySQL 8.0+ (prod)

### 1. Clonar el Repositorio
```bash
git clone https://github.com/MLara8061/penacom.git
cd penacom
```

### 2. Backend (Laravel)
```bash
cd backend

# Instalar dependencias
composer install

# Copiar archivo de entorno
copy .env.example .env

# Generar key
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Crear usuario admin
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@penacom.com','password'=>bcrypt('password123')]);

# Iniciar servidor
php artisan serve
```

### 3. Frontend (Vue)
```bash
cd frontend

# Instalar dependencias
npm install

# Iniciar servidor de desarrollo
npm run dev
```

### 4. Acceder a la Aplicación

**Frontend**: http://localhost:5173  
**Backend API**: http://localhost:8000  
**Admin Login**: admin@penacom.com / password123

## 🎨 Sistema de Diseño

### Paleta de Colores
- **Primary Blue**: `#0066CC`
- **Secondary Blue**: `#4A90E2`
- **Light Blue**: `#E8F4FF`
- **Dark**: `#1A1A2E`
- **White**: `#FFFFFF`

### Breakpoints
- Mobile: `< 768px`
- Tablet: `768px - 1023px`
- Desktop: `≥ 1024px`

## 📡 API Endpoints

### Autenticación
```
POST   /api/login              # Login
POST   /api/logout             # Logout
```

### Servicios (Protegido)
```
GET    /api/services           # Listar servicios
POST   /api/services           # Crear servicio
PUT    /api/services/{id}      # Actualizar servicio
DELETE /api/services/{id}      # Eliminar servicio
PATCH  /api/services/{id}/toggle # Toggle activo
```

### Horarios (Protegido)
```
GET    /api/schedules          # Listar horarios
POST   /api/schedules          # Crear horario
PUT    /api/schedules/{id}     # Actualizar horario
DELETE /api/schedules/{id}     # Eliminar horario
```

### Contactos (Protegido)
```
GET    /api/contacts           # Listar contactos
POST   /api/contacts           # Crear contacto
DELETE /api/contacts/{id}      # Eliminar contacto
```

## 🔐 Seguridad

- Autenticación basada en tokens (Sanctum)
- Validación de requests con Form Requests
- Protección CSRF
- CORS configurado
- Sanitización de inputs

## 🚢 Deploy

### Backend (Laravel)
1. Configurar `.env` para producción
2. Cambiar `DB_CONNECTION=mysql`
3. Ejecutar `php artisan config:cache`
4. Ejecutar `php artisan route:cache`
5. Configurar servidor web (Apache/Nginx)

### Frontend (Vue)
```bash
npm run build
# Los archivos estáticos estarán en /dist
```

## 👥 Información de la Empresa

**Peñacom** - Soluciones LED de vanguardia desde 2013
- 📍 Ubicación: Cancún, Quintana Roo, México
- 📞 Teléfono: (998) 123-4567
- 📧 Email: contacto@penacom.mx
- 🌐 Web: https://github.com/MLara8061/penacom

## 📝 Licencia

Este proyecto es privado y pertenece a Peñacom.

## 👨‍💻 Autor

Desarrollado para Peñacom por MLara8061

---

⭐ Si te gusta este proyecto, dale una estrella en GitHub!
