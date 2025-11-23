# Proyecto Web con Panel Administrativo

Stack tecnológico: **Laravel + Vue + MySQL**

## Arquitectura del Proyecto

### Patrón de Diseño: Repository Pattern + Service Layer

**Ventajas:**
- ✅ Separación de responsabilidades
- ✅ Código reutilizable y testeable
- ✅ Fácil mantenimiento
- ✅ API REST para frontend/backend desacoplados
- ✅ Optimizado para hosting compartido

---

## Estructura del Proyecto

```
peñacom/
├── backend/           # Laravel API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── API/          # Controladores de API
│   │   │   │   └── Auth/         # Autenticación
│   │   │   └── Requests/         # Validaciones
│   │   ├── Services/             # Lógica de negocio
│   │   ├── Repositories/         # Acceso a datos
│   │   │   ├── Contracts/        # Interfaces
│   │   │   └── Eloquent/         # Implementaciones
│   │   ├── Models/               # Modelos Eloquent
│   │   └── Providers/            # Service Providers
│   ├── database/
│   │   └── migrations/           # Migraciones
│   └── routes/
│       └── api.php               # Rutas API
│
└── frontend/          # Vue SPA
    └── src/
        ├── components/
        │   ├── admin/            # Componentes del panel admin
        │   └── public/           # Componentes públicos
        ├── views/
        │   ├── admin/            # Vistas del panel
        │   └── public/           # Vistas públicas
        ├── router/               # Vue Router
        ├── services/             # Servicios para API calls
        └── store/                # State management (opcional)
```

---

## Backend - Laravel

### 1. Capas de la Arquitectura

#### **Controllers (Controladores)**
- Reciben requests HTTP
- Validan datos usando Form Requests
- Delegan lógica a Services
- Retornan respuestas JSON

#### **Services (Capa de Negocio)**
- Contienen la lógica de negocio
- Coordinan operaciones entre Repositories
- Manejan transacciones
- Independientes de HTTP

#### **Repositories (Acceso a Datos)**
- Abstraen el acceso a la base de datos
- Implementan interfaces (Contracts)
- Métodos CRUD y consultas específicas
- Usan Eloquent internamente

#### **Models (Modelos)**
- Representan tablas de la base de datos
- Define relaciones y casteos
- Sin lógica de negocio

---

### 2. Funcionalidades Implementadas

#### **Módulo de Servicios**
- CRUD completo de servicios
- Activar/desactivar servicios
- Vista pública solo servicios activos
- Ordenamiento

#### **Módulo de Horarios**
- Gestión de horarios por día
- Marcar días cerrados
- Actualización masiva

#### **Módulo de Contacto**
- Información de contacto
- Datos de dirección
- Redes sociales
- WhatsApp

#### **Autenticación**
- Laravel Sanctum
- Tokens para SPA
- Rutas protegidas

---

### 3. Archivos Clave Creados

#### Repositories (Interfaces)
- `BaseRepositoryInterface.php`
- `ServiceRepositoryInterface.php`
- `ScheduleRepositoryInterface.php`
- `ContactRepositoryInterface.php`

#### Repositories (Implementaciones)
- `BaseRepository.php`
- `ServiceRepository.php`
- `ScheduleRepository.php`
- `ContactRepository.php`

#### Services
- `ServiceService.php`
- `ScheduleService.php`
- `ContactService.php`

#### Controllers
- `ServiceController.php`
- `ScheduleController.php`
- `ContactController.php`
- `AuthController.php`

#### Form Requests
- `ServiceRequest.php`
- `ScheduleRequest.php`
- `ContactRequest.php`

#### Models
- `Service.php`
- `Schedule.php`
- `Contact.php`

#### Migrations
- `create_services_table.php`
- `create_schedules_table.php`
- `create_contacts_table.php`

---

## Frontend - Vue

### 1. Estructura

#### **Services (API Calls)**
- `api.js` - Cliente Axios con interceptors
- `authService.js` - Autenticación
- `serviceService.js` - Gestión de servicios
- `scheduleService.js` - Gestión de horarios
- `contactService.js` - Gestión de contacto

