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

        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // The user who referred
            $table->string('referral_user_id'); // The user who was referred
            $table->string('referral_username'); // The username of the referred user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
