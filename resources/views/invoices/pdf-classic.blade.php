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
        @page {
            margin: 0;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: #ffffff;
            color: #1a1a1a;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        
        :root {
            --primary-color: {{ $invoice->organization->settings['pdf_primary_color'] ?? '#1e40af' }};
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 50px 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 2px solid var(--primary-color);
        }
        .company-info h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }
        .company-info .tagline {
            color: #6b7280;
            font-size: 12px;
            font-weight: 400;
            margin-bottom: 12px;
        }
        .invoice-header {
            text-align: right;
        }
        .invoice-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .invoice-number {
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: var(--primary-color);
            color: white;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 18px 0;
        }
        .info-box {
            background: transparent;
            border: 0;
            padding: 0;
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
        .muted { color: #4b5563; }
        .small { font-size: 10px; }
        .info-box p:last-child {
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }
        thead {
            background: var(--primary-color);
        }
        th {
            padding: 14px 16px;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 12px;
            font-family: 'Arial', sans-serif;
            letter-spacing: 0.3px;
        }
        th:first-child {
            border-top-left-radius: 4px;
        }
        th:last-child {
            border-top-right-radius: 4px;
            text-align: right;
        }
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
            color: #1a1a1a;
            font-size: 12px;
            vertical-align: top;
        }
        td:last-child {
            text-align: right;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tbody tr:hover {
            background: #f9fafb;
        }
        .totals-box {
            background: #f9fafb;
            border: 2px solid var(--primary-color);
            border-radius: 6px;
            padding: 20px;
            width: 320px;
            margin-left: auto;
            margin-top: 30px;
        }
        .totals-box h3 {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 16px;
            text-transform: uppercase;
            font-family: 'Arial', sans-serif;
            letter-spacing: 0.5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 12px;
            color: #4b5563;
        }
        .total-row:last-child {
            margin-bottom: 0;
        }
        .total-divider {
            height: 2px;
            background: var(--primary-color);
            margin: 14px 0;
            opacity: 0.3;
        }
        .final-total {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px solid var(--primary-color);
        }
        .notes {
            margin-top: 30px;
            padding: 20px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 4px solid var(--primary-color);
            border-radius: 4px;
        }
        .notes p {
            color: #4b5563;
            font-size: 13px;
            line-height: 1.8;
            margin: 0;
        }
        .notes strong {
            color: #1a1a1a;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info" style="max-width:60%">
                @if(($invoice->organization->settings['pdf_show_logo'] ?? true) && $invoice->organization->logo_path)
                @php
                    $logoPath = public_path('storage/' . $invoice->organization->logo_path);
                    $logoExists = file_exists($logoPath);
                @endphp
                @if($logoExists)
                <div style="margin-bottom:16px">
                    <img src="{{ $logoPath }}" alt="{{ $invoice->organization->name }} Logo" style="max-height: 60px; max-width: 220px; object-fit: contain; display: block; height: auto;">
                </div>
                @endif
                @endif
                <h1>{{ $invoice->organization->name }}</h1>
                @if($invoice->organization->tagline)
                <p class="tagline">{{ $invoice->organization->tagline }}</p>
                @endif
                @php($orgSettings = $invoice->organization->settings ?? [])
                <div style="margin-top:10px; line-height: 1.8;">
                    @if($invoice->organization->vat_number || ($orgSettings['kvk'] ?? null) || ($orgSettings['iban'] ?? null))
                    <p class="muted small" style="margin-bottom:4px">
                        @if($invoice->organization->vat_number) <strong>BTW:</strong> {{ $invoice->organization->vat_number }} @endif
                        @if(($orgSettings['kvk'] ?? null)) @if($invoice->organization->vat_number) | @endif <strong>KvK:</strong> {{ $orgSettings['kvk'] }} @endif
                        @if(($orgSettings['iban'] ?? null)) @if($invoice->organization->vat_number || ($orgSettings['kvk'] ?? null)) | @endif <strong>IBAN:</strong> {{ $orgSettings['iban'] }} @endif
                    </p>
                    @endif
                    @if(($orgSettings['address_line1'] ?? null) || ($orgSettings['city'] ?? null))
                    <p class="muted small" style="margin-bottom:4px">
                        @if(($orgSettings['address_line1'] ?? null)) {{ $orgSettings['address_line1'] }} @endif
                        @if(($orgSettings['address_line2'] ?? null)) {{ $orgSettings['address_line2'] }} @endif
                    </p>
                    <p class="muted small" style="margin-bottom:4px">
                        @if(($orgSettings['postal_code'] ?? null)) {{ $orgSettings['postal_code'] }} @endif
                        @if(($orgSettings['city'] ?? null)) {{ $orgSettings['city'] }} @endif
                        @if(($orgSettings['country'] ?? null)) {{ $orgSettings['country'] }} @endif
                    </p>
                    @endif
                    @if(($orgSettings['phone'] ?? null) || ($orgSettings['website'] ?? null) || $invoice->organization->owner)
                    <p class="muted small" style="margin-bottom:4px">
                        @if(($orgSettings['phone'] ?? null)) <strong>Tel:</strong> {{ $orgSettings['phone'] }} @endif
                        @if(($orgSettings['website'] ?? null)) @if(($orgSettings['phone'] ?? null)) | @endif <strong>Web:</strong> {{ $orgSettings['website'] }} @endif
                        @if($invoice->organization->owner) @if(($orgSettings['phone'] ?? null) || ($orgSettings['website'] ?? null)) | @endif <strong>E-mail:</strong> {{ $invoice->organization->owner->email }} @endif
                    </p>
                    @endif
                </div>
            </div>
            <div class="invoice-header">
                <h2>Factuur</h2>
                <div class="invoice-number">#{{ $invoice->number }}</div>
                @if($invoice->status !== 'draft')
                <div class="status-badge">{{ ['sent' => 'Verzonden', 'paid' => 'Betaald'][$invoice->status] ?? ucfirst($invoice->status) }}</div>
                @endif
            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <!-- Invoice To -->
            <div class="info-box">
                <h3>Aan</h3>
                <p><strong>{{ $invoice->client->name }}</strong></p>
                @if($invoice->client->contact_name)
                <p>{{ $invoice->client->contact_name }}</p>
                @endif
                @if($invoice->client->email)
                <p class="muted small">{{ $invoice->client->email }}</p>
                @endif
                @if($invoice->client->phone)
                <p class="muted small">{{ $invoice->client->phone }}</p>
                @endif
                @if(!empty($invoice->client->address['street']))
                <p class="muted small">{{ $invoice->client->address['street'] }}</p>
                <p class="muted small">{{ $invoice->client->address['postal_code'] ?? '' }} {{ $invoice->client->address['city'] ?? '' }}</p>
                <p class="muted small">{{ $invoice->client->address['country'] ?? '' }}</p>
                @endif
                @if($invoice->client->tax_id)
                <p class="muted small">BTW: {{ $invoice->client->tax_id }}</p>
                @endif
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="info-grid" style="margin-top: 10px;">
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
            <div class="info-box"></div>
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
        <div style="text-align: center; margin-top: 50px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #1a1a1a; font-weight: 600; font-size: 12px; margin-bottom: 6px;">{{ $invoice->organization->name }}</p>
            <p style="color: #6b7280; font-size: 11px;">{{ $invoice->organization->settings['pdf_footer_message'] ?? 'Bedankt voor uw vertrouwen' }}</p>
        </div>
    </div>
</body>
</html>

