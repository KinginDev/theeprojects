<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Our Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="relative min-h-screen">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Your Brand</h1>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Welcome to Our Platform</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">Choose your login portal below</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- User Login Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
                    <div class="p-6">
                        <div
                            class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-2">User Portal
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 text-center mb-4">Access your personal account</p>
                        <a href="{{ route('login') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors">
                            Login as User
                        </a>
                    </div>
                </div>

                <!-- Merchant Login Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
                    <div class="p-6">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-2">Merchant Portal
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 text-center mb-4">Manage your business</p>
                        <a href="{{ route('merchant.login') }}"
                            class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md transition-colors">
                            Login as Merchant
                        </a>
                    </div>
                </div>

                <!-- Admin Login Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
                    <div class="p-6">
                        <div
                            class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center mb-2">Admin Portal
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 text-center mb-4">System administration</p>
                        <a href="{{ route('admin.login') }}"
                            class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-md transition-colors">
                            Login as Admin
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="absolute bottom-0 w-full bg-white dark:bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </p>
            </div>
        </footer>
    </div>
</body>

</html>