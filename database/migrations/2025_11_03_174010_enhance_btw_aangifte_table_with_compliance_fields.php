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
        Schema::table('btw_aangifte', function (Blueprint $table) {
            // Deadline tracking
            $table->date('deadline')->nullable()->after('indien_datum')
                ->comment('Deadline for filing (last day of month following quarter)');
            $table->boolean('is_overdue')->default(false)->after('deadline')
                ->comment('Whether filing is overdue');
            $table->decimal('late_filing_penalty', 10, 2)->default(0)->after('is_overdue')
                ->comment('Late filing penalty amount');
            
            // Correction tracking (8-week rule from 2025)
            $table->unsignedBigInteger('correction_of_id')->nullable()->after('late_filing_penalty')
                ->comment('ID of original aangifte if this is a correction');
            $table->text('correction_reason')->nullable()->after('correction_of_id')
                ->comment('Reason for correction');
            $table->date('correction_discovered_date')->nullable()->after('correction_reason')
                ->comment('Date when error was discovered');
            $table->boolean('filed_within_8_weeks')->default(true)->after('correction_discovered_date')
                ->comment('Whether correction filed within 8 weeks');
            
            // Filing method and reference
            $table->enum('filed_via', ['manual', 'api'])->default('manual')->after('filed_within_8_weeks')
                ->comment('Method used to file');
            $table->string('belastingdienst_reference', 255)->nullable()->after('filed_via')
                ->comment('Reference number from Belastingdienst');
            
            // BTW percentage breakdown (required by Belastingdienst)
            $table->decimal('ontvangen_btw_0', 15, 2)->default(0)->after('ontvangen_btw')
                ->comment('BTW received at 0% rate');
            $table->decimal('ontvangen_btw_9', 15, 2)->default(0)->after('ontvangen_btw_0')
                ->comment('BTW received at 9% rate (low rate)');
            $table->decimal('ontvangen_btw_21', 15, 2)->default(0)->after('ontvangen_btw_9')
                ->comment('BTW received at 21% rate (standard)');
            
            $table->decimal('betaalde_btw_0', 15, 2)->default(0)->after('betaalde_btw')
                ->comment('BTW paid at 0% rate');
            $table->decimal('betaalde_btw_9', 15, 2)->default(0)->after('betaalde_btw_0')
                ->comment('BTW paid at 9% rate');
            $table->decimal('betaalde_btw_21', 15, 2)->default(0)->after('betaalde_btw_9')
                ->comment('BTW paid at 21% rate');
            
            // Validation and status
            $table->json('validation_errors')->nullable()->after('opmerkingen')
                ->comment('JSON array of validation errors');
            $table->boolean('is_validated')->default(false)->after('validation_errors')
                ->comment('Whether aangifte passed validation checks');
            
            // Foreign key for corrections
            $table->foreign('correction_of_id')->references('id')->on('btw_aangifte')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('btw_aangifte', function (Blueprint $table) {
            $table->dropForeign(['correction_of_id']);
            $table->dropColumn([
                'deadline',
                'is_overdue',
                'late_filing_penalty',
                'correction_of_id',
                'correction_reason',
                'correction_discovered_date',
                'filed_within_8_weeks',
                'filed_via',
                'belastingdienst_reference',
                'ontvangen_btw_0',
                'ontvangen_btw_9',
                'ontvangen_btw_21',
                'betaalde_btw_0',
                'betaalde_btw_9',
                'betaalde_btw_21',
                'validation_errors',
                'is_validated',
            ]);
        });
    }
};
