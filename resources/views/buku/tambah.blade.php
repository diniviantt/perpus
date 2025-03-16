<x-app-layout title="{{ __('Tambah Buku') }}">
    <x-header value="{{ __('Tambah Buku') }}" />
    <x-session-status />

    <div class="mb-4 bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between px-4 py-3 text-white bg-blue-500 rounded-t-lg">
            <h6 class="text-lg font-bold">Form Tambah Buku</h6>
        </div>
        <div class="p-4">
            <form action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Kolom 1: Buku Utama -->
                    <div class="mb-4">
                        <label for="judul" class="block mb-1 font-semibold text-blue-500">Judul Buku</label>
                        <input type="text" name="judul"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('judul') }}">
                        @error('judul')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="kode_buku" class="block mb-1 font-semibold text-blue-500">Kode Buku</label>
                        <input type="text" name="kode_buku"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('kode_buku') }}">
                        @error('kode_buku')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
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

                    <div class="mb-4">
                        <label for="pengarang" class="block mb-1 font-semibold text-blue-500">Pengarang</label>
                        <input type="text" name="pengarang"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('pengarang') }}">
                        @error('pengarang')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="penerbit" class="block mb-1 font-semibold text-blue-500">Penerbit</label>
                        <input type="text" name="penerbit"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('penerbit') }}">
                        @error('penerbit')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom 2: Informasi Tambahan -->
                    <div class="mb-4">
                        <label for="tahun_terbit" class="block mb-1 font-semibold text-blue-500">Tahun Terbit</label>
                        <input type="text" name="tahun_terbit"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('tahun_terbit') }}">
                        @error('tahun_terbit')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="block mb-1 font-semibold text-blue-500">Deskripsi</label>
                        <textarea class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            name="deskripsi" rows="2">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block mb-1 font-semibold text-blue-500">Stock</label>
                        <input type="number"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            name="stock" rows="2">{{ old('stock') }}</input>
                        @error('stock')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="gambar" class="block mb-1 font-semibold text-blue-500">Tambah Sampul Buku</label>
                        <input type="file" name="gambar" id="gambar"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('gambar')
                            <div class="mt-1 text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-2">
                    <a href="{{ route('buku.index') }}"
                        class="px-4 py-2 text-white transition duration-200 bg-red-500 rounded-md hover:bg-red-600">Kembali</a>
                    <button type="submit"
                        class="px-4 py-2 text-white transition duration-200 bg-blue-500 rounded-md hover:bg-blue-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            $('#multiselect').select2({
                allowClear: true,
            });
        </script>
    </x-slot>
</x-app-layout>
