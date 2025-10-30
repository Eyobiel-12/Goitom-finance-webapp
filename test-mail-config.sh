#!/bin/bash
echo "Current Mail Configuration:"
echo "MAIL_MAILER: $(php artisan tinker --execute='echo config("mail.default");')"
echo "MAIL_HOST: $(php artisan tinker --execute='echo config("mail.mailers.smtp.host");')"
echo "MAIL_PORT: $(php artisan tinker --execute='echo config("mail.mailers.smtp.port");')"
echo "MAIL_ENCRYPTION: $(php artisan tinker --execute='echo config("mail.mailers.smtp.encryption", "NOT SET");')"
echo "MAIL_USERNAME: $(php artisan tinker --execute='echo config("mail.mailers.smtp.username");')"
echo "MAIL_FROM: $(php artisan tinker --execute='echo config("mail.from.address");')"
