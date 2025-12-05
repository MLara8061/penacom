# Configuración de Email para Recuperación de Contraseña

## Sistema Implementado ✅

El sistema de recuperación de contraseña está completamente funcional y consta de:

### Backend (Laravel)

- ✅ `AuthController::forgotPassword()` - Envía enlace de recuperación
- ✅ `AuthController::resetPassword()` - Valida token y actualiza contraseña
- ✅ Rutas API configuradas:
  - POST `/api/auth/forgot-password`
  - POST `/api/auth/reset-password`
- ✅ Tabla `password_reset_tokens` en base de datos

### Frontend (Vue)

- ✅ `/admin/forgot-password` - Formulario para solicitar recuperación
- ✅ `/admin/reset-password` - Formulario para ingresar nueva contraseña
- ✅ Enlace "¿Olvidaste tu contraseña?" en página de login
- ✅ Integración con AlertNotification para feedback visual

## Configuración de Email Requerida

Para que el sistema envíe correos reales en **PRODUCCIÓN**, debes configurar el archivo `.env` del backend:

### Opción 1: Gmail (Más fácil para pruebas)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=tu_contraseña_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tucorreo@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Nota**: Para Gmail necesitas usar una "Contraseña de aplicación" en lugar de tu contraseña normal:

1. Ve a tu cuenta de Google
2. Seguridad → Verificación en dos pasos (actívala si no la tienes)
3. Contraseñas de aplicaciones → Generar nueva
4. Usa esa contraseña en `MAIL_PASSWORD`

### Opción 2: Hostinger Email (Recomendado para producción)

Si tienes un correo corporativo como `admin@casagery.com`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=admin@casagery.com
MAIL_PASSWORD=tu_contraseña_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@casagery.com
MAIL_FROM_NAME="Casa Gery Admin"
```

### Opción 3: SendGrid (Para alto volumen)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu_api_key_de_sendgrid
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@casagery.com
MAIL_FROM_NAME="Casa Gery"
```

## URLs de Producción

El sistema usa la variable `APP_URL` para generar los enlaces de recuperación. Asegúrate de configurar:

```env
APP_URL=https://casagery.com
```

Esto hará que los enlaces en los correos sean:

```
https://casagery.com/admin/reset-password?token=xxx&email=usuario@email.com
```

## Personalización del Email

Si deseas personalizar el contenido del correo electrónico, puedes crear una plantilla personalizada:

1. Ejecutar en backend:

```bash
php artisan vendor:publish --tag=laravel-mail
```

2. Editar el archivo generado en:

```
resources/views/vendor/mail/html/message.blade.php
```

## Pruebas Locales (Sin configurar email real)

Durante el desarrollo, Laravel está configurado con `MAIL_MAILER=log`, lo que significa que los emails se guardan en:

```
backend/storage/logs/laravel.log
```

Puedes buscar el token de recuperación en ese archivo y construir manualmente la URL para probar.

## Seguridad

- Los tokens expiran después de **60 minutos** (configurado en `config/auth.php`)
- Los tokens solo se pueden usar **una vez**
- Los tokens son únicos y aleatorios de 64 caracteres
- Las contraseñas deben tener **mínimo 8 caracteres**
- Se requiere **confirmación de contraseña** en el formulario

## Flujo Completo

1. Usuario hace clic en "¿Olvidaste tu contraseña?" en `/admin/login`
2. Ingresa su email en `/admin/forgot-password`
3. Laravel envía email con enlace tipo:
   ```
   https://casagery.com/admin/reset-password?token=ABC123&email=user@email.com
   ```
4. Usuario hace clic en el enlace del correo
5. Ingresa nueva contraseña en el formulario
6. Sistema valida token y actualiza contraseña
7. Usuario es redirigido a `/admin/login` para iniciar sesión

## Comandos Útiles

Limpiar tokens expirados manualmente:

```bash
php artisan auth:clear-resets
```

Ver configuración de email actual:

```bash
php artisan tinker
>>> config('mail')
```

Probar envío de email:

```bash
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

## Troubleshooting

### Error: "Could not authenticate"

- Verifica MAIL_USERNAME y MAIL_PASSWORD
- Si usas Gmail, asegúrate de usar contraseña de aplicación

### Error: "Connection timed out"

- Verifica MAIL_PORT (normalmente 587 con TLS o 465 con SSL)
- Verifica que el firewall permita conexiones SMTP

### Emails no llegan

- Revisa la carpeta de spam
- Verifica que MAIL_FROM_ADDRESS sea válido
- Revisa logs: `backend/storage/logs/laravel.log`

## Estado Actual

✅ **Frontend**: Desplegado en https://casagery.com
✅ **Backend**: Código implementado
⚠️ **Email**: Configurado en modo `log` (desarrollo)

**Siguiente paso**: Configurar variables de email en el `.env` de producción del servidor.
