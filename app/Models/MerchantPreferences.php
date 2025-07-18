<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantPreferences extends Model
{
    protected $table    = "merchant_preferences";
      protected $fillable = [
        "merchant_id",
        'api_key', 'secret_key', 'site_token', 'monnify_api_key', 'monnify_contract_code',
        'airtime_api_url', 'transaction_api_url', 'data_network_api_url', 'data_api_url',
        'electricity_pay_api_url', 'electricity_verify_api_url', 'tv_bouquet_api_url',
        'tv_billcode_api_url', 'education_waec_registration_api_url', 'education_waec_api_url',
        'education_jamb_api_url', 'education_check_result_api_url', 'education_jamb_verify_api_url',
        'insurance_health_insurance_api_url', 'insurance_personal_accident_api_url', 'insurance_ui_insure_api_url',
        'insurance_state_api_url', 'insurance_color_api_url', 'insurance_brand_api_url',
        'insurance_engine_capacity_api_url', 'header_color', 'template_color', 'site_name', 'site_logo','test_color','site_bank_name','site_bank_account_name','site_bank_account_account','site_bank_comment','monnify_percent','whatsapp_number','welcome_message','email','bonus','company_address','company_email','company_phone'
    ];

}
