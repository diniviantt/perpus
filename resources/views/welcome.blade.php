<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PerpustakaanSimple') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/laravel-indigo-2.webp') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;900&display=swap" rel="stylesheet">

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative text-sm antialiased text-gray-500 bg-gradient-to-t from-white to-indigo-100 md:text-base">
    <div id="particles-js"></div>
    <main class="absolute top-0 left-0 w-full h-screen">
        <div class="container">
            <div class="flex flex-col items-center justify-center h-screen">
                <div class="w-full text-center">
                    <h1 class="text-5xl font-black text-gray-800 uppercase sm:text-6xl md:text-7xl">
                        <span class="text-gray-900">ORZ</span> Stack
                    </h1>

                    <p class="py-1">
                        <span class="px-2 py-1 text-white bg-gray-800">
                            {{ __('The skeleton application for the Laravel starter kit project.') }}
                        </span>
                    </p>

                    <div class="flex flex-wrap items-center justify-center gap-2 my-4">
                        @if (Route::has('login'))
                            @auth
                                <x-button-link :to="route('dashboard')"
                                    class="bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                                    {{ __('Dashboard') }}
                                </x-button-link>
                            @else
                                <x-button-link :to="route('login')"
                                    class="bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                                    {{ __('Login') }}
                                </x-button-link>

                                @if (Route::has('register'))
                                    <x-button-link :to="route('register')"
                                        class="bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                                        {{ __('Register') }}
                                    </x-button-link>
                                @endif
                            @endauth
                        @endif

                        <x-button-link to="https://github.com/orz14/orz-stack"
                            class="!text-gray-800 bg-transparent hover:bg-white focus:bg-white !border !border-gray-800"
                            target="_blank">
                            {{ __('GitHub') }}
                        </x-button-link>
                    </div>

                    <div class="text-sm">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/particles.min.js') }}"></script>
    <script src="{{ asset('assets/js/particles.config.js') }}"></script>
</body>

</html>
