<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

final class ClientsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsEmptyRows
{
    use Importable, SkipsErrors;

    public function __construct(
        private readonly int $organizationId
    ) {
    }

    public function model(array $row): ?Client
    {
        return new Client([
            'organization_id' => $this->organizationId,
            'name' => $row['naam'] ?? $row['name'] ?? '',
            'contact_name' => $row['contactpersoon'] ?? $row['contact_name'] ?? null,
            'email' => $row['email'] ?? null,
            'phone' => $row['telefoon'] ?? $row['phone'] ?? null,
            'address' => [
                'street' => $row['straat'] ?? $row['street'] ?? '',
                'house_number' => $row['huisnummer'] ?? $row['house_number'] ?? '',
                'postal_code' => $row['postcode'] ?? $row['postal_code'] ?? '',
                'city' => $row['plaats'] ?? $row['city'] ?? '',
                'country' => $row['land'] ?? $row['country'] ?? 'NL',
            ],
            'tax_id' => $row['btw_nummer'] ?? $row['tax_id'] ?? null,
            'kvk_number' => $row['kvk_nummer'] ?? $row['kvk_number'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.naam' => 'required_without:*.name|string|max:255',
            '*.name' => 'required_without:*.naam|string|max:255',
            '*.email' => 'nullable|email',
        ];
    }
}
