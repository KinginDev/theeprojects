@extends('admin-layout.layouts.app')

@section('title', 'Dashboard Page')

@section('content')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Empty page</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Starter page</li>
                                </ol>
                            </div>



                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->

                <div class="container main-tags">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card moni-card br-2">
                                    <div class="h6">Transaction Flow</div>


                                    <form id="fundForm">
                                        @csrf
                                        <div class="m-3">
                                            <label for="">Amount</label>
                                            <input type="number" class="form-control" value=""
                                                name="amount" id="amount">
                                        </div>
                                        {{-- <div class="m-3">
                                            <label for="">User Username</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="m-3">
                                            <label for="">User Email</label>
                                            <input type="text" class="form-control">
                                        </div> --}}
                                        {{-- <div class="m-3">
                                            <label for=""></label>
                                            <input type="text" class="form-control">
                                        </div> --}}
                                        <div class="m-3">
                                            <button class="btn btn-primary w-100" type="submit" name="submit">SAVE
                                                CHANGE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container to hold the main page elements ends here-->

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
    <!-- end main content-->

    <script>
        $(document).ready(function() {
            $('#fundForm').on('submit', function(event) {
                event.preventDefault();
                var formData = {
                    _token: $('input[name="_token"]').val(),
                    amount: $('#amount').val()
                };
                $.ajax({
                    url: '{{ route('fund.user', $user->id) }}',
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
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
