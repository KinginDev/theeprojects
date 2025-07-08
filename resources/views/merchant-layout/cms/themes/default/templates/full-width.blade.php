@extends('merchant-layout.layouts.cms')

@section('title', $page->title)

@section('meta')
    <meta name="description" content="{{ $page->meta_data['description'] ?? '' }}">
    <meta name="keywords" content="{{ $page->meta_data['keywords'] ?? '' }}">
@endsection

@section('content')
    <div class="container-fluid p-0">
        <div class="cms-content full-width">
            {!! $page->content !!}
        </div>
    </div>
@endsection
