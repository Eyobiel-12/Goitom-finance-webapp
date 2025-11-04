# Anti-Spam Email Setup - Goitom Finance

## ✅ Wat is geïmplementeerd

### 1. BaseMail Class met Anti-Spam Headers
- **Precedence**: Bulk header (voorkomt auto-replies)
- **List-Unsubscribe**: Verplicht voor marketing emails
- **X-Priority**: Normale prioriteit
- **Auto-Submitted**: Voorkomt auto-replies
- **Return-Path**: Gelijk aan from address
- **Message-ID**: Unieke message ID met juiste domain
- **X-Mailer**: Identificeert applicatie
- **X-Auto-Response-Suppress**: Voorkomt auto-replies

### 2. Alle Mail Classes Bijgewerkt
- ✅ `InvoiceSentMail` - Factuur emails
- ✅ `WelcomeMail` - Welkom emails
- ✅ `OtpVerificationMail` - OTP verificatie
- ✅ `PasswordResetOtpMail` - Password reset
- ✅ `TrialExpiredMail` - Trial expiry
- ✅ `PaymentLastWarningMail` - Payment warnings

### 3. Email Templates
- ✅ Unsubscribe link toegevoegd aan invoice email template
- ✅ Unsubscribe route en pagina toegevoegd

### 4. Mail Configuratie
- ✅ SSL verificatie toegevoegd
- ✅ Proper EHLO domain configuratie

## 🔧 DNS Configuratie (VERPLICHT)

Voor beste deliverability moet je de volgende DNS records toevoegen:

### SPF Record
```
Type: TXT
Name: @ (of je domeinnaam)
Value: v=spf1 include:_spf.hostinger.com ~all
TTL: 3600
```

### DKIM Record
DKIM wordt meestal automatisch geconfigureerd door Hostinger. Check je Hostinger email panel voor de DKIM keys.

### DMARC Record
```
Type: TXT
Name: _dmarc
Value: v=DMARC1; p=quarantine; rua=mailto:info@goitomfinance.email; ruf=mailto:info@goitomfinance.email; pct=100
TTL: 3600
```

**DMARC Policy Uitleg:**
- `p=quarantine`: Quarantine verdachte emails (niet reject)
- `p=reject`: Reject verdachte emails (strikt)
- `p=none`: Alleen monitoren (aanbevolen voor start)

**Voor productie start met `p=none` en monitoren voor 1-2 weken, dan pas naar `quarantine` of `reject`.**

## 📧 .env Configuratie

Zorg dat je `.env` de volgende instellingen heeft:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@goitomfinance.email
MAIL_PASSWORD=jouw_wachtwoord
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@goitomfinance.email
MAIL_FROM_NAME="Goitom Finance"
MAIL_EHLO_DOMAIN=goitomfinance.email
APP_URL=https://jouw-domein.com
```

## ✅ Best Practices voor Email Deliverability

### 1. Email Content
- ✅ **Geen spam trigger woorden**: Vermijd "GRATIS", "WINST", "BELEG NU", etc.
- ✅ **Goede HTML structuur**: Proper HTML emails
- ✅ **Tekst-bij-beeld ratio**: Minimaal 60% tekst, maximaal 40% images
- ✅ **Geen grote attachments**: PDF's zijn OK, maar geen grote bestanden
- ✅ **Unsubscribe link**: Altijd zichtbaar in footer

### 2. Sending Behavior
- ✅ **Geen mass mailing**: Gebruik queues voor bulk emails
- ✅ **Warme sender**: Start met lage volumes en bouw op
- ✅ **Clean mailing list**: Verwijder bounced/unsubscribed emails
- ✅ **Consistent sending**: Regelmatige sending patterns

### 3. Technical Setup
- ✅ **SSL/TLS**: Altijd encrypted connections
- ✅ **Proper headers**: Alle anti-spam headers geconfigureerd
- ✅ **Return-Path**: Gelijk aan from address
- ✅ **Message-ID**: Unieke IDs met juiste domain

## 🧪 Testen

### Test Email Verzenden
```bash
php artisan tinker
```

```php
\Illuminate\Support\Facades\Mail::raw('Test email', function($m) {
    $m->to('jouw@email.com')->subject('Test Email');
});
```

### Check Email Headers
Gebruik tools zoals:
- **Mail-Tester.com**: Gratis email testing tool
- **MXToolbox**: SPF/DKIM/DMARC checker
- **Gmail Spam Check**: Test in Gmail inbox

### Test Resultaten
- **Score > 8/10**: Goede deliverability
- **Score 6-8/10**: Acceptabel, maar kan beter
- **Score < 6/10**: Check DNS records en email content

## 📊 Monitoring

### Check Email Logs
```bash
tail -f storage/logs/laravel.log | grep -i mail
```

### Monitor Bounces
- Check je email provider dashboard voor bounce rates
- Verwijder bounced email addresses direct
- Monitor spam complaints

## 🚨 Troubleshooting

### Emails komen in spam
1. **Check DNS records**: SPF, DKIM, DMARC correct?
2. **Check email content**: Geen spam trigger woorden?
3. **Check sender reputation**: Warme sender IP?
4. **Check headers**: Alle anti-spam headers aanwezig?
5. **Test met Mail-Tester**: Check score

### Emails worden niet verzonden
1. **Check .env configuratie**: SMTP settings correct?
2. **Check firewall**: Poort 465 open?
3. **Check credentials**: Username/password correct?
4. **Check logs**: `storage/logs/laravel.log`

### SSL/TLS Errors
1. **Check MAIL_ENCRYPTION**: Moet `ssl` of `tls` zijn
2. **Check MAIL_PORT**: 465 voor SSL, 587 voor TLS
3. **Check verify_peer**: In config/mail.php op `true` staan

## 📚 Extra Resources

- [SPF Record Generator](https://www.spfrecord.com/)
- [DMARC Record Generator](https://www.dmarcanalyzer.com/)
- [Mail-Tester](https://www.mail-tester.com/)
- [MXToolbox](https://mxtoolbox.com/)

## ⚠️ Belangrijk

1. **DNS Records zijn VERPLICHT** voor goede deliverability
2. **Start met DMARC `p=none`** en monitoren
3. **Warme sender** - Start met lage volumes
4. **Monitor bounce rates** en verwijder bounced emails
5. **Test regelmatig** met Mail-Tester

