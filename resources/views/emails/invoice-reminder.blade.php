<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herinnering: {{ $invoice->number }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 3px solid #d4af37;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #1a1a1a;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .invoice-details {
            background-color: #f9f9f9;
            border-left: 4px solid #d4af37;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .invoice-details h2 {
            margin-top: 0;
            color: #d4af37;
            font-size: 18px;
        }
        .invoice-details p {
            margin: 8px 0;
            color: #666;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #d4af37;
            margin: 15px 0;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .cta-button {
            display: inline-block;
            background-color: #d4af37;
            color: #1a1a1a;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Herinnering: Openstaande Factuur</h1>
        </div>

        <div class="content">
            <p>Beste {{ $invoice->client->contact_name ?? $invoice->client->name }},</p>

            <p>Dit is een vriendelijke herinnering dat onderstaande factuur nog openstaat.</p>

            @if($daysOverdue > 0)
            <div class="warning">
                <strong>⚠️ Deze factuur is {{ $daysOverdue }} dag(en) achterstallig.</strong>
            </div>
            @endif

            <div class="invoice-details">
                <h2>Factuur Details</h2>
                <p><strong>Factuurnummer:</strong> {{ $invoice->number }}</p>
                <p><strong>Factuurdatum:</strong> {{ $invoice->issue_date->format('d-m-Y') }}</p>
                @if($invoice->due_date)
                <p><strong>Vervaldatum:</strong> {{ $invoice->due_date->format('d-m-Y') }}</p>
                @endif
                <div class="amount">
                    Openstaand bedrag: {{ number_format($invoice->total, 2, ',', '.') }} {{ $invoice->currency }}
                </div>
            </div>

            <p>We verzoeken u vriendelijk om betaling zo spoedig mogelijk te verrichten.</p>

            <p>
                U kunt de factuur als PDF downloaden via deze link:
                <a href="{{ config('app.url') }}/app/invoices/{{ $invoice->id }}/pdf" style="color:#d4af37; font-weight:bold;">
                    Factuur {{ $invoice->number }} downloaden
                </a>
            </p>

            <p>Voor vragen over deze factuur kunt u contact met ons opnemen.</p>

            <p>Met vriendelijke groet,<br>
            <strong>{{ $organization->name }}</strong></p>
        </div>

        <div class="footer">
            <p>{{ $organization->name }}<br>
            @if($organization->tagline)
            {{ $organization->tagline }}<br>
            @endif
            <a href="mailto:{{ $organization->owner->email ?? config('mail.from.address') }}">{{ $organization->owner->email ?? config('mail.from.address') }}</a></p>
        </div>
    </div>
</body>
</html>

