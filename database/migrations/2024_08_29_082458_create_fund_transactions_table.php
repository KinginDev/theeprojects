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
        Schema::create('fund_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('username');
            $table->string('tel');
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->unique();
            $table->string('identity');
            $table->string('status');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_transactions');
    }
};
