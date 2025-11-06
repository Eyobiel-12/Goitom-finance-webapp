<div style="font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; color:#111;">
    <h2>Je trial is verlopen</h2>
    <p>Hallo {{ $organization->owner?->name ?? 'there' }},</p>
    <p>De gratis proefperiode voor {{ $organization->name }} is verlopen. Om Goitom Finance te blijven gebruiken, rond je betaling af.</p>
    <p>
        <a href="{{ route('app.subscription.index') }}" style="background:#facc15;color:#111;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:600;">Betaal nu</a>
    </p>
    <p>Je hebt nog 7 dagen read‑only toegang. Na deze periode wordt je account tijdelijk gepauzeerd.</p>
</div>


