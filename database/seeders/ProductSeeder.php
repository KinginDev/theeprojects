<?php
namespace Database\Seeders;

use App\Enums\ProductTypes;
use App\Models\Percentage;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Airtime Products
            [
                'name'         => 'MTN Airtime',
                'slug'         => 'MTN_Airtime_VTU',
                'description'  => 'MTN Airtime VTU for all networks',
                'type'         => ProductTypes::AIRTIME,
                'service_name' => 'mtn',
                'is_active'    => true,
            ],
            [
                'name'         => 'Airtel Airtime',
                'slug'         => 'Airtel_Airtime_VTU',
                'description'  => 'Airtel Airtime VTU for all networks',
                'type'         => ProductTypes::AIRTIME,
                'service_name' => 'airtel',
                'is_active'    => true,
            ],
            [
                'name'         => 'Glo Airtime',
                'slug'         => 'GLO_Airtime_VTU',
                'description'  => 'Glo Airtime VTU for all networks',
                'type'         => ProductTypes::AIRTIME,
                'service_name' => 'glo',
                'is_active'    => true,
            ],
            [
                'name'         => '9mobile Airtime',
                'slug'         => '9mobile_Airtime_VTU',
                'description'  => '9mobile Airtime VTU for all networks',
                'service_name' => '9mobile',
                'type'         => ProductTypes::AIRTIME,
                'is_active'    => true,
            ],

            // Data Products
            [
                'name'         => 'MTN SME Data',
                'slug'         => 'MTN_SME_Data',
                'description'  => 'MTN SME Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'MTN SME2 Data',
                'slug'         => 'MTN_SME2_Data',
                'description'  => 'MTN SME2 Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'MTN Gifting Data',
                'slug'         => 'MTN_GIFTING_Data',
                'description'  => 'MTN Gifting Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'MTN Corporate Gifting Data',
                'slug'         => 'MTN_CORPORATE_GIFTING_Data',
                'description'  => 'MTN Corporate Gifting Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'Airtel Gifting Data',
                'slug'         => 'Airtel_GIFTING_Data',
                'description'  => 'Airtel Gifting Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'Airtel Corporate Gifting Data',
                'slug'         => 'Airtel_CORPORATE_GIFTING_Data',
                'description'  => 'Airtel Corporate Gifting Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'Glo Gifting Data',
                'slug'         => 'GLO_GIFTING_Data',
                'description'  => 'Glo Gifting Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'Glo Corporate Gifting Data',
                'slug'         => 'GLO_CORPORATE_GIFTING_Data',
                'description'  => 'Glo Corporate Gifting Data bundles',
                'type'         => ProductTypes::DATA,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => '9mobile Gifting Data',
                'slug'         => '9mobile_GIFTING_Data',
                'description'  => '9mobile Gifting Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => '9mobile Corporate Gifting Data',
                'slug'         => '9mobile_CORPORATE_GIFTING_Data',
                'description'  => '9mobile Corporate Gifting Data bundles',
                'service_name' => null,
                'type'         => ProductTypes::DATA,
                'is_active'    => true,
            ],
            [
                'name'         => 'Smile  Payment',
                'slug'         => 'Smile_Payment',
                'description'  => 'Smile Network Data bundles',
                'type'         => ProductTypes::DATA,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'Spectranet Internet Data',
                'slug'         => 'Spectranet_Internet_Data',
                'description'  => 'Spectranet Internet Data bundles',
                'type'         => ProductTypes::DATA,
                'service_name' => null,
                'is_active'    => true,
            ],

            // TV Products
            [
                'name'         => 'DSTV Subscription',
                'slug'         => 'DSTV_Subscription',
                'description'  => 'DSTV subscription packages',
                'type'         => ProductTypes::TV,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'GOTV Subscription',
                'slug'         => 'Gotv_Payment',
                'description'  => 'GOTV subscription packages',
                'type'         => ProductTypes::TV,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'Startimes Subscription',
                'slug'         => 'Startimes_Subscription',
                'description'  => 'Startimes subscription packages',
                'type'         => ProductTypes::TV,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'Showmax Subscription',
                'slug'         => 'ShowMax',
                'description'  => 'Showmax subscription packages',
                'type'         => ProductTypes::TV,
                'service_name' => null,
                'is_active'    => true,
            ],

            // Electricity Products
            [
                'name'         => 'Aba Electric Payment',
                'slug'         => 'Aba_Electric_Payment_-_ABEDC',
                'description'  => 'Aba Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'is_active'    => true,
                'service_name' => "aba-electric",
            ],
            [
                'name'         => 'Abuja Electricity Distribution',
                'slug'         => 'Abuja_Electricity_Distribution_Company_-_AEDC',
                'description'  => 'Abuja Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'is_active'    => true,
                'service_name' => "abuja-electric",
            ],
            [
                'name'         => 'Benin Electricity',
                'slug'         => 'Benin_Electricity_-_BEDC',
                'description'  => 'Benin Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'is_active'    => true,
                'service_name' => "benin-electric",
            ],
            [
                'name'         => 'Eko Electric Payment',
                'slug'         => 'Eko_Electric_Payment_-_EKEDC',
                'description'  => 'Eko Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "eko-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Enugu Electric',
                'slug'         => 'Enugu_Electric_-_EEDC',
                'description'  => 'Enugu Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "enugu-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Ibadan Electric',
                'slug'         => 'IBEDC_-_Ibadan_Electricity_Distribution_Company',
                'description'  => 'Ibadan Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "ibadan-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Ikeja Electric Payment',
                'slug'         => 'Ikeja_Electric_Payment_-_IKEDC',
                'description'  => 'Ikeja Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "ikeja-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Jos Electric',
                'slug'         => 'Jos_Electric_-_JED',
                'description'  => 'Jos Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "jos-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Kaduna Electric',
                'slug'         => 'Kaduna_Electric_-_KAEDCO',
                'description'  => 'Kaduna Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "kaduna-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Kano Electric',
                'slug'         => 'KEDCO_-_Kano_Electric',
                'description'  => 'Kano Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "kano-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Port Harcourt Electric',
                'slug'         => 'PHED_-_Port_Harcourt_Electric',
                'description'  => 'Port Harcourt Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "portharcourt-electric",
                'is_active'    => true,
            ],
            [
                'name'         => 'Yola Electric',
                'slug'         => 'Yola_Electric_Disco_Payment_-_YEDC',
                'description'  => 'Yola Electricity Distribution Company bill payment',
                'type'         => ProductTypes::ELECTRICITY,
                'service_name' => "yola-electric",
                'is_active'    => true,
            ],

            // Education Products
            [
                'name'         => 'WAEC Result Checker',
                'slug'         => 'WAEC_Result_Checker_PIN',
                'description'  => 'WAEC result checker PIN',
                'type'         => ProductTypes::EDUCATION,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'WAEC Registration',
                'slug'         => 'WAEC_Registration_PIN',
                'description'  => 'WAEC registration PIN',
                'type'         => ProductTypes::EDUCATION,
                'service_name' => null,
                'is_active'    => true,
            ],

            // Insurance Products
            [
                'name'         => 'Personal Accident Insurance',
                'slug'         => 'Personal_Accident_Insurance',
                'description'  => 'Personal accident insurance coverage',
                'type'         => ProductTypes::INSURANCE,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'Third Party Motor Insurance',
                'slug'         => 'Third_Party_Motor_Insurance_-_Universal_Insurance',
                'description'  => 'Third party motor insurance - Universal Insurance',
                'type'         => ProductTypes::INSURANCE,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'Home Cover Insurance',
                'slug'         => 'Home_Cover_Insurance',
                'description'  => 'Home cover insurance protection',
                'type'         => ProductTypes::INSURANCE,
                'service_name' => null,
                'is_active'    => true,
            ],

            // Other Products
            [
                'name'         => 'VTpass POS Terminal Payment',
                'slug'         => 'VTpass_POS_Terminal_Payment',
                'description'  => 'VTpass POS Terminal Payment services',
                'type'         => ProductTypes::OTHER,
                'service_name' => null,
                'is_active'    => true,
            ],
            [
                'name'         => 'SMSclone.com',
                'slug'         => 'SMSclone.com',
                'description'  => 'SMSclone.com services',
                'type'         => ProductTypes::OTHER,
                'service_name' => null,
                'is_active'    => true,
            ],
        ];

        Schema::disableForeignKeyConstraints();
        if (Product::count() > 1) {
            Product::truncate();
        }
        Schema::enableForeignKeyConstraints();

        Product::insert($products);

        $products = Product::all();
        foreach ($products as $product) {
            Percentage::where('service', $product->slug)
                ->update(['product_id' => $product->id]);
        }
    }
}
