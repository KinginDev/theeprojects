<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_transactions', function (Blueprint $table) {
            $table->id();                                        // Auto-incrementing primary key
            $table->string('username');                          // Username of the user
            $table->string('product_name');                      // Name of the insurance product
            $table->string('type');                              // Type of insurance
            $table->string('tel');                               // Phone number
            $table->decimal('amount', 10, 2);                    // Amount paid
            $table->string('reference')->unique();               // Unique transaction ID
            $table->text('purchased_code')->nullable();          // Purchased code (nullable)
            $table->text('response_description')->nullable();    // Response description (nullable)
            $table->timestamp('transaction_date')->useCurrent(); // Transaction date
            $table->string('identity');                          // Identity field
            $table->string('prev_bal');
            $table->string('current_bal');
            $table->string('percent_profit');
            $table->string('status'); // Status of the transaction
            $table->timestamps();     // Laravel timestamps (created_at and updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_transactions');
    }
}
