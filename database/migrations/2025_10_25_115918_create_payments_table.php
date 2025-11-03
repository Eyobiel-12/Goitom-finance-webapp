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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['bank_transfer', 'cash', 'card', 'paypal', 'other'])->default('bank_transfer');
            $table->date('date');
            $table->string('txn_reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['invoice_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
