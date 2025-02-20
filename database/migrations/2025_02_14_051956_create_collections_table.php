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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->json('include_conditions')->nullable();
            $table->json('exclude_conditions')->nullable();
            $table->string('image')->nullable();
            $table->string('small_image')->nullable();
            $table->string('medium_image')->nullable();
            $table->string('large_image')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('heading')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->tinyInteger('status')->default(1)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
