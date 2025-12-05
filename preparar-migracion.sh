#!/bin/bash
echo "============================================"
echo "  Preparando archivos para migración"
echo "============================================"
echo ""

# Paso 1: Limpiar builds anteriores
echo "[1/5] Limpiando builds anteriores..."
rm -rf backend-deploy
rm -f frontend-deploy.tar.gz

# Paso 2: Preparar backend
echo "[2/5] Preparando backend..."
mkdir -p backend-deploy
rsync -av --exclude-from=backend-exclude.txt backend/ backend-deploy/

# Paso 3: Compilar frontend
echo "[3/5] Compilando frontend..."
cd frontend
npm run build
cd ..

# Paso 4: Comprimir frontend
echo "[4/5] Comprimiendo frontend..."
cd frontend/dist
tar -czf ../../frontend-deploy.tar.gz *
cd ../..

# Paso 5: Listo
echo "[5/5] Listo!"
echo ""
echo "============================================"
echo "  Archivos preparados:"
echo "  - backend-deploy/ (subir via FTP/cPanel)"
echo "  - frontend-deploy.tar.gz (subir y extraer en public_html)"
echo "============================================"
echo ""
echo "Siguiente paso: Ver MIGRACION.md"
