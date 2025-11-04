<div style="font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; color:#111;">
    <h2>Laatste waarschuwing</h2>
    <p>Hallo {{ $organization->owner?->name ?? 'there' }},</p>
    <p>Je read‑only periode is bijna voorbij. Zonder betaling wordt {{ $organization->name }} tijdelijk gepauzeerd.</p>
    <p>
        <a href="{{ route('app.subscription.index') }}" style="background:#facc15;color:#111;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:600;">Betaal nu</a>
    </p>
</div>


