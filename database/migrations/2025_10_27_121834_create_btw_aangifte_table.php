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
        Schema::create('btw_aangifte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->year('jaar')->index();
            $table->tinyInteger('kwartaal')->nullable(); // 1-4 for quarterly, null for annual
            $table->decimal('btw_afdracht', 10, 2)->default(0); // Te betalen BTW
            $table->decimal('ontvangen_btw', 10, 2)->default(0); // BTW op ontvangen facturen
            $table->decimal('betaalde_btw', 10, 2)->default(0); // BTW op uitgaven
            $table->decimal('btw_terug', 10, 2)->default(0); // Te ontvangen BTW
            $table->string('status')->default('concept'); // concept, ingediend, goedgekeurd, betaald
            $table->timestamp('indien_datum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('btw_aangifte');
    }
};
