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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->string('size', 100)->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->string('color_name', 100)->nullable();
            $table->string('color_code', 100)->nullable();
            $table->string('ui_color_name', 100)->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('brand_name', 100)->nullable();
            $table->string('article_code', 100)->nullable();
            $table->string('barcode', 100)->nullable();
            $table->decimal('original_price')->nullable();
            $table->decimal('changed_price')->nullable();
            $table->unsignedBigInteger('changed_price_reason_id')->nullable();
            $table->string('changed_price_reason')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('sales_person_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('set null');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('changed_price_reason_id')->references('id')->on('change_price_reasons')->onDelete('set null');
            $table->foreign('sales_person_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
