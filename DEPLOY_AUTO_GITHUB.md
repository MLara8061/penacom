# 🔄 Despliegue Automático GitHub → Hostinger (Laravel + Vue)

## 📋 Requisitos Previos

1. **Repositorio GitHub**: Tu código debe estar en GitHub
2. **Hostinger Premium/Business**: Necesitas acceso SSH
3. **Git instalado en Hostinger**: La mayoría lo tiene por defecto
4. **Composer y Node.js**: En el servidor (o usar binarios locales)

## 🎯 Estrategia de Despliegue

Para Laravel + Vue hay dos opciones:

### Opción A: Pre-compilar Frontend (Recomendado)
- Compilas Vue localmente → subes `dist/` al repo
- GitHub Webhook → despliega Laravel + archivos estáticos
- ✅ Más rápido, no necesita Node.js en servidor

### Opción B: Compilar en Servidor
- Subes código fuente Vue al repo
- GitHub Webhook → compila Vue en servidor → despliega todo
- ⚠️ Requiere Node.js en Hostinger (no siempre disponible)

**Usaremos Opción A** por ser más compatible con hosting compartido.

---

## 🔧 PASO 1: Preparar el Repositorio

### A. Estructura del Repositorio

```
tu-repo/
├── backend/                 # Laravel
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── .env.example
│   └── ...
├── frontend/                # Vue (código fuente)
│   ├── src/
│   ├── dist/               # ⚠️ Este se ignora en .gitignore
│   └── ...
├── public_html/            # Vue compilado (para servidor)
│   ├── index.html
│   ├── assets/
│   └── logo.png
├── deploy.php              # Script de despliegue
└── .github/
    └── workflows/
        └── deploy.yml      # GitHub Actions (opcional)
```

### B. Actualizar .gitignore

**En `frontend/.gitignore`**, asegúrate que `dist/` esté ignorado:
```
dist/
node_modules/
.env
```

**En la raíz**, crea `.gitignore`:
```
# Laravel
backend/.env
backend/vendor/
backend/node_modules/
backend/storage/*.key
backend/storage/logs/*.log
backend/bootstrap/cache/*.php
backend/.phpunit.result.cache

# Vue
frontend/node_modules/
frontend/dist/

# Ignorar compilado local, solo subimos el del deploy
!public_html/
```

### C. Crear Carpeta de Producción

Compilamos el frontend y lo guardamos en `public_html/`:

```powershell
cd frontend
npm run build

# Copiar dist/ a public_html/ en la raíz
Remove-Item -Recurse -Force ..\public_html\* -ErrorAction SilentlyContinue
Copy-Item -Recurse .\dist\* ..\public_html\

# Verificar
ls ..\public_html
```

Ahora `public_html/` contiene el frontend compilado que SÍ subiremos a GitHub.

### D. Subir al Repositorio

```powershell
cd C:\Users\Arla.ALLIENWARE\Desktop\penacom

git add .
git commit -m "Setup for auto-deployment"
git push origin main
```

---

## 🔐 PASO 2: Configurar SSH en Hostinger

### A. Conectar por SSH

1. En Hostinger hPanel, ve a **Avanzado** → **SSH Access**
2. Activa SSH si no lo está
3. Copia las credenciales:
   ```
   Host: ssh.hostinger.com (o tu servidor específico)
   Port: 22 o 65002
   User: u123456789
   ```

4. Conecta desde PowerShell:
```powershell
ssh u123456789@ssh.hostinger.com -p 65002
```

O usa PuTTY si prefieres interfaz gráfica.

### B. Configurar Git en el Servidor

Una vez conectado por SSH:

```bash
# Verificar que git esté instalado
git --version

# Configurar git
git config --global user.name "Tu Nombre"
git config --global user.email "tu@email.com"

# Crear clave SSH para GitHub
ssh-keygen -t ed25519 -C "tu@email.com"
# Presiona Enter 3 veces (sin passphrase)

# Copiar la clave pública
cat ~/.ssh/id_ed25519.pub
```

### C. Añadir Deploy Key a GitHub

1. Copia el contenido de `cat ~/.ssh/id_ed25519.pub`
2. Ve a tu repo en GitHub → **Settings** → **Deploy keys**
3. Click **Add deploy key**
4. Pega la clave, marca ✅ **Allow write access** (solo si necesitas push desde servidor)
5. Guarda

### D. Probar Conexión

En SSH del servidor:
```bash
ssh -T git@github.com
# Deberías ver: "Hi username! You've successfully authenticated"
```

---

## 📁 PASO 3: Clonar Repositorio en Hostinger

### A. Estructura Recomendada

