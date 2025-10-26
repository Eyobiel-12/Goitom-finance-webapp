<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'client_id' => Client::factory(),
            'project_id' => null,
            'number' => 'INV-' . now()->format('Y') . '-' . str_pad((string) fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'issue_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
            'subtotal' => fake()->randomFloat(2, 100, 5000),
            'vat_total' => 0,
            'total' => 0,
            'currency' => 'EUR',
            'status' => fake()->randomElement(['draft', 'sent', 'paid', 'overdue', 'cancelled']),
            'pdf_path' => null,
            'sent_at' => null,
            'notes' => null,
            'metadata' => null,
        ];
    }
}
