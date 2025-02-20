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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('type', 100)->default('Fixed Price');
            $table->decimal('value', 8, 2);
            $table->string('usage_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->dateTime('starts_at')->nullable()->index();
            $table->dateTime('expires_at')->nullable()->index();
            $table->decimal('min_amount', 8, 2)->nullable()->index();
            $table->unsignedInteger('min_items_count')->nullable()->index();
            $table->string('description', 255)->nullable();
            $table->string('banner_path', 155)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->index(['is_active', 'starts_at', 'expires_at']);
            $table->index(['is_active', 'min_amount']);
            $table->index(['is_active', 'min_items_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
