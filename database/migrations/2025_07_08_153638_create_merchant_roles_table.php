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

        Schema::create('merchant_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->json('permissions');
            $table->unsignedBigInteger('merchant_id'); // Creator of this role
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

          Schema::create('merchant_role_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('merchant_roles')->onDelete('cascade');

            // Prevent duplicate role assignments
            $table->unique(['merchant_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_roles');
         Schema::dropIfExists('merchant_role_user');
    }
};
