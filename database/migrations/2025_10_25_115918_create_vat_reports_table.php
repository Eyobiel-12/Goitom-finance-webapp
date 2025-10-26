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
        Schema::create('vat_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('taxable_base', 15, 2)->default(0);
            $table->decimal('vat_collected', 15, 2)->default(0);
            $table->decimal('vat_paid', 15, 2)->default(0);
            $table->decimal('net_due', 15, 2)->default(0);
            $table->string('export_path')->nullable(); // CSV/PDF export path
            $table->timestamps();
            
            $table->index(['organization_id', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vat_reports');
    }
};
