@extends('admin-layout.layouts.app')

@section('title', 'Site Settings')

@section('content')

    <!-- ============================================================== -->
    <!-- Start Right Content Here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- Start Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0" style="color: #FF6600 !important;">Site Settings</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                    <li class="breadcrumb-item active">Site Settings</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page Title -->
                <!-- Display success message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Site Settings Form -->
                <div class="container main-tags">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <div class="card">
                                <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                    <h5 class="card-title mb-0">Configure Site Settings</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('settings.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- General Settings -->
                                        <div class="mb-3">
                                            <label for="site_name" class="form-label">Site Name</label>
                                            <input type="text" class="form-control" id="site_name" name="site_name"
                                                value="{{ old('site_name', $settings->site_name ?? '') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_logo" class="form-label">Site Logo</label>
                                            <input type="file" class="form-control" id="site_logo" name="site_logo"
                                                accept="image/*">
                                            @if (isset($settings->site_logo))
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $settings->site_logo) }}"
                                                        alt="Site Logo" style="max-height: 100px;">
                                                </div>
                                            @endif



                                        </div>
                                        <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                            <h5 class="card-title mb-0">Api Site Settings</h5>
                                        </div>

                                        <!-- API Keys and Tokens -->
                                        <div class="mb-3 mt-3">
                                            <label for="api_key" class="form-label">VTPASS API Key</label>
                                            <input type="text" class="form-control" id="api_key" name="api_key"
                                                value="{{ old('api_key', $settings->api_key ?? '') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="secret_key" class="form-label">VTPASS Secret Key</label>
                                            <input type="text" class="form-control" id="secret_key" name="secret_key"
                                                value="{{ old('secret_key', $settings->secret_key ?? '') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_token" class="form-label"> Lucysrosedata Site Token</label>
                                            <input type="text" class="form-control" id="site_token" name="site_token"
                                                value="{{ old('site_token', $settings->site_token ?? '') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="monnify_api_key" class="form-label">Monnify API Key</label>
                                            <input type="text" class="form-control" id="monnify_api_key"
                                                name="monnify_api_key"
                                                value="{{ old('monnify_api_key', $settings->monnify_api_key ?? '') }}"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="monnify_contract_code" class="form-label">Monnify Contract
                                                Code</label>
                                            <input type="text" class="form-control" id="monnify_contract_code"
                                                name="monnify_contract_code"
                                                value="{{ old('monnify_contract_code', $settings->monnify_contract_code ?? '') }}"
                                                required>
                                        </div>


                                        @if ($user->role == 0)
                                            <!-- API URLs -->
                                            <div class="mb-3">
                                                <label for="airtime_api_url" class="form-label">Airtime API URL</label>
                                                <input type="text" class="form-control" id="airtime_api_url"
                                                    name="airtime_api_url"
                                                    value="{{ old('airtime_api_url', $settings->airtime_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="transaction_api_url" class="form-label">Transaction API
                                                    URL</label>
                                                <input type="text" class="form-control" id="transaction_api_url"
                                                    name="transaction_api_url"
                                                    value="{{ old('transaction_api_url', $settings->transaction_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="data_network_api_url" class="form-label">Data Network API
                                                    URL</label>
                                                <input type="text" class="form-control" id="data_network_api_url"
                                                    name="data_network_api_url"
                                                    value="{{ old('data_network_api_url', $settings->data_network_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="data_api_url" class="form-label">Data API URL</label>
                                                <input type="text" class="form-control" id="data_api_url"
                                                    name="data_api_url"
                                                    value="{{ old('data_api_url', $settings->data_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="data_mtn" class="form-label">Data API MTN</label>
                                                <input type="text" class="form-control" id="data_mtn"
                                                    name="data_mtn"
                                                    value="{{ old('data_api_url', $settings->data_mtn ?? '') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="data_airtime" class="form-label">Data API AIRTEL</label>
                                                <input type="text" class="form-control" id="data_airtime"
                                                    name="data_airtime"
                                                    value="{{ old('data_api_url', $settings->data_airtime ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="electricity_pay_api_url" class="form-label">Electricity Pay
                                                    API
                                                    URL</label>
                                                <input type="text" class="form-control" id="electricity_pay_api_url"
                                                    name="electricity_pay_api_url"
                                                    value="{{ old('electricity_pay_api_url', $settings->electricity_pay_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="electricity_verify_api_url" class="form-label">Electricity
                                                    Verify
                                                    API URL</label>
                                                <input type="text" class="form-control"
                                                    id="electricity_verify_api_url" name="electricity_verify_api_url"
                                                    value="{{ old('electricity_verify_api_url', $settings->electricity_verify_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tv_bouquet_api_url" class="form-label">TV Bouquet API
                                                    URL</label>
                                                <input type="text" class="form-control" id="tv_bouquet_api_url"
                                                    name="tv_bouquet_api_url"
                                                    value="{{ old('tv_bouquet_api_url', $settings->tv_bouquet_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tv_billcode_api_url" class="form-label">TV Billcode API
                                                    URL</label>
                                                <input type="text" class="form-control" id="tv_billcode_api_url"
                                                    name="tv_billcode_api_url"
                                                    value="{{ old('tv_billcode_api_url', $settings->tv_billcode_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="education_waec_registration_api_url" class="form-label">WAEC
                                                    Registration API URL</label>
                                                <input type="text" class="form-control"
                                                    id="education_waec_registration_api_url"
                                                    name="education_waec_registration_api_url"
                                                    value="{{ old('education_waec_registration_api_url', $settings->education_waec_registration_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="education_waec_api_url" class="form-label">WAEC API
                                                    URL</label>
                                                <input type="text" class="form-control" id="education_waec_api_url"
                                                    name="education_waec_api_url"
                                                    value="{{ old('education_waec_api_url', $settings->education_waec_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="education_jamb_api_url" class="form-label">JAMB API
                                                    URL</label>
                                                <input type="text" class="form-control" id="education_jamb_api_url"
                                                    name="education_jamb_api_url"
                                                    value="{{ old('education_jamb_api_url', $settings->education_jamb_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="education_check_result_api_url" class="form-label">Check
                                                    Result
                                                    API URL</label>
                                                <input type="text" class="form-control"
                                                    id="education_check_result_api_url"
                                                    name="education_check_result_api_url"
                                                    value="{{ old('education_check_result_api_url', $settings->education_check_result_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="education_jamb_verify_api_url" class="form-label">JAMB Verify
                                                    API
                                                    URL</label>
                                                <input type="text" class="form-control"
                                                    id="education_jamb_verify_api_url"
                                                    name="education_jamb_verify_api_url"
                                                    value="{{ old('education_jamb_verify_api_url', $settings->education_jamb_verify_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="insurance_health_insurance_api_url" class="form-label">Health
                                                    Insurance API URL</label>
                                                <input type="text" class="form-control"
                                                    id="insurance_health_insurance_api_url"
                                                    name="insurance_health_insurance_api_url"
                                                    value="{{ old('insurance_health_insurance_api_url', $settings->insurance_health_insurance_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="insurance_personal_accident_api_url"
                                                    class="form-label">Personal
                                                    Accident API URL</label>
                                                <input type="text" class="form-control"
                                                    id="insurance_personal_accident_api_url"
                                                    name="insurance_personal_accident_api_url"
                                                    value="{{ old('insurance_personal_accident_api_url', $settings->insurance_personal_accident_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="insurance_ui_insure_api_url" class="form-label">UI Insure API
                                                    URL</label>
                                                <input type="text" class="form-control"
                                                    id="insurance_ui_insure_api_url" name="insurance_ui_insure_api_url"
                                                    value="{{ old('insurance_ui_insure_api_url', $settings->insurance_ui_insure_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="insurance_state_api_url" class="form-label">Insurance State
                                                    API
                                                    URL</label>
                                                <input type="text" class="form-control" id="insurance_state_api_url"
                                                    name="insurance_state_api_url"
                                                    value="{{ old('insurance_state_api_url', $settings->insurance_state_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="insurance_color_api_url" class="form-label">Insurance Color
                                                    API
                                                    URL</label>
                                                <input type="text" class="form-control" id="insurance_color_api_url"
                                                    name="insurance_color_api_url"
                                                    value="{{ old('insurance_color_api_url', $settings->insurance_color_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="insurance_brand_api_url" class="form-label">Insurance Brand
                                                    API
                                                    URL</label>
                                                <input type="text" class="form-control" id="insurance_brand_api_url"
                                                    name="insurance_brand_api_url"
                                                    value="{{ old('insurance_brand_api_url', $settings->insurance_brand_api_url ?? '') }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="insurance_engine_capacity_api_url"
                                                    class="form-label">Insurance
                                                    Engine Capacity API URL</label>
                                                <input type="text" class="form-control"
                                                    id="insurance_engine_capacity_api_url"
                                                    name="insurance_engine_capacity_api_url"
                                                    value="{{ old('insurance_engine_capacity_api_url', $settings->insurance_engine_capacity_api_url ?? '') }}"
                                                    required>
                                            </div>
                                        @endif
                                        <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                            <h5 class="card-title mb-0">Site Color Settings</h5>
                                        </div>

                                        <!-- Color Settings -->
                                        <div class="mb-3 mt-5">
                                            <label for="header_color" class="form-label">Header Color</label>
                                            <input type="color" class="form-control form-control-color"
                                                id="header_color" name="header_color"
                                                value="{{ old('header_color', $settings->header_color ?? '#FFFFFF') }}"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="template_color" class="form-label">Template Background
                                                Color</label>
                                            <input type="color" class="form-control form-control-color"
                                                id="template_color" name="template_color"
                                                value="{{ old('template_color', $settings->template_color ?? '#FFFFFF') }}"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="test_color" class="form-label">Text
                                                Color</label>
                                            <input type="color" class="form-control form-control-color" id="test_color"
                                                name="test_color"
                                                value="{{ old('test_color', $settings->test_color ?? '#FFFFFF') }}"
                                                required>
                                        </div>

                                        <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                            <h5 class="card-title mb-0">Bank Account Settings</h5>
                                        </div>

                                        <div class="mb-3 mt-5">
                                            <label for="site_bank_name" class="form-label">Bank Name</label>
                                            <input type="text" class="form-control" id="site_bank_name"
                                                name="site_bank_name"
                                                value="{{ old('site_bank_name', $settings->site_bank_name ?? '') }}"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_bank_account_name" class="form-label">Bank Acoount
                                                Name</label>
                                            <input type="text" class="form-control" id="site_bank_account_name"
                                                name="site_bank_account_name"
                                                value="{{ old('site_bank_account_name', $settings->site_bank_account_name ?? '') }}"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_bank_account_account" class="form-label">Bank Account
                                                Number</label>
                                            <input type="text" class="form-control" id="site_bank_account_account"
                                                name="site_bank_account_account"
                                                value="{{ old('site_bank_account_account', $settings->site_bank_account_account ?? '') }}"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_bank_comment" class="form-label">Comment</label>
                                            <textarea name="site_bank_comment" id="site_bank_comment" cols="30" rows="10" style="width: 100%;"
                                                required>{{ old('site_bank_comment', $settings->site_bank_comment ?? '') }}</textarea>

                                        </div>
                                        <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                            <h5 class="card-title mb-0">WhatsApp Chat Settings</h5>
                                        </div>
                                        <div class="mb-3 mt-5">
                                            <label for="whatsapp_number" class="form-label">WhatsApp Number (eg :
                                                234234567890)</label>
                                            <input type="text" class="form-control" id="whatsapp_number"
                                                name="whatsapp_number"
                                                value="{{ old('whatsapp_number', $settings->whatsapp_number ?? '') }}"
                                                required>
                                        </div>
                                        <div class="mb-3 mt-5">
                                            <label for="welcome_message" class="form-label">Welcome Message</label>
                                            <textarea name="welcome_message" id="welcome_message" cols="30" rows="10" style="width: 100%;" required>{{ old('welcome_message', $settings->welcome_message ?? '') }}</textarea>
                                        </div>
                                        <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                            <h5 class="card-title mb-0">Email Settings</h5>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="admin_receive_email" class="form-label">Admin Receive
                                                Email</label>
                                            <input type="text" class="form-control" id="admin_receive_email"
                                                name="email"
                                                value="{{ old('email', $settings->email ?? '') }}" required>
                                        </div>

                                        <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                            <h5 class="card-title mb-0">Other Settings</h5>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="monnify_percent" class="form-label">Monnify Percent</label>
                                            <input type="text" class="form-control" id="monnify_percent"
                                                name="monnify_percent"
                                                value="{{ old('monnify_percent', $settings->monnify_percent ?? '') }}" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="bonus" class="form-label">Referral Bonus %</label>
                                            <input type="text" class="form-control" id="bonus"
                                                name="bonus"
                                                value="{{ old('bonus', $settings->bonus ?? '') }}" required>
                                        </div>


                                         <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                            <h5 class="card-title mb-0">Site Address section Settings</h5>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="monnify_percent" class="form-label">Company Address</label>
                                            <input type="text" class="form-control" id=""
                                                name="company_address"
                                                value="{{$settings->company_address}}" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="bonus" class="form-label">Company Email</label>
                                            <input type="text" class="form-control" id="bonus"
                                                name="company_email"
                                                value="{{$settings->company_email}}" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="bonus" class="form-label">Company Phone no.</label>
                                            <input type="text" class="form-control" id="bonus"
                                                name="company_phone"
                                                value="{{$settings->company_phone}}" required>
                                        </div>





                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"
                                                style="background-color: #FF6600 !important;">Update Settings</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- End Site Settings Form -->

            </div>
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ $configuration->site_name }}.
                    </div>

                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->
@endsection
