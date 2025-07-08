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
         Schema::create('merchant_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->index();
            $table->text('content')->nullable();
            $table->json('meta_data')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('template')->default('default');
            $table->timestamps();

            // Make sure slugs are unique per merchant
            $table->unique(['merchant_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_pages');
    }
};
