@extends('user.navGuest')

@section('content')
    <section id="beranda"
        class="relative flex flex-col-reverse items-center justify-between min-h-screen px-6 py-12 mx-auto text-white md:flex-row md:px-10 lg:px-16 xl:px-20"
        style="background: linear-gradient(to right, #1A1A1A, #0D0F3A, #150050, #2A0070, #3F0071, #4E0090, #610094);">
        <div class="text-center md:w-1/2 md:text-left md:mb-8">
            <h1 class="text-5xl font-black leading-tight">Book For <span class="text-yellow-400">Knowledge</span></h1>
            <div class="w-16 mx-auto mt-4 md:mx-0">
                <svg class="w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
                    <path d="M0 5 Q 25 0, 50 5 T 100 5" stroke="#A07CF6" stroke-width="2" fill="none"
                        stroke-linecap="round" />
                </svg>
            </div>
            <p class="mt-4 text-base font-light md:text-lg">
                Jelajahi ribuan koleksi buku dan temukan referensi terbaik untuk menunjang pembelajaranmu!
            </p>
            <a href="#tentang"
                class="inline-block px-4 py-2 mt-6 mb-6 font-thin text-white bg-[#F0A500] rounded-lg border border-transparent hover:border-[#892CDC] hover:bg-transparent hover:text-[#892CDC] transition-all">
                Selengkapnya
                <i class="ml-2 fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="flex justify-center mb-8 -mt-16 md:w-1/2">
            <img class="w-3/4 rounded-lg md:w-full drop-shadow-lg" src="{{ asset('assets/img/bg2.png') }}"
                alt="Gambar Perpustakaan">
        </div>
    </section>

    <section id="tentang" data-aos="fade-up" data-aos-duration="900"
        class="flex flex-col items-center justify-center w-full min-h-screen mx-auto mt-5 text-center"
        style="background: linear-gradient(to right, #1A1A1A, #0D0F3A, #150050, #2A0070, #3F0071, #4E0090, #610094);">
        <div class="py-52">
            <h2 class="text-3xl tracking-widest section-title md:text-4xl">
                <i class="fas fa-info-circle text-[#F0A500] mr-2"></i>
                <span class="font-bold text-3xl md:text-4xl text-[#892CDC] tracking-widest">
                    <span class="text-[#F0A500]">Dyni</span>L!brary
                </span>
            </h2>
            <div class="w-1/4 mx-auto mt-4 mb-10">
                <svg class="w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
                    <path d="M0 5 Q 25 0, 50 5 T 100 5" stroke="#A07CF6" stroke-width="1" fill="none"
                        stroke-linecap="round" />
                </svg>
            </div>
            <p class="mb-3 text-sm text-gray-300 px-36 md:text-base" style="font-family: 'Comfortaa', sans-serif;">
                <span class="font-normal text-[#892CDC] tracking-widest" style="font-family: 'Writeline', sans-serif;">
                    <span class="text-[#F0A500]">Dyni</span>Library
                </span> adalah platform peminjaman buku di perpustakaan sekolah yang dirancang untuk memudahkan siswa dalam
                mencari dan meminjam buku secara online. Dengan <span class="font-bold text-[#892CDC] tracking-widest"
                    style="font-family: 'Writeline', sans-serif;">
                    <span class="text-[#F0A500]">Dyni</span>Library
                </span>, siswa dapat melihat ketersediaan buku, melakukan peminjaman tanpa harus datang langsung, serta
                mengelola daftar bacaan mereka dengan lebih praktis.
                <br><br>
                Kami hadir untuk mendukung budaya literasi di sekolah dengan sistem yang efisien dan user-friendly. Dengan
                fitur pencarian yang cepat dan proses peminjaman yang transparan, <span
                    class="font-bold text-[#892CDC] tracking-widest" style="font-family: 'Writeline', sans-serif;">
                    <span class="text-[#F0A500]">Dyni</span>Library
                </span> memastikan pengalaman membaca menjadi lebih mudah dan menyenangkan bagi seluruh siswa.
                <br><br>
                Gabung sekarang dan temukan buku favoritmu dengan lebih praktis di <span
                    class="font-bold text-[#892CDC] tracking-widest" style="font-family: 'Writeline', sans-serif;">
                    <span class="text-xl font-bold tracking-widest md:text-lg text-[#F0A500]">Dyni</span>Library</span>!
            </p>
            <a href="#buku"
                class="inline-flex items-center px-6 py-2 mt-6 font-thin text-white bg-[#F0A500] rounded-lg shadow-lg transition-all border-2 border-transparent hover:border-[#892CDC] hover:bg-transparent hover:text-[#892CDC] hover:border">
                Lihat Koleksi Buku
                <i class="ml-2 fas fa-arrow-right"></i>
            </a>
        </div>
    </section>



    <section id="buku" data-aos="fade-up" data-aos-duration="900"
        class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-12 mx-auto mt-5 text-center"
        style="background: linear-gradient(to right, #1A1A1A, #0D0F3A, #150050, #2A0070, #3F0071, #4E0090, #610094);">
        <div class="w-full">
            <h2 class="section-title text-2xl md:text-3xl tracking-widest text-[#F0A500]">
                <i class="fas fa-book text-[#A07CF6] mr-2"></i>
                Buku <span class="text-[#A07CF6]">Terbaru </span>
            </h2>
            <div class="w-1/4 mx-auto mt-4 mb-10">
                <svg class="w-full" viewBox="0 0 100 10" preserveAspectRatio="none">
                    <path d="M0 5 Q 25 0, 50 5 T 100 5" stroke="#A07CF6" stroke-width="1" fill="none"
                        stroke-linecap="round" />
                </svg>
            </div>


            <div class="badge-container">
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="badge">Fiksi</span>
                    <span class="badge">Non-Fiksi</span>
                    <span class="badge">Sains</span>
                    <span class="badge">Sejarah</span>
                    <span class="badge">Biografi</span>
                    <span class="badge">Teknologi</span>
                    <span class="badge">Kesehatan</span>
                    <span class="badge">Pendidikan</span>
                    <span class="badge">Sastra</span>
                    <span class="badge">Psikologi</span>
                    <span class="badge">Agama</span>
                    <span class="badge">Karya Ilmiah</span>
                    <span class="badge">Kreatif</span>
                    <span class="badge">Petualangan</span>
                    <span class="badge">Romantis</span>
                    <span class="badge">Misteri</span>
                </div>
            </div>
            <!-- Swiper -->
            <center>
                <div class="mt-8 swiper-container" style="width: 80%;">
                    <div class="swiper-wrapper">
                        @forelse ($buku as $item)
                            <div class="swiper-slide">
                                <div class="flex items-start p-2 ">
                                    <div class="w-1/2 h-full overflow-hidden rounded-lg">
                                        @if (isset($item->gambar))
                                            <img class="object-cover w-full h-full"
                                                src="{{ asset('/images/' . $item->gambar) }}" alt="{{ $item->judul }}">
                                        @else
                                            <img class="object-cover w-full h-full"
                                                src="{{ asset('/img/buku/laskarpelangi_3d.png') }}" alt="No Image">
                                        @endif
                                    </div>
                                    <div class="w-1/2 p-4 text-left">
                                        <h3 class="text-2xl font-black text-[#892CDC] truncate">{{ $item->judul }}
                                        </h3>
                                        <p class="pr-16 mt-2 mb-3 text-base text-gray-300 line-clamp-2">
                                            {{ Str::limit($item->deskripsi, 100) }}</p>
                                        <span
                                            class="border border-[#892CDC] text-blue-100 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $item->kategori ?? 'Genre' }}</span>
                                        <p class="mt-2 text-sm text-gray-400">Penulis : {{ $item->penulis }}</p>
                                        <p class="mt-1 text-sm text-gray-400">Tahun Terbit : {{ $item->tahun_terbit }}
                                        </p>
                                        <a href="#"
                                            class="inline-block px-4 py-2 mt-4 text-sm font-thin text-white bg-[#892CDC] rounded-lg border border-transparent hover:border-[#892CDC] hover:bg-gray-950 transition-all">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <span class="col-span-4 mb-10 text-lg text-center text-gray-500">Tidak ada koleksi buku
                                terbaru
                                saat ini.</span>
                        @endforelse
                    </div>
                    <!-- Navigation buttons -->
                    <div style="right: 3%; font-size: 10px;" class="swiper-button-next"></div>
                    <div style="left: 3%; font-size: 10px;" class="swiper-button-prev"></div>
                    <div style="bottom: 25  px; " class="swiper-pagination"></div>
                </div>
            </center>
        </div>
    </section>

    <section id="fitur" data-aos="fade-up" data-aos-duration="900"
        class="flex flex-col items-center justify-center w-full min-h-screen px-4 py-8 mx-auto text-center"
        style="background: linear-gradient(to right, #1A1A1A, #0D0F3A, #150050, #2A0070, #3F0071, #4E0090, #610094);">
        <h2 class="section-title text-5xl text-[#F0A500] mb-4">
            <i class="fas fa-cogs text-[#A07CF6] mr-2"></i>
            Cara Kerja DyniL!brary
        </h2>
        <p class="mb-8 text-lg text-gray-300">Temukan buku favoritmu dengan mudah melalui platform kami.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-10 md:gap-x-10 mt-6 w-full max-w-[1100px]">
            <div
                class="flex items-center h-full p-6 transition-transform transform rounded-lg step hover:scale-105 w-full md:w-[32rem]">
                <div class="number text-[10rem] font-bold text-[#F0A500] mr-6">1</div>
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-white">Buat Akun</h3>
                    <p class="text-base text-gray-50">Daftar untuk membuat akun dan mulai menjelajahi koleksi buku kami.
                    </p>
                </div>
            </div>
            <div
                class="flex items-center h-full p-6 transition-transform transform rounded-lg step hover:scale-105 w-full md:w-[32rem]">
                <div class="number text-[10rem] font-bold text-[#F0A500] mr-6">2</div>
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-white">Cari Buku </h3>
                    <p class="text-base text-gray-50">Gunakan fitur pencarian untuk menemukan buku yang kamu inginkan
                        dengan cepat.</p>
                </div>
            </div>
            <div
                class="flex items-center h-full p-6 transition-transform transform rounded-lg step hover:scale-105 w-full md:w-[32rem]">
                <div class="number text-[10rem] font-bold text-[#F0A500] mr-6">3</div>
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-white">Pinjam Buku</h3>
                    <p class="text-base text-gray-50">Lakukan peminjaman buku secara online dan nikmati membaca di rumah.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="w-full px-4 py-6 text-gray-300"
        style="background: linear-gradient(to right, #1A1A1A, #0D0F3A, #150050, #2A0070, #3F0071, #4E0090, #610094);">
        <div class="items-center mx-auto text-center md:flex-row ">
            <div class="justify-center mb-4 text-center md:mb-0 md:text-left">
                <h3 class="text-2xl font-bold text-center">DyniLibrary</h3>
                <p class="text-sm text-center text-gray-200">Platform peminjaman buku online untuk mendukung literasi
                    siswa.</p>
            </div>
        </div>
        <div class="mt-4 text-center">
            <div class="flex justify-center space-x-4 mt -2">
                <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white"
                    aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white"
                    aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white"
                    aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="mx-2 text-gray-200 transition duration-300 hover:text-white"
                    aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
        <div class="mt-4 text-center text-gray-200">
            &copy; 2025 DyniLibrary. Semua Hak Dilindungi.
        </div>
    </footer>
