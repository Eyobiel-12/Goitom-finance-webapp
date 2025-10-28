<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Factuur {{ $invoice->number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: #ffffff;
            color: #000000;
            line-height: 1.8;
        }
        
        :root {
            --primary-color: {{ $invoice->organization->settings['pdf_primary_color'] ?? '#000000' }};
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 50px 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }
        .company-info h1 {
            font-size: 20px;
            font-weight: 400;
            color: #000000;
            margin-bottom: 5px;
        }
        .company-info .tagline {
            color: #666666;
            font-size: 11px;
            font-weight: 400;
        }
        .invoice-header {
            text-align: right;
        }
        .invoice-header h2 {
            font-size: 24px;
            font-weight: 300;
            color: var(--primary-color);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .invoice-number {
            font-size: 12px;
            font-weight: 400;
            color: #000000;
            margin-bottom: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #000000;
            color: white;
            border-radius: 2px;
            font-size: 9px;
            font-weight: 400;
            letter-spacing: 1px;
        }
        .divider {
            height: 1px;
            background: #000000;
            margin: 30px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-box {
            background: transparent;
            padding: 0;
        }
        .info-box h3 {
            font-size: 9px;
            font-weight: 400;
            color: #666666;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .info-box p {
            font-size: 11px;
            color: #000000;
            margin-bottom: 4px;
            line-height: 1.6;
        }
        .info-box p:last-child {
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        thead {
            background: transparent;
        }
        th {
            padding: 10px 10px;
            text-align: left;
            color: #000000;
            font-weight: 400;
            font-size: 10px;
            letter-spacing: 1px;
            border-bottom: 1px solid #000000;
        }
        th:last-child {
            text-align: right;
        }
        td {
            padding: 10px 10px;
            border-bottom: 1px solid #e5e5e5;
            color: #000000;
            font-size: 11px;
        }
        td:last-child {
            text-align: right;
            font-weight: 400;
        }
        .totals-box {
            background: transparent;
            padding: 0;
            width: 250px;
            margin-left: auto;
            margin-top: 20px;
        }
        .totals-box h3 {
            font-size: 9px;
            font-weight: 400;
            color: #666666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
            color: #000000;
        }
        .total-row:last-child {
            margin-bottom: 0;
        }
        .total-divider {
            height: 1px;
            background: #000000;
            margin: 15px 0;
        }
        .final-total {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 400;
            color: #000000;
            margin-top: 10px;
        }
        .notes {
            margin-top: 30px;
            padding: 15px;
            background: transparent;
            border-left: 1px solid #000000;
        }
        .notes p {
            color: #666666;
            font-size: 11px;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                @if($invoice->organization->settings['pdf_show_logo'] ?? true && $invoice->organization->logo_path)
                <img src="{{ public_path('storage/' . $invoice->organization->logo_path) }}" alt="Logo" style="height: 40px; margin-bottom: 15px;">
                @endif
                <h1>{{ $invoice->organization->name }}</h1>
                <p class="tagline">{{ $invoice->organization->tagline ?? '' }}</p>
            </div>
            <div class="invoice-header">
                <h2>FACTUUR</h2>
                <div class="invoice-number">#{{ $invoice->number }}</div>
                <div class="status-badge">{{ strtoupper($invoice->status) }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Info Grid -->
        <div class="info-grid">
            <!-- Company Details -->
            <div class="info-box">
                <h3>Bedrijfsgegevens</h3>
                <p>{{ $invoice->organization->name }}</p>
                @if($invoice->organization->owner)
                <p>{{ $invoice->organization->owner->email }}</p>
                @endif
            </div>

            <!-- Invoice To -->
            <div class="info-box">
                <h3>Factuur Aan</h3>
                <p><strong>{{ $invoice->client->name }}</strong></p>
                @if($invoice->client->contact_name)
                <p>{{ $invoice->client->contact_name }}</p>
                @endif
                @if($invoice->client->email)
                <p>{{ $invoice->client->email }}</p>
                @endif
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="info-grid" style="margin-top: 30px;">
            <div class="info-box">
                <h3>Factuurgegevens</h3>
                <p><strong>Datum:</strong> {{ $invoice->issue_date->format('d-m-Y') }}</p>
                @if($invoice->due_date)
                <p><strong>Vervaldatum:</strong> {{ $invoice->due_date->format('d-m-Y') }}</p>
                @endif
            </div>
            <div class="info-box">
                <!-- Empty for layout balance -->
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Omschrijving</th>
                    <th>Qty</th>
                    <th>Prijs</th>
                    <th>Bedrag</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format($item->qty, 2, ',', '.') }}</td>
                    <td>€{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td>€{{ number_format($item->line_total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-box">
            <h3>Totalen</h3>
            <div class="total-row">
                <span>Subtotaal:</span>
                <span>€{{ number_format($invoice->subtotal, 2, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>BTW:</span>
                <span>€{{ number_format($invoice->vat_total, 2, ',', '.') }}</span>
            </div>
            <div class="total-divider"></div>
            <div class="final-total">
                <span>TOTAAL</span>
                <span>€{{ number_format($invoice->total, 2, ',', '.') }}</span>
            </div>
        </div>

        @if($invoice->notes)
        <div class="notes">
            <p>{{ $invoice->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div style="text-align: center; margin-top: 40px; padding-top: 15px; border-top: 1px solid #e5e5e5;">
            <p style="color: #666666; font-weight: 300; font-size: 9px; letter-spacing: 1px;">{{ $invoice->organization->settings['pdf_footer_message'] ?? 'Bedankt voor je vertrouwen' }}</p>
        </div>
    </div>
</body>
</html>

