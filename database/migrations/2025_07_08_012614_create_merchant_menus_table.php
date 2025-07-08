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
          Schema::create('merchant_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->string('name');
            $table->string('location')->default('header'); // header, footer, sidebar, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Make sure menu names are unique per merchant
            $table->unique(['merchant_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_menus');
    }
};
