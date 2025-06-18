@extends('admin-layout.layouts.app')

@section('title', 'Manage Merchant Pages')

@section('content')
@php
        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- Bootstrap Alert Container -->
                <div id="alert-container" class="alert-container" style="display: none;">
                    <div class="alert alert-dismissible fade show" role="alert">
                        <span id="alert-message"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0" style="color: #FF6600;">Manage Merchant Pages</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Manage Merchant Pages</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <!-- Page content -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #FF6600;">
                                <h5 class="card-title mb-0">Merchant Pages Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-hover table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Page Name</th>
                                                <th>Page ID</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pages as $page)
                                                <tr>
                                                    <td><strong>{{ $page->pages }}</strong></td>
                                                    <td>
                                                        @if ($page->id >= 1 && $page->id <= 17)
                                                            ADMIN
                                                        @elseif($page->id >= 18 && $page->id <= 33)
                                                            USER
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($page->action)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $page->created_at }}</td>
                                                    <td>{{ $page->updated_at }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-toggle status-toggle"
                                                            data-id="{{ $page->id }}"
                                                            data-status="{{ $page->action ? 'deactivate' : 'activate' }}"
                                                            style="background-color: {{ $page->action ? '#FF3333' : '#33CC33' }}; color: #FFF; border-radius: 15px; padding: 5px 15px;">
                                                            {{ $page->action ? 'Deactivate' : 'Activate' }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page content -->

            </div> <!-- container-fluid -->
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
    <!-- End main content -->

    <!-- Confirmation Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #FF6600; color: #FFF;">
                    <h5 class="modal-title" id="statusModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to <span id="modal-action" style="font-weight: bold;"></span> this page?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmAction"
                        style="background-color: #FF6600; border: none;">Yes, Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let selectedPageId, selectedAction;

            // Handle status toggle button click
            $('.status-toggle').on('click', function() {
                selectedPageId = $(this).data('id');
                selectedAction = $(this).data('status');

                // Set action text in the modal
                $('#modal-action').text(selectedAction);

                // Show the confirmation modal
                $('#statusModal').modal('show');
            });

            // Function to show alert
            function showAlert(message, type) {
                $('#alert-container .alert').removeClass('alert-success alert-danger').addClass('alert-' + type);
                $('#alert-message').text(message);
                $('#alert-container').fadeIn();

                // Auto-hide after 5 seconds
                setTimeout(function() {
                    $('#alert-container').fadeOut();
                }, 10000);
            }

            // Confirm action
            $('#confirmAction').on('click', function() {
                $.ajax({
                    url: `/admin/update-page-status/${selectedPageId}/${selectedAction}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.success) {
                            showAlert('Page status updated successfully.', 'success');
                            window.location.reload();
                        } else {
                            showAlert('An error occurred while updating the status.', 'danger');
                        }
                    },
                    error: function() {
                        showAlert('An error occurred while updating the status.', 'danger');
                    }
                });
            });
        });
    </script>

@endsection
