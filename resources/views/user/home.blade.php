@extends('user.navGuest')

@section('content')
<section id="beranda" class="relative flex flex-col-reverse items-center justify-between min-h-screen px-4 py-12 text-white md:flex-row bg-gradient-to-r">
    <div class="text-center md:w-1/2 md:text-left md:mb-8">
        <h1 class="text-3xl font-extrabold leading-tight md:text-4xl">Book For <span class="text-yellow-400">Knowledge</span></h1>
        <hr class="w-16 mx-auto mt-4 border-2 border-yellow-400 md:mx-0">
        <p class="mt-4 text-base font-light md:text-lg">
            Jelajahi ribuan koleksi buku dan temukan referensi terbaik untuk menunjang pembelajaranmu!
        </p>
        <a href="#" class="inline-block px-4 py-2 mt-6 mb-6 font-semibold text-white transition-all bg-[#F0A500] rounded-lg shadow-lg hover:bg-[#F0A500] md:px-6 md:py-2">
            Jelajahi Koleksi
        </a>
    </div>
    <div class="flex justify-center mb-8 -mt-16 md:w-1/2">
        <img class="w-3/4 rounded-lg md:w-full drop-shadow-lg" src="{{ asset('assets/img/bg2.png') }}" alt="Gambar Perpustakaan">
    </div>
</section>

<section id="tentang" data-aos="fade-up" data-aos-duration="900" class="flex flex-col items-center justify-center w-5/6 min-h-screen mx-auto mt-5 text-center bg-gray-900 rounded-3xl">
    <div class="w-5/6">
        <span class="text-2xl font-thin tracking-widest md:text-3xl section-title">
            <span class="font-bold text-2xl md:text-3xl text-[#892CDC] tracking-widest">
                <span class="text-[#F0A500] text-2xl md:text-3xl">Dyni</span>L!brary
            </span>
        </span> 
        <hr class="w-1/4 border-[#A07CF6] border-1 mt-4 mx-auto mb-10">
        <p class="mb-5 text-xs text-gray-300 md:text-lg" style="font-family: 'Comfortaa', sans-serif;">
            <span class="font-normal text-[#892CDC] tracking-widest" style="font-family: 'Writeline', sans-serif;">
                <span class="text-[#F0A500]">Dyni</span>Library
            </span> adalah platform peminjaman buku fisik di perpustakaan sekolah yang dirancang untuk memudahkan siswa dalam mencari dan membooking buku secara online. Dengan <span class="font-bold text-[#892CDC] tracking-widest" style="font-family: 'Writeline', sans-serif;">
                <span class="text-[#F0A500]">Dyni</span>Library
            </span>, siswa dapat melihat ketersediaan buku, melakukan peminjaman tanpa harus datang langsung, serta mengelola daftar bacaan mereka dengan lebih praktis.
        </p>
        <p class="mb-5 text-xs text-gray-300 md:text-lg" style="font-family: 'Comfortaa', sans-serif;">
            Kami hadir untuk mendukung budaya literasi di sekolah dengan sistem yang efisien dan user-friendly. Dengan fitur pencarian yang cepat dan proses peminjaman yang transparan, <span class="font-bold text-[#892CDC] tracking-widest" style="font-family: 'Writeline', sans-serif;">
                <span class="text-[#F0A500]">Dyni</span>Library
            </span> memastikan pengalaman membaca menjadi lebih mudah dan menyenangkan bagi seluruh siswa.
        </p>
        <p class="mb-3 text-base font-bold text-gray-300 md:text-lg" style="font-family: 'Comfortaa', sans-serif;">
            Gabung sekarang dan temukan buku favoritmu dengan lebih praktis di <span class="font-bold text-[#892CDC] tracking-widest" style="font-family: 'Writeline', sans-serif;">
                <span class="text-2xl font-bold tracking-widest md:text-lg text-[#F0A500]">Dyni</span>Library
            </span>!
        </p>
    </div>
</section>

