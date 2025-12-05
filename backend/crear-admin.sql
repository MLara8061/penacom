-- Script para crear usuario administrador inicial
-- Ejecutar en phpMyAdmin después de las migraciones

-- Insertar usuario admin
-- Email: admin@tudominio.com
-- Password: admin123 (CAMBIAR DESPUÉS DEL PRIMER LOGIN)
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at)
VALUES (
  'Administrador',
  'admin@tudominio.com',
  '$2y$12$LQv3c1yYqBNzXjQcE0qL6.DJiOJEjJF6JFqTdQH7V1qLR.3Z5YU9O',
  'admin',
  NOW(),
  NOW(),
  NOW()
);

-- Verificar que se creó
SELECT * FROM users WHERE email = 'admin@tudominio.com';

-- IMPORTANTE: Después del primer login, cambiar la contraseña desde el panel admin
