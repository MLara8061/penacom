# 🚀 Guía de Migración a Servidor del Cliente

## 📝 Información del Servidor

**Panel de Control**: cPanel
**URL cPanel**: https://svgt208.serverneubox.com.mx:2083
**Usuario**: peniacom
**Contraseña**: P3n1ac0m12$

---

## 🎯 PASO 1: Acceder a cPanel

1. Ve a: https://svgt208.serverneubox.com.mx:2083
2. Usuario: `peniacom`
3. Contraseña: `P3n1ac0m12$`

---

## 🎯 PASO 2: Verificar Requisitos del Servidor

### A. Verificar versión de PHP

1. En cPanel, busca "MultiPHP Manager" o "Select PHP Version"
2. Necesitamos **PHP 8.1 o superior**
3. Si no está disponible, contactar al proveedor de hosting

### B. Habilitar extensiones PHP necesarias

En cPanel → Select PHP Version → Extensions, asegúrate de tener activadas:

- ✅ `pdo_mysql` o `pdo_sqlite`
- ✅ `mbstring`
- ✅ `xml`
- ✅ `bcmath`
- ✅ `json`
- ✅ `fileinfo`
- ✅ `openssl`
- ✅ `tokenizer`

---

## 🎯 PASO 3: Crear Base de Datos MySQL

1. En cPanel, busca **"MySQL Databases"** o **"Bases de datos MySQL"**
2. Crear nueva base de datos:
   - Nombre: `peniacom_penacom` (o el que prefieras)
3. Crear nuevo usuario:
   - Usuario: `peniacom_admin`
   - Contraseña: (genera una segura)
4. Asignar usuario a la base de datos con **TODOS LOS PRIVILEGIOS**
5. **Guardar estos datos**, los necesitaremos para el .env

**Datos a guardar:**

```
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=peniacom_penacom
DB_USERNAME=peniacom_admin
DB_PASSWORD=la_contraseña_que_generaste
```

---

## 🎯 PASO 4: Configurar Subdominios

### A. Subdominio para la API

1. En cPanel, busca **"Subdomains"** o **"Subdominios"**
2. Crear subdominio:
   - Subdominio: `api`
   - Dominio: (tu dominio principal)
   - Document Root: `/home/peniacom/api/public`
3. Anotar el dominio completo: `api.tudominio.com`

### B. Dominio principal para Frontend

1. En cPanel, busca **"Domains"** o **"Dominios"**
2. Verificar el dominio principal
3. Document Root debería ser: `/home/peniacom/public_html`

---

## 🎯 PASO 5: Preparar Archivos Localmente

### A. Configurar Backend para Producción

Editar `backend/.env.production`:

```env
APP_NAME="Casa Gery"
APP_ENV=production
APP_KEY=base64:TRIT1LHfhVyN5XwrnzPZHuMajsUJGRwlWBBgfSQIpVk=
APP_DEBUG=false
APP_URL=https://api.tudominio.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=peniacom_penacom
DB_USERNAME=peniacom_admin
DB_PASSWORD=TU_PASSWORD_AQUI

MAIL_MAILER=smtp
MAIL_HOST=mail.tudominio.com
MAIL_PORT=587
MAIL_USERNAME=noreply@tudominio.com
MAIL_PASSWORD=TU_PASSWORD_EMAIL
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tudominio.com
MAIL_FROM_NAME="Casa Gery"

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### B. Compilar Frontend con API correcta

Editar `frontend/.env.production`:

```env
VITE_API_URL=https://api.tudominio.com/api
```

---

## 🎯 PASO 6: Subir Backend via File Manager

### Opción A: File Manager de cPanel (Recomendado)

1. En cPanel → **File Manager**
2. Crear carpeta `/home/peniacom/api`
3. Dentro de `api`, crear estas carpetas:
   - `app/`
   - `bootstrap/`
   - `config/`
   - `database/`
   - `public/`
   - `resources/`
   - `routes/`
   - `storage/`
   - `vendor/`
4. Comprimir backend localmente en ZIP
5. Subir el ZIP via File Manager
6. Extraer en `/home/peniacom/api`
7. Crear archivo `.env` con el contenido de producción

### Opción B: FTP/SFTP

1. En cPanel → **FTP Accounts** → Crear cuenta FTP
2. Usar cliente FTP (FileZilla) para subir archivos
3. Subir todo el contenido de `backend/` a `/home/peniacom/api/`

---

## 🎯 PASO 7: Configurar Permisos del Backend

1. En cPanel → File Manager
2. Ir a `/home/peniacom/api/`
3. Permisos de carpetas (chmod 755):
   - `storage/` (y todas sus subcarpetas)
   - `bootstrap/cache/`
4. Permisos de archivos (chmod 644):
   - `.env`

---

## 🎯 PASO 8: Instalar Dependencias de Composer

### Si cPanel tiene Terminal:

1. En cPanel → **Terminal**
2. Ejecutar:

```bash
cd ~/api
php composer.phar install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Si NO tiene Terminal:

