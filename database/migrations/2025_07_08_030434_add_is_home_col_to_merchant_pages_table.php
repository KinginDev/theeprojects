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
        Schema::table('merchant_pages', function (Blueprint $table) {
            $table->boolean('is_home')->default(false)->after('template')->comment('Indicates if this page is the home page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_pages', function (Blueprint $table) {
            $table->dropColumn('is_home');
        });
    }
};
