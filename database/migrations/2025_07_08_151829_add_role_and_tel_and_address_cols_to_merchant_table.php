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
        Schema::table('merchants', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_merchant_id')->nullable();
            $table->string('address')->nullable()->after('phone');

            $table->foreign('parent_merchant_id')->references('id')->on('merchants')->onDelete('set null');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('merchants', function (Blueprint $table) {
            $table->dropForeign(['parent_merchant_id']);

            $table->dropColumn(['parent_merchant_id', 'address']);
        });


    }
};
