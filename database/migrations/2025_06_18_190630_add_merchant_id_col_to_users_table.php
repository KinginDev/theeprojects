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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable()->after('id');                      // Add merchant_id column
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('set null'); // Foreign key constraint

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['merchant_id']); // Drop foreign key constraint
            $table->dropColumn('merchant_id');    // Drop the merchant_id column
        });
    }
};
