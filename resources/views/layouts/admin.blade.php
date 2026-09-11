<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="flex min-h-screen"> 
                <x-admin-sidbar />
                <main class="min-w-0 flex-1 bg-gray-50">
                    <div class="border-b border-gray-200 bg-white px-6 py-4 lg:hidden">
                        <a href="{{ route('books.manage') }}" class="font-bold text-blue-700">LMS Admin</a>
                    </div>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>



