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
            $table->string('code', 50)->unique()->index();
            $table->enum('type', ['percentage', 'fixed', 'free_shipping', 'buy_x_get_y', 'buy_x_for_y']);
            $table->decimal('value', 10, 2)->nullable();
            $table->decimal('min_spend', 10, 2)->nullable();
            $table->decimal('max_spend', 10, 2)->nullable();
            $table->json('shipping_methods')->nullable();
            $table->json('buy_x_product_ids')->nullable();
            $table->json('get_y_product_ids')->nullable();
            $table->integer('buy_x_quantity')->nullable();
            $table->integer('get_y_quantity')->nullable();
            $table->decimal('buy_x_discount')->nullable();
            $table->enum('buy_x_discount_type', ['percentage', 'fixed'])->default('fixed');
            $table->boolean('usage_limit_total')->default(false);
            $table->integer('usage_limit_total_value')->nullable();
            $table->boolean('usage_limit_per_customer')->default(false);
            $table->integer('usage_limit_per_customer_value')->nullable();
            $table->enum('limit_by_price', ['all_items', 'reduced_items', 'full_price_items'])->nullable();
            $table->json('allowed_tags')->nullable();
            $table->json('disallowed_tags')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['start_date']);
            $table->index(['expire_date']);
            $table->index(['start_date', 'expire_date']);
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
