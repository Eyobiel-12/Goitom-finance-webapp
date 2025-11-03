<?php

namespace Database\Factories;

use App\Models\InvoiceItem;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    protected $model = InvoiceItem::class;

    public function definition(): array
    {
        $qty = fake()->randomFloat(2, 1, 10);
        $unitPrice = fake()->randomFloat(2, 10, 1000);
        $netAmount = $qty * $unitPrice;
        $vatRate = fake()->randomElement([0, 6, 9, 21]);
        $vatAmount = $netAmount * ($vatRate / 100);
        $lineTotal = $netAmount + $vatAmount;

        return [
            'invoice_id' => Invoice::factory(),
            'description' => fake()->sentence(3),
            'qty' => $qty,
            'unit_price' => $unitPrice,
            'vat_rate' => $vatRate,
            'net_amount' => $netAmount,
            'vat_amount' => $vatAmount,
            'line_total' => $lineTotal,
        ];
    }
}
