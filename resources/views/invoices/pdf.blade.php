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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: #ffffff;
            color: #1a1a1a;
            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 60px 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }
        .company-info h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        .company-info .tagline {
            color: #6b7280;
            font-size: 14px;
            font-weight: 400;
        }
        .invoice-header {
            text-align: right;
        }
        .invoice-header h2 {
            font-size: 36px;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .invoice-number {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            background: #10b981;
            color: white;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .divider {
            height: 3px;
            background: #10b981;
            margin: 30px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 30px 0;
        }
        .info-box {
            background: #f9fafb;
            border-radius: 12px;
            padding: 24px;
        }
        .info-box h3 {
            font-size: 14px;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-box p {
            font-size: 15px;
            color: #1a1a1a;
            margin-bottom: 6px;
            line-height: 1.8;
        }
        .info-box p:last-child {
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 40px 0;
        }
        thead {
            background: #10b981;
        }
        th {
            padding: 16px 20px;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.3px;
        }
        th:first-child {
            border-top-left-radius: 8px;
        }
        th:last-child {
            border-top-right-radius: 8px;
            text-align: right;
        }
        td {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
            color: #1a1a1a;
            font-size: 15px;
        }
        td:last-child {
            text-align: right;
            font-weight: 600;
        }
        .totals-box {
            background: #f9fafb;
            border-radius: 12px;
            padding: 24px;
            width: 320px;
            margin-left: auto;
            margin-top: 30px;
        }
        .totals-box h3 {
            font-size: 14px;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
            color: #1a1a1a;
        }
        .total-row:last-child {
            margin-bottom: 0;
        }
        .total-divider {
            height: 2px;
            background: #10b981;
            margin: 20px 0;
        }
        .final-total {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            font-weight: 700;
            color: #10b981;
            margin-top: 10px;
        }
        .notes {
            margin-top: 40px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 12px;
            border-left: 4px solid #10b981;
        }
        .notes p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>{{ $invoice->organization->name }}</h1>
                <p class="tagline">Professionele Financiële Diensten</p>
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
                @if($invoice->organization->settings && isset($invoice->organization->settings['address']))
                <p>{{ $invoice->organization->settings['address'] }}</p>
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
                @if($invoice->client->phone)
                <p>{{ $invoice->client->phone }}</p>
                @endif
                @if($invoice->client->address)
                <p>
                    @if(isset($invoice->client->address['street'])){{ $invoice->client->address['street'] }}<br>@endif
                    @if(isset($invoice->client->address['city'])){{ $invoice->client->address['city'] }}@endif
                    @if(isset($invoice->client->address['country'])), {{ $invoice->client->address['country'] }}@endif
                </p>
                @endif
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="info-grid" style="margin-top: 20px;">
            <div class="info-box">
                <h3>Factuurgegevens</h3>
                <p><strong>Factuurdatum:</strong> {{ $invoice->issue_date->format('d-m-Y') }}</p>
                @if($invoice->due_date)
                <p><strong>Vervaldatum:</strong> {{ $invoice->due_date->format('d-m-Y') }}</p>
                @endif
                @if($invoice->project)
                <p><strong>Project:</strong> {{ $invoice->project->name }}</p>
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
                    <th>Aantal</th>
                    <th>Prijs per Stuk</th>
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
                <span>BTW ({{ number_format(($invoice->vat_total / $invoice->subtotal) * 100, 0) }}%):</span>
                <span>€{{ number_format($invoice->vat_total, 2, ',', '.') }}</span>
            </div>
            <div class="total-divider"></div>
            <div class="final-total">
                <span>TOTAAL:</span>
                <span>€{{ number_format($invoice->total, 2, ',', '.') }}</span>
            </div>
        </div>

        @if($invoice->notes)
        <div class="notes">
            <p><strong>Opmerkingen:</strong> {{ $invoice->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div style="text-align: center; margin-top: 60px; padding-top: 30px; border-top: 2px solid #e5e7eb;">
            <p style="color: #1a1a1a; font-weight: 600; font-size: 16px; margin-bottom: 8px;">{{ $invoice->organization->name }}</p>
            <p style="color: #6b7280; font-size: 14px;">Bedankt voor je vertrouwen!</p>
        </div>
    </div>
</body>
</html>