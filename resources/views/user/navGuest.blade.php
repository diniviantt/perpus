<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">

    <!-- DataTables with Tailwind -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.tailwindcss.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Vite (Menghandle CSS dan JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <title>D-L!brary</title>

    <style>
        @font-face {
            font-family: 'Writeline';
            src: url('/assets/font/writeline/Writeline.otf') format('opentype');
        }

        @font-face {
            font-family: 'Comfortaa';
            src: url('/assets/font/comfortaa/Comfortaa-Regular.ttf') format('truetype');
        }
    </style>
</head>

<body style="background: linear-gradient(to right, #1A1A1A, #0D0F3A, #150050, #2A0070, #3F0071, #4E0090, #610094);">
    <div id="navbar" class="fixed top-0 left-0 z-50 flex items-center w-full px-4 py-3 transition-all duration-300">
        <div class="flex items-center space-x-2">
            <img class="w-10 h-10" src="/assets/img/book.png" alt="Logo">
            <span class="text-lg font-bold text-[#F0A500] tracking-widest"
                style="font-family: 'Writeline', sans-serif;">
                <span class="text-[#F0A500]">Dyni</span>L!brary
            </span>
        </div>

        <!-- Menu Button for Mobile -->
        <button id="menu-toggle" class="text-white md:hidden focus:outline-none">☰</button>

        <!-- Navbar Items -->
        <ul id="menu" class="hidden ml-auto space-x-6 text-sm md:flex"
            style="font-family: 'Comfortaa', sans-serif;">
            <li>
                <a href="#beranda"
                    class="relative text-white cursor-pointer transition-colors duration-300 hover:text-[#F0A500] after:content-[''] after:absolute after:left-1/2 after:bottom-[-5px] after:w-0 after:h-[1px] after:bg-[#F0A500] after:transition-all after:duration-300 hover:after:w-full hover:after:left-0">Beranda</a>
            </li>
            <li>
                <a href="#tentang"
                    class="relative text-white cursor-pointer transition-colors duration-300 hover:text-[#F0A500] after:content-[''] after:absolute after:left-1/2 after:bottom-[-5px] after:w-0 after:h-[1px] after:bg-[#F0A500] after:transition-all after:duration-300 hover:after:w-full hover:after:left-0">Tentang</a>
            </li>
            <li>
                <a href="#buku"
                    class="relative text-white cursor-pointer transition-colors duration-300 hover:text-[#F0A500] after:content-[''] after:absolute after:left-1/2 after:bottom-[-5px] after:w-0 after:h-[1px] after:bg-[#F0A500] after:transition-all after:duration-300 hover:after:w-full hover:after:left-0">Buku</a>
            </li>
            <li>
                <a href="#fitur"
                    class="relative text-white cursor-pointer transition-colors duration-300 hover:text-[#F0A500] after:content-[''] after:absolute after:left-1/2 after:bottom-[-5px] after:w-0 after:h-[1px] after:bg-[#F0A500] after:transition-all after:duration-300 hover:after:w-full hover:after:left-0">Fitur</a>
            </li>
        </ul>

        <!-- Search Bar & User Icon -->
        <div class="flex items-center ml-10 space-x-6">
            <!-- Search Bar -->
            <div class="relative hidden md:flex">
                <input type="text" placeholder="Cari..."
                    class="px-4 py-2 text-sm text-white bg-transparent border border-white rounded-lg focus:outline-none focus:border-[#F0A500] placeholder:text-white">
            </div>

            <!-- User Icon -->
            <a href="{{ route('login') }}" class="text-white transition hover:text-[#F0A500]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A6 6 0 0112 15a6 6 0 016.879 2.804M12 11a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
            </a>
        </div>
    </div>

    <div class="flex flex-wrap items-center mt-20">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
        < /script <!-- Select2 JS --> <
        script src = "https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js" >
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Menambahkan efek backdrop blur saat di-scroll
        window.onscroll = function() {
            const navbar = document.getElementById('navbar');
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                navbar.classList.add('backdrop-blur-sm', 'bg-black', 'bg-opacity-50'); // Mengurangi opasitas
            } else {
                navbar.classList.remove('backdrop-blur-sm', 'bg-black', 'bg-opacity-50');
            }
        };

        // Toggle menu untuk mobile
        document.getElementById('menu-toggle').onclick = function() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        };
    </script>

    @stack('scripts')
</body>

</html>
