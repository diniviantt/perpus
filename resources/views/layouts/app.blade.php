<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' · ' : '' }}{{ config('app.name', 'PerpustakaanSimple') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/laravel-indigo-2.webp') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- DataTables --}}
    <link href="https://cdn.datatables.net/2.1.2/css/dataTables.tailwindcss.min.css" rel="stylesheet" />

    {{-- Styles --}}
    @vite('resources/css/app.css')
    @if (isset($styles))
        {{ $styles }}
    @endif
</head>

<body class="antialiased text-[#697a8d] bg-[#F5F5F9] text-sm md:text-base">
    <x-partials.sidebar />
    <x-partials.navbar />

    <section class="main">
        <div class="h-full px-6">
            <main>
                {{ $slot }}
            </main>
            @if (isset($modals))
                {{ $modals }}
            @endif
            <x-partials.footer />
        </div>
    </section>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>


    @vite('resources/js/app.js')
    <script src="/assets/js/main.js"></script>
    @if (isset($scripts))
        {{ $scripts }}
    @endif
</body>

</html>
