<x-app-layout title="{{ __('Detail Buku') }}">
    <x-header value="{{ __('Detail Buku') }}" />
    <x-session-status />

    <div class="flex p-6 mb-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-center w-1/3">
            @if ($buku->gambar != null)
                <img class="object-cover rounded-lg shadow-md" src="{{ asset('/images/' . $buku->gambar) }}"
                    alt="Cover Buku" style="height: 550px; width: auto;">
            @else
                <img class="object-cover rounded-lg shadow-md" src="{{ asset('/images/noImage.jpg') }}" alt="No Image"
                    style="max-height: 250px; width: auto;">
            @endif
        </div>
        <div class="w-2/3 pl-6 text-container">
            <h1 class="mb-2 text-3xl font-extrabold text-blue-600">{{ $buku->judul }}</h1>
            <p class="p-2 mt-1 leading-relaxed text-justify text-gray-700"
                style="text-indent: 0.75rem; letter-spacing: 0.05rem; word-spacing: 0.1rem;">
                {{ $buku->deskripsi }}
            </p>

            <div class="grid gap-2 mt-4 text-gray-800">
                <h5 class="text-lg font-semibold">Pengarang: <span class="text-blue-500">{{ $buku->pengarang }}</span>
                </h5>
                <h5 class="text-lg font-semibold">Penerbit: <span class="text-blue-500">{{ $buku->penerbit }}</span>
                </h5>
                <h5 class="text-lg font-semibold">Tahun Terbit: <span
                        class="text-blue-500">{{ $buku->tahun_terbit }}</span></h5>
                <h5 class="text-lg font-semibold">Kode Buku: <span class="text-blue-500">{{ $buku->kode_buku }}</span>
                </h5>
            </div>

            <h5 class="mt-4 text-lg font-semibold text-gray-800">Kategori:</h5>
            <div class="flex flex-wrap gap-2 mt-2">
                @foreach ($buku->kategori_buku as $k)
                    <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-blue-500 rounded-full">
                        {{ $k->nama }}
                    </span>
                @endforeach
            </div>

            <div class="flex items-center justify-between mt-28">
                <a href="{{ route('buku.index') }}"
                    class="flex items-center px-4 py-2.5 text-white transition duration-200 bg-blue-500 rounded-full hover:bg-blue-600">
                    <i class="text-lg fas fa-arrow-left"></i>
                </a>
                @role('peminjam')
                    @if ($bukuDipinjam)
                        <button
                            class="flex items-center px-4 py-2.5 text-white bg-gray-500 rounded-full cursor-not-allowed">
                            <span>📖 Sedang Anda Dipinjam</span>
                        </button>
                    @else
                        <a href="#" id="pinjamSekarang" data-buku-id="{{ $buku->id }}"
                            class="flex items-center px-4 py-2.5 text-white transition duration-200 bg-blue-500 rounded-full hover:bg-blue-600">
                            <span>Pinjam Sekarang!</span>
                        </a>
                    @endif
                @endrole

            </div>
        </div>

    </div>

    <div class="w-full p-6 mx-auto bg-white border border-gray-200 shadow-md rounded-xl">
        {{-- Header Section --}}
        <h2 class="mb-4 text-lg font-semibold text-gray-800">
            Ulasan Pengguna ({{ $reviews->count() }})
        </h2>

        {{-- Daftar Ulasan --}}
        <div class="space-y-4 overflow-y-auto max-h-72">
            @forelse ($reviews as $review)
                <div class="relative p-5 border border-gray-200 rounded-lg shadow-sm bg-gray-50 review-item"
                    data-id="{{ $review->id }}">
                    {{-- Header Ulasan --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            {{-- Foto Profil --}}
                            <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : asset('assets/img/profile.webp') }}"
                                alt="User Profile" class="w-10 h-10 border border-gray-300 rounded-full shadow-sm">

                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-900">{{ $review->user->email }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Hapus (hanya jika user yang login adalah pemilik ulasan) --}}
                        @if (auth()->id() === $review->users_id)
                            <button type="button" class="text-gray-600 hover:text-gray-900 hapus-ulasan"
                                data-id="{{ $review->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </div>

                    {{-- Isi Ulasan --}}
                    <p class="mt-2 text-sm leading-relaxed text-gray-700">
                        {{ $review->ulasan }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada ulasan.</p>
            @endforelse
        </div>

        {{-- Form Tambah Ulasan --}}
        <div class="mt-6">
            <h3 class="mb-3 text-sm font-semibold text-gray-800">Tulis Ulasan Anda</h3>

            <form action="{{ route('ulasan-buku') }}" method="POST">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                {{-- Input Ulasan --}}
                <textarea name="ulasan" class="w-full p-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Bagikan pengalaman Anda tentang buku ini..." maxlength="500"></textarea>

                {{-- Tombol Kirim --}}
                <button type="submit"
                    class="flex items-center gap-2 px-5 py-2 mt-4 text-sm font-semibold text-gray-700 transition bg-white border border-gray-300 rounded-full ring-gray-300 hover:bg-gray-100">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>

    <x-slot name="styles">
        <style>
            .text-container {
                padding: 1rem;
                /* Ruang di dalam kontainer teks */
                background-color: #F9FAFB;
                /* Warna latar belakang yang lembut */
                border-radius: 0.5rem;
                /* Sudut membulat */
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                /* Bayangan halus */
            }

            h5 {
                margin-bottom: 0.5rem;
                /* Jarak bawah untuk subjudul */
            }

            p {
                margin-top: 0.5rem;
                /* Jarak atas untuk paragraf */
            }

            .custom-toast {
                width: 320px !important;
                /* Lebih panjang */
                height: 45px !important;
                /* Lebih tipis */
                font-size: 13px;
                text-align: center;
                padding: 8px !important;
                border-radius: 6px !important;
                background: rgba(46, 204, 113, 0.7) !important;
                /* Hijau dengan opacity 70% */
                color: white !important;
                border: none !important;
                box-shadow: none !important;
            }

            /* Perkecil ikon SweetAlert */
            .custom-toast .swal2-icon {
                width: 20px !important;
                height: 20px !important;
                min-width: 20px !important;
                min-height: 20px !important;
            }

            /* Perkecil padding dalam alert */
            .custom-toast .swal2-title {
                font-size: 12px !important;
                padding: 5px 10px !important;
            }
        </style>
    </x-slot>


    <x-slot name="scripts">
        <script>
            $('#multiselect').select2({
                allowClear: true,
            });
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".hapus-ulasan").forEach(button => {
                    button.addEventListener("click", function() {
                        let reviewId = this.getAttribute("data-id");

                        fetch(`/dashboard/ulasan-hapus/${reviewId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute("content"),
                                    "Accept": "application/json",
                                    "Content-Type": "application/json"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest(".review-item").remove();
                                    Swal.fire({
                                        toast: true,
                                        position: "bottom-end", // Pojok kanan bawah
                                        icon: "success",
                                        title: "Ulasan berhasil dihapus!",
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        customClass: {
                                            popup: 'custom-toast' // Gunakan class custom
                                        },
                                        didOpen: (toast) => {
                                            toast.style.animation =
                                            "none"; // Hapus animasi getar
                                        }
                                    });

                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Gagal!",
                                        text: data.message,
                                        toast: true,
                                        position: "bottom-end",
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops!",
                                    text: "Terjadi kesalahan, coba lagi.",
                                    toast: true,
                                    position: "bottom-end",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            });
                    });
                });
            });


            $(document).ready(function() {
                $("#pinjamSekarang").on("click", function(e) {
                    e.preventDefault(); // Hindari reload halaman

                    let bukuId = $(this).data("buku-id"); // Ambil ID buku dari tombol
                    let userId = "{{ auth()->user()->id }}"; // Ambil ID user yang sedang login
                    let csrfToken = $('meta[name="csrf-token"]').attr("content");

                    // Kirim permintaan peminjaman via AJAX
                    $.ajax({
                        url: "{{ route('peminjaman.store') }}",
                        type: "POST",
                        data: {
                            buku_id: bukuId,
                            users_id: userId,
                            _token: csrfToken
                        },
                        beforeSend: function() {
                            $("#pinjamSekarang").text("Memproses...").prop("disabled", true);
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Peminjaman berhasil diajukan.",
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "OK",
                            }).then(() => {
                                $("#pinjamSekarang").text("Pinjam Sekarang!").prop(
                                    "disabled", false);
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            $("#pinjamSekarang").text("Pinjam Sekarang!").prop("disabled", false);

                            Swal.fire({
                                title: "Gagal!",
                                text: "Terjadi kesalahan, coba lagi nanti.",
                                icon: "error",
                                confirmButtonColor: "#d33",
                                confirmButtonText: "OK",
                            });
                        }
                    });
                });
            });
        </script>
    </x-slot>

</x-app-layout>
