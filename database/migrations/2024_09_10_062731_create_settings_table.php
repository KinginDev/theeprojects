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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('api_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->string('site_token')->nullable();
            $table->string('monnify_api_key')->nullable();
            $table->string('monnify_secret_key')->nullable();
            $table->string('monnify_percent')->nullable();
            $table->string('monnify_contract_code')->nullable();
            $table->string('airtime_api_url')->nullable();
            $table->string('transaction_api_url')->nullable();
            $table->string('data_network_api_url')->nullable();
            $table->string('data_api_url')->nullable();
            $table->string('data_mtn')->nullable();
            $table->string('data_airtime')->nullable();
            $table->string('electricity_pay_api_url')->nullable();
            $table->string('electricity_verify_api_url')->nullable();
            $table->string('tv_bouquet_api_url')->nullable();
            $table->string('tv_billcode_api_url')->nullable();
            $table->string('education_waec_registration_api_url')->nullable();
            $table->string('education_waec_api_url')->nullable();
            $table->string('education_jamb_api_url')->nullable();
            $table->string('education_check_result_api_url')->nullable();
            $table->string('education_jamb_verify_api_url')->nullable();
            $table->string('education_purchase_api_url')->nullable();
            $table->string('insurance_health_insurance_api_url')->nullable();
            $table->string('insurance_personal_accident_api_url')->nullable();
            $table->string('insurance_ui_insure_api_url')->nullable();
            $table->string('insurance_state_api_url')->nullable();
            $table->string('insurance_color_api_url')->nullable();
            $table->string('insurance_brand_api_url')->nullable();
            $table->string('insurance_engine_capacity_api_url')->nullable();
            $table->string('header_color')->nullable();
            $table->string('template_color')->nullable();
            $table->string('test_color')->nullable();
            $table->string('site_name')->nullable();       // Add site name
            $table->string('site_logo')->nullable();       // Add site logo
            $table->string('company_name')->nullable();    // Add company name
            $table->string('company_address')->nullable(); // Add company address
            $table->string('company_phone')->nullable();   // Add company phone
            $table->string('company_email')->nullable();   // Add company phone

            $table->string('site_bank_name')->nullable();            // Add site bank name
            $table->string('site_bank_account_name')->nullable();    // Add site bank account name
            $table->string('site_bank_account_account')->nullable(); // Add site bank account number
            $table->string('bonus')->nullable();                     // Bonus
            $table->text('site_bank_comment')->nullable();           // Add site bank comment
            $table->text('whatsapp_number')->nullable();             // Add WhatsApp number
            $table->text('welcome_message')->nullable();             // Add welcome message
            $table->text('email')->nullable();                       // Add site email
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
