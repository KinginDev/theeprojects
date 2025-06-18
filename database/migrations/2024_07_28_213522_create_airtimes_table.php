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
        Schema::create('airtimes', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // e.g., Airtel, MTN, Glo, Etisalat
            $table->string('provider_charge_price');
            $table->timestamp('recharge_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airtimes');
    }
};
