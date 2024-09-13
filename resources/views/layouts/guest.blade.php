<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KainPoTayo') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="background-image: url('{{ asset('cspc-bg.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <main class="min-h-screen flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto w-full">
                <div>
                    <a href="/">
                        <x-application-logo class="mb-4 w-28 h-25 fill-current text-gray-500" />
                    </a>
                </div>
    
                <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-md">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </body>
</html>
