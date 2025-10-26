<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'description',
        'qty',
        'unit_price',
        'vat_rate',
        'net_amount',
        'vat_amount',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'vat_rate' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'vat_amount' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    /**
     * Get the invoice that owns this item.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Calculate net amount based on qty and unit price.
     */
    public function calculateNetAmount(): float
    {
        return $this->qty * $this->unit_price;
    }

    /**
     * Calculate VAT amount based on net amount and VAT rate.
     */
    public function calculateVatAmount(): float
    {
        return $this->calculateNetAmount() * ($this->vat_rate / 100);
    }

    /**
     * Calculate line total (net + VAT).
     */
    public function calculateLineTotal(): float
    {
        return $this->calculateNetAmount() + $this->calculateVatAmount();
    }

    /**
     * Update calculated amounts.
     */
    public function updateCalculatedAmounts(): void
    {
        $this->net_amount = $this->calculateNetAmount();
        $this->vat_amount = $this->calculateVatAmount();
        $this->line_total = $this->calculateLineTotal();
    }
}
