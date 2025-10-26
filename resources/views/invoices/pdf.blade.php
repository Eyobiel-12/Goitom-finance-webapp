<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur {{ $invoice->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            color: #1a1a1a;
        }
        .header {
            border-bottom: 3px solid #d4af37;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-info {
            margin-top: 20px;
        }
        .invoice-details {
            float: right;
            text-align: right;
        }
        .client-info {
            margin: 30px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        th {
            background: #1a1a1a;
            color: #d4af37;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        .totals {
            margin-top: 30px;
            text-align: right;
        }
        .total-row {
            font-size: 18px;
            font-weight: bold;
            background: #f5f5f5;
            padding: 15px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="invoice-details">
            <h1 style="margin: 0; color: #d4af37;">FACTUUR</h1>
            <p style="margin: 5px 0;"><strong>Nummer:</strong> {{ $invoice->number }}</p>
            <p style="margin: 5px 0;"><strong>Datum:</strong> {{ $invoice->issue_date->format('d-m-Y') }}</p>
            @if($invoice->due_date)
            <p style="margin: 5px 0;"><strong>Vervaldatum:</strong> {{ $invoice->due_date->format('d-m-Y') }}</p>
            @endif
        </div>
        <div class="company-info">
            <h2>{{ $invoice->organization->name }}</h2>
            @if($invoice->organization->owner)
            <p>{{ $invoice->organization->owner->email }}</p>
            @endif
        </div>
    </div>

    <div class="client-info">
        <h3>Factuur voor:</h3>
        <p><strong>{{ $invoice->client->name }}</strong></p>
        @if($invoice->client->contact_name)
        <p>{{ $invoice->client->contact_name }}</p>
        @endif
        @if($invoice->client->email)
        <p>{{ $invoice->client->email }}</p>
        @endif
        @if($invoice->client->phone)
        <p>{{ $invoice->client->phone }}</p>
        @endif
        @if($invoice->client->address)
        <p>
            @if(isset($invoice->client->address['street'])){{ $invoice->client->address['street'] }}<br>@endif
            @if(isset($invoice->client->address['postal_code']) && isset($invoice->client->address['city'])){{ $invoice->client->address['postal_code'] }} {{ $invoice->client->address['city'] }}@endif
        </p>
        @endif
    </div>

    @if($invoice->project)
    <div style="margin: 20px 0;">
        <strong>Project:</strong> {{ $invoice->project->name }}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Beschrijving</th>
                <th style="text-align: center;">Aantal</th>
                <th style="text-align: right;">Prijs</th>
                <th style="text-align: center;">BTW %</th>
                <th style="text-align: right;">Totaal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td style="text-align: center;">{{ number_format($item->qty, 2, ',', '.') }}</td>
                <td style="text-align: right;">€{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($item->vat_rate, 0) }}%</td>
                <td style="text-align: right;">€{{ number_format($item->line_total, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div style="margin-bottom: 10px;">
            Subtotaal (excl. BTW): <strong>€{{ number_format($invoice->subtotal, 2, ',', '.') }}</strong>
        </div>
        <div style="margin-bottom: 10px;">
            BTW: <strong>€{{ number_format($invoice->vat_total, 2, ',', '.') }}</strong>
        </div>
        <div class="total-row">
            TOTAAL (incl. BTW): <strong>€{{ number_format($invoice->total, 2, ',', '.') }}</strong>
        </div>
    </div>

    @if($invoice->notes)
    <div style="margin-top: 40px;">
        <strong>Opmerkingen:</strong>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>{{ $invoice->organization->name }}</p>
        <p>Hartelijk dank voor uw zaken!</p>
    </div>
</body>
</html>