<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factuur {{ $invoice->number }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #d4af37;">Beste {{ $invoice->client->contact_name ?? $invoice->client->name }},</h1>
        
        <p>Hartelijk dank voor uw vertrouwen in {{ $organization->name }}.</p>
        
        <p>Bij deze ontvangt u factuur <strong>{{ $invoice->number }}</strong> voor een totaalbedrag van 
        <strong>€{{ number_format($invoice->total, 2, ',', '.') }}</strong>.</p>
        
        <div style="background: #f5f5f5; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <strong>Factuurdetails:</strong><br>
            Factuurnummer: {{ $invoice->number }}<br>
            Factuurdatum: {{ $invoice->issue_date->format('d-m-Y') }}<br>
            Vervaldatum: {{ $invoice->due_date?->format('d-m-Y') ?? 'Niet gespecificeerd' }}<br>
            Bedrag (incl. BTW): €{{ number_format($invoice->total, 2, ',', '.') }}
        </div>
        
        <p>De bijgevoegde PDF kunt u downloaden en bewaren voor uw administratie.</p>
        
        @if($invoice->notes)
        <div style="margin-top: 20px;">
            <strong>Opmerkingen:</strong>
            <p>{{ $invoice->notes }}</p>
        </div>
        @endif
        
        <p style="margin-top: 30px;">
            Met vriendelijke groet,<br>
            {{ $organization->name }}
        </p>
    </div>
</body>
</html>
