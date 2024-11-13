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
        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Foreign key to products table
            $table->foreignId('color_id')->constrained()->onDelete('cascade');  // Foreign key to colors table
            $table->string('supplier_color_code')->nullable();  // Supplier color code (nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
