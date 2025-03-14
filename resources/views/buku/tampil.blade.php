<x-app-layout title="{{ __('Daftar Buku') }}">
    <x-header value="{{ __('Daftar Buku') }}" />
    <x-session-status />
    @php
        // Ambil ID buku yang ada di koleksi pengguna
        $koleksiIds = $buku->pluck('buku_id')->toArray();
    @endphp
    @role('admin')
        <div class="flex gap-4 mb-3">
            <!-- Tombol Tambah Buku -->
            <a href="{{ route('buku.create') }}"
                class="flex items-center gap-2 px-6 py-3 text-gray-200 transition-all duration-300 bg-indigo-500 rounded-lg shadow-lg hover:bg-indigo-700 active:scale-95 group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 transition-transform duration-300 group-hover:rotate-180" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M21.5,2H12.118L8.118,0H2.5C1.122,0,0,1.122,0,2.5V22H10.298c-.2-.32-.381-.653-.538-1H1V7H23v4.026c.36,.306,.695,.641,1,1.003V4.5c0-1.378-1.121-2.5-2.5-2.5ZM1,6V2.5c0-.827,.673-1.5,1.5-1.5H7.882l4,2h9.618c.827,0,1.5,.673,1.5,1.5v1.5H1Zm16.5,5c-3.584,0-6.5,2.916-6.5,6.5s2.916,6.5,6.5,6.5,6.5-2.916,6.5-6.5-2.916-6.5-6.5-6.5Zm0,12c-3.032,0-5.5-2.468-5.5-5.5s2.468-5.5,5.5-5.5,5.5,2.468,5.5,5.5-2.468,5.5-5.5,5.5Zm.5-6h2.5v1h-2.5v2.5h-1v-2.5h-2.5v-1h2.5v-2.5h1v2.5Z" />
                </svg>
                <span>Tambah Buku</span>
            </a>

            <!-- Tombol Import Buku -->
            <a href="#"
                class="flex items-center gap-2 px-6 py-3 text-gray-200 transition-all bg-indigo-500 rounded-lg shadow-lg hover:bg-indigo-700 active:scale-95 group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 transition-transform duration-300 group-hover:scale-125" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 2L5 9h4v8h6V9h4l-7-7zM2 20h20v2H2v-2z" />
                </svg>
                <span>Import Buku</span>
            </a>

            <!-- Tombol Export Buku -->
            <a href="{{ route('buku-export') }}"
                class="flex items-center gap-2 px-6 py-3 text-gray-200 transition-all bg-indigo-500 rounded-lg shadow-lg hover:bg-indigo-700 active:scale-95 group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 transition-transform duration-300 group-hover:-translate-y-1" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M14,2V11H19L12,18L5,11H10V2H14M2,20H22V22H2V20Z" />
                </svg>
                <span>Export Buku</span>
            </a>
        </div>
    @endrole

    <form class="mt-5 mb-10" action="{{ route('buku.index') }}" method="GET">
        <div class="flex">
            <input type="search" name="search"
                class="flex-1 p-2 bg-gray-200 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Cari Judul Buku" aria-label="Search" value="{{ old('search') }}" />
            <button class="p-2 text-white transition duration-200 bg-indigo-600 hover:bg-indigo-800 rounded-r-md"
                type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </form>

    <div class="container mx-auto mb-3">
        <div class="grid justify-center grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
            @forelse ($buku as $item)
                <div id="buku-{{ $item->id }}" class="h-max">
                    <div class="flex overflow-hidden bg-white rounded-lg shadow-md h-72">
                        {{-- Gambar --}}
                        <div class="w-1/2 h-full">
                            <img class="object-cover w-full h-full"
                                src="{{ asset('/images/' . ($item->gambar ?? 'noImage.jpg')) }}"
                                alt="{{ $item->judul }}">
                        </div>

                        {{-- Keterangan Buku --}}
                        <div class="flex flex-col justify-between w-1/2 p-4">
                            <div>
                                <h5 class="mb-3 text-lg font-bold leading-tight text-indigo-600">
                                    <a href="{{ route('buku.show', $item->id) }}"
                                        class="hover:underline">{{ $item->judul }}</a>
                                </h5>
                                <p class="text-sm text-gray-600">Kode Buku: {{ $item->kode_buku }}</p>
                                <p class="text-sm text-gray-600">Pengarang: <span
                                        class="text-indigo-500">{{ $item->pengarang }}</span></p>
                                <p class="text-sm text-gray-600">Kategori:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($item->kategori_buku as $kategori_buku)
                                        <span class="px-2 py-1 text-xs text-white bg-indigo-500 rounded-full">
                                            {{ $kategori_buku->nama }}
                                        </span>
                                    @endforeach

                                </div>

                                <p class="text-sm text-gray-600">Stock:</p>
                                @if ($item->stock > 0)
                                    <p class="px-2 py-1 text-xs text-white bg-green-500 rounded-full w-max">Tersedia
                                        ({{ $item->stock }})
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">Buku ini masih tersedia untuk dipinjam.</p>
                                @else
                                    <p class="px-2 py-1 text-xs text-white bg-red-500 rounded-full w-max">Habis</p>
                                    <p class="mt-1 text-xs text-gray-500">Maaf, buku ini sedang tidak tersedia.</p>
                                @endif
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex space-x-2">
                                <a href="{{ route('buku.show', $item->id) }}"
                                    class="flex items-center justify-center w-8 h-8 text-white transition bg-blue-600 rounded hover:bg-blue-700"
                                    aria-label="Detail" title="Lihat Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                @role('admin')
                                    <a href="{{ route('buku.edit', $item->id) }}"
                                        class="flex items-center justify-center w-8 h-8 text-white transition bg-yellow-500 rounded hover:bg-yellow-600"
                                        aria-label="Edit" title="Edit Buku">
                                        <i data-lucide="square-pen" class="w-5 h-5"></i>
                                    </a>
                                    <button
                                        class="flex items-center justify-center w-8 h-8 text-white transition bg-red-500 rounded hover:bg-red-600"
                                        onclick="confirmDelete({{ $item->id }})" aria-label="Delete"
                                        title="Hapus Buku">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <a href="{{ route('buku.show', $item->id) }}"
                                        class="flex items-center justify-center w-8 h-8 text-white transition bg-blue-500 rounded hover:bg-blue-600"
                                        aria-label="Pinjam Buku" title="Pinjam Buku">
                                        <i data-lucide="book-open" class="w-4 h-4"></i>
                                    </a>

                                    @if (!in_array($item->id, $koleksiBukuIds))
                                        <button id="btn-tambah-koleksi" onclick="tambahKoleksi({{ $item->id }})"
                                            data-id="{{ $item->id }}"
                                            class="flex items-center justify-center w-8 h-8 text-white transition bg-purple-600 rounded hover:bg-purple-700"
                                            aria-label="Tambah ke Koleksi" title="Tambahkan ke Koleksi ">
                                            <i data-lucide="bookmark" class="w-4 h-4"></i>
                                        </button>
                                        {{-- Ganti dengan kondisi yang sesuai untuk memeriksa apakah buku ada di koleksi --}}
                                    @else
                                        @foreach ($koleksi as $k)
                                            @if ($k->buku_id == $item->id)
                                                <button
                                                    class="flex items-center justify-center w-8 h-8 text-white transition bg-red-500 rounded hover:bg-red-600"
                                                    onclick="confirmDeleteKoleksi({{ $k->id }})"
                                                    aria-label="Hapus dari Koleksi" title="Hapus dari Koleksi">
                                                    <i data-lucide="bookmark-x" class="w-4 h-4"></i>
                                                </button>
                                            @endif
                                        @endforeach
                                    @endif
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h1 class="mt-3 text-center text-gray-600">Tidak ada buku</h1>
            @endforelse
        </div>

        <div class="flex justify-between mx-2 my-2">
            <p class="my-2 text-gray-700">Menampilkan {{ $buku->currentPage() }} dari {{ $buku->lastPage() }} Halaman
            </p>
            {{ $buku->links() }}
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            lucide.createIcons();

            function confirmDeleteKoleksi(id) {

                Swal.fire({
                    title: "Apakah Anda yakin??",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengkonfirmasi, lakukan penghapusan
                        $.ajax({
                            url: `/dashboard/koleksi-buku/${id}`, // Ganti dengan URL yang sesuai untuk menghapus koleksi
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire("Dihapus!", "Buku telah dihapus dari koleksi.", "success").then(
                                    () => {
                                        window.location.reload(true);
                                    });
                            },
                            error: function() {
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus buku.", "error");
                            }
                        });
                    }
                });
            }

            function confirmDelete(id) {
                window.Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.Swal.fire({
                            title: "Menghapus...",
                            text: "Mohon tunggu, sedang menghapus data.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                window.Swal.showLoading();
                            }
                        });

                        $.ajax({
                            type: "DELETE",
                            url: `${window.location.origin}/dashboard/buku/${id}`,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                window.Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload(true); // Reload page without cache
                                });
                            },
                            error: function(xhr) {
                                console.log("Error:", xhr.responseText); // Debug error di console

                                let errorMessage = "Terjadi kesalahan saat menghapus data.";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                window.Swal.fire({
                                    title: "Error!",
                                    text: errorMessage,
                                    icon: "error"
                                });
                            },
                            complete: function() {
                                window.Swal.close(); // Tutup loading Swal saat request selesai
                            }
                        });
                    }
                });
            }


            function tambahKoleksi(id) {
                // let bukuId = $(this).data("id"); // Ambil ID dari atribut data-id

                $.ajax({
                    url: "/dashboard/koleksi-buku/",
                    type: "POST",
                    data: {
                        buku_id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.status === "success") {
                            Swal.fire("Berhasil!", "Buku telah ditambahkan ke koleksi.", "success");
                        } else if (response.status === "exists") {
                            Swal.fire("Info", "Buku sudah ada di koleksi Anda.", "info");
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Terjadi kesalahan.", "error");
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
