@extends('merchant-layout.layouts.app')

@section('title', 'Edit Page')

@push('after_styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Page</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('merchant.pages.update', $page->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Page Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ old('title', $page->title) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="slug" class="form-label">URL Slug</label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                            value="{{ old('slug', $page->slug) }}">
                                        <small class="text-muted">Leave empty to generate from title</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="template" class="form-label">Template</label>
                                        <select class="form-select" id="template" name="template">
                                            <option value="default" {{ $page->template == 'default' ? 'selected' : '' }}>
                                                Default
                                            </option>
                                            <option value="full-width"
                                                {{ $page->template == 'full-width' ? 'selected' : '' }}>Full
                                                Width</option>
                                            <option value="sidebar" {{ $page->template == 'sidebar' ? 'selected' : '' }}>
                                                With
                                                Sidebar</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea class="form-control editor" id="content" name="content" rows="10">{{ old('content', $page->content) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $page->meta_data['description'] ?? '') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                            value="{{ old('meta_keywords', $page->meta_data['keywords'] ?? '') }}">
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_home" name="is_home"
                                            value="1" {{ $page->is_home ?? false ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_home">Set as Home Page</label>
                                        <small class="form-text text-muted">
                                            This will be the default page shown when visitors come to your site.
                                            Only one page can be set as the home page.
                                        </small>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_published"
                                            name="is_published" value="1" {{ $page->is_published ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">Published</label>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary">Update Page</button>
                                        <a href="{{ route('merchant.pages.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('after_scripts')
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.editor').summernote({
                    height: 300,
                    callbacks: {
                        onInit: function() {
                            // Get the content from the textarea and set it in the editor
                            var content = $('.editor').val();

                            $('.editor').summernote('code', content);
                        }
                    },
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                    ]
                });
            });
        </script>
    @endpush
