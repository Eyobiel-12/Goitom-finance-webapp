<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('qty', 10, 2)->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('vat_rate', 5, 2)->default(21.00);
            $table->decimal('net_amount', 10, 2); // qty * unit_price
            $table->decimal('vat_amount', 10, 2); // net_amount * vat_rate / 100
            $table->decimal('line_total', 10, 2); // net_amount + vat_amount
            $table->timestamps();
            
            $table->index(['invoice_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
