# Guía Rápida de Troubleshooting - Acceso cPanel

## ❌ Error: "Nombre de usuario no válido"

### Posibles usuarios a probar (en orden):

1. **peniacom** (sin nada más)
2. **peniacom_admin** (con sufijo admin)
3. **peniacom@svgt208.serverneubox.com.mx** (con dominio completo)
4. **admin** (usuario genérico)
5. **root** (si es VPS/dedicado - poco probable)

### URLs a probar:

1. https://svgt208.serverneubox.com.mx:2083 (SSL seguro)
2. http://svgt208.serverneubox.com.mx:2082 (sin SSL)
3. https://svgt208.serverneubox.com.mx/cpanel
4. https://svgt208.serverneubox.com.mx:2087 (WHM - si es reseller)

### Contraseña:

```
P3n1ac0m12$
```

---

## 🔍 Verificar Información con el Proveedor

**Contacto: ServeNeubox**

### Datos a solicitar:

1. **URL exacta de acceso a cPanel**

   - ¿Es svgt208.serverneubox.com.mx:2083?
   - ¿O tienen otra URL?

2. **Usuario correcto de cPanel**

   - ¿Es "peniacom"?
   - ¿Necesita algún prefijo o sufijo?
   - ¿Formato especial?

3. **Restablecer contraseña**

   - Solicitar nueva contraseña o resetear actual

4. **Tipo de cuenta**

   - ¿Es hosting compartido?
   - ¿Es reseller?
   - ¿Es VPS?

5. **Acceso alternativo**
   - Datos de FTP
   - ¿Tienen acceso SSH?
   - Panel web alternativo

---

## 📞 Mensaje Sugerido para ServeNeubox

```
Asunto: Urgente - No puedo acceder a cPanel cuenta peniacom

Buenos días/tardes,

Necesito ayuda para acceder al cPanel de la cuenta:
- Cuenta/Usuario: peniacom
- Servidor: svgt208.serverneubox.com.mx

Cuando intento acceder a https://svgt208.serverneubox.com.mx:2083
me aparece el error: "Nombre de usuario no válido"

¿Pueden confirmarme:
1. ¿Cuál es el usuario EXACTO de cPanel?
2. ¿Cuál es la URL correcta de acceso?
3. ¿Pueden restablecer la contraseña?
4. ¿Tienen alguna guía de primer acceso?

Alternativamente, ¿pueden proporcionarme acceso FTP mientras tanto?

Gracias,
[Tu nombre]
```

---

## 🔄 Mientras tanto - Preparar Archivos

Mientras resuelves el acceso, puedes preparar los archivos localmente:

### En Windows, ejecuta:

```bash
cd c:\Users\Arla.ALLIENWARE\Desktop\penacom
preparar-migracion.bat
```

Esto generará:

- `backend-deploy/` - Listo para subir
- `frontend-deploy.tar.gz` - Listo para subir

---

## 📧 ¿Email de Bienvenida?

Busca en el email del cliente un mensaje de ServeNeubox con asunto tipo:

- "Bienvenido a ServeNeubox"
- "Detalles de tu cuenta de hosting"
- "Información de acceso - peniacom"

Ese email debería tener los datos correctos.

---

## ⚠️ Importante

El usuario "peniacom" que te proporcionaron podría:

1. No ser el usuario de cPanel (sino de facturación)
2. Necesitar activación inicial
3. Ser para otro servicio (email, FTP, etc.)

**Es necesario contactar a ServeNeubox para confirmar datos correctos.**
