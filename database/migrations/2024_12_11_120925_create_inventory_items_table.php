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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventroy_transfer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_quantity_id');
            $table->unsignedBigInteger('product_color_id')->nullable();
            $table->unsignedBigInteger('product_size_id')->nullable(); 
            $table->unsignedBigInteger('brand_id')->nullable()->index();
            $table->integer('quantity')->default(0);
            $table->timestamps();
        
            $table->foreign('inventroy_transfer_id')->references('id')->on('inventory_transfers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_quantity_id')->references('id')->on('product_quantities')->onDelete('cascade');
            $table->foreign('product_color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('product_size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
