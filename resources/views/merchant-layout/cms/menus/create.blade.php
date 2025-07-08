@extends('merchant-layout.layouts.app')

@section('title', 'Create New Menu')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
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

                        @if (isset($menu))
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4 class="card-title">Add Menu Item</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('merchant.menu-items.store', $menu->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Item Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="parent_id" class="form-label">Parent Item</label>
                                            <select class="form-select" id="parent_id" name="parent_id">
                                                <option value="">None</option>
                                                @foreach ($menuItems ?? [] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="url" class="form-label">URL</label>
                                            <input type="text" class="form-control" id="url" name="url">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="is_active_item"
                                                name="is_active" value="1" checked>
                                            <label class="form-check-label" for="is_active_item">Active</label>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Add Menu Item</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (isset($menu) && isset($menuItems) && count($menuItems) > 0)
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Menu Items</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach ($menuItems as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $item->title }}</span>
                                                <div>
                                                    <a href="{{ route('merchant.menu-items.edit', $item->id) }}"
                                                        class="btn btn-sm btn-secondary">Edit</a>
                                                    <form action="{{ route('merchant.menu-items.destroy', $item->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <h5 class="text-muted">Create a menu first to add menu items</h5>
                                    <p class="text-muted">After creating the menu, you'll be able to add and manage menu
                                        items</p>
                                </div>
                            </div>
                        </div>
                    @endif
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
                        url: '{{ route('merchant.cms.menu-items.sort') }}',
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
