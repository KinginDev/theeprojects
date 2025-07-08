@extends('merchant-layout.layouts.cms')

@section('title', $merchant->name . ' - Home')

@section('content')
    <div class="container py-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to {{ $merchant->name }}</h1>
            <p class="lead">{{ $merchant->description }}</p>
            <hr class="my-4">
            <p>No home page has been set up yet. Please check back later.</p>
        </div>
    </div>
@endsection
