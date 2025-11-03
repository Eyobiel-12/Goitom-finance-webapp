# GitHub Verbinden met Railway

## Probleem
GitHub is niet verbonden met Railway, dus automatische deployments worden niet getriggerd.

## Oplossing: Connect GitHub via Railway Dashboard

### Stap 1: Open Railway Dashboard
Ga naar: https://railway.com/project/be61fba8-22da-4b81-a3a5-c27b74d9e7b5/settings

### Stap 2: Settings → GitHub
1. Klik op **"Settings"** in je project
2. Klik op **"GitHub"** tab
3. Klik op **"Connect GitHub"** button

### Stap 3: Authorize Railway
1. GitHub OAuth popup verschijnt
2. Klik op **"Authorize Railway"**
3. Selecteer repository: **"Goitom-finance-webapp"**
4. Klik op **"Connect"**

### Stap 4: Configure Settings
Na het verbinden:
1. Set **Automatic Deployments** = `ON`
2. Set **Deploy on Push** = `ON`
3. Set **Branch** = `main`

### Stap 5: Trigger Deployment
Na het verbinden van GitHub, trigger een nieuwe deployment:

**Methode 1: Redeploy in Dashboard**
1. Ga naar je **goitom-finance** service
2. Klik op **"..."** menu
3. Selecteer **"Redeploy"**

**Methode 2: Push naar GitHub**
```bash
# Als GitHub al verbonden is, trigger een lege commit:
git commit --allow-empty -m "Redeploy on Railway"
git push
```

## Alternatief: Deploy via Railway CLI (zonder GitHub)

Als je GitHub niet wilt verbinden:

### Redeploy via CLI:
1. Open Railway Shell in dashboard (zie service → Settings → Shell)
2. Run commando's direct daar

### Of gebruik Railway UI:
1. Ga naar service
2. Click "Deployments" 
3. Click "Redeploy" voor laatste deployment

## Verificatie
Na GitHub connectie:
- Push naar main branch zou automatisch deployment triggeren
- Check "Deployments" tab in Railway dashboard
- Success = Groene check mark
- Failure = Rode X met logs

## Belangrijk
Met GitHub connected:
- Elke `git push` triggert nieuwe deployment
- Automatische builds en deploys
- Logs beschikbaar in Railway dashboard

