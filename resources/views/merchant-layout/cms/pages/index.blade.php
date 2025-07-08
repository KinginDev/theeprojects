@extends('merchant-layout.layouts.app')


@section('title', 'CMS Pages')
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">CMS Pages</h4>
                                <div class="card-tools">
                                    <a href="{{ route('merchant.pages.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add New Page
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Template</th>

                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pages as $page)
                                            <tr>
                                                <td>
                                                    {{ $page->title }}
                                                    @if ($page->is_home)
                                                        <span class="badge bg-success ms-2">Home Page</span>
                                                    @endif
                                                </td>
                                                <td>{{ $page->slug }}</td>
                                                <td>{{ $page->template }}</td>
                                                <td>{{ $page->is_published ? 'Published' : 'Draft' }}</td>
                                                <td>
                                                    <a href="{{ route('merchant.pages.edit', $page->id) }}"
                                                        class="btn btn-sm btn-info">Edit</a>
                                                    <form action="{{ route('merchant.pages.destroy', $page->id) }}"
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
                                    {{ $pages->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
