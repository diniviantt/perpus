<x-app-layout title="{{ __('Edit Kategori') }}">
    <x-header value="{{ __('Edit Kategori') }}" />
    <x-session-status />

    <div class="p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('kategori.update', $kategori->id) }}" method="post">
            @csrf
            @method('put')

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input name="nama" type="text" value="{{ old('nama', $kategori->nama) }}"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    id="nama" placeholder="Masukkan nama kategori" required>
                @error('nama')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" cols="30" rows="3"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    id="deskripsi" placeholder="Masukkan deskripsi">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('kategori.index') }}"
                    class="inline-flex items-center px-4 py-2 mx-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
