# Railway Deployment Guide

## Project URL
https://goitom-finance-production.up.railway.app

## Dashboard
https://railway.com/project/be61fba8-22da-4b81-a3a5-c27b74d9e7b5

## Deployment Stappen

### 1. Service Linken
```bash
railway link --project goitom-finance
```

### 2. Environment Variables Instellen

Ga naar het Railway dashboard en voeg deze environment variables toe:

#### Database (Railway Postgres)
```env
DB_CONNECTION=pgsql
DB_HOST=centerbeam.proxy.rlwy.net
DB_PORT=52027
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=PassWord
```

Of gebruik de DATABASE_URL:
```env
DATABASE_URL=postgresql://postgres:PassWord@centerbeam.proxy.rlwy.net:52027/railway
```

#### Mail (Hostinger)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@goitomfinance.email
MAIL_PASSWORD=Mydude12=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@goitomfinance.email
MAIL_FROM_NAME="Goitom Finance"
```

#### App
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://goitom-finance-production.up.railway.app
APP_KEY=<generate-met-php-artisan-key:generate>
```

#### Queue
```env
QUEUE_CONNECTION=database
```

#### Storage
```env
FILESYSTEM_DISK=public
```

### 3. Database Migratie
```bash
railway run php artisan migrate --force
```

### 4. Storage Link
```bash
railway run php artisan storage:link
```

### 5. Queue Worker
Voeg een service toe voor de queue worker:
```bash
railway add --name queue-worker
```

Set start command in Railway UI:
```
php artisan queue:work --tries=3
```

### 6. Deploy
```bash
railway up
```

## Commands

### View Logs
```bash
railway logs
```

### View Environment Variables
```bash
railway variables
```

### Connect to Database
```bash
railway connect postgres
```

### Run Artisan Commands
```bash
railway run php artisan <command>
```

## Belangrijk

- Zorg dat APP_KEY is gegenereerd
- Database wordt automatisch geconfigureerd door Railway
- Mail configuratie is al aanwezig
- Queue worker moet als aparte service draaien

