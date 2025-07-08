@extends('merchant-layout.layouts.app')

@section('title', 'Edit Menu')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Menu Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('merchant.menus.update', $menu->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Menu Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $menu->name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location" class="form-label">Menu Location</label>
                                        <select class="form-select" id="location" name="location">
                                            @foreach ($locations as $location)
                                                <option value="{{ $location }}"
                                                    {{ $menu->location == $location ? 'selected' : '' }}>
                                                    {{ ucfirst($location) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                            value="1" {{ $menu->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Update Menu</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Add Menu Item</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('merchant.menu-items.store', $menu->id) }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Item Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="parent_id" class="form-label">Parent Item</label>
                                        <select class="form-select" id="parent_id" name="parent_id">
                                            <option value="">None (Top Level)</option>
                                            @foreach ($menuItems as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Link Type</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="link_type"
                                                id="link_type_custom" value="custom" checked>
                                            <label class="form-check-label" for="link_type_custom">
                                                Custom URL
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="link_type"
                                                id="link_type_page" value="page">
                                            <label class="form-check-label" for="link_type_page">
                                                Page
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3" id="url_field">
                                        <label for="url" class="form-label">URL</label>
                                        <input type="url" class="form-control" id="url" name="url">
                                    </div>

                                    <div class="mb-3" id="page_field" style="display:none;">
                                        <label for="page_id" class="form-label">Select Page</label>
                                        <select class="form-select" id="page_id" name="page_id">
                                            <option value="">-- Select a page --</option>
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="target" class="form-label">Open in</label>
                                        <select class="form-select" id="target" name="target">
                                            <option value="_self">Same window</option>
                                            <option value="_blank">New window</option>
                                        </select>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success">Add Item</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Menu Structure</h4>
                            </div>
                            <div class="card-body">
                                <div id="menu-items-container">
                                    @if (count($menuItems) > 0)
                                        <ul class="list-group menu-items-sortable">
                                            @foreach ($menuItems as $item)
                                                @include('merchant-layout.cms.menus.item', [
                                                    'item' => $item,
                                                ])
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="alert alert-info">
                                            No items in this menu yet. Add some using the form on the left.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script>
        // Toggle between URL and page selection
        document.addEventListener('DOMContentLoaded', function() {
            const linkTypeCustom = document.getElementById('link_type_custom');
            const linkTypePage = document.getElementById('link_type_page');
            const urlField = document.getElementById('url_field');
            const pageField = document.getElementById('page_field');

            linkTypeCustom.addEventListener('change', function() {
                if (this.checked) {
                    urlField.style.display = 'block';
                    pageField.style.display = 'none';
                }
            });

            linkTypePage.addEventListener('change', function() {
                if (this.checked) {
                    urlField.style.display = 'none';
                    pageField.style.display = 'block';
                }
            });
        });
    </script>
@endpush
