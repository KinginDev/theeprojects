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
            $table->string('token', 60)->nullable();
            $table->timestamp('onboarded_at')->nullable()->after('token');
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            // Remove the token and onboarded_at columns
            $table->dropColumn(['token', 'onboarded_at']);
            // // Revert the password column to its original state
            $table->string('password')->nullable(false)->change();
        });
    }
};
