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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->string('product_code');
            $table->unsignedBigInteger('product_type_id');
            $table->unsignedBigInteger('size_scale_id');
            $table->unsignedBigInteger('min_size_id');
            $table->unsignedBigInteger('max_size_id');
            $table->date('delivery_date');
            $table->decimal('price');
            $table->text('short_description')->nullable();

            $table->timestamps();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->foreign('size_scale_id')->references('id')->on('size_scales')->onDelete('cascade');
            $table->foreign('min_size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('max_size_id')->references('id')->on('sizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
