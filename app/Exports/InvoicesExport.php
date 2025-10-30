<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class InvoicesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private readonly int $organizationId
    ) {
    }

    public function collection()
    {
        return Invoice::forOrganization($this->organizationId)
            ->with(['client', 'items'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Factuurnummer',
            'Klant',
            'Project',
            'Datum',
            'Vervaldatum',
            'Subtotaal',
            'BTW',
            'Totaal',
            'Valuta',
            'Status',
            'Verzonden op',
            'Aangemaakt',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->number,
            $invoice->client->name ?? '',
            $invoice->project->name ?? '',
            $invoice->issue_date?->format('d-m-Y'),
            $invoice->due_date?->format('d-m-Y'),
            number_format($invoice->subtotal, 2, ',', '.'),
            number_format($invoice->vat_total, 2, ',', '.'),
            number_format($invoice->total, 2, ',', '.'),
            $invoice->currency,
            $invoice->status,
            $invoice->sent_at?->format('d-m-Y H:i'),
            $invoice->created_at?->format('d-m-Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
