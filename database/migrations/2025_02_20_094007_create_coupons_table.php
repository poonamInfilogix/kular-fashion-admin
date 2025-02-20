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
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->decimal('min_purchase_amount', 8, 2)->nullable();
            $table->unsignedInteger('min_items_count', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_one_time_use')->default(false);
            $table->string('description')->nullable();
            $table->string('banner_path')->nullable();
            $table->timestamps();
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
