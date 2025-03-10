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

            <div class="flex items-center mt-16">
                <a href="{{ route('buku.index') }}"
                    class="flex items-center px-4 py-2.5 text-white transition duration-200 bg-blue-500 rounded-full hover:bg-blue-600">
                    <i class="text-lg fas fa-arrow-left"></i>
                </a>
            </div>
        </div>

    </div>

    <x-slot name="scripts">
        <script>
            $('#multiselect').select2({
                allowClear: true,
            });
        </script>
    </x-slot>
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
        </style>
    </x-slot>
</x-app-layout>
