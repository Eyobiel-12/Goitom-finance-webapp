<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class ClientsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private readonly int $organizationId
    ) {
    }

    public function collection()
    {
        return Client::forOrganization($this->organizationId)
            ->with('organization')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Naam',
            'Contactpersoon',
            'Email',
            'Telefoon',
            'Straat',
            'Huisnummer',
            'Postcode',
            'Plaats',
            'Land',
            'BTW Nummer',
            'KVK Nummer',
            'Aangemaakt',
            'Bijgewerkt',
        ];
    }

    public function map($client): array
    {
        $address = is_array($client->address) ? $client->address : [];
        
        return [
            $client->name,
            $client->contact_name ?? '',
            $client->email ?? '',
            $client->phone ?? '',
            $address['street'] ?? '',
            $address['house_number'] ?? '',
            $address['postal_code'] ?? '',
            $address['city'] ?? '',
            $address['country'] ?? 'NL',
            $client->tax_id ?? '',
            $client->kvk_number ?? '',
            $client->created_at?->format('d-m-Y H:i'),
            $client->updated_at?->format('d-m-Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
