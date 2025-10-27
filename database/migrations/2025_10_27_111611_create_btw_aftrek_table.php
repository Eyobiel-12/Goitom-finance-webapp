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
        Schema::create('btw_aftrek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('naam'); // Naam van de aftrekpost
            $table->text('beschrijving')->nullable();
            $table->decimal('bedrag_excl_btw', 10, 2); // Bedrag zonder BTW
            $table->decimal('btw_percentage', 5, 2); // BTW percentage (21%, 9%, etc)
            $table->decimal('btw_bedrag', 10, 2); // Berekend BTW bedrag
            $table->decimal('totaal_bedrag', 10, 2); // Totaal bedrag inclusief BTW
            $table->string('categorie')->nullable(); // Bijv. "Kosten", "Investeringen", etc.
            $table->date('datum');
            $table->string('status')->default('draft'); // draft, ingediend, goedgekeurd
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('btw_aftrek');
    }
};
