<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' · ' : '' }}{{ config('app.name', 'Kasir Simple') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/learning.png') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (isset($styles))
        {{ $styles }}
    @endif
</head>

<body class="text-sm antialiased text-gray-900 bg-gray-100 md:text-base">
    <div class="container">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <div class="w-full max-w-lg py-10 overflow-hidden bg-white shadow-md px-7 sm:px-16 sm:py-14 rounded-3xl">
                <section class="mb-4">
                    <a href="/">
                        <x-application-logo class="w-10 h-10 mx-auto sm:w-12 sm:h-12" />
                    </a>
                </section>

                {{ $slot }}
            </div>
        </div>
    </div>

    @if (isset($scripts))
        {{ $scripts }}
    @endif
</body>

</html>