@endsection

@push('styles')
    <style>
        :root {
            --color-primary: #F0A500;
            --color-secondary: #892CDC;
            --color-tertiary: #A07CF6;
            --color-bg: #1A1A1A;
            /* Mengganti dengan warna latar belakang yang lebih cerah */
            --color-text: #FFFFFF;
            /* Mengganti dengan warna teks yang lebih cerah */
        }

        .section-title {
            font-family: 'normal', sans-serif;
            font-weight: bolder;
        }

        .steps {
            display: flex;
            justify-content: center;
            gap: 30px;
            max-width: 1000px;
        }

        .step {
            text-align: left;
            max-width: 350px;
        }

        .step h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .step p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .steps {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .step {
                text-align: center;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .swiper-container {
            overflow: hidden;
            position: relative;
        }

        .swiper-button-prev,
        .swiper-button-next {
            width: 40px;
            height: 40px;
            background-color: var(--color-secondary);
            border-radius: 50%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .swiper-button-prev::after,
        .swiper-button-next::after {
            font-size: 16px;
            color: var(--color-text);
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .swiper-pagination-bullet {
            background: var(--color-primary);
        }

        .swiper-pagination -bullet-active {
            background: var(--color-secondary);
        }

        .badge-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            width: 80%;
            /* Adjust width as needed */
            max-width: 99%;
            /* Maximum width for the oval */
            height: 80%;
            /* Fixed height for the oval */
            background-color: rgba(240, 165, 0, 0.1);
            /* Light background for the oval */
            border-radius: 75px;
            /* Half of the height for a perfect oval */
            padding: 20px;
            /* Padding inside the oval */
            margin: 0 auto;
            /* Center the oval container */
            overflow: hidden;
            /* Hide overflow if badges exceed the container */
        }

        .badge {
            display: inline-block;
            background-color: rgba(240, 165, 0, 0.2);
            /* Light background */
            color: #F0A500;
            /* Text color */
            padding: 10px 15px;
            /* Padding for badges */
            border-radius: 20px;
            /* Rounded corners for badges */
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
            /* Smooth transition */
        }

        .badge:hover {
            background-color: #F0A500;
            /* Darker background on hover */
            color: #2C2C2C;
            /* Darker text color on hover */
            transform: scale(1.05);
            /* Slightly enlarge on hover */
        }

        .swiper-slide {
            padding: 10px;
        }

        .swiper-slide .flex {
            padding: 1rem;
            max-width: 90%;
            margin: auto;
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
            slidesPerView: 1,
        });
    </script>
@endpush
