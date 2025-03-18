<x-app-layout title="{{ __('Koleksi Buku') }}">
    <x-session-status />

    <x-card>
        <div class="p-4 md:p-6">
            <!-- Tambahkan Judul dan Deskripsi -->
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-indigo-600">📚 Koleksi Buku Saya</h2>
                <p class="text-gray-600">Berikut adalah daftar buku yang telah Anda koleksi. Jelajahi dan kelola koleksi
                    Anda dengan mudah.</p>
                <div class="w-24 mx-auto mt-2 border-b-2 border-indigo-300"></div>
            </div>

            @if (collect($koleksi)->isEmpty())
                <p class="text-center text-gray-500">Belum ada buku dalam koleksi.</p>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                    @foreach ($koleksi as $k)
                        <div id="buku-{{ $k->id }}" class="w-full h-max">
                            <div class="flex overflow-hidden bg-white rounded-lg shadow-md h-72">
                                {{-- Gambar --}}
                                <div class="w-1/2 h-full p-2 bg-white rounded-lg">
                                    <img class="object-cover w-full h-full rounded-lg"
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
                                                Tersedia ({{ $k->buku->stock }})
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500">Buku ini masih tersedia untuk
                                                dipinjam.</p>
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
                                            class="flex items-center justify-center w-8 h-8 text-indigo-600 transition border border-indigo-500 rounded-lg shadow-sm hover:bg-indigo-100"
                                            aria-label="Detail" title="Lihat Detail">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        <a href="{{ route('buku.show', $k->buku->id) }}"
                                            class="flex items-center justify-center w-8 h-8 text-blue-600 transition border border-blue-500 rounded-lg shadow-sm hover:bg-blue-100"
                                            aria-label="Pinjam Buku" title="Pinjam Buku">
                                            <i data-lucide="book-open" class="w-4 h-4"></i>
                                        </a>

                                        <button onclick="confirmDelete({{ $k->id }})"
                                            class="flex items-center justify-center w-8 h-8 text-red-600 transition border border-red-500 rounded-lg shadow-sm hover:bg-red-100"
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
                        $.ajax({
                            url: `/dashboard/koleksi-buku/${id}`,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire("Dihapus!", "Buku telah dihapus dari koleksi.", "success").then(
                                    () => {
                                        location.reload();
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
