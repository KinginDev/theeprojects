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
        Schema::create('eletricity_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('product_name');
            $table->string('type');
            $table->string('tel');
            $table->string('amount');
            $table->string('reference');
            $table->string('purchased_code');
            $table->string('response_description');
            $table->string('transaction_date');
            $table->string('identity');
            $table->string('prev_bal');
            $table->string('current_bal');
            $table->string('percent_profit');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eletricity_transactions');
    }
};
