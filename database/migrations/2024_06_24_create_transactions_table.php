<?php

use App\Enums\ProductTypes;
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
        $productTypes = collect(ProductTypes::cases())
            ->map(fn($type) => $type->value)
            ->toArray();
        Schema::create('transactions', function (Blueprint $table) use ($productTypes) {
            $table->id();
            $table->string('reference')->unique();
            $table->morphs('transactable'); // Creates transactable_type and transactable_id
            $table->decimal('amount', 10, 2);
            $table->enum('type', $productTypes); // airtime, data, tv, electricity, etc.
            $table->enum('status', ['pending', 'processing', 'success', 'failed'])->default('pending');
            $table->json('payload')->nullable();              // Store transaction details
            $table->string('provider_reference')->nullable(); // Reference from service provider
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
