@extends('merchant-layout.layouts.app')

@section('title', 'Site Settings')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/style/settings.css') }}">

@endpush

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid settings-container">
                <!-- Start Page Title -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 text-primary">Site Settings</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                    <li class="breadcrumb-item active">Site Settings</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="settings-card">
                    <ul class="nav nav-tabs settings-nav" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                                type="button" role="tab" aria-controls="general" aria-selected="true"
                                data-tab-id="general">
                                <i class="bi bi-gear me-2"></i>General
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="api-tab" data-bs-toggle="tab" data-bs-target="#api"
                                type="button" role="tab" aria-controls="api" aria-selected="false" data-tab-id="api">
                                <i class="bi bi-code-square me-2"></i>API Settings
                            </button>
                        </li>
                         <li class="nav-item" role="presentation">
                            <button class="nav-link" id="domain-tab" data-bs-toggle="tab" data-bs-target="#domain"
                                type="button" role="tab" aria-controls="domain" aria-selected="false"
                                data-tab-id="domain">
                                <i class="bi bi-globe me-2"></i>Domain Settings
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance"
                                type="button" role="tab" aria-controls="appearance" aria-selected="false"
                                data-tab-id="appearance">
                                <i class="bi bi-palette me-2"></i>Appearance
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="banking-tab" data-bs-toggle="tab" data-bs-target="#banking"
                                type="button" role="tab" aria-controls="banking" aria-selected="false"
                                data-tab-id="banking">
                                <i class="bi bi-bank me-2"></i>Banking
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="communication-tab" data-bs-toggle="tab"
                                data-bs-target="#communication" type="button" role="tab" aria-controls="communication"
                                aria-selected="false" data-tab-id="communication">
                                <i class="bi bi-chat-dots me-2"></i>Communication
                            </button>
                        </li>
                    </ul>

                    <form action="{{ route('merchant.settings.update') }}" method="POST" enctype="multipart/form-data"
                        class="p-4">
                        @csrf
                        @method('PUT')

                        <div class="tab-content" id="settingsTabContent">
                            <!-- General Tab -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <div class="settings-section">
                                    <div class="settings-section-header">
                                        <h5 class="mb-4">Basic Information</h5>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="site_name" class="form-label">Site Name</label>
                                                <input type="text"
                                                    class="form-control @error('site_name') is-invalid @enderror"
                                                    id="site_name" name="site_name"
                                                    value="{{ old('site_name', $settings->site_name ?? '') }}" required>
                                                @error('site_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="site_logo" class="form-label">Site Logo</label>
                                                <input type="file"
                                                    class="form-control @error('site_logo') is-invalid @enderror"
                                                    id="site_logo" name="site_logo" accept="image/*">
                                                @error('site_logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if (isset($settings->site_logo))
                                                    <img src="{{ asset('storage/' . $settings->site_logo) }}"
                                                        alt="Site Logo" class="logo-preview mt-2" width="100px"
                                                        height="100px">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- API Settings Tab -->
                            <div class="tab-pane fade" id="api" role="tabpanel">
                                <div class="settings-section">
                                    <div class="settings-section-header">
                                        <h5 class="mb-4">API Configuration</h5>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="site_token" class="form-label">LucyRoseData Site Token</label>
                                                <div class="input-group">
                                                    <input type="password"
                                                        class="form-control api-key-field @error('site_token') is-invalid @enderror"
                                                        id="site_token" name="site_token"
                                                        value="{{ old('site_token', $settings->site_token ?? '') }}"
                                                        required>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword('site_token')">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    @error('site_token')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="api_key" class="form-label">VTPASS API Key</label>
                                                    <div class="input-group">
                                                        <input type="password"
                                                            class="form-control api-key-field @error('api_key') is-invalid @enderror"
                                                            id="api_key" name="api_key"
                                                            value="{{ old('api_key', $settings->api_key ?? '') }}"
                                                            required>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="togglePassword('api_key')">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        @error('api_key')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="secret_key" class="form-label">VTPASS Secret Key</label>
                                                    <div class="input-group">
                                                        <input type="password"
                                                            class="form-control api-key-field @error('secret_key') is-invalid @enderror"
                                                            id="secret_key" name="secret_key"
                                                            value="{{ old('secret_key', $settings->secret_key ?? '') }}"
                                                            required>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="togglePassword('secret_key')">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        @error('secret_key')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="monnify_api_key" class="form-label">MONNIFY Secret
                                                        Key</label>
                                                    <div class="input-group">
                                                        <input type="password"
                                                            class="form-control api-key-field @error('monnify_api_key') is-invalid @enderror"
                                                            id="monnify_api_key" name="monnify_api_key"
                                                            value="{{ old('monnify_api_key', $settings->monnify_api_key ?? '') }}"
                                                            required>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="togglePassword('monnify_api_key')">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        @error('monnify_api_key')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="monnify_contract_code" class="form-label">MONNIFY Contract
                                                        Code</label>
                                                    <div class="input-group">
                                                        <input type="password"
                                                            class="form-control api-key-field @error('monnify_contract_code') is-invalid @enderror"
                                                            id="monnify_contract_code" name="monnify_contract_code"
                                                            value="{{ old('monnify_contract_code', $settings->monnify_contract_code ?? '') }}"
                                                            required>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="togglePassword('monnify_contract_code')">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        @error('monnify_contract_code')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="monnify_percent" class="form-label">MONNIFY
                                                        Percent</label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control api-key-field @error('monnify_percent') is-invalid @enderror"
                                                            id="monnify_percent" name="monnify_percent"
                                                            value="{{ old('monnify_percent', $settings->monnify_percent ?? '') }}"
                                                            required>
                                                        @error('monnify_percent')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Domain Settings Tab -->
<div class="tab-pane fade" id="domain" role="tabpanel">
    <div class="settings-section">
        <div class="settings-section-header">
            <h5 class="mb-4">Domain Configuration</h5>
        </div>

        <!-- Current Domain Info -->
        <div class="alert alert-info mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Current Domain</strong>
            </div>
            <p class="mb-1">Your current domain: <strong>{{ $merchant->domain }}</strong></p>
            @if(str_contains($merchant->domain, env('APP_DOMAIN')))
                <small class="text-muted">This is your default subdomain.</small>
            @else
                <small class="text-muted">This is your custom domain.</small>
            @endif
        </div>

        <!-- External Domain Settings -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">Domain Settings</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="external_domain" class="form-label">Custom Domain</label>
                            <div class="input-group">
                                <input type="text"
                                    class="form-control @error('external_domain') is-invalid @enderror"
                                    id="external_domain"
                                    name="external_domain"
                                    placeholder="example.com"
                                    value="{{ old('external_domain', $merchant->domain) }}">
                                @if(!str_contains($merchant->domain, env('APP_DOMAIN')) && $merchant->external_domain_active)
                                    <span class="input-group-text bg-success text-white">
                                        <i class="bi bi-check-circle-fill"></i> Active
                                    </span>
                                @elseif(!str_contains($merchant->domain, env('APP_DOMAIN')) && !$merchant->external_domain_active)
                                    <span class="input-group-text bg-warning text-dark">
                                        <i class="bi bi-exclamation-triangle-fill"></i> Pending
                                    </span>
                                @endif
                                @error('external_domain')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Enter your domain without "http://" or "www" (e.g., example.com)</small>
                        </div>
                    </div>
                </div>

                <!-- DNS Setup Instructions -->
                <div class="mt-4">
                    <h6 class="text-primary mb-3"><i class="bi bi-lightbulb me-2"></i>How to set up your custom domain</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-2">To connect your custom domain, add the following DNS records at your domain registrar:</p>
                        <ol class="mb-0">
                            <li class="mb-2">
                                <strong>A Record:</strong>
                                <ul class="ps-3">
                                    <li>Host: @ or leave empty</li>
                                    <li>Value: 123.456.789.123 (Our server IP)</li>
                                    <li>TTL: 3600 or automatic</li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <strong>CNAME Record:</strong>
                                <ul class="ps-3">
                                    <li>Host: www</li>
                                    <li>Value: {{ explode('.', $merchant->domain)[0] }}.{{ env('APP_DOMAIN') }}.</li>
                                    <li>TTL: 3600 or automatic</li>
                                </ul>
                            </li>
                        </ol>
                        <p class="mt-3 mb-1 text-muted"><small>Note: DNS changes may take up to 48 hours to propagate globally.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                            <!-- Appearance Tab -->
                            <div class="tab-pane fade" id="appearance" role="tabpanel">
                                <div class="settings-section">
                                    <div class="settings-section-header">
                                        <h5 class="mb-4">Visual Customization</h5>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="header_color" class="form-label">Header Color</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="color"
                                                        class="form-control form-control-color @error('header_color') is-invalid @enderror"
                                                        id="header_color" name="header_color"
                                                        value="{{ old('header_color', $settings->header_color ?? '#FF6600') }}">
                                                    <div class="color-preview"
                                                        style="background-color: {{ old('header_color', $settings->header_color ?? '#FF6600') }}">
                                                    </div>
                                                    @error('header_color')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="template_color" class="form-label">Background Color</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="color"
                                                        class="form-control form-control-color @error('template_color') is-invalid @enderror"
                                                        id="template_color" name="template_color"
                                                        value="{{ old('template_color', $settings->template_color ?? '#FFFFFF') }}">
                                                    <div class="color-preview"
                                                        style="background-color: {{ old('template_color', $settings->template_color ?? '#FFFFFF') }}">
                                                    </div>
                                                    @error('template_color')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="test_color" class="form-label">Text Color</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="color"
                                                        class="form-control form-control-color @error('test_color') is-invalid @enderror"
                                                        id="test_color" name="test_color"
                                                        value="{{ old('test_color', $settings->test_color ?? '#000000') }}">
                                                    <div class="color-preview"
                                                        style="background-color: {{ old('test_color', $settings->test_color ?? '#000000') }}">
                                                    </div>
                                                    @error('test_color')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Banking Tab -->
                            <div class="tab-pane fade" id="banking" role="tabpanel">
                                <div class="settings-section">
                                    <div class="settings-section-header">
                                        <h5 class="mb-4">Banking Information</h5>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="site_bank_name" class="form-label">Bank Name</label>
                                                <input type="text"
                                                    class="form-control @error('site_bank_name') is-invalid @enderror"
                                                    id="site_bank_name" name="site_bank_name"
                                                    value="{{ old('site_bank_name', $settings->site_bank_name ?? '') }}"
                                                    required>
                                                @error('site_bank_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="site_bank_account_name" class="form-label">Account
                                                    Name</label>
                                                <input type="text"
                                                    class="form-control @error('site_bank_account_name') is-invalid @enderror"
                                                    id="site_bank_account_name" name="site_bank_account_name"
                                                    value="{{ old('site_bank_account_name', $settings->site_bank_account_name ?? '') }}"
                                                    required>
                                                @error('site_bank_account_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="site_bank_account_account" class="form-label">Account
                                                    Number</label>
                                                <input type="text"
                                                    class="form-control @error('site_bank_account_account') is-invalid @enderror"
                                                    id="site_bank_account_account" name="site_bank_account_account"
                                                    value="{{ old('site_bank_account_account', $settings->site_bank_account_account ?? '') }}"
                                                    required>
                                                @error('site_bank_account_account')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="site_bank_comment" class="form-label">Comment</label>
                                                <textarea class="form-control @error('site_bank_comment') is-invalid @enderror" id="site_bank_comment"
                                                    name="site_bank_comment" required rows="4">{{ old('site_bank_comment', $settings->site_bank_comment ?? '') }}</textarea>
                                                @error('site_bank_comment')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Communication Tab -->
                            <div class="tab-pane fade" id="communication" role="tabpanel">
                                <div class="settings-section">
                                    <div class="settings-section-header">
                                        <h5 class="mb-4">Communication Settings</h5>
                                    </div>

                                    <!-- WhatsApp Section -->
                                    <div class="mb-4">
                                        <h6 class="text-muted mb-3">WhatsApp Configuration</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="whatsapp_number" class="form-label">WhatsApp
                                                        Number</label>
                                                    <input type="text"
                                                        class="form-control @error('whatsapp_number') is-invalid @enderror"
                                                        id="whatsapp_number" name="whatsapp_number"
                                                        placeholder="234234567890"
                                                        value="{{ old('whatsapp_number', $settings->whatsapp_number ?? '') }}"
                                                        required>
                                                    <small class="form-text text-muted">Format: Country code followed by
                                                        number (e.g., 234234567890)</small>
                                                    @error('whatsapp_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="welcome_message" class="form-label">Welcome
                                                        Message</label>
                                                    <textarea class="form-control @error('welcome_message') is-invalid @enderror" id="welcome_message"
                                                        name="welcome_message" rows="4" required>{{ old('welcome_message', $settings->welcome_message ?? '') }}</textarea>
                                                    @error('welcome_message')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Section -->
                                    <div>
                                        <h6 class="text-muted mb-3">Email Configuration</h6>
                                        <div class="form-group">
                                            <label for="admin_receive_email" class="form-label">Admin Email
                                                Address</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="admin_receive_email" name="email"
                                                value="{{ old('email', $settings->email ?? '') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="bi bi-save me-2"></i>Save Changes
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ $configuration->site_name }}
                    </div>
                </div>
            </div>
        </footer>
    </div>

@endsection