1. Instalar localmente con: `composer install --no-dev --optimize-autoloader`
2. Subir la carpeta `vendor/` completa

---

## 🎯 PASO 9: Subir Frontend

1. Compilar localmente:

```bash
cd frontend
npm run build
```

2. En cPanel → File Manager
3. Ir a `/home/peniacom/public_html/`
4. Eliminar todos los archivos existentes (excepto `cgi-bin` si existe)
5. Subir todo el contenido de `frontend/dist/`:
   - `index.html`
   - Carpeta `assets/`
   - Otros archivos

---

## 🎯 PASO 10: Configurar .htaccess

### A. Para Frontend (public_html/.htaccess)

Crear archivo `.htaccess` en `/home/peniacom/public_html/`:

```apache
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
  RewriteRule ^index\.html$ - [L]
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . /index.html [L]
</IfModule>

# Habilitar CORS
<IfModule mod_headers.c>
  Header set Access-Control-Allow-Origin "*"
</IfModule>
```

### B. Para Backend (api/public/.htaccess)

Ya viene con Laravel, pero verifica que tenga:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## 🎯 PASO 11: Instalar Certificados SSL

1. En cPanel → **SSL/TLS Status** o **Let's Encrypt SSL**
2. Seleccionar:
   - ✅ Dominio principal
   - ✅ Subdominio `api`
3. Instalar certificados gratuitos
4. Esperar 5-10 minutos

---

## 🎯 PASO 12: Configurar Email SMTP

1. En cPanel → **Email Accounts**
2. Crear cuenta: `noreply@tudominio.com`
3. Anotar datos SMTP:

```
MAIL_HOST=mail.tudominio.com
MAIL_PORT=587
MAIL_USERNAME=noreply@tudominio.com
MAIL_PASSWORD=la_contraseña_del_email
```

4. Actualizar estos datos en `api/.env`

---

## 🎯 PASO 13: Crear Usuario Administrador

1. Acceder a phpMyAdmin en cPanel
2. Seleccionar la base de datos
3. Ir a tabla `users`
4. Insertar registro:

```sql
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES (
  'Admin',
  'admin@tudominio.com',
  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'admin',
  NOW(),
  NOW()
);
```

Contraseña: `password` (cámbiala después de login)

---

## 🎯 PASO 14: Pruebas Finales

### A. Probar Backend

1. Ir a: `https://api.tudominio.com/api/settings`
2. Debería devolver JSON con la configuración

### B. Probar Frontend

1. Ir a: `https://tudominio.com`
2. Verificar que carga la página principal

### C. Probar Login

1. Ir a: `https://tudominio.com/admin/login`
2. Email: `admin@tudominio.com`
3. Password: `password`

### D. Probar Recuperación de Contraseña

1. Click en "¿Olvidaste tu contraseña?"
2. Ingresar email
3. Verificar que llegue el correo

---

## 🔧 Troubleshooting

### Error 500 en API

- Revisar permisos de `storage/` y `bootstrap/cache/`
- Verificar `.env` con datos correctos
- Revisar logs en cPanel → Error Logs

### Frontend no carga

- Verificar que `.htaccess` existe
- Verificar que mod_rewrite está activo

### No llegan emails

- Verificar datos SMTP en `.env`
- Probar desde cPanel → Email Deliverability

### CORS Errors

- Agregar dominio en backend `config/cors.php`
- Verificar headers en `.htaccess`

---

## 📞 Contactos de Soporte

**Servidor**: ServeNeubox
**Dominio**: Por definir
**cPanel**: https://svgt208.serverneubox.com.mx:2083

---

## ✅ Checklist Final

- [ ] PHP 8.1+ configurado
- [ ] Base de datos creada
- [ ] Subdominios configurados
- [ ] Backend subido y configurado
- [ ] Frontend compilado y subido
- [ ] Permisos correctos
- [ ] SSL instalado
- [ ] Email SMTP configurado
- [ ] Usuario admin creado
- [ ] Pruebas completadas
- [ ] Cambiar contraseña de admin
