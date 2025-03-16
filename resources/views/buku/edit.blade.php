<x-app-layout title="{{ __('Edit Buku') }}">
    <x-session-status />

    <div class="bg-white rounded-lg shadow-lg ">
        <div class="flex items-center justify-between px-4 py-3 text-xl text-gray-600 rounded-t-lg">
            <h6 class="font-bold">Form Edit Buku</h6>
        </div>
        <div class="p-4">
            <form action="{{ route('buku.update', $buku->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    <div class="mb-1">
                        <label for="judul" class="block mb-1 font-semibold text-blue-500">Judul Buku</label>
                        <input type="text" name="judul"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('judul', $buku->judul) }}">
                        @error('judul')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="kode_buku" class="block mb-1 font-semibold text-blue-500">Kode Buku</label>
                        <input type="text" name="kode_buku"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('kode_buku', $buku->kode_buku) }}">
                        @error('kode_buku')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="kategori" class="block mb-1 font-semibold text-blue-500">Kategori</label>
                        <select
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            name="kategori_buku[]" id="multiselect" multiple>
                            @forelse ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @empty
                                <option disabled>tidak ada kategori</option>
                            @endforelse
                        </select>
                        @error('kategori')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="pengarang" class="block mb-1 font-semibold text-blue-500">Pengarang</label>
                        <input type="text" name="pengarang"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('pengarang', $buku->pengarang) }}">
                        @error('pengarang')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="penerbit" class="block mb-1 font-semibold text-blue-500">Penerbit</label>
                        <input type="text" name="penerbit"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('penerbit', $buku->penerbit) }}">
                        @error('penerbit')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="tahun_terbit" class="block mb-1 font-semibold text-blue-500">Tahun Terbit</label>
                        <input type="text" name="tahun_terbit"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                        @error('tahun_terbit')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-2 mb-1">
                        <label for="deskripsi" class="block mb-1 font-semibold text-blue-500">Deskripsi</label>
                        <textarea class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            name="deskripsi" rows="2">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-2 mb-1">
                        <label for="stock" class="block mb-1 font-semibold text-blue-500">Stock</label>
                        <input type="number" name="stock"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('stock', $buku->stock) }}">
                        @error('stock')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-span-2 mb-1">
                        <label for="gambar" class="block mb-1 font-semibold text-blue-500">Tambah Sampul Buku</label>
                        <input type="file" name="gambar" id="gambar"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('gambar')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between mt-2 space-x-2">
                    <!-- Kembali Button with Lucide Icon and Tooltip -->
                    <a href="{{ route('buku.index') }}"
                        class="flex items-center justify-center w-10 h-10 text-white bg-blue-500 rounded-full hover:bg-blue-600"
                        title="Kembali">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>

                    <!-- Simpan Button with Lucide Icon and Tooltip -->
                    <button type="submit"
                        class="flex items-center justify-center w-10 h-10 text-white bg-blue-500 rounded-full hover:bg-blue-600"
                        title="Simpan">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <!-- You can replace this icon with another simpan icon -->
                    </button>
                </div>

            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $('#multiselect').select2({
                allowClear: true
            });
        </script>
    </x-slot>
</x-app-layout>
