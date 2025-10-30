<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['organization_id']);
        });
        
        // Make organization_id nullable
        DB::statement('ALTER TABLE templates ALTER COLUMN organization_id DROP NOT NULL');
        
        Schema::table('templates', function (Blueprint $table) {
            // Re-add foreign key but allow null
            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });
        
        // Set null values to a default organization_id (or update them)
        // You may need to adjust this based on your data
        DB::statement('UPDATE templates SET organization_id = 1 WHERE organization_id IS NULL');
        DB::statement('ALTER TABLE templates ALTER COLUMN organization_id SET NOT NULL');
        
        Schema::table('templates', function (Blueprint $table) {
            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');
        });
    }
};
