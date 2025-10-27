# Railway Setup - Nieuwe Deployment

## Project Details
- **Project:** insightful-imagination
- **URL:** https://web-production-e2c4c.up.railway.app
- **Dashboard:** https://railway.com/project/insightful-imagination
- **GitHub:** Connected ✅

## Services
- **web** - Main application
- **queue** - Queue worker

## Environment Variables Toevoegen

Ga naar Railway Dashboard:
https://railway.com/project/insightful-imagination

### Voor beide services (web en queue):

#### Database
```
DATABASE_URL=${{Postgres.DATABASE_URL}}
```

#### App Settings
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://web-production-e2c4c.up.railway.app
APP_KEY=base64:zDsVuApscXYIdqYchnvXjuF/DyV15QV87eWBtlc2cX4=
```

#### Mail (Hostinger)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@goitomfinance.email
MAIL_PASSWORD=Mydude12=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@goitomfinance.email
MAIL_FROM_NAME=Goitom Finance
```

#### Queue & Storage
```
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public
```

## Stappen

1. ✅ GitHub is connected
2. ⏳ Wacht tot build is klaar (zie Activity log)
3. ⏳ Voeg environment variables toe (bovenstaande lijst)
4. ⏳ Check of applicatie werkt: https://web-production-e2c4c.up.railway.app

## Status
- Build in progress...
- Check "Activity" log voor updates
- Deployment status verschijnt rechts in de cards

