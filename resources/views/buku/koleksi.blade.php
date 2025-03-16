<x-app-layout title="{{ __('Koleksi Buku') }}">
    <x-header value="{{ __('Koleksi Buku') }}" />
    <x-session-status />


    <x-card>

        <div class="p-4 md:p-6">
            @if (collect($koleksi)->isEmpty())
                <p class="text-center text-gray-500">Belum ada buku dalam koleksi.</p>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    @foreach ($koleksi as $k)
                        <div id="buku-{{ $k->id }}" class="w-full h-max">
                            <div class="flex overflow-hidden bg-white rounded-lg shadow-md h-72">
                                {{-- Gambar --}}
                                <div class="w-1/2 h-full">
                                    <img class="object-cover w-full h-full"
                                        src="{{ asset('/images/' . ($k->buku->gambar ?? 'noImage.jpg')) }}"
                                        alt="{{ $k->buku->judul }}">
                                </div>

                                {{-- Keterangan Buku --}}
                                <div class="flex flex-col justify-between w-1/2 p-4">
                                    <div>
                                        <h5 class="mb-3 text-lg font-bold leading-tight text-indigo-600">
                                            <a href="{{ route('buku.show', $k->buku->id) }}"
                                                class="hover:underline">{{ $k->buku->judul }}</a>
                                        </h5>
                                        <p class="text-sm text-gray-600">Pengarang: <span
                                                class="text-indigo-500">{{ $k->buku->pengarang }}</span></p>
                                        <p class="text-sm text-gray-600">Kategori:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($k->buku->kategori_buku as $kategori)
                                                <span
                                                    class="px-2 py-1 text-xs text-white bg-indigo-500 rounded-full">{{ $kategori->nama }}</span>
                                            @endforeach
                                        </div>

                                        <p class="text-sm text-gray-600">Stock:</p>
                                        @if ($k->buku->stock > 0)
                                            <p class="px-2 py-1 text-xs text-white bg-green-500 rounded-full w-max">
                                                Tersedia
                                                ({{ $k->buku->stock }})
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500">Buku ini masih tersedia untuk
                                                dipinjam.
                                            </p>
                                        @else
                                            <p class="px-2 py-1 text-xs text-white bg-red-500 rounded-full w-max">Habis
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500">Maaf, buku ini sedang tidak tersedia.
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Tombol Aksi --}}
                                    <div class="flex mt-4 space-x-2">
                                        <a href="{{ route('buku.show', $k->buku->id) }}"
                                            class="flex items-center justify-center w-8 h-8 text-white transition bg-blue-600 rounded hover:bg-blue-700"
                                            aria-label="Detail" title="Lihat Detail">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>


                                        <!-- Cek apakah buku sudah ada di koleksi -->
                                        {{-- <button id="btn-tambah-koleksi" data-id="{{ $k->buku->id }}"
                                            class="flex items-center justify-center w-8 h-8 text-white transition bg-purple-600 rounded hover:bg-purple-700"
                                            aria-label="Tambah ke Koleksi" title="Tambahkan ke Koleksi">
                                            <i data-lucide="bookmark" class="w-4 h-4"></i>
                                        </button> --}}
                                        <a href="{{ route('buku.show', $k->buku->id) }}"
                                            class="flex items-center justify-center w-8 h-8 text-white transition bg-blue-500 rounded hover:bg-blue-600"
                                            aria-label="Pinjam Buku" title="Pinjam Buku">
                                            <i data-lucide="book-open" class="w-4 h-4"></i>
                                        </a>

                                        <button
                                            class="flex items-center justify-center w-8 h-8 text-white transition bg-red-500 rounded hover:bg-red-600"
                                            onclick="confirmDelete({{ $k->id }})"
                                            aria-label="Hapus dari Koleksi" title="Hapus dari Koleksi">
                                            <i data-lucide="bookmark-x" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </x-card>

    <x-slot name="scripts">
        <script>
            lucide.createIcons();
            // Event listener untuk tombol tambah koleksi
            $(document).on("click", "#btn-tambah-koleksi", function() {
                let bukuId = $(this).data("id"); // Ambil ID dari atribut data-id

                $.ajax({
                    url: "{{ route('tambah-koleksi') }}",
                    type: "POST",
                    data: {
                        buku_id: bukuId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
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
            });

            // Fungsi konfirmasi hapus koleksi
            function confirmDelete(id) {
                Swal.fire({
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
                                        location.reload(); // Reload halaman setelah penghapusan
                                    });
                            },
                            error: function() {
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus buku.", "error");
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
