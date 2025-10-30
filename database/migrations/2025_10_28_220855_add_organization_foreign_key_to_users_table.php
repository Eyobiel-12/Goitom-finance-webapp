<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alleen toevoegen indien de constraint nog niet bestaat (idempotent voor PostgreSQL)
        $constraintName = 'users_organization_id_foreign';

        $exists = collect(DB::select(
            "SELECT 1 FROM information_schema.table_constraints WHERE table_name = 'users' AND constraint_name = ?",
            [$constraintName]
        ))->isNotEmpty();

        if (! $exists) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('organization_id')
                    ->references('id')
                    ->on('organizations')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Alleen droppen indien de constraint bestaat
        $constraintName = 'users_organization_id_foreign';
        $exists = collect(DB::select(
            "SELECT 1 FROM information_schema.table_constraints WHERE table_name = 'users' AND constraint_name = ?",
            [$constraintName]
        ))->isNotEmpty();

        if ($exists) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['organization_id']);
            });
        }
    }
};
