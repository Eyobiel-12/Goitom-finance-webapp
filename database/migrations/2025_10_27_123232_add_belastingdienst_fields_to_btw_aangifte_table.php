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
            $table->decimal('omzet_excl_btw', 15, 2)->default(0)->after('ontvangen_btw');
            $table->decimal('uitgaven_excl_btw', 15, 2)->default(0)->after('betaalde_btw');
            $table->text('opmerkingen')->nullable()->after('indien_datum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('btw_aangifte', function (Blueprint $table) {
            $table->dropColumn(['omzet_excl_btw', 'uitgaven_excl_btw', 'opmerkingen']);
        });
    }
};
