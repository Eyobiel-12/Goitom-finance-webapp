<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            // Usage limits (NULL = unlimited for Pro)
            $table->integer('limit_invoices_per_month')->default(20)->after('subscription_ends_at');
            $table->integer('limit_clients')->default(50)->after('limit_invoices_per_month');
            $table->integer('limit_active_projects')->default(10)->after('limit_clients');
            $table->bigInteger('limit_storage_mb')->default(100)->after('limit_active_projects');
            
            // Current month usage tracking (resets monthly)
            $table->integer('usage_invoices_this_month')->default(0)->after('limit_storage_mb');
            $table->date('usage_month_started')->nullable()->after('usage_invoices_this_month');
        });
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn([
                'limit_invoices_per_month',
                'limit_clients',
                'limit_active_projects',
                'limit_storage_mb',
                'usage_invoices_this_month',
                'usage_month_started',
            ]);
        });
    }
};
