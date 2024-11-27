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
        Schema::create('product_quantities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_color_id');
            $table->unsignedBigInteger('product_size_id'); 
            $table->integer('quantity')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->integer('original_printed_barcodes')->default(0);
            $table->integer('total_printed_barcodes')->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_color_id')->references('id')->on('product_colors')->onDelete('cascade');
            $table->foreign('product_size_id')->references('id')->on('product_sizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_quantities');
    }
};
