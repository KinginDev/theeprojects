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
          Schema::create('merchant_menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('merchant_menus')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('merchant_menu_items')->onDelete('cascade');
            $table->string('title');
            $table->string('url')->nullable();
            $table->foreignId('page_id')->nullable()->constrained('merchant_pages')->nullOnDelete();
            $table->integer('order')->default(0);
            $table->string('target')->default('_self'); // _blank, _self, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_menu_items');
    }
};
