@extends('admin-layout.layouts.app')

@section('title', 'Dashboard Page')

@section('content')
@php
        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Airtime Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                <li class="breadcrumb-item active">Airtime Charge</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <!-- Main Container -->
            <div class="container main-tags">
                <div class="row">
                    <div class="col-12">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card moni-card br-2">
                                <div class="h6">{{ $airtimes->service }}</div>

                                <form id="chargeAirtimeForm">
                                    @csrf
                                    <div class="m-3">
                                        <label for="smart_earners">SMART EARNERS PERCENTAGE:</label>
                                        <input type="text" class="form-control" name="smart_earners" id="smart_earners" required value="{{ $airtimes->smart_earners_percent }}">
                                    </div>
                                    <div class="m-3">
                                        <label for="top_users">TOP USERS PERCENTAGE:</label>
                                        <input type="text" class="form-control" name="top_users" id="top_users" required value="{{ $airtimes->topuser_earners_percent }}">
                                    </div>
                                    <div class="m-3">
                                        <label for="api_percent">API PERCENTAGE:</label>
                                        <input type="text" class="form-control" name="api_percent" id="api_percent" required value="{{ $airtimes->api_earners_percent }}">
                                    </div>
                                    <div class="m-3">
                                        <button class="btn btn-primary w-100" type="submit" name="submit">SAVE CHANGE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Main Container -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12 text-center">
                    <script>document.write(new Date().getFullYear())</script> © {{ $configuration->site_name }}.
                </div>
            </div>
        </div>
    </footer>

</div>
<!-- End Main Content -->

<!-- jQuery Script -->
<script>
    $(document).ready(function() {
        $('#chargeAirtimeForm').on('submit', function(event) {
            event.preventDefault();

            var formData = {
                _token: $('input[name="_token"]').val(),
                smart_earners: $('#smart_earners').val(),  // Corrected field name
                top_users: $('#top_users').val(),
                api_percent: $('#api_percent').val()
            };

            $.ajax({
                url: '{{ route('addChargeAirtime.user', ['id' => $airtimes->id]) }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success"
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to save changes.",
                        icon: "error"
                    });
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
