<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Reset - Goitom Finance</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #e0e0e0;
            background-color: #1a1a1a;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #2a2a2a;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            border: 1px solid #3a3a3a;
        }
        .header {
            background-color: #d4af37;
            color: #1a1a1a;
            padding: 15px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .content {
            padding: 20px 0;
            text-align: center;
        }
        .otp-code {
            display: inline-block;
            background-color: #d4af37;
            color: #1a1a1a;
            font-size: 36px;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 8px;
            margin: 20px 0;
            letter-spacing: 3px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .warning {
            background-color: #ff6b6b;
            color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #3a3a3a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Wachtwoord Reset
        </div>
        <div class="content">
            <p>Je hebt een wachtwoord reset aangevraagd.</p>
            <p>Gebruik de volgende code om je wachtwoord te resetten:</p>
            <div class="otp-code">{{ $otpCode }}</div>
            <p>Deze code is 10 minuten geldig.</p>
            <div class="warning">
                ⚠️ Als je deze e-mail niet hebt aangevraagd, negeer dan deze e-mail en verander je wachtwoord via je accountinstellingen.
            </div>
            <p>Als je vragen hebt, neem dan gerust contact met ons op.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Goitom Finance. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>
</html>

