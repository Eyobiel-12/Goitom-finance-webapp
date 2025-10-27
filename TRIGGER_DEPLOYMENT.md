# Trigger Deployment Manueel

## Het probleem
Push naar GitHub is gedaan (commit 128f83c), maar Railway heeft geen nieuwe deployment getriggerd.

## Oplossing 1: Wacht & Check Automatic Trigger

Railway zou automatisch een nieuwe deployment moeten triggeren binnen enkele minuten. Check:

1. Ga naar: https://railway.com/project/be61fba8-22da-4b81-a3a5-c27b74d9e7b5
2. Klik op je "goitom-finance" service
3. Ga naar "Deployments" tab
4. Check of er een nieuwe deployment is (meest recent bovenaan)

## Oplossing 2: Trigger Manual Redeploy

Als er geen nieuwe deployment is:

1. Ga naar je **goitom-finance** service in Railway
2. Klik op de **"..."** menu (3 dots rechtsboven)
3. Selecteer **"Redeploy"**
4. Of klik op **"Deployments"** tab → **"Manual Deploy"**

## Oplossing 3: Check GitHub Integration

Als Railway helemaal niet triggert:

1. Ga naar Railway Dashboard → Settings → **GitHub**
2. Check dat de repository correct is gekoppeld
3. Check dat automatische deployments aan staan

## Oplossing 4: Force Push (laatste redmiddel)

Als niets werkt:

```bash
git commit --allow-empty -m "Trigger deployment"
git push
```

## Wat er gefixt is

De laatste commit voegt toe:
- `libicu-dev` (voor intl extension)
- `docker-php-ext-install intl zip pdo_pgsql pgsql` (installeert de PHP extensions)

Dit zou het probleem moeten oplossen.

## Verificatie na deployment

Na een succesvolle deployment, check de logs voor:

```
✅ PHP extensions installed
✅ Composer install succeeded
✅ npm run build succeeded
```

Als er nog steeds errors zijn, deel de logs met mij.

