# Railway Quick Setup

## Environment Variables (Copy deze naar Railway Dashboard)

Ga naar: https://railway.com/project/be61fba8-22da-4b81-a3a5-c27b74d9e7b5

Selecteer je **app service** → Settings → Variables

### Voeg deze toe (een voor een):

```
DATABASE_URL
${{Postgres.DATABASE_URL}}

APP_ENV
production

APP_DEBUG
false

APP_URL
https://goitom-finance-production.up.railway.app

APP_KEY
base64:zDsVuApscXYIdqYchnvXjuF/DyV15QV87eWBtlc2cX4=

MAIL_MAILER
smtp

MAIL_HOST
smtp.hostinger.com

MAIL_PORT
465

MAIL_USERNAME
info@goitomfinance.email

MAIL_PASSWORD
Mydude12=

MAIL_ENCRYPTION
ssl

MAIL_FROM_ADDRESS
info@goitomfinance.email

MAIL_FROM_NAME
Goitom Finance

QUEUE_CONNECTION
database

FILESYSTEM_DISK
public
```

## Na het toevoegen van alle variables:

### Open Railway Shell en run:

```bash
php artisan migrate --force
php artisan storage:link
```

## Klaar! 🚀

De applicatie wordt automatisch gedeployed via Docker!