```
/home/u123456789/
├── domains/
│   └── tudominio.com/
│       ├── public_html/          # Frontend (enlace simbólico)
│       └── api/                  # Backend (enlace simbólico)
└── repo/                         # Repositorio Git
    └── penacom/                  
        ├── backend/
        ├── public_html/
        └── deploy.php
```

### B. Clonar el Repo

```bash
# Navegar a home
cd ~

# Crear carpeta para repos
mkdir -p repo
cd repo

# Clonar tu repositorio
git clone git@github.com:MLara8061/penacom.git
cd penacom

# Verificar
ls -la
```

### C. Crear Enlaces Simbólicos

```bash
# Variables (ajusta según tu hosting)
REPO_PATH=~/repo/penacom
DOMAIN_PATH=~/domains/tudominio.com  # O ~/public_html si es el dominio principal

# Backup de archivos existentes (primera vez)
mv $DOMAIN_PATH/public_html $DOMAIN_PATH/public_html.backup
mv $DOMAIN_PATH/api $DOMAIN_PATH/api.backup  # Si existe

# Crear symlinks
ln -s $REPO_PATH/public_html $DOMAIN_PATH/public_html
ln -s $REPO_PATH/backend $DOMAIN_PATH/api

# Verificar
ls -la $DOMAIN_PATH
```

### D. Configurar Laravel

```bash
cd ~/repo/penacom/backend

# Copiar .env
cp .env.example .env

# Editar .env con nano o vim
nano .env
# Configura: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL, etc.

# Instalar dependencias de Composer
# Si composer no está disponible, descarga composer.phar:
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader

# O si composer está instalado globalmente:
composer install --no-dev --optimize-autoloader

# Generar APP_KEY
php artisan key:generate

# Configurar permisos
chmod -R 775 storage bootstrap/cache

# Ejecutar migraciones
php artisan migrate --force

# Cachear configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🚀 PASO 4: Script de Despliegue Automático

### A. Crear Script de Deploy

En tu repositorio local, crea `deploy.php` en la raíz:

```php
<?php
/**
 * GitHub Webhook Auto-Deploy Script
 * Para Laravel + Vue (pre-compilado)
 */

// Configuración
define('SECRET_TOKEN', 'tu_token_super_secreto_aqui_12345'); // Cámbialo!
define('REPO_PATH', '/home/u123456789/repo/penacom');
define('BRANCH', 'refs/heads/main');
define('LOG_FILE', REPO_PATH . '/deploy.log');

// Función de logging
function log_message($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents(LOG_FILE, $logMessage, FILE_APPEND);
    echo $logMessage;
}

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    log_message('ERROR: Method not allowed');
    die('Method Not Allowed');
}

// Leer payload
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// Verificar firma de GitHub (seguridad)
if (isset($_SERVER['HTTP_X_HUB_SIGNATURE_256'])) {
    $signature = 'sha256=' . hash_hmac('sha256', $payload, SECRET_TOKEN);
    if (!hash_equals($signature, $_SERVER['HTTP_X_HUB_SIGNATURE_256'])) {
        http_response_code(403);
        log_message('ERROR: Invalid signature');
        die('Invalid signature');
    }
} else {
    // Fallback: verificar token en query string
    if (!isset($_GET['token']) || $_GET['token'] !== SECRET_TOKEN) {
        http_response_code(403);
        log_message('ERROR: Invalid token');
        die('Invalid token');
    }
}

// Verificar que sea push al branch correcto
if (!isset($data['ref']) || $data['ref'] !== BRANCH) {
    log_message('INFO: Push to different branch: ' . ($data['ref'] ?? 'unknown'));
    die('Not main branch');
}

log_message('=== INICIO DESPLIEGUE ===');
log_message('Triggered by: ' . ($data['pusher']['name'] ?? 'unknown'));
log_message('Commit: ' . substr($data['after'] ?? '', 0, 7));

// Cambiar al directorio del repo
chdir(REPO_PATH);

// Comandos de despliegue
$commands = [
    // 1. Poner sitio en mantenimiento
    'cd backend && php artisan down --retry=60 2>&1',
    
    // 2. Hacer pull de GitHub
    'git fetch origin main 2>&1',
    'git reset --hard origin/main 2>&1',
    
    // 3. Actualizar dependencias de Laravel
    'cd backend && php composer.phar install --no-dev --optimize-autoloader 2>&1',
    // O si composer es global: 'cd backend && composer install --no-dev --optimize-autoloader 2>&1',
    
    // 4. Ejecutar migraciones (solo si cambiaron)
    'cd backend && php artisan migrate --force 2>&1',
    
    // 5. Limpiar y cachear configuración
    'cd backend && php artisan config:clear 2>&1',
    'cd backend && php artisan cache:clear 2>&1',
    'cd backend && php artisan config:cache 2>&1',
    'cd backend && php artisan route:cache 2>&1',
    'cd backend && php artisan view:cache 2>&1',
    
    // 6. Configurar permisos
    'chmod -R 775 backend/storage backend/bootstrap/cache 2>&1',
    
    // 7. Quitar modo mantenimiento
    'cd backend && php artisan up 2>&1',
];

