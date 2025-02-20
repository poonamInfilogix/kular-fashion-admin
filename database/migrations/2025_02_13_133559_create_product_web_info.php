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
        Schema::create('product_web_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_splitted_with_colors')->default(false)->index();
            $table->string('heading')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_web_info');
    }
};
