# Database Environment Variable toevoegen

Je moet **nog één extra variabele** toevoegen aan de "web" service in Railway:

## Stap 1: Ga naar Railway Dashboard

1. Ga naar https://railway.app
2. Selecteer je project "insightful-imagination"
3. Klik op de "web" service
4. Klik op het tabblad "Variables"
5. Klik "+ New Variable"

## Stap 2: Voeg DB_CONNECTION toe

- **Name**: `DB_CONNECTION`
- **Value**: `pgsql`

Klik "Add"

## Stap 3: Wacht op herstart

De service herstart automatisch. Dit kan 1-2 minuten duren.

## Stap 4: Test de applicatie

Ga naar: https://web-production-e2c4c.up.railway.app

---

## Alternatief: Check config/database.php

Als het nog steeds niet werkt, controleer of `config/database.php` correct is geconfigureerd voor PostgreSQL.

