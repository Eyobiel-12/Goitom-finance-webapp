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
        Schema::create('btw_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->unique();
            $table->enum('btw_stelsel', ['factuur', 'kassa'])->default('factuur')
                ->comment('Factuurstelsel = invoice basis, Kassastelsel = cash basis');
            $table->boolean('kor_eligible')->default(false)
                ->comment('Kleine Ondernemers Regeling eligible');
            $table->decimal('kor_turnover_limit', 10, 2)->default(20000.00)
                ->comment('KOR turnover limit in euros');
            $table->boolean('kor_exemption')->default(false)
                ->comment('Currently exempt under KOR');
            $table->enum('filing_frequency', ['monthly', 'quarterly', 'annual'])->default('quarterly')
                ->comment('BTW filing frequency');
            $table->integer('reminder_days_before_deadline')->default(7)
                ->comment('Days before deadline to send reminder');
            $table->boolean('auto_submit')->default(false)
                ->comment('Auto-submit filings via API (future)');
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->index('organization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('btw_settings');
    }
};
