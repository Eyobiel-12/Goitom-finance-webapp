<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Factuur Abonnement {{ $payment->id }}</title>
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
            border-bottom: 3px solid #facc15;
        }
        .company-info h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        .invoice-header {
            text-align: right;
        }
        .invoice-header h2 {
            font-size: 24px;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 14px;
            color: #4b5563;
        }
        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .bill-to, .payment-info {
            width: 48%;
        }
        .section-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .section-content {
            font-size: 13px;
            color: #1a1a1a;
            line-height: 1.8;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table thead {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }
        .items-table th {
            padding: 12px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
            color: #1a1a1a;
        }
        .items-table tbody tr:last-child td {
            border-bottom: 2px solid #e5e7eb;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-left: auto;
            width: 300px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 13px;
        }
        .total-row.grand-total {
            border-top: 2px solid #1a1a1a;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 16px;
            font-weight: 700;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 11px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                <h1>Goitom Finance</h1>
                <p class="tagline">Facturatie & Administratie</p>
            </div>
            <div class="invoice-header">
                <h2>FACTUUR</h2>
                <div class="invoice-number">#SUB-{{ str_pad((string)$payment->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        <div class="details-section">
            <div class="bill-to">
                <div class="section-title">Factuur aan</div>
                <div class="section-content">
                    <strong>{{ $organization->name }}</strong><br>
                    @if($organization->owner)
                    {{ $organization->owner->name }}<br>
                    {{ $organization->owner->email }}
                    @endif
                </div>
            </div>
            <div class="payment-info">
                <div class="section-title">Factuurgegevens</div>
                <div class="section-content">
                    <strong>Factuurdatum:</strong> {{ $payment->paid_at?->format('d-m-Y') ?? $payment->created_at->format('d-m-Y') }}<br>
                    <strong>Betaald op:</strong> {{ $payment->paid_at?->format('d-m-Y H:i') ?? $payment->created_at->format('d-m-Y H:i') }}<br>
                    <strong>Referentie:</strong> {{ $payment->gateway_payment_id ?? 'N/A' }}
                </div>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Omschrijving</th>
                    <th class="text-right">Periode</th>
                    <th class="text-right">Bedrag</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ ucfirst($payment->plan) }} Abonnement</strong><br>
                        <span style="color: #6b7280; font-size: 11px;">{{ \App\Services\SubscriptionService::getIntervalLabel($payment->interval_months) }}</span>
                    </td>
                    <td class="text-right">{{ $payment->interval_months }} maanden</td>
                    <td class="text-right">€{{ number_format($payment->amount, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span>Subtotaal:</span>
                <span>€{{ number_format($payment->amount, 2, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>BTW (0%):</span>
                <span>€0,00</span>
            </div>
            <div class="total-row grand-total">
                <span>Totaal:</span>
                <span>€{{ number_format($payment->amount, 2, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Dit is een automatisch gegenereerde factuur voor uw abonnement.</p>
            <p>Bedankt voor uw vertrouwen in Goitom Finance.</p>
        </div>
    </div>
</body>
</html>