// Ejecutar comandos
foreach ($commands as $command) {
    log_message("Ejecutando: $command");
    $output = shell_exec($command);
    log_message("Output: " . trim($output));
}

log_message('=== FIN DESPLIEGUE ===');

http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Deployment completed',
    'timestamp' => date('c')
]);
```

**Importante:** 
1. Cambia `SECRET_TOKEN` por algo único y seguro
2. Ajusta rutas si tu estructura es diferente
3. Si Composer está global, cambia `php composer.phar` por `composer`

### B. Subir Script al Servidor

```powershell
# Local
cd C:\Users\Arla.ALLIENWARE\Desktop\penacom
git add deploy.php
git commit -m "Add auto-deploy script"
git push origin main
```

Luego en SSH del servidor:
```bash
cd ~/repo/penacom
git pull origin main

# Configurar permisos
chmod +x deploy.php
```

### C. Hacer Accesible el Script

Crea un enlace simbólico o copia el script a una ubicación web accesible:

**Opción 1: Subdirectorio oculto**
```bash
mkdir -p ~/domains/tudominio.com/public_html/.deploy
cp ~/repo/penacom/deploy.php ~/domains/tudominio.com/public_html/.deploy/
chmod 755 ~/domains/tudominio.com/public_html/.deploy/deploy.php
```

URL: `https://tudominio.com/.deploy/deploy.php?token=tu_token_super_secreto_aqui_12345`

**Opción 2: Subdominio dedicado**
```bash
# Crea un subdominio en Hostinger: deploy.tudominio.com
# Apúntalo a una carpeta nueva
mkdir -p ~/webhook
cp ~/repo/penacom/deploy.php ~/webhook/index.php
chmod 755 ~/webhook/index.php
```

URL: `https://deploy.tudominio.com/?token=tu_token_super_secreto_aqui_12345`

---

## 🎣 PASO 5: Configurar Webhook en GitHub

### A. Crear el Webhook

1. Ve a tu repo en GitHub
2. **Settings** → **Webhooks** → **Add webhook**
3. Configura:
   ```
   Payload URL: https://tudominio.com/.deploy/deploy.php
   Content type: application/json
   Secret: tu_token_super_secreto_aqui_12345
   ```
4. En "Which events?": Selecciona **Just the push event**
5. Marca ✅ **Active**
6. Click **Add webhook**

### B. Probar el Webhook

1. Haz un cambio pequeño en tu código local:
```powershell
cd C:\Users\Arla.ALLIENWARE\Desktop\penacom
echo "# Test deploy" >> README.md
git add README.md
git commit -m "Test: auto-deploy webhook"
git push origin main
```

2. En GitHub, ve a **Settings** → **Webhooks** → Tu webhook
3. Click en el webhook → pestaña **Recent Deliveries**
4. Deberías ver una entrega con ✅ verde (código 200)
5. Click en ella para ver Request y Response

### C. Verificar Logs

En SSH del servidor:
```bash
cd ~/repo/penacom
tail -f deploy.log
```

Deberías ver:
```
[2025-11-27 15:30:45] === INICIO DESPLIEGUE ===
[2025-11-27 15:30:45] Triggered by: MLara8061
[2025-11-27 15:30:45] Commit: abc1234
...
[2025-11-27 15:30:52] === FIN DESPLIEGUE ===
```

---

## 🔄 PASO 6: Workflow Completo de Desarrollo

### Para actualizar Frontend:

```powershell
cd C:\Users\Arla.ALLIENWARE\Desktop\penacom\frontend

# Hacer cambios en src/...

# Compilar
npm run build

# Actualizar public_html
Remove-Item -Recurse -Force ..\public_html\* -ErrorAction SilentlyContinue
Copy-Item -Recurse .\dist\* ..\public_html\

# Commit y push
cd ..
git add public_html/
git commit -m "Update: nueva funcionalidad en frontend"
git push origin main

# 🎉 GitHub Webhook desplegará automáticamente!
```

### Para actualizar Backend:

