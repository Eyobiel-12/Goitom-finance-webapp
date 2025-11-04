<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uitschrijven - Goitom Finance</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 500px;
            background: #1a1a1a;
            border-radius: 12px;
            padding: 40px;
            border: 1px solid #d4af37;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        h1 {
            color: #d4af37;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }
        p {
            color: #e0e0e0;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .success {
            background: #2a2a2a;
            border: 1px solid #d4af37;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            text-align: center;
        }
        .success p {
            color: #d4af37;
            font-weight: 600;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #333333;
        }
        .footer p {
            color: #666666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Uitschrijven van E-mails</h1>
        <p>U bent succesvol uitgeschreven van onze e-maillijst.</p>
        <p>U ontvangt geen marketing e-mails meer van Goitom Finance.</p>
        <div class="success">
            <p>✓ Uitschrijving voltooid</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Goitom Finance - Alle rechten voorbehouden</p>
        </div>
    </div>
</body>
</html>

