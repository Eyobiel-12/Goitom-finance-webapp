# Railway Docker Deployment

## Docker Setup

Deze applicatie gebruikt **Docker** voor deployment op Railway.

## Files

- `Dockerfile` - Multi-stage Docker build
- `docker-compose.yml` - Lokale development setup
- `docker/` - Configuratie bestanden (nginx, PHP, supervisor)
- `.dockerignore` - Bestanden om te negeren tijdens build

## Railway Deployment

Railway detecteert automatisch de `Dockerfile` via `railway.json`:

```json
{
  "build": {
    "builder": "DOCKERFILE",
    "dockerfilePath": "Dockerfile"
  }
}
```

## Deployment Stappen

### 1. Environment Variables (zie RAILWAY_DEPLOY.md)

Voeg deze toe in Railway Dashboard → app service:

```env
DATABASE_URL=${{Postgres.DATABASE_URL}}
APP_ENV=production
APP_DEBUG=false
APP_URL=https://goitom-finance-production.up.railway.app
APP_KEY=<generate>
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@goitomfinance.email
MAIL_PASSWORD=Mydude12=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@goitomfinance.email
MAIL_FROM_NAME="Goitom Finance"
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public
```

### 2. Generate APP_KEY

```bash
railway run php artisan key:generate
```

### 3. Run Migrations

```bash
railway run php artisan migrate --force
```

### 4. Link Storage

```bash
railway run php artisan storage:link
```

### 5. Deploy

```bash
railway up
```

## Lokale Development (Docker)

```bash
# Start services
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Check logs
docker-compose logs -f

# Stop services
docker-compose down

# Rebuild containers
docker-compose up -d --build
```

## Docker Image Layers

1. **Base** - PHP 8.3 + extensions + Composer
2. **Builder** - Install dependencies + build assets
3. **Production** - Final image with optimizations

## Services in Container

- PHP-FPM (port 9000)
- Nginx (port 8000)
- Supervisor (orchestration)
- Queue worker (automatisch)

## Build Optimizations

- Multi-stage build (kleinere image)
- Opcache enabled
- Production dependencies only
- Optimized autoloader
- Asset minification

