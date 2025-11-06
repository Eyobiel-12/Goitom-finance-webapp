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
</div>


