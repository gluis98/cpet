# Deploy CPET en Coolify

Guía para desplegar esta aplicación Laravel 13 con **MySQL como recurso separado** en Coolify.

## Requisitos

- Repositorio Git con este proyecto
- Coolify con build pack **Dockerfile**
- PHP/MySQL no se incluyen en el contenedor de la app: MySQL va como servicio independiente

## 1. Crear MySQL en Coolify

1. New Resource → **Database** → MySQL (8.x recomendado)
2. Nombre de base: `cpet`
3. Anota: host interno, puerto `3306`, usuario, password y nombre de BD

El host interno suele ser el nombre del servicio Coolify (ej. `cpet-mysql` o similar). Úsalo como `DB_HOST`.

## 2. Crear la Application

1. New Resource → **Application**
2. Conecta el repositorio y la rama (`main` / `master`)
3. Build Pack: **Dockerfile** (no Nixpacks)
4. Puerto expuesto: **80**
5. Health check:
   - Path: `/up`
   - Intervalo: 30s
   - Retries: 3

## 3. Variables de entorno

Copia desde `.env.example` y ajusta al menos:

```env
APP_NAME=CPET
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.ejemplo
APP_KEY=base64:...   # generar con: php artisan key:generate --show

DB_CONNECTION=mysql
DB_HOST=<hostname-interno-mysql-coolify>
DB_PORT=3306
DB_DATABASE=cpet
DB_USERNAME=<usuario>
DB_PASSWORD=<password>

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
LOG_LEVEL=warning

# Primer deploy
RUN_MIGRATIONS=true
RUN_SEEDERS=true
```

Después del primer deploy exitoso, pon `RUN_MIGRATIONS=false` y `RUN_SEEDERS=false` (o déjalos en `true` solo si quieres migraciones automáticas en cada redeploy).

## 4. Persistencia (storage)

Monta un volumen persistente en:

- `/var/www/html/storage`

Así se conservan fotos, documentos y logs entre deploys.

Opcional: si usas `storage:link`, el enlace se recrea en el entrypoint.

## 5. Dominio y SSL

1. Asigna el dominio en Coolify
2. Activa SSL (Let's Encrypt)
3. `APP_URL` debe coincidir con `https://tu-dominio`

La app confía en proxies (`trustProxies('*')`) para HTTPS detrás de Coolify.

## 6. Datos geo (municipios / parroquias)

Las migraciones crean el esquema. Los seeders solo cargan catálogos pequeños (`estados`, `cargos`, `armamentos`, `tipos_cargos`).

Si necesitas municipios/parroquias/oficiales del dump histórico:

1. Conéctate al MySQL de Coolify
2. Importa selectivamente desde `database/cpet.sql` (o un export limpio)

## 7. Usuario admin

Tras el seed o import, crea un usuario:

```bash
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@mail.com','password'=>bcrypt('secret'),'role'=>'Administrador']);
```

O usa la UI de registro si está habilitada.

## 8. Checklist post-deploy

- [ ] `/up` responde 200
- [ ] Login funciona
- [ ] `php artisan migrate:status` OK
- [ ] Subida de archivos escribe en `storage`
- [ ] Assets Vite cargan (`public/build` incluido en la imagen)

## Build local (opcional)

```bash
docker build -t cpet .
docker run --rm -p 8080:80 \
  -e APP_KEY=base64:... \
  -e APP_URL=http://localhost:8080 \
  -e DB_HOST=host.docker.internal \
  -e DB_DATABASE=cpet \
  -e DB_USERNAME=root \
  -e DB_PASSWORD= \
  -e RUN_MIGRATIONS=true \
  cpet
```
