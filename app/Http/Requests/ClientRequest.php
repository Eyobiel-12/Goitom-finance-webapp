<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'array'],
            'address.street' => ['nullable', 'string'],
            'address.city' => ['nullable', 'string'],
            'address.postal_code' => ['nullable', 'string'],
            'address.country' => ['nullable', 'string', 'max:2'],
            'tax_id' => ['nullable', 'string', 'max:100'],
        ];
    }
}
