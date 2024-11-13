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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Foreign key to products table
            $table->foreignId('size_id')->constrained()->onDelete('cascade');  // Foreign key to sizes table
            $table->decimal('mrp', 8, 2)->default(0.00);  // Default Maximum Retail Price (MRP) is 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
