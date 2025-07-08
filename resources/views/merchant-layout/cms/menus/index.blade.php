@extends('merchant-layout.layouts.app')
@section('title', 'CMS Menus')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });
        });
    </script>
