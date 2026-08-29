# Multi-stage build for Laravel 13 on Coolify (PHP-FPM + Nginx)
FROM node:22-alpine AS node-build
WORKDIR /app
COPY package.json package-lock.json* ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi
COPY resources ./resources
COPY vite.config.js ./
COPY scripts ./scripts
COPY public ./public
RUN npm run build && test -f public/css/app.built.css

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction
COPY . .
RUN composer dump-autoload --optimize --no-dev --no-scripts

FROM php:8.3-fpm-alpine AS app
RUN apk add --no-cache \
        nginx \
        supervisor \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mysqli \
        mbstring \
        zip \
        intl \
        bcmath \
        pcntl \
        gd \
        opcache \
    && apk del $PHPIZE_DEPS

WORKDIR /var/www/html

COPY --from=vendor /app /var/www/html
COPY --from=node-build /app/public/build /var/www/html/public/build
COPY --from=node-build /app/public/css/app.built.css /var/www/html/public/css/app.built.css
COPY --from=node-build /app/public/js/app.built.js /var/www/html/public/js/app.built.js

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/99-custom.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

ENV RUN_MIGRATIONS=false

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=40s --retries=3 \
    CMD wget -qO- http://127.0.0.1/up || exit 1

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