```powershell
cd C:\Users\Arla.ALLIENWARE\Desktop\penacom\backend

# Hacer cambios en app/, routes/, etc.

# Commit y push
cd ..
git add backend/
git commit -m "Update: nuevo endpoint API"
git push origin main

# 🎉 Despliegue automático!
```

### Si hay Migraciones Nuevas:

El script ya ejecuta `php artisan migrate --force`, pero si quieres control manual:

```bash
# SSH al servidor
ssh u123456789@ssh.hostinger.com -p 65002

cd ~/repo/penacom/backend
php artisan migrate --force
```

---

## 🔒 Seguridad y Mejores Prácticas

### 1. Proteger el Script de Deploy

Crea `.htaccess` en la carpeta del script:
```apache
# En .deploy/.htaccess
<Files "deploy.php">
    # Solo permite acceso desde GitHub
    Order Deny,Allow
    Deny from all
    Allow from 140.82.112.0/20
    Allow from 143.55.64.0/20
    Allow from 185.199.108.0/22
    Allow from 192.30.252.0/22
</Files>
```

### 2. Variables de Entorno

Nunca subas `.env` al repo. Usa `.env.example` y configura `.env` solo en servidor.

### 3. Backup Automático

Añade al script de deploy (antes del git pull):
```php
// Backup de la base de datos
'cd backend && php artisan backup:run 2>&1',
```

Configura Laravel Backup: https://spatie.be/docs/laravel-backup

### 4. Notificaciones

Añade al final del script:
```php
// Notificar por Slack/Discord/Email
$webhookUrl = 'https://hooks.slack.com/services/YOUR/WEBHOOK/URL';
$message = "✅ Deploy exitoso: commit " . substr($data['after'], 0, 7);
file_get_contents($webhookUrl, false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode(['text' => $message])
    ]
]));
```

---

## 🐛 Troubleshooting

### Error: "Permission denied (publickey)"

**Solución:**
```bash
# En servidor, verifica SSH key
cat ~/.ssh/id_ed25519.pub
# Asegúrate que esté en GitHub Deploy Keys
```

### Error: "Could not resolve host"

**Solución:**
```bash
# Verifica DNS en servidor
ping github.com

# Si falla, contacta soporte Hostinger
```

### Script no se ejecuta

**Solución:**
```bash
# Verifica permisos
ls -la ~/domains/tudominio.com/public_html/.deploy/deploy.php

# Debe ser 755 y propiedad del usuario web
chmod 755 deploy.php
chown u123456789:u123456789 deploy.php
```

### Webhook muestra error 500

**Solución:**
1. Activa logs de PHP en Hostinger
2. Revisa `deploy.log`:
```bash
tail -100 ~/repo/penacom/deploy.log
```

### Composer no encuentra dependencias

**Solución:**
```bash
# Descarga composer.phar local en el servidor
cd ~/repo/penacom/backend
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader
```

---

## 📊 Monitoreo de Deploys

### Ver últimos deploys:
```bash
tail -50 ~/repo/penacom/deploy.log | grep "=== INICIO"
```

### Estadísticas:
```bash
grep "INICIO DESPLIEGUE" ~/repo/penacom/deploy.log | wc -l
# Muestra número total de deploys
```

### Último commit desplegado:
```bash
cd ~/repo/penacom
git log -1 --oneline
```

---

## ✅ Checklist de Configuración

- [ ] Repositorio en GitHub con estructura correcta
- [ ] Frontend compilado en `public_html/` (no `dist/`)
- [ ] SSH configurado en Hostinger
- [ ] Deploy key añadida a GitHub
- [ ] Repositorio clonado en `~/repo/penacom`
- [ ] Enlaces simbólicos creados
- [ ] `.env` configurado en servidor
- [ ] Composer dependencies instaladas
- [ ] Script `deploy.php` configurado con SECRET_TOKEN
- [ ] Script accesible vía web
- [ ] Webhook creado en GitHub
- [ ] Test de deploy realizado exitosamente
- [ ] Logs verificados

---

## 🎉 ¡Listo!

Ahora cada vez que hagas `git push origin main`:

1. GitHub envía webhook a tu servidor
2. Script valida el token/firma
3. Hace `git pull` del código nuevo
4. Actualiza Laravel (composer, cache, migraciones)
5. Frontend ya viene compilado en `public_html/`
6. ¡Sitio actualizado en segundos!

**Tiempo de deploy:** ~10-30 segundos dependiendo del tamaño de cambios.

---

## 📚 Recursos Adicionales

- [GitHub Webhooks Docs](https://docs.github.com/en/webhooks)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Hostinger SSH Guide](https://support.hostinger.com/en/articles/1583245-how-to-connect-to-ssh)
