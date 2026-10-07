-- Elimina todas las vacaciones para recargarlas.
-- Ejecutar en MySQL (HeidiSQL / phpMyAdmin / consola):
--   USE cpet;
--   SOURCE scripts/wipe-vacaciones.sql;
-- O desde Laravel:
--   php artisan vacaciones:wipe --force

DELETE FROM oficiales_vacaciones;
