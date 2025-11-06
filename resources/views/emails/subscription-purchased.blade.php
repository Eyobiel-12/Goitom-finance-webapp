<div style="font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; color:#111;">
    <h2>Bedankt voor je aankoop</h2>
    <p>Hallo {{ $organization->owner?->name ?? $organization->name }},</p>
    <p>Je {{ ucfirst($payment->plan) }} abonnement is succesvol verlengd voor {{ $payment->interval_months }} maanden.</p>
    <ul>
        <li>Bedrag: €{{ number_format($payment->amount, 2, ',', '.') }} {{ $payment->currency }}</li>
        <li>Betaald op: {{ $payment->paid_at?->format('d-m-Y H:i') }}</li>
        <li>Betaalmethode: {{ $payment->method ?? '—' }}</li>
        <li>Referentie: {{ $payment->gateway_payment_id }}</li>
    </ul>
    <p>Je kunt je abonnement beheren via de pagina Abonnement.</p>
    <p style="margin-top: 20px; padding: 15px; background: #f0f9ff; border-left: 4px solid #0ea5e9; border-radius: 4px;">
        <strong>📎 Factuur bijgevoegd</strong><br>
        Je ontvangt een PDF-factuur als bijlage bij deze e-mail. Bewaar deze voor je administratie.
    </p>
</div>


