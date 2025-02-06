<x-app-layout title="{{ __('Daftar Buku') }}">
    <x-header value="{{ __('Daftar Buku') }}" />
    <x-session-status />

    @role('admin')
        <a href="{{ route('buku.create') }}"
            class="px-4 py-2 mb-3 font-semibold text-white transition duration-200 transform bg-indigo-600 rounded shadow-lg hover:bg-indigo-800 hover:scale-105">
            Tambah Buku
        </a>
    @endrole

    <form class="mt-5 mb-3" action="{{ route('buku.index') }}" method="GET">
        <div class="flex">
            <input type="search" name="search"
                class="flex-1 p-2 bg-gray-200 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Cari Judul Buku" aria-label="Search" />
            <button class="p-2 text-white transition duration-200 bg-indigo-600 hover:bg-indigo-800 rounded-r-md"
                type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </form>

    <div class="container mx-auto mb-3">
        <div class="grid justify-center grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse ($buku as $item)
                <div class="h-max">
                    <div
                        class="h-full overflow-hidden transition-transform transform bg-white rounded-lg shadow-lg hover:scale-105">
                        @if (isset($item->gambar))
                            <img class="object-cover w-full h-48" src="{{ asset('/images/' . $item->gambar) }}"
                                alt="{{ $item->judul }}">
                        @else
                            <img class="object-cover w-full h-48" src="{{ asset('/images/noImage.jpg') }}"
                                alt="No Image">
                        @endif
                        <div class="flex flex-col h-full p-4">
                            <div class="flex-grow">
                                <h5 class="text-lg font-bold text-indigo-600">
                                    <a href="{{ route('buku.show', $item->id) }}" class="hover:underline">
                                        {{ $item->judul }}
                                    </a>
                                </h5>
                                <p class="text-gray-600">Kode Buku: {{ $item->kode_buku }}</p>
                                <p class="text-gray-600">Pengarang: <span
                                        class="text-indigo-500">{{ $item->pengarang }}</span></p>
                                <p class="text-gray-600">Kategori:
                                    <span class="text-indigo-500">
                                        @foreach ($item->load('kategori_buku')->kategori_buku as $kategori)
                                            {{ $kategori->nama }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                </p>
                                <p class="text-gray-600">Status: {{ $item->status }}</p>
                            </div>

                            <div class="flex mt-4 space-x-2">
                                <a href="{{ route('buku.show', $item->id) }}"
                                    class="flex-1 py-2 font-semibold text-center text-white transition duration-200 bg-blue-600 rounded hover:bg-blue-700">
                                    Detail
                                </a>

                                @role('admin')
                                    <a href="{{ route('buku.edit', $item->id) }}"
                                        class="flex-1 py-2 font-semibold text-center text-white transition duration-200 bg-yellow-500 rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <button
                                        class="flex-1 py-2 font-semibold text-center text-white transition duration-200 bg-red-600 rounded hover:bg-red-700"
                                        data-toggle="modal" data-target="#DeleteModal{{ $item->id }}">
                                        Delete
                                    </button>
                                @else
                                    <a href="{{ route('peminjaman.create') }}"
                                        class="flex-1 py-2 font-semibold text-center text-white transition duration-200 bg-red-600 rounded hover:bg-red-700">
                                        Pinjam Buku
                                    </a>
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <!-- Delete Modal -->
                <div class="modal fade" id="DeleteModal{{ $item->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="ModalLabelDelete" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                                       <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabelDelete">Ohh No!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus buku ini?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                    class="px-4 py-2 font-semibold text-black bg-gray-300 rounded hover:bg-gray-400"
                                    data-dismiss="modal">Batal</button>
                                <form action="/buku/{{ $item->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-4 py-2 font-semibold text-white bg-red-600 rounded hover:bg-red-700"
                                        type="submit">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                --}}
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
    </div>
</x-app-layout>
