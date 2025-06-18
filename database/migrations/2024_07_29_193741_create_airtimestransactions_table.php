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
        Schema::create('airtimes_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('network');
            $table->string('tel');
            $table->string('amount');
            $table->string('transaction_id');
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
        Schema::dropIfExists('airtimes_transactions');
    }
};
