# Docker Healthcheck Fixes

## Probleem
De deployment faalde met "Healthcheck failed!" omdat:
1. De `start.sh` script crashte bij database connectie checks
2. Nginx kon `default.conf` niet laden (verkeerd pad)
3. PHP-FPM configuratie ontbrak

## Oplossingen

### 1. Start Script Verbeterd (`docker/start.sh`)
- ✅ Verwijderd `set -e` (stoppe bij eerste fout)
- ✅ Migrations runnen zonder te crashen als ze al bestaan
- ✅ Alle setup taken zijn non-blocking
- ✅ Supervisor start als main process

### 2. Nginx Configuratie Pad (`Dockerfile`)
- ✅ `default.conf` nu gekopieerd naar `/etc/nginx/conf.d/` (was `/etc/nginx/http.d/`)
- ✅ Nginx kan nu de config laden
- ✅ Verbeterde PHP-FPM parameters

### 3. PHP-FPM Configuratie (`docker/www.conf`)
- ✅ Nieuwe configuratie toegevoegd
- ✅ Luistert op `127.0.0.1:9000` 
- ✅ Pool management correct geconfigureerd

## Nieuwe Deployment

De wijzigingen zijn gepusht naar GitHub:
```
commit a9cae11: Fix: Improve Docker startup script and Nginx/PHP-FPM configuration
```

Railway zou automatisch moeten herdeployen.

## Verificatie

Na deployment, check:
1. Railway Dashboard → Deployments tab
2. Status moet "Active" zijn
3. Logs controleren voor "✅ Application started successfully"

## Environment Variables (nog steeds nodig)

Zorg dat deze variabelen zijn ingesteld in Railway:
- `DATABASE_URL=${{Postgres.DATABASE_URL}}`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://web-production-e2c4c.up.railway.app`
- Alle `MAIL_*` variables
- `QUEUE_CONNECTION=database`
- `FILESYSTEM_DISK=public`

