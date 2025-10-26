# E-mail Setup voor Goitom Finance

## Hostinger E-mail Configuratie

Voeg de volgende regels toe aan je `.env` bestand:

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

## Test E-mail

Voer het volgende commando uit om te testen of e-mail werkt:

```bash
php artisan tinker
```

En dan in de tinker console:
```php
\Illuminate\Support\Facades\Mail::raw('Test email', function($m) {
    $m->to('jouw@email.com')->subject('Test');
});
```

## Queue Worker (Als je queues gebruikt)

Start de queue worker:
```bash
php artisan queue:work
```

## Troubleshooting

1. **Check logs**: `storage/logs/laravel.log`
2. **Clear config cache**: `php artisan config:clear`
3. **Check firewall**: Hostinger SMTP poort 465 moet open zijn
4. **Test SMTP connectie**: Gebruik een e-mail test tool of Mailtrap

