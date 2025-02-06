<x-app-layout title="{{ __('Detail Buku') }}">
    <x-header value="{{ __('Detail Buku') }}" />
    <x-session-status />

    <h1 class="mb-6 text-3xl font-bold text-center text-blue-600">{{ $buku->judul }}</h1>

    <div class="p-4 mb-4 bg-white rounded-lg shadow-lg">
        <div class="flex flex-col items-center">
            @if ($buku->gambar != null)
                <img class="mb-3 rounded-lg" src="{{ asset('/images/' . $buku->gambar) }}"
                    style="height:200px;width:200px">
            @else
                <img class="mb-3 rounded-lg" src="{{ asset('/images/noImage.jpg') }}" style="height:200px;width:200px">
            @endif

            <h5 class="text-lg font-semibold">Pengarang: <span class="text-blue-500">{{ $buku->pengarang }}</span></h5>
            <h5 class="text-lg font-semibold">Penerbit: <span class="text-blue-500">{{ $buku->penerbit }}</span></h5>
            <h5 class="text-lg font-semibold">Tahun Terbit: <span class="text-blue-500">{{ $buku->tahun_terbit }}</span>
            </h5>
            <h5 class="text-lg font-semibold">Deskripsi:</h5>
            <p class="mt-2 text-justify text-gray-700"
                style="text-indent: 1rem; letter-spacing: .1rem; word-spacing: .1rem;">{{ $buku->deskripsi }}</p>
        </div>
    </div>

    <div class="flex justify-center">
        <a href="{{ route('buku.index') }}"
            class="px-4 py-2 text-white transition duration-200 bg-blue-500 rounded-md hover:bg-blue-600">Kembali</a>
    </div>

    <x-slot name="scripts">
        <script>
            $('#multiselect').select2({
                allowClear: true,
            });
        </script>
    </x-slot>
</x-app-layout>
