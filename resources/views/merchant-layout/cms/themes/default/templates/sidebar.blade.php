@extends('merchant-layout.layouts.cms')

@section('title', $page->title)

@section('meta')
    <meta name="description" content="{{ $page->meta_data['description'] ?? '' }}">
    <meta name="keywords" content="{{ $page->meta_data['keywords'] ?? '' }}">
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <h1>{{ $page->title }}</h1>

                <div class="cms-content">
                    {!! $page->content !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar bg-light p-4 rounded">
                    <h4>Other Pages</h4>
                    <ul class="list-unstyled">
                        @foreach ($merchant->pages()->where('is_published', true)->where('id', '!=', $page->id)->limit(5)->get() as $otherPage)
                            <li class="mb-2">
                                <a href="{{ route('merchant.page.show', $otherPage->slug) }}">
                                    {{ $otherPage->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    @if (isset($merchant->preferences['sidebar_content']))
                        <div class="mt-4">
                            <h4>About Us</h4>
                            <div>
                                {!! $merchant->preferences['sidebar_content'] !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
