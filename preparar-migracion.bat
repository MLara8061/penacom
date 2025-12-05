@echo off
echo ============================================
echo   Preparando archivos para migracion
echo ============================================
echo.

REM Paso 1: Limpiar builds anteriores
echo [1/5] Limpiando builds anteriores...
if exist backend-deploy rd /s /q backend-deploy
if exist frontend-deploy.zip del /f frontend-deploy.zip

REM Paso 2: Preparar backend
echo [2/5] Preparando backend...
mkdir backend-deploy
xcopy backend backend-deploy\ /E /I /Q /EXCLUDE:backend-exclude.txt

REM Paso 3: Compilar frontend
echo [3/5] Compilando frontend...
cd frontend
call npm run build
cd ..

REM Paso 4: Comprimir frontend
echo [4/5] Comprimiendo frontend...
cd frontend\dist
tar -czf ..\..\frontend-deploy.tar.gz *
cd ..\..

REM Paso 5: Listo
echo [5/5] Listo!
echo.
echo ============================================
echo   Archivos preparados:
echo   - backend-deploy\ (subir via FTP/cPanel)
echo   - frontend-deploy.tar.gz (subir y extraer en public_html)
echo ============================================
echo.
echo Siguiente paso: Ver MIGRACION.md
pause
