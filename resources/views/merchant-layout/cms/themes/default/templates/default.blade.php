@extends('merchant-layout.layouts.cms')

@section('title', $page->title)

@section('meta')
    <meta name="description" content="{{ $page->meta_data['description'] ?? '' }}">
    <meta name="keywords" content="{{ $page->meta_data['keywords'] ?? '' }}">
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $page->title }}</h1>

                <div class="cms-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
