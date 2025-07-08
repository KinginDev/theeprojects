@extends('merchant-layout.layouts.app')

@section('title', 'Create New Menu')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create New Menu</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('merchant.menus.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Menu Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Menu Location</label>
                                        <select class="form-select" id="location" name="location">
                                            @foreach ($locations as $location)
                                                <option value="{{ $location }}">{{ ucfirst($location) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                            value="1" checked>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Create Menu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">CMS Menus</h4>
                                <div class="card-tools">
                                    <a href="{{ route('merchant.menus.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add New Menu
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menus as $menu)
                                            <tr>
                                                <td>{{ $menu->name }}</td>
                                                <td>{{ ucfirst($menu->location) }}</td>
                                                <td>{{ $menu->is_active ? 'Active' : 'Inactive' }}</td>
                                                <td>
                                                    <a href="{{ route('merchant.menus.edit', $menu->id) }}"
                                                        class="btn btn-sm btn-info">Edit</a>
                                                    <form action="{{ route('merchant.menus.destroy', $menu->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $menus->links() }}
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    @if (isset($menu))
        <script>
            $(document).ready(function() {
                // Handle form submission for adding menu items
                $('form').on('submit', function(e) {
                    e.preventDefault();
                    var form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            // Handle success response
                            location.reload();
                        },
                        error: function(xhr) {
                            // Handle error response
                            alert('Error: ' + xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            // Initialize sortable functionality for menu items
            $('.menu-items-sortable').sortable({
                handle: '.menu-item-handle',
                update: function(event, ui) {
                    var sortedIDs = $(this).sortable('toArray');
                    $.ajax({
                        url: '{{ route('merchant.menu-items.sort') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            sorted_ids: sortedIDs
                        },
                        success: function(response) {
                            // Handle success response
                        },
                        error: function(xhr) {
                            // Handle error response
                            alert('Error: ' + xhr.responseText);
                        }
                    });
                }
            });
        </script>
    @endif
@endpush
