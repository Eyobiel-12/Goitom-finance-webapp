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
            color: #1a1a1a;
            line-height: 1.6;
        }
        
        :root {
            --primary-color: {{ $invoice->organization->settings['pdf_primary_color'] ?? '#e63946' }};
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 25px 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color) 0%, darken(var(--primary-color), 10%) 100%);
            border-radius: 10px;
        }
        .company-info h1 {
            font-size: 28px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .company-info .tagline {
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            opacity: 0.9;
        }
        .invoice-header {
            text-align: right;
        }
        .invoice-header h2 {
            font-size: 32px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .invoice-number {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 18px;
            background: #ffffff;
            color: var(--primary-color);
            border-radius: 8px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-box {
            background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            padding: 15px;
        }
        .info-box h3 {
            font-size: 11px;
            font-weight: 900;
            color: var(--primary-color);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .info-box p {
            font-size: 12px;
            color: #1a1a1a;
            margin-bottom: 5px;
            line-height: 1.6;
            font-weight: 600;
        }
        .info-box p:last-child {
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            overflow: hidden;
        }
        thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, darken(var(--primary-color), 10%) 100%);
        }
        th {
            padding: 12px 15px;
            text-align: left;
            color: #ffffff;
            font-weight: 900;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        th:first-child {
            border-top-left-radius: 6px;
        }
        th:last-child {
            border-top-right-radius: 6px;
            text-align: right;
        }
        td {
            padding: 12px 15px;
            border-bottom: 2px solid #f0f0f0;
            color: #1a1a1a;
            font-size: 12px;
            font-weight: 600;
        }
        td:last-child {
            text-align: right;
            font-weight: 900;
        }
        .totals-box {
            background: linear-gradient(135deg, var(--primary-color) 0%, darken(var(--primary-color), 10%) 100%);
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            margin-left: auto;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .totals-box h3 {
            font-size: 11px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 12px;
            color: #ffffff;
            font-weight: 600;
        }
        .total-row:last-child {
            margin-bottom: 0;
        }
        .total-divider {
            height: 3px;
            background: #ffffff;
            margin: 12px 0;
            border-radius: 2px;
        }
        .final-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 900;
            color: #ffffff;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px solid rgba(255,255,255,0.3);
        }
        .notes {
            margin-top: 25px;
            padding: 18px;
            background: #fff5f5;
            border: 3px solid var(--primary-color);
            border-radius: 10px;
            border-left: 8px solid var(--primary-color);
        }
        .notes p {
            color: #1a1a1a;
            font-size: 13px;
            line-height: 1.8;
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
                <div style="margin-bottom:12px">
                    <img src="{{ $logoPath }}" alt="{{ $invoice->organization->name }} Logo" style="max-height: 60px; max-width: 220px; object-fit: contain; display: block; height: auto; filter: brightness(0) invert(1);">
                </div>
                @endif
                @endif
                <h1>{{ $invoice->organization->name }}</h1>
                @if($invoice->organization->tagline)
                <p class="tagline">{{ $invoice->organization->tagline }}</p>
                @endif
                @php($orgSettings = $invoice->organization->settings ?? [])
                <div style="margin-top:12px; line-height: 1.8;">
                    @if($invoice->organization->vat_number || ($orgSettings['kvk'] ?? null) || ($orgSettings['iban'] ?? null))
                    <p style="color: rgba(255,255,255,0.9); font-size: 11px; margin-bottom:4px">
                        @if($invoice->organization->vat_number) <strong>BTW:</strong> {{ $invoice->organization->vat_number }} @endif
                        @if(($orgSettings['kvk'] ?? null)) @if($invoice->organization->vat_number) | @endif <strong>KvK:</strong> {{ $orgSettings['kvk'] }} @endif
                        @if(($orgSettings['iban'] ?? null)) @if($invoice->organization->vat_number || ($orgSettings['kvk'] ?? null)) | @endif <strong>IBAN:</strong> {{ $orgSettings['iban'] }} @endif
                    </p>
                    @endif
                    @if(($orgSettings['address_line1'] ?? null) || ($orgSettings['city'] ?? null))
                    <p style="color: rgba(255,255,255,0.9); font-size: 11px; margin-bottom:4px">
                        @if(($orgSettings['address_line1'] ?? null)) {{ $orgSettings['address_line1'] }} @endif
                        @if(($orgSettings['address_line2'] ?? null)) {{ $orgSettings['address_line2'] }} @endif
                    </p>
                    <p style="color: rgba(255,255,255,0.9); font-size: 11px; margin-bottom:4px">
                        @if(($orgSettings['postal_code'] ?? null)) {{ $orgSettings['postal_code'] }} @endif
                        @if(($orgSettings['city'] ?? null)) {{ $orgSettings['city'] }} @endif
                        @if(($orgSettings['country'] ?? null)) {{ $orgSettings['country'] }} @endif
                    </p>
                    @endif
                    @if(($orgSettings['phone'] ?? null) || ($orgSettings['website'] ?? null) || $invoice->organization->owner)
                    <p style="color: rgba(255,255,255,0.9); font-size: 11px; margin-bottom:4px">
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
                <p>{{ $invoice->client->email }}</p>
                @endif
                @if($invoice->client->phone)
                <p>{{ $invoice->client->phone }}</p>
                @endif
                @if(!empty($invoice->client->address['street']))
                <p>{{ $invoice->client->address['street'] }}</p>
                <p>{{ $invoice->client->address['postal_code'] ?? '' }} {{ $invoice->client->address['city'] ?? '' }}</p>
                <p>{{ $invoice->client->address['country'] ?? '' }}</p>
                @endif
                @if($invoice->client->tax_id)
                <p>BTW: {{ $invoice->client->tax_id }}</p>
                @endif
            </div>
            <div class="info-box"></div>
        </div>

        <!-- Invoice Details -->
        <div class="info-grid" style="margin-top: 20px;">
            <div class="info-box">
                <h3>Factuurgegevens</h3>
                <p><strong>Datum:</strong> {{ $invoice->issue_date->format('d-m-Y') }}</p>
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
                <span>💰 TOTAAL</span>
                <span>€{{ number_format($invoice->total, 2, ',', '.') }}</span>
            </div>
        </div>

        @if($invoice->notes)
        <div class="notes">
            <p><strong>⚡ Opmerkingen:</strong> {{ $invoice->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div style="text-align: center; margin-top: 30px; padding-top: 15px; border-top: 3px solid var(--primary-color);">
            <p style="color: var(--primary-color); font-weight: 900; font-size: 14px; margin-bottom: 5px;">{{ $invoice->organization->name }}</p>
            <p style="color: #6b7280; font-size: 11px; font-weight: 600;">{{ $invoice->organization->settings['pdf_footer_message'] ?? 'Bedankt voor je vertrouwen!' }}</p>
        </div>
    </div>
</body>
</html>