#### **Router**
- Rutas públicas
- Rutas administrativas (protegidas)
- Navigation guards
- Layouts separados

---

### 2. Características

- **SPA (Single Page Application)** con Vue Router
- **Axios** para consumir API REST
- **Interceptors** para tokens de autenticación
- **Guards** para proteger rutas admin
- **Separación** de vistas públicas y administrativas

---

## Configuración Inicial

### Backend (Laravel)

1. **Instalar Laravel:**
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

2. **Configurar base de datos en `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

3. **Registrar Service Provider en `config/app.php`:**
```php
'providers' => [
    // ...
    App\Providers\RepositoryServiceProvider::class,
],
```

4. **Ejecutar migraciones:**
```bash
php artisan migrate
```

5. **Instalar Laravel Sanctum:**
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

6. **Configurar CORS en `config/cors.php`**

---

### Frontend (Vue)

1. **Crear proyecto Vue:**
```bash
cd frontend
npm create vue@latest .
# Seleccionar: Vue Router, Pinia (opcional)
npm install
```

2. **Instalar Axios:**
```bash
npm install axios
```

3. **Configurar variables de entorno `.env`:**
```env
VITE_API_URL=http://localhost:8000/api
```

4. **Ejecutar desarrollo:**
```bash
npm run dev
```

---

## Rutas API (Backend)

### Públicas
- `GET /api/services/active` - Servicios activos
- `GET /api/schedules` - Todos los horarios
- `GET /api/contact` - Información de contacto

### Autenticación
- `POST /api/auth/login` - Login
- `POST /api/auth/logout` - Logout (protegida)
- `GET /api/auth/me` - Usuario actual (protegida)

### Admin (Protegidas con Sanctum)

#### Servicios
- `GET /api/services` - Listar todos
- `POST /api/services` - Crear
- `GET /api/services/{id}` - Ver uno
- `PUT /api/services/{id}` - Actualizar
- `DELETE /api/services/{id}` - Eliminar
- `PATCH /api/services/{id}/toggle-status` - Cambiar estado

#### Horarios
- `GET /api/schedules` - Listar todos
- `GET /api/schedules/{day}` - Ver por día
- `PUT /api/schedules/{day}` - Actualizar día
- `PUT /api/schedules/bulk` - Actualización masiva

#### Contacto
- `GET /api/contact` - Ver información
- `PUT /api/contact` - Actualizar información

---

## Despliegue en Hosting Compartido

### Backend
1. Subir archivos al servidor
2. Configurar `.env` con datos del hosting
3. Apuntar dominio a carpeta `public/`
4. Ejecutar: `php artisan migrate --force`

### Frontend
1. Compilar para producción: `npm run build`
2. Subir carpeta `dist/` generada
3. Configurar redirects para SPA

### Base de Datos
- Crear base de datos MySQL desde cPanel
- Importar migraciones o usar `php artisan migrate`

---

## Próximos Pasos

1. **Crear layouts** para Vue (PublicLayout, AdminLayout)
2. **Desarrollar componentes** UI
3. **Implementar seeders** para datos iniciales
4. **Agregar validación de imágenes** (upload)
5. **Configurar middleware** para roles
6. **Agregar sistema de logs**
7. **Implementar cache** en consultas frecuentes
8. **Testing** (PHPUnit para backend, Vitest para frontend)

---

## Buenas Prácticas Implementadas

✅ Separation of Concerns  
✅ Dependency Injection  
✅ Interface-based programming  
✅ Form Request Validation  
✅ API Resources (puedes agregarlos)  
✅ Transaction management  
✅ Token-based authentication  
✅ CORS configuration  
✅ Error handling  
✅ RESTful API design  

---

## Herramientas Recomendadas

- **Postman/Insomnia** - Testing de API
- **Laravel Telescope** - Debugging
- **Vue DevTools** - Debugging Vue
- **Prettier + ESLint** - Code formatting
- **PHP CS Fixer** - PHP formatting

---

**¡Proyecto listo para empezar a desarrollar!** 🚀
