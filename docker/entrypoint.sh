#!/bin/sh
set -e

cd /var/www/html

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php artisan migrate --force --no-interaction
fi

if [ "${RUN_SEEDERS}" = "true" ]; then
  php artisan db:seed --force --no-interaction
fi

php artisan view:clear || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

if [ ! -f public/css/app.built.css ]; then
  echo "ADVERTENCIA: falta public/css/app.built.css — ejecute npm run build."
fi

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