<section id="buku" data-aos="fade-up" data-aos-duration="900" class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-12 mx-auto mt-5 text-center">
    <div class="w-full">
        <span class="text-2xl md:text-3xl font-bold tracking-widest text-[#F0A500] section-title">
            Buku <span class="text-[#A07CF6]">Terbaru</span>
        </span>
        <hr class="w-1/4 mx-auto mt-4 border-[#A07CF6] border-1">
        
        <!-- Swiper -->
        <center>
            <div class="mt-8 swiper-container" style="width: 80%;">
                <div class="swiper-wrapper">
                    @forelse ($buku as $item)
                    <div style="padding-bottom: -100px;" class="swiper-slide">
                        <div class="flex items-start p-2 transition-transform transform rounded-lg shadow-lg bg-gray-950 hover:scale-105" style="border: 1px solid rgba(0, 0, 0, 0.1);">
                            <div class="w-1/2 h-full overflow-hidden rounded-lg">
                                @if (isset($item->gambar))
                                <img class="object-cover w-full h-full" src="{{ asset('/images/'.$item->gambar) }}" alt="{{ $item->judul }}">
                                @else
                                <img class="object-cover w-full h-full" src="{{ asset('/img/buku/laskarpelangi_3d.png') }}" alt="No Image">
                                @endif
                            </div>
                            <div class="w-1/2 p-4 text-left">
                                <h3 class="text-2xl font-black text-[#892CDC] truncate">{{ $item->judul }}</h3>
                                <p class="pr-16 mt-2 mb-3 text-base text-gray-300 line-clamp-2">{{ Str::limit($item->deskripsi, 100) }}</p>
                                <span class="border border-[#892CDC] text-blue-100 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $item->kategori ?? 'Genre'}}</span>
                                <p class="mt-2 text-sm text-gray-400">Penulis : {{ $item->penulis }}</p>
                                <p class="mt-1 text-sm text-gray-400">Tahun Terbit : {{ $item->tahun_terbit }}</p>
                                <a href="#" class="inline-block px-4 py-2 mt-4 text-sm font-semibold text-white bg-[#892CDC] rounded-lg hover:bg-[#A07CF6]">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <span class="col-span-4 mb-10 text-lg text-center text-gray-500">Tidak ada koleksi buku terbaru saat ini.</span>
                    @endforelse
                </div>
                <!-- Navigation buttons -->
                <div style="right: 10%; font-size: 10px;" class="swiper-button-next"></div>
                <div style="left: 10%; font-size: 10px;" class="swiper-button-prev"></div>
                <div style="bottom: 80px; " class="swiper-pagination"></div>
            </div>
        </center>
    </div>
</section>

<section id="fitur" data-aos="fade-up" class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-12 mx-auto mt-5 text-center">
    <h2 class="text-2xl font-bold md:text-3xl text-[#F0A500] section-title">Fitur <span class="text-[#A07CF6]">Unggulan</span></h2>
    <hr class="w-1/4 mx-auto mt-4 border-[#A07CF6] border-1">
    <div class="grid w-full gap-8 mt-10 md:grid-cols-2 lg:grid-cols-3">
        <div class="flex flex-col items-center p-6 transition-transform transform bg-white rounded-lg shadow-lg hover:scale-105">
            <i class="fas fa-book fa-3x text-[#892CDC] mb-2"></i>
            <h3 class="text-xl font-semibold text-[#892CDC]">Peminjaman Online</h3>
            <p class="mt-2 text-gray-600">Mudah melakukan peminjaman buku tanpa harus datang langsung ke perpustakaan.</p>
        </div>
        <div class="flex flex-col items-center p-6 transition-transform transform bg-white rounded-lg shadow-lg hover:scale-105">
            <i class="fas fa-search fa-3x text-[#892CDC] mb-2"></i>
            <h3 class="text-xl font-semibold text-[#892CDC]">Pencarian Cepat</h3>
            <p class="mt-2 text-gray-600">Cari buku favoritmu dengan sistem pencarian yang cepat dan akurat.</p>
        </div>
        <div class="flex flex-col items-center p-6 transition-transform transform bg-white rounded-lg shadow-lg hover:scale-105">
            <i class="fas fa-list fa-3x text-[#892CDC] mb-2"></i>
            <h3 class="text-xl font-semibold text-[#892CDC]">Daftar Bacaan</h3>
            <p class="mt-2 text-gray-600">Simpan buku favoritmu ke dalam daftar bacaan untuk dibaca nanti.</p>
        </div>
    </div>
</section>

<!-- Section Testimoni -->
<section data-aos="fade-up" data-aos-duration="900" id="testimoni" class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-12 mx-auto mt-5 text-center bg-gray-950">
    <h2 class="text-2xl font-bold text-[#F0A500] section-title">Apa Kata Mereka?</h2>
    <hr class="w-1/4 mx-auto mt-4 border-[#A07CF6] border-1 mb-10">
    <div class="w-full max-w-3xl">
        <div class="flex flex-col space-y-4">
            <blockquote class="p-4 bg-gray-900 rounded-lg shadow-lg">
                <p class="text-gray-300">"DyniLibrary sangat membantu saya dalam menemukan buku yang saya butuhkan. Proses peminjaman yang mudah dan cepat!"</p>
                <footer class="mt-2 text-right text-gray-500">- Siswa A</footer>
            </blockquote>
            <blockquote class="p-4 bg-gray-900 rounded-lg shadow-lg">
                <p class="text-gray-300">"Saya suka fitur pencarian cepatnya. Sangat efisien!"</p>
                <footer class="mt-2 text-right text-gray-500">- Siswa B</footer>
            </blockquote>
            <blockquote class="p-4 bg-gray-900 rounded-lg shadow-lg">
                <p class="text-gray-300">"Saya suka fitur pencarian cepatnya. Sangat efisien!"</p>
                <footer class="mt-2 text-right text-gray-500">- Siswa B</footer>
            </blockquote>
            <blockquote class="p-4 bg-gray-900 rounded-lg shadow-lg">
                <p class="text-gray-300">"Saya suka fitur pencarian cepatnya. Sangat efisien!"</p>
                <footer class="mt-2 text-right text-gray-500">- Siswa B</footer>
            </blockquote>
        </div>
    </div>
</section>

<footer class="w-full px-4 py-6 text-gray-300 bg-gray-950">
    <div class="items-center mx-auto text-center md:flex-row ">
        <div class="justify-center mb-4 text-center md:mb-0 md:text-left">
            <h3 class="text-2xl font-bold text-center">DyniLibrary</h3>
            <p class="text-sm text-center text-gray-200">Platform peminjaman buku online untuk kemudahan literasi.</p>
        </div>
        
    </div>
    <div class="mt-4 text-center">
        <div class="flex justify-center mt-2 space-x-4">
            <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </div>
    <div class="mt-4 text-center text-gray-200">
        &copy; 2025 DyniLibrary. All Rights Reserved.
    </div>
</footer>
@endsection

@push('styles')
<style>
    :root {
        --color-primary: #F0A500; /* Warna utama */
        --color-secondary: #892CDC; /* Warna sekunder */
        --color-tertiary: #A07CF6; /* Warna tersier */
        --color-bg: #1F2937; /* Warna latar belakang */
        --color-text: #FFFFFF; /* Warna teks */
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Menyembunyikan scrollbar */
    .swiper-container {
        overflow: hidden; /* Menyembunyikan scrollbar */
    }

    .swiper-button-prev,
        .swiper-button-next {
            width: 40px;
            height: 40px;
            background-color: var(--color-secondary);
            border-radius: 50%;
        }
        .swiper-button-prev::after,
        .swiper-button-next::after {
            font-size: 16px;
            color: var(--color-text);
        }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background-color: rgba(0, 0, 0, 0.8); /* Latar belakang saat hover */
    }

    /* Gaya untuk pagination */
    .swiper-pagination-bullet {
        background: var(--color-primary); /* Warna bullet */
    }

    .swiper-pagination-bullet-active {
        background: var(--color-secondary); /* Warna bullet aktif */
    }

    /* Gaya untuk badge genre */
    .genre-badge {
        display: inline-block;
        background-color: transparent; /* Latar belakang transparan */
        color: var(--color-primary); /* Warna teks badge */
        padding: 5px 10px; /* Padding untuk badge */
        border: 2px solid var(--color-primary); /* Border badge */
        border-radius: 5px; /* Sudut melengkung */
        font-weight: bold; /* Teks tebal */
        margin-bottom: 10px; /* Jarak bawah badge */
    }

    /* Gaya untuk card */
    .swiper-slide {
        padding: 10px; /* Mengurangi padding di sekitar card */
    }

    .swiper-slide .flex {
        padding: 1rem; /* Mengurangi padding dalam card */
        max-width: 90%; /* Membatasi lebar card */
        margin: auto; /* Memusatkan card */
    }

    /* Gaya untuk judul section */
    .section-title {
        font-family: 'Writeline', sans-serif; /* Ganti dengan font yang diinginkan */
    }
</style>
@endpush

@push('scripts')
<script>
    var swiper = new Swiper(".swiper-container", {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        slidesPerView: 1, // Menampilkan satu slide per view
    });
</script>
@endpush