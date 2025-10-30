Herinnering: Openstaande factuur

Beste {{ $invoice->client->contact_name ?? $invoice->client->name }},

Dit is een vriendelijke herinnering dat factuur {{ $invoice->number }} nog openstaat.
Bedrag: {{ number_format($invoice->total, 2, ',', '.') }} {{ $invoice->currency }}
Factuurdatum: {{ $invoice->issue_date?->format('d-m-Y') }}
Vervaldatum: {{ $invoice->due_date?->format('d-m-Y') }}
@if($daysOverdue > 0)
Achterstallig: {{ $daysOverdue }} dag(en)
@endif

Wilt u het bedrag zo spoedig mogelijk voldoen? Bij vragen kunt u antwoorden op dit bericht.

Met vriendelijke groet,
{{ $organization->name }}

