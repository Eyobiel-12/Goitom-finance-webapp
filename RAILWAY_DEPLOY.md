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

**⚠️ BELANGRIJK**: Gebruik ALLEEN `DATABASE_URL` - dit is de private endpoint zonder egress fees!

Railway stelt automatisch de juiste variabelen beschikbaar. In Railway dashboard → Postgres service → Variables zie je:

**Private endpoint (GEBRUIK DIT!):**
```env
DATABASE_URL="postgresql://postgres:DvNJOjnKLHYQLTovDlWqZJCvIVultjwS@private:5432/railway"
```

**⚠️ Gebruik NIET:**
- `DATABASE_PUBLIC_URL` (trekt egress fees via `centerbeam.proxy.rlwy.net`)
- Individuele `DB_HOST`, `DB_PORT` etc. (gebruik alleen `DATABASE_URL`)

**In je app service, voeg toe:**
```env
DATABASE_URL=${{Postgres.DATABASE_URL}}
```

Dit linkt automatisch naar de private endpoint.

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
- **GEBRUIK PRIVATE ENDPOINT** (`${{Postgres.DATABASE_URL}}`) om egress fees te vermijden
- Mail configuratie is al aanwezig
- Queue worker moet als aparte service draaien

## Environment Variables Setup in Railway

Ga naar Railway Dashboard → goitom-finance project → Selecteer je **app service** → Settings → Variables → "Add Variable"

### ✅ CORRECTE Configuratie (zonder egress fees)

**In je app service, voeg deze toe:**

1. **DATABASE_URL** = Gebruik Railway's private reference:
   - Variable: `DATABASE_URL`
   - Value: `${{Postgres.DATABASE_URL}}`
   - Dit gebruikt automatisch: `postgresql://postgres:DvNJOjnKLHYQLTovDlWqZJCvIVultjwS@private:5432/railway`

2. **APP_ENV** = `production`

3. **APP_DEBUG** = `false`

4. **APP_URL** = `https://goitom-finance-production.up.railway.app`

5. **MAIL_MAILER** = `smtp`

6. **MAIL_HOST** = `smtp.hostinger.com`

7. **MAIL_PORT** = `465`

8. **MAIL_USERNAME** = `info@goitomfinance.email`

9. **MAIL_PASSWORD** = `Mydude12=`

10. **MAIL_ENCRYPTION** = `ssl`

11. **MAIL_FROM_ADDRESS** = `info@goitomfinance.email`

12. **MAIL_FROM_NAME** = `Goitom Finance`

13. **QUEUE_CONNECTION** = `database`

14. **FILESYSTEM_DISK** = `public`

### ❌ FOUTIEVE Configuratie (trekt egress fees!)

**Voeg deze NIET toe:**
```env
DB_CONNECTION=pgsql
DB_HOST=centerbeam.proxy.rlwy.net  ← PUBLIC ENDPOINT
DB_PORT=52027
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=PassWord
```

**Gebruik ALLEEN:**
```env
DATABASE_URL=${{Postgres.DATABASE_URL}}
```

### Generate APP_KEY

Na het toevoegen van de variabelen:
```bash
railway run php artisan key:generate
```

