<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('subscription_plan')->default('starter')->after('btw_stelsel'); // starter|pro
            $table->string('subscription_status')->default('trial')->after('subscription_plan'); // trial|active|past_due|canceled|paused
            $table->timestamp('trial_ends_at')->nullable()->after('subscription_status');
            $table->string('mollie_customer_id')->nullable()->after('trial_ends_at');
            $table->string('mollie_subscription_id')->nullable()->after('mollie_customer_id');
            $table->timestamp('subscription_ends_at')->nullable()->after('mollie_subscription_id');
        });
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_plan',
                'subscription_status',
                'trial_ends_at',
                'mollie_customer_id',
                'mollie_subscription_id',
                'subscription_ends_at'
            ]);
        });
    }
};
