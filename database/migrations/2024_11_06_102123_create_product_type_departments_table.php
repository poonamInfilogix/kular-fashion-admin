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
        Schema::create('product_type_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_type_id')->index();
            $table->unsignedBigInteger('department_id')->index();
            $table->timestamps();
    
            // Foreign key constraint for product_type_id
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_type_departments');
    }
};
