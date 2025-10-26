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
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #ffffff;
            color: #1a1a1a;
            line-height: 1.6;
        }
        
        :root {
            --primary-color: {{ $invoice->organization->settings['pdf_primary_color'] ?? '#1e40af' }};
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid var(--primary-color);
        }
        .company-info h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        .company-info .tagline {
            color: #4b5563;
            font-size: 11px;
            font-weight: 400;
            font-style: italic;
        }
        .invoice-header {
            text-align: right;
        }
        .invoice-header h2 {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-family: 'Georgia', serif;
        }
        .invoice-number {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            background: var(--primary-color);
            color: white;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 600;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-box {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 15px;
        }
        .info-box h3 {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
            text-transform: uppercase;
            font-family: 'Arial', sans-serif;
        }
        .info-box p {
            font-size: 11px;
            color: #1a1a1a;
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
            border: 1px solid #d1d5db;
        }
        thead {
            background: var(--primary-color);
        }
        th {
            padding: 10px 12px;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 11px;
            font-family: 'Arial', sans-serif;
        }
        th:first-child {
            border-top-left-radius: 4px;
        }
        th:last-child {
            border-top-right-radius: 4px;
            text-align: right;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #1a1a1a;
            font-size: 11px;
        }
        td:last-child {
            text-align: right;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .totals-box {
            background: #f9fafb;
            border: 2px solid var(--primary-color);
            border-radius: 4px;
            padding: 15px;
            width: 280px;
            margin-left: auto;
            margin-top: 20px;
        }
        .totals-box h3 {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            text-transform: uppercase;
            font-family: 'Arial', sans-serif;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
            color: #1a1a1a;
        }
        .total-row:last-child {
            margin-bottom: 0;
        }
        .total-divider {
            height: 2px;
            background: var(--primary-color);
            margin: 12px 0;
        }
        .final-total {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
        }
        .notes {
            margin-top: 25px;
            padding: 15px;
            background: #f9fafb;
            border: 1px solid #d1d5db;
            border-left: 4px solid var(--primary-color);
        }
        .notes p {
            color: #4b5563;
            font-size: 12px;
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
                <img src="{{ public_path('storage/' . $invoice->organization->logo_path) }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                @endif
                <h1>{{ $invoice->organization->name }}</h1>
                @if($invoice->organization->tagline)
                <p class="tagline">{{ $invoice->organization->tagline }}</p>
                @endif
            </div>
            <div class="invoice-header">
                <h2>Factuur</h2>
                <div class="invoice-number">#{{ $invoice->number }}</div>
                <div class="status-badge">{{ ucfirst($invoice->status) }}</div>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <!-- Company Details -->
            <div class="info-box">
                <h3>Van</h3>
                <p>{{ $invoice->organization->name }}</p>
                @if($invoice->organization->owner)
                <p>{{ $invoice->organization->owner->email }}</p>
                @endif
            </div>

            <!-- Invoice To -->
            <div class="info-box">
                <h3>Aan</h3>
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
                    <th>Stukprijs</th>
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
                <span>TOTAAL</span>
                <span>€{{ number_format($invoice->total, 2, ',', '.') }}</span>
            </div>
        </div>

        @if($invoice->notes)
        <div class="notes">
            <p><strong>Opmerkingen:</strong> {{ $invoice->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div style="text-align: center; margin-top: 30px; padding-top: 15px; border-top: 2px solid #d1d5db;">
            <p style="color: #1a1a1a; font-weight: 600; font-size: 11px; margin-bottom: 4px;">{{ $invoice->organization->name }}</p>
            <p style="color: #6b7280; font-size: 10px; font-style: italic;">{{ $invoice->organization->settings['pdf_footer_message'] ?? 'Bedankt voor uw vertrouwen' }}</p>
        </div>
    </div>
</body>
</html>

