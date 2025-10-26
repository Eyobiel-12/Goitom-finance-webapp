<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur {{ $invoice->number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: white;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background: white;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #d4af37;
        }
        
        .company-info h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0b0b0b;
            margin-bottom: 10px;
        }
        
        .company-info p {
            color: #666;
            margin-bottom: 5px;
        }
        
        .invoice-details {
            text-align: right;
        }
        
        .invoice-details h2 {
            font-size: 24px;
            color: #d4af37;
            margin-bottom: 10px;
        }
        
        .invoice-details p {
            color: #666;
            margin-bottom: 5px;
        }
        
        .client-info {
            margin-bottom: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .client-info h3 {
            color: #0b0b0b;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .client-info p {
            margin-bottom: 5px;
            color: #666;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th {
            background: #0b0b0b;
            color: white;
            padding: 15px 10px;
            text-align: left;
            font-weight: 600;
        }
        
        .items-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #eee;
        }
        
        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .totals {
            margin-left: auto;
            width: 300px;
        }
        
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        
        .totals .total-row {
            font-weight: 700;
            font-size: 16px;
            background: #d4af37;
            color: white;
        }
        
        .totals .total-row td {
            border-bottom: none;
        }
        
        .notes {
            margin-top: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .notes h3 {
            color: #0b0b0b;
            margin-bottom: 10px;
        }
        
        .notes p {
            color: #666;
            line-height: 1.6;
        }
        
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-draft { background: #f3f4f6; color: #374151; }
        .status-sent { background: #fef3c7; color: #92400e; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        .status-cancelled { background: #f3f4f6; color: #6b7280; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>{{ $invoice->organization->name }}</h1>
                @if($invoice->organization->vat_number)
                    <p>BTW: {{ $invoice->organization->vat_number }}</p>
                @endif
                <p>{{ $invoice->organization->country }}</p>
            </div>
            
            <div class="invoice-details">
                <h2>FACTUUR</h2>
                <p><strong>Nummer:</strong> {{ $invoice->number }}</p>
                <p><strong>Datum:</strong> {{ $invoice->issue_date->format('d-m-Y') }}</p>
                @if($invoice->due_date)
                    <p><strong>Vervaldatum:</strong> {{ $invoice->due_date->format('d-m-Y') }}</p>
                @endif
                <p><strong>Status:</strong> 
                    <span class="status-badge status-{{ $invoice->status }}">
                        @switch($invoice->status)
                            @case('draft') Concept @break
                            @case('sent') Verzonden @break
                            @case('paid') Betaald @break
                            @case('overdue') Achterstallig @break
                            @case('cancelled') Geannuleerd @break
                        @endswitch
                    </span>
                </p>
            </div>
        </div>
        
        <!-- Client Information -->
        <div class="client-info">
            <h3>Factuur voor:</h3>
            <p><strong>{{ $invoice->client->name }}</strong></p>
            @if($invoice->client->contact_name)
                <p>Contact: {{ $invoice->client->contact_name }}</p>
            @endif
            @if($invoice->client->email)
                <p>Email: {{ $invoice->client->email }}</p>
            @endif
            @if($invoice->client->phone)
                <p>Telefoon: {{ $invoice->client->phone }}</p>
            @endif
            @if($invoice->client->address)
                <p>
                    {{ $invoice->client->address['street'] ?? '' }}<br>
                    {{ $invoice->client->address['postal_code'] ?? '' }} {{ $invoice->client->address['city'] ?? '' }}<br>
                    {{ $invoice->client->address['country'] ?? '' }}
                </p>
            @endif
            @if($invoice->client->tax_id)
                <p>BTW: {{ $invoice->client->tax_id }}</p>
            @endif
        </div>
        
        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Omschrijving</th>
                    <th class="text-right">Aantal</th>
                    <th class="text-right">Prijs</th>
                    <th class="text-right">BTW</th>
                    <th class="text-right">Totaal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ number_format($item->qty, 2) }}</td>
                    <td class="text-right">€ {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->vat_rate, 1) }}%</td>
                    <td class="text-right">€ {{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotaal:</td>
                    <td class="text-right">€ {{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>BTW:</td>
                    <td class="text-right">€ {{ number_format($invoice->vat_total, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Totaal:</td>
                    <td class="text-right">€ {{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>
        
        <!-- Notes -->
        @if($invoice->notes)
        <div class="notes">
            <h3>Opmerkingen</h3>
            <p>{{ $invoice->notes }}</p>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            <p>Deze factuur is gegenereerd door Goitom Finance</p>
            <p>Voor vragen kunt u contact opnemen met {{ $invoice->organization->name }}</p>
        </div>
    </div>
</body>
</html>
