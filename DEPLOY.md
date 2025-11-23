# 🚀 Guía de Despliegue en Hostinger

## Requisitos Previos
- Cuenta de Hostinger con acceso a cPanel
- Base de datos MySQL creada en Hostinger
- Acceso FTP o File Manager
- Composer instalado localmente

---

## 📋 Paso 1: Preparar Backend (Laravel)

### 1.1 Optimizar Laravel para Producción

En tu computadora local, ejecuta:

```bash
cd backend

# Limpiar caché de desarrollo
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Instalar solo dependencias de producción
composer install --optimize-autoloader --no-dev
```

### 1.2 Configurar .env para Producción

Crea un archivo `.env` para producción con estos datos:

```env
APP_NAME=Peñacom
APP_ENV=production
APP_KEY=base64:TU_KEY_GENERADA
APP_DEBUG=false
APP_URL=https://tudominio.com

# Base de datos Hostinger
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nombre_bd_hostinger
DB_USERNAME=usuario_bd_hostinger
DB_PASSWORD=contraseña_bd_hostinger

# Sanctum
SANCTUM_STATEFUL_DOMAINS=tudominio.com,www.tudominio.com
SESSION_DOMAIN=.tudominio.com

# Cache y Sessions
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Logs
LOG_CHANNEL=single
LOG_LEVEL=error
```

---

## 📤 Paso 2: Subir Archivos al Servidor

### Opción A: FTP (FileZilla recomendado)

1. **Conectar por FTP:**
   - Host: ftp.tudominio.com
   - Usuario: tu usuario FTP
   - Contraseña: tu contraseña FTP
   - Puerto: 21

2. **Estructura de carpetas en Hostinger:**
   ```
   public_html/
   ├── api/              # ← Aquí va el backend
   └── (frontend aquí)   # ← Archivos compilados de Vue
   ```

3. **Subir Backend:**
   - Crea carpeta `api` dentro de `public_html`
   - Sube TODA la carpeta `backend` a `public_html/api/`
   - Carpetas importantes a subir:
     - ✅ app/
     - ✅ bootstrap/
     - ✅ config/
     - ✅ database/
     - ✅ routes/
     - ✅ storage/
     - ✅ vendor/
     - ✅ .env (el de producción)
     - ✅ artisan
     - ✅ composer.json

### Opción B: File Manager de cPanel

1. Accede a cPanel → File Manager
2. Navega a `public_html`
3. Crea carpeta `api`
4. Sube archivos comprimidos (.zip) y extrae

---

## 🔧 Paso 3: Configurar Laravel en el Servidor

### 3.1 Permisos de Carpetas

Conéctate por SSH o usa Terminal en cPanel:

```bash
cd public_html/api

# Permisos de escritura
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 3.2 Ejecutar Migraciones

```bash
php artisan migrate --force
```

### 3.3 Crear Usuario Admin

```bash
php artisan tinker
```

Dentro de tinker:
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@penacom.com',
    'password' => bcrypt('TU_CONTRASEÑA_SEGURA')
]);
exit
```

### 3.4 Optimizar Configuración

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3.5 Configurar .htaccess para API

Crea/edita `public_html/api/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Y en `public_html/api/public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## 🎨 Paso 4: Preparar y Subir Frontend (Vue)

### 4.1 Configurar Variables de Entorno

Edita `frontend/.env.production`:

```env
VITE_API_URL=https://tudominio.com/api/api
```

### 4.2 Compilar para Producción

En tu computadora local:

```bash
cd frontend

# Compilar
npm run build
```

Esto genera la carpeta `dist/` con archivos optimizados.

### 4.3 Subir Frontend

1. **Por FTP:** Sube el CONTENIDO de `frontend/dist/` a `public_html/`
2. **Estructura final:**
   ```
   public_html/
   ├── api/              # Backend Laravel
   ├── assets/           # Archivos compilados Vue
   ├── index.html        # HTML principal
   └── favicon.ico
   ```

### 4.4 Configurar .htaccess para SPA

Crea `public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
  
  # No reescribir archivos o directorios existentes
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  
  # Excluir la carpeta api
  RewriteCond %{REQUEST_URI} !^/api
  
  # Redirigir todo a index.html (SPA)
  RewriteRule ^ /index.html [L]
</IfModule>
```

---

## 🗄️ Paso 5: Configurar Base de Datos MySQL

### 5.1 Crear Base de Datos en cPanel

1. cPanel → MySQL Databases
2. Crear nueva base de datos: `usuario_penacom`
3. Crear usuario MySQL con contraseña segura
4. Asignar usuario a la base de datos con TODOS los privilegios

### 5.2 Importar Estructura (Opcional)

Si tienes datos de prueba, exporta desde local:

```bash
# Local
php artisan migrate:fresh --seed
mysqldump -u root nombre_bd > backup.sql
```

Luego importa en cPanel → phpMyAdmin.

---

## ⚙️ Paso 6: Configuración Final

### 6.1 Verificar PHP Version

En cPanel → Select PHP Version:
- Selecciona PHP 8.2 o superior

### 6.2 Extensiones PHP Requeridas

Activa estas extensiones en cPanel:
- ✅ mbstring
- ✅ openssl
- ✅ pdo
- ✅ pdo_mysql
- ✅ tokenizer
- ✅ xml
- ✅ ctype
- ✅ json
- ✅ bcmath

### 6.3 Probar API

Visita: `https://tudominio.com/api/api/services`

Deberías ver respuesta JSON.

### 6.4 Probar Frontend

Visita: `https://tudominio.com`

Deberías ver la landing page.

---

## 🔒 Seguridad Post-Despliegue

### 1. Ocultar carpetas sensibles

En `public_html/.htaccess` agrega:

```apache
# Denegar acceso a carpetas sensibles
<FilesMatch "^\.env">
    Order allow,deny
    Deny from all
</FilesMatch>

<DirectoryMatch "^\.|\/\.">
    Order allow,deny
    Deny from all
</DirectoryMatch>
```

### 2. Cambiar APP_KEY

```bash
cd public_html/api
php artisan key:generate
```

### 3. Configurar SSL/HTTPS

En cPanel → SSL/TLS:
- Instala certificado SSL gratuito (Let's Encrypt)
- Fuerza HTTPS en `.htaccess`:

```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🐛 Solución de Problemas

### Error 500

```bash
# Ver logs
cd public_html/api
tail -50 storage/logs/laravel.log
```

### Permisos Denegados

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R usuario:usuario storage
```

### CORS Errors

Edita `backend/config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['https://tudominio.com'],
```

### 404 en rutas Vue

Verifica que `.htaccess` del frontend esté bien configurado para SPA.

---

## 📊 Monitoreo

### Logs de Laravel

```bash
tail -f public_html/api/storage/logs/laravel.log
```

### Errores PHP

cPanel → Errors → Error Log

---

## 🔄 Actualizaciones Futuras

### Actualizar Backend

```bash
# Local: hacer cambios y commit
git pull origin main

# Servidor: subir archivos modificados
# Ejecutar:
php artisan migrate --force
php artisan config:cache
php artisan route:cache
```

### Actualizar Frontend

```bash
# Local
npm run build

# Subir contenido de dist/ a public_html/
```

---

## ✅ Checklist Final

- [ ] Backend subido a `public_html/api/`
- [ ] `.env` configurado con datos de producción
- [ ] Permisos 755 en `storage/` y `bootstrap/cache/`
- [ ] Migraciones ejecutadas
- [ ] Usuario admin creado
- [ ] Frontend compilado subido a `public_html/`
- [ ] `.htaccess` configurados (backend y frontend)
- [ ] Base de datos MySQL creada y configurada
- [ ] PHP 8.2+ activo
- [ ] Extensiones PHP habilitadas
- [ ] SSL/HTTPS configurado
- [ ] API responde correctamente
- [ ] Landing page carga correctamente
- [ ] Login admin funciona

---

## 📞 Soporte

Si encuentras problemas:

1. Revisa logs: `storage/logs/laravel.log`
2. Verifica permisos de carpetas
3. Contacta soporte de Hostinger para configuración PHP/MySQL
4. Revisa documentación de Laravel: https://laravel.com/docs

---

**¡Tu proyecto Peñacom está listo para producción!** 🚀
