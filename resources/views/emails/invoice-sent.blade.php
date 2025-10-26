<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur {{ $invoice->number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #1a1a1a;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #d4af37;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .header {
            background: linear-gradient(135deg, #d4af37 0%, #b8941e 100%);
            padding: 30px;
            text-align: center;
            color: #1a1a1a;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            color: #1a1a1a;
        }
        .content {
            padding: 30px;
            color: #e0e0e0;
        }
        .greeting {
            color: #d4af37;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .intro-text {
            color: #cccccc;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        .invoice-box {
            background: linear-gradient(135deg, #2a2a2a 0%, #1f1f1f 100%);
            border: 1px solid #d4af37;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        .invoice-box strong {
            color: #d4af37;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .invoice-details {
            color: #e0e0e0 !important;
            margin-top: 15px;
            line-height: 2;
        }
        .invoice-details div {
            color: #ffffff !important;
        }
        .invoice-number {
            font-size: 20px;
            font-weight: bold;
            color: #d4af37;
        }
        .amount-highlight {
            font-size: 24px;
            font-weight: bold;
            color: #d4af37;
            margin: 10px 0;
        }
        .notes-box {
            background: #2a2a2a;
            border-left: 4px solid #d4af37;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .notes-box strong {
            color: #d4af37;
        }
        .footer {
            background: #0f0f0f;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #333333;
        }
        .footer p {
            color: #666666;
            font-size: 14px;
            margin: 5px 0;
        }
        .signature {
            color: #d4af37;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            @if($organization->logo_path)
            <div style="text-align: center; margin-bottom: 15px;">
                <img src="{{ Storage::url($organization->logo_path) }}" alt="{{ $organization->name }}" style="max-height: 60px; object-fit: contain;">
            </div>
            @endif
            <h1>📄 Uw Factuur</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">Beste {{ $invoice->client->contact_name ?? $invoice->client->name }},</div>
            
            <div class="intro-text">
                Hartelijk dank voor uw vertrouwen in <strong style="color: #d4af37;">{{ $organization->name }}</strong>.
            </div>
            
            <div class="intro-text">
                Bij deze ontvangt u factuur <span class="invoice-number">{{ $invoice->number }}</span> 
                voor een totaalbedrag van <span class="amount-highlight">€{{ number_format($invoice->total, 2, ',', '.') }}</span>.
            </div>
            
            <!-- Invoice Details Box -->
            <div style="background: #2a2a2a; border: 2px solid #d4af37; border-radius: 12px; padding: 25px; margin: 25px 0;">
                <strong style="color: #d4af37; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold;">📋 Factuurdetails</strong>
                <div style="margin-top: 20px; line-height: 3;">
                    <div style="margin-bottom: 12px;"><strong style="color: #d4af37; font-weight: bold;">Factuurnummer:</strong> <span style="color: #ffffff; font-weight: bold; font-size: 16px;">{{ $invoice->number }}</span></div>
                    <div style="margin-bottom: 12px;"><strong style="color: #d4af37; font-weight: bold;">Factuurdatum:</strong> <span style="color: #ffffff; font-weight: bold;">{{ $invoice->issue_date->format('d-m-Y') }}</span></div>
                    <div style="margin-bottom: 12px;"><strong style="color: #d4af37; font-weight: bold;">Vervaldatum:</strong> <span style="color: #ffffff; font-weight: bold;">{{ $invoice->due_date?->format('d-m-Y') ?? 'Niet gespecificeerd' }}</span></div>
                    <div style="margin-bottom: 12px;"><strong style="color: #d4af37; font-weight: bold;">Bedrag (incl. BTW):</strong> <span style="color: #ffffff; font-weight: bold; font-size: 18px;">€{{ number_format($invoice->total, 2, ',', '.') }}</span></div>
                </div>
            </div>
            
            <div class="intro-text">
                De bijgevoegde PDF kunt u downloaden en bewaren voor uw administratie.
            </div>
            
            @if($invoice->notes)
            <div class="notes-box">
                <strong>📝 Opmerkingen:</strong>
                <p style="color: #cccccc; margin: 10px 0 0 0;">{{ $invoice->notes }}</p>
            </div>
            @endif
            
            <div class="intro-text">
                Met vriendelijke groet,<br>
                <span class="signature">{{ $organization->name }}</span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} {{ $organization->name }}</p>
            <p>Professionele Financiële Diensten</p>
        </div>
    </div>
</body>
</html>
