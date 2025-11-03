# Railway Environment Variables Setup

Railway CLI vereist interactieve mode voor het linken van services. Hier zijn de stappen om environment variables in Railway Dashboard in te stellen:

## Stap 1: Ga naar Railway Dashboard

1. Open: https://railway.com/project/be61fba8-22da-4b81-a3a5-c27b74d9e7b5
2. Selecteer je **app service** (niet de Postgres service)
3. Ga naar **Settings** → **Variables**

## Stap 2: Voeg Variables toe

Klik op **"Add Variable"** en voeg deze toe (een voor een):

### Database (PRIVATE ENDPOINT - geen egress fees)
```
Variable: DATABASE_URL
Value: ${{Postgres.DATABASE_URL}}
```

### App Settings
```
Variable: APP_ENV
Value: production

Variable: APP_DEBUG
Value: false

Variable: APP_URL
Value: https://goitom-finance-production.up.railway.app
```

### Mail Settings
```
Variable: MAIL_MAILER
Value: smtp

Variable: MAIL_HOST
Value: smtp.hostinger.com

Variable: MAIL_PORT
Value: 465

Variable: MAIL_USERNAME
Value: info@goitomfinance.email

Variable: MAIL_PASSWORD
Value: Mydude12=

Variable: MAIL_ENCRYPTION
Value: ssl

Variable: MAIL_FROM_ADDRESS
Value: info@goitomfinance.email

Variable: MAIL_FROM_NAME
Value: Goitom Finance
```

### Queue & Storage
```
Variable: QUEUE_CONNECTION
Value: database

Variable: FILESYSTEM_DISK
Value: public
```

## Stap 3: Generate APP_KEY

Na het toevoegen van bovenstaande variables, open Railway Shell en run:

```bash
railway shell
php artisan key:generate
```

Voeg daarna toe:
```
Variable: APP_KEY
Value: <het gegenereerde key>
```

OF in Railway UI → Shell:
```bash
php artisan key:generate --show
```

## Stap 4: Run Migrations

In Railway Shell:
```bash
php artisan migrate --force
php artisan storage:link
```

## Automatische Deployment

Na het toevoegen van alle variables, Railway zal automatisch:
1. De Docker image builden
2. De applicatie deployen
3. Health checks uitvoeren

## Verificatie

Check de deploy logs:
```bash
railway logs
```

Check environment variables:
```bash
railway variables
```

