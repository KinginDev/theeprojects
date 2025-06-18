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
        Schema::table('fund_transactions', function (Blueprint $table) {
            $table->decimal('prev_bal', 10, 2)->after('amount')->default(0.00)->comment('Previous balance before transaction');
            $table->decimal('current_bal', 10, 2)->after('prev_bal')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fund_transactions', function (Blueprint $table) {
            $table->dropColumn(['prev_bal', 'current_bal']);
        });
    }
};
