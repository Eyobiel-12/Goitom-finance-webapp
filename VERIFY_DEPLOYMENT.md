# Verificeer Railway Deployment

## 1. Check Variables in Dashboard

Ga naar: https://railway.com/project/be61fba8-22da-4b81-a3a5-c27b74d9e7b5

### In je APP service (niet Postgres):
- Settings → Variables
- Controleer dat deze variabelen aanwezig zijn:

✅ DATABASE_URL
✅ APP_ENV
✅ APP_DEBUG
✅ APP_URL
✅ APP_KEY
✅ MAIL_MAILER
✅ MAIL_HOST
✅ MAIL_PORT
✅ MAIL_USERNAME
✅ MAIL_PASSWORD
✅ MAIL_ENCRYPTION
✅ MAIL_FROM_ADDRESS
✅ MAIL_FROM_NAME
✅ QUEUE_CONNECTION
✅ FILESYSTEM_DISK

## 2. Check Deployments

### In je APP service:
- Ga naar **"Deployments"** tab
- Check of de laatste deployment **successful** is
- Als er errors zijn, check de logs

## 3. Run Migrations

### Open Railway Shell (in APP service):
```bash
php artisan migrate --force
```

Als succesvol:
```bash
php artisan storage:link
```

## 4. Check Application URL

Je applicatie zou moeten werken op:
https://goitom-finance-production.up.railway.app

## 5. Test de Applicatie

1. Open: https://goitom-finance-production.up.railway.app
2. Test registratie/login
3. Check of alles werkt

## Mogelijke Issues

### Issue: "Application Key Not Set"
**Fix:** Check of APP_KEY correct is ingesteld

### Issue: "Database Connection Error"
**Fix:** Check DATABASE_URL variable

### Issue: "Storage Link Not Found"
**Fix:** Run `php artisan storage:link` in Railway Shell

### Issue: "Migration Error"
**Fix:** Check database permissions en run migrations opnieuw

## Deployment Success Criteria

✅ Health check returns 200 OK
✅ Login page loads correctly
✅ Database migrations run successfully
✅ No errors in Railway logs
✅ Application responds to requests

