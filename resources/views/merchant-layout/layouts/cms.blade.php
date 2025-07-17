<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ $merchant->name }}</title>

    @yield('meta')

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/merchant-theme.css') }}" rel="stylesheet">

    <!-- Theme-specific styles -->
    @if (file_exists(public_path("assets/themes/{$merchant->theme}/css/style.css")))
        <link href="{{ asset("assets/themes/{$merchant->theme}/css/style.css") }}" rel="stylesheet">
    @endif

    @stack('before_styles')
    @yield('styles')
    @stack('after_styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="site-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    @if ($merchant->logo)
                        <img src="{{ asset('storage/' . $merchant->logo) }}" alt="{{ $merchant->name }}" height="40">
                    @else
                        {{ $merchant->name }}
                    @endif
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    @if (isset($headerMenu))
                        @include('merchant-layout.cms.partials.menu', ['menu' => $headerMenu])
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <main class="site-content flex-grow-1">
        @yield('content')
    </main>

    <footer class="site-footer bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ $merchant->name }}</h5>
                    <p>{{ $merchant->description }}</p>
                </div>
                <div class="col-md-6">
                    @if (isset($footerMenu))
                        <h5>Quick Links</h5>
                        <ul class="nav flex-column">
                            @foreach ($footerMenu->items as $item)
                                <li class="nav-item">
                                    <a class="nav-link text-light"
                                        href="{{ $item->url ?? ($item->page ? route('page.show', $item->page->slug) : '#') }}"
                                        target="{{ $item->target ?? '_self' }}">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} {{ $merchant->name }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Theme-specific scripts -->
    @if (file_exists(public_path("assets/themes/{$merchant->theme}/js/scripts.js")))
        <script src="{{ asset("assets/themes/{$merchant->theme}/js/scripts.js") }}"></script>
    @endif

    @stack('before_scripts')
    @yield('scripts')
    @stack('after_scripts')
</body>

</html>
