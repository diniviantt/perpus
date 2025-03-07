<x-app-layout title="{{ __('Detail Kategori') }}">
    <x-header value="{{ __('Detail Kategori') }}" />
    <x-session-status />

    <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="m-3 text-2xl font-bold text-primary">{{ $kategori->nama }}</h3>
        <p class="m-3">{{ $kategori->deskripsi ?? 'Tidak Ada Deskripsi' }}</p>
        <div class="flex justify-end">
            <a href="{{ route('kategori.index') }}"
                class="px-4 py-2 mx-3 my-3 text-white bg-blue-500 rounded-md hover:bg-blue-600">Kembali</a>
        </div>
    </div>

    <h4 class="m-3 text-xl font-bold text-primary">Buku Terkait Kategori :</h4>

    <div class="mb-3 container-fluid">
        <div class="flex flex-wrap justify-center">
            @forelse ($kategori->kategori_buku as $item)
                <div class="max-w-xs mx-2 my-2">
                    <div class="bg-white rounded-lg shadow-md min-h-[28rem]">
                        <img class="object-cover w-full h-48 rounded-t-lg"
                            src="{{ $item->gambar ? asset('/images/' . $item->gambar) : asset('/images/noImage.jpg') }}"
                            alt="{{ $item->judul }}">
                        <div class="flex flex-col justify-between h-full p-4">
                            <div>
                                <h5 class="text-xl font-bold text-primary">
                                    <a href="{{ route('buku.show', $item->id) }}"
                                        class="hover:underline">{{ $item->judul }}</a>
                                </h5>
                                <p class="text-sm">Kode Buku: {{ $item->kode_buku }}</p>
                                <p class="text-sm">Pengarang: <a href="#"
                                        class="hover:underline">{{ $item->pengarang }}</a></p>
                                <p class="text-sm">Kategori:</p>
                                <p class="text-primary">
                                    @foreach ($item->kategori_buku as $kategori)
                                        {{ $kategori->nama }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                                <p class="text-sm">Status: {{ $item->status }}</p>
                            </div>
                            <div class="mt-4">
                                @role('admin')
                                    <div class="flex space-x-2">
                                        <a href="{{ route('buku.show', $item->id) }}"
                                            class="px-2 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600">Detail</a>
                                        <a href="{{ route('buku.edit', $item->id) }}"
                                            class="px-2 py-1 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">Edit</a>
                                        <button class="px-2 py-1 text-white bg-red-500 rounded-md hover:bg-red-600"
                                            data-toggle="modal"
                                            data-target="#DeleteModal{{ $item->id }}">Delete</button>
                                    </div>
                                @endrole

                                @role('peminjam')
                                    <div class="flex space-x-2">
                                        <a href="{{ route('buku.show', $item->id) }}"
                                            class="px-2 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600">Detail</a>
                                        <a href="{{ route('buku.pinjam', $item->id) }}"
                                            class="px-2 py-1 text-white bg-red-500 rounded-md hover:bg-red-600">Pinjam
                                            Buku</a>
                                    </div>
                                @endrole
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="DeleteModal{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="ModalLabelDelete" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabelDelete">Ohh No!</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                class="px-4 py-2 text-gray-700 bg-gray-300 rounded-md hover:bg-gray-400"
                                                data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('buku.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button
                                                    class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600"
                                                    type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Delete Modal -->
                        </div>
                    </div>
                </div>
                @empty
                    <h3 class="mt-3 text-primary">Tidak ada buku</h3>
                @endforelse
            </div>
        </div>
    </x-app-layout>
