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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('wallet_owner'); // Creates wallet_owner_type and wallet_owner_id
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('transaction_id');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['credit', 'debit']);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('description')->nullable();
            $table->json('meta_data')->nullable();
            $table->decimal('prev_balance', 10, 2)->default(0);
            $table->decimal('current_balance', 10, 2)->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
