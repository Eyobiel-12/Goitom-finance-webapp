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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('vat_number')->nullable(); // encrypted
            $table->string('country', 2)->default('NL');
            $table->string('currency', 3)->default('EUR');
            $table->decimal('default_vat_rate', 5, 2)->default(21.00);
            $table->string('logo_path')->nullable();
            $table->string('branding_color', 7)->default('#d4af37');
            $table->json('settings')->nullable();
            $table->enum('status', ['active', 'suspended', 'pending'])->default('pending');
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
