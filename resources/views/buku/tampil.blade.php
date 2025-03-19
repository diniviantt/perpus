<x-app-layout title="{{ __('Daftar Buku') }}">
    {{-- <x-header value="{{ __('Daftar Buku') }}" /> --}}
    <x-session-status />
    @php
        // Ambil ID buku yang ada di koleksi pengguna
        $koleksiIds = $buku->pluck('buku_id')->toArray();

        $bukuDipinjamIds = $bukuDipinjam->pluck('buku_id')->toArray();

    @endphp
    @if (session('status'))
        <div id="flash-message"
            class="p-3 mb-4 text-white text-center rounded-lg
        {{ session('alert') == 'success' ? 'bg-green-500' : 'bg-red-500' }}">
            {{ session('status') }}
        </div>
    @endif

    @role('admin')
        <div class="flex gap-4 mb-3">
            <!-- Tombol Tambah Buku -->
            <a href="javascript:void(0)" onclick="AddBuku()"
                class="relative flex items-center justify-center p-3 text-gray-200 transition-all duration-300 bg-indigo-500 rounded-lg shadow-lg hover:bg-indigo-700 active:scale-95 group"
                title="Tambah Buku">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 transition-transform duration-300 group-hover:rotate-180" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M21.5,2H12.118L8.118,0H2.5C1.122,0,0,1.122,0,2.5V22H10.298c-.2-.32-.381-.653-.538-1H1V7H23v4.026c.36,.306,.695,.641,1,1.003V4.5c0-1.378-1.121-2.5-2.5-2.5ZM1,6V2.5c0-.827,.673-1.5,1.5-1.5H7.882l4,2h9.618c.827,0,1.5,.673,1.5,1.5v1.5H1Zm16.5,5c-3.584,0-6.5,2.916-6.5,6.5s2.916,6.5,6.5,6.5,6.5-2.916,6.5-6.5-2.916-6.5-6.5-6.5Zm0,12c-3.032,0-5.5-2.468-5.5-5.5s2.468-5.5,5.5-5.5,5.5,2.468,5.5,5.5-2.468,5.5-5.5,5.5Zm.5-6h2.5v1h-2.5v2.5h-1v-2.5h-2.5v-1h2.5v-2.5h1v2.5Z" />
                </svg>
            </a>

            <!-- Tombol Import Buku -->
            <a href="javascript:void(0)" onclick="importData()"
                class="relative flex items-center justify-center p-3 text-gray-200 transition-all bg-indigo-500 rounded-lg shadow-lg hover:bg-indigo-700 active:scale-95 group"
                title="Import Buku">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 transition-transform duration-300 group-hover:scale-125" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 2L5 9h4v8h6V9h4l-7-7zM2 20h20v2H2v-2z" />
                </svg>
            </a>

            <!-- Tombol Export Buku -->
            <a href="{{ route('buku-export') }}"
                class="relative flex items-center justify-center p-3 text-gray-200 transition-all bg-indigo-500 rounded-lg shadow-lg hover:bg-indigo-700 active:scale-95 group"
                title="Export Buku">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 transition-transform duration-300 group-hover:-translate-y-1" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M14,2V11H19L12,18L5,11H10V2H14M2,20H22V22H2V20Z" />
                </svg>
            </a>
        </div>
    @endrole


    <form class="mt-5 mb-10" action="{{ route('buku.index') }}" method="GET">
        <div class="flex w-full">
            <input type="search" name="search"
                class="flex-1 p-3 transition duration-200 bg-white border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Cari Judul Buku" aria-label="Search" value="{{ request('search') }}" />
            <button
                class="flex items-center justify-center w-12 h-12 ml-2 text-white transition duration-200 transform bg-indigo-600 rounded-full shadow-md hover:bg-indigo-700 hover:scale-105"
                type="submit" aria-label="Search">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </form>



    <div class="flex flex-col items-center justify-center mb-8 text-center">
        <h1 class="mb-2 text-4xl font-extrabold text-gray-700">📖 Temukan Buku Favorit Anda</h1>
        <p class="p-5 mb-2 text-lg text-gray-500">
            Temukan buku yang sesuai dengan minat Anda dan pinjam sekarang untuk pengalaman membaca yang luar biasa!
        </p>

        <div class="flex items-center justify-center mx-10 mb-7">
            <div class="flex flex-wrap justify-center gap-3">
                <!-- Badge "All" -->
                <a href="{{ route('buku.index') }}"
                    class="inline-flex items-center px-5 py-2 text-lg font-bold text-white transition duration-300 transform bg-indigo-600 rounded-full shadow-md hover:bg-indigo-700 hover:scale-105">
                    📚 All
                </a>

                @foreach ($kategori as $item)
                    <a href="{{ route('buku.index', ['kategori' => $item->id]) }}"
                        class="inline-flex items-center px-5 py-2 text-lg font-bold text-white transition duration-300 transform bg-indigo-600 rounded-full shadow-md hover:bg-indigo-700 hover:scale-105
                        {{ request('kategori') == $item->id ? 'bg-indigo-800 scale-110' : '' }}">
                        {{ $item->nama }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container px-1 mb-3"> <!-- Ganti -mx-6 dengan px-6 -->
        <div class="grid justify-center grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
            @forelse ($buku as $item)
                <div id="buku-{{ $item->id }}" class="w-full h-max"> <!-- Tambahkan w-full -->
                    <div class="flex w-full overflow-hidden bg-white rounded-lg shadow-md h-72">
                        <div class="flex w-1/2 h-full p-2 bg-white">
                            <img class="object-cover w-full h-full rounded-lg"
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
                                <div class="gap-2">
                                    @foreach ($item->kategori_buku as $kategori_buku)
                                        <span
                                            class="px-1 text-[10px] text-indigo-500 border border-indigo-500 rounded-full mr-1">
                                            {{ $kategori_buku->nama }}
                                        </span>
                                    @endforeach
                                </div>



                                <div class="items-center gap-2 ">
                                    <p class="text-sm text-gray-600">Stock:
                                        @if ($item->stock > 0)
                                            <span
                                                class="px-1 text-[10px] text-green-600 border border-green-500 rounded-full ring-green-500">
                                                Tersedia ({{ $item->stock }})
                                            </span>
                                        @else
                                            <span
                                                class="px-1 text-[10px] text-red-600 border border-red-500 rounded-full ring-red-500">
                                                Habis
                                            </span>
                                        @endif
                                    </p>

                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    @if ($item->stock > 0)
                                        Buku ini masih tersedia untuk dipinjam.
                                    @else
                                        Maaf, buku ini sedang tidak tersedia.
                                    @endif
                                </p>


                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex space-x-2">
                                <a href="{{ route('buku.show', $item->id) }}"
                                    class="flex items-center justify-center w-8 h-8 text-blue-500 transition border border-blue-500 rounded-lg hover:bg-blue-300 hover:text-white"
                                    aria-label="Detail" title="Lihat Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                @role('admin')
                                    <a href="{{ route('buku.edit', $item->id) }}"
                                        class="flex items-center justify-center w-8 h-8 text-yellow-500 transition border border-yellow-500 rounded-lg hover:bg-yellow-300 hover:text-white"
                                        aria-label="Edit" title="Edit Buku">
                                        <i data-lucide="square-pen" class="w-5 h-5"></i>
                                    </a>
                                    <button
                                        class="flex items-center justify-center w-8 h-8 text-red-500 transition border border-red-500 rounded-lg hover:bg-red-300 hover:text-white"
                                        onclick="confirmDelete({{ $item->id }})" aria-label="Delete"
                                        title="Hapus Buku">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </button>
                                    @if ($item->status === 'Aktif')
                                        <!-- Tombol untuk Nonaktifkan -->
                                        <button
                                            class="flex items-center justify-center w-8 h-8 text-orange-500 transition border border-orange-500 rounded-lg hover:bg-orange-300 hover:text-white"
                                            onclick="toggleStatus({{ $item->id }})" aria-label="Nonaktifkan Buku"
                                            title="Nonaktifkan Buku">
                                            <i data-lucide="power-off" class="w-4 h-4"></i>
                                        </button>
                                    @else
                                        <!-- Tombol untuk Aktifkan -->
                                        <button
                                            class="flex items-center justify-center w-8 h-8 text-blue-500 transition border border-blue-500 rounded-lg hover:bg-blue-300 hover:text-white"
                                            onclick="toggleStatus({{ $item->id }})" aria-label="Aktifkan Buku"
                                            title="Aktifkan Buku">
                                            <i data-lucide="power" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                @else
                                    @if (in_array($item->id, $bukuDipinjamIds))
                                        {{-- Jika buku sedang dipinjam, tampilkan ikon disabled --}}
                                        <button
                                            class="flex items-center justify-center w-8 h-8 text-gray-500 border border-gray-300 rounded-lg cursor-not-allowed"
                                            title="Buku sedang dipinjam">
                                            <i class="w-4 h-4" data-lucide="book-open-check"></i>
                                        </button>
                                    @else
                                        {{-- Jika buku bisa dipinjam, tampilkan tombol interaktif --}}
                                        <button id="pinjamSekarang-{{ $item->id }}"
                                            data-buku-id="{{ $item->id }}"
                                            class="flex items-center justify-center w-8 h-8 text-blue-500 transition border border-blue-500 rounded-lg hover:bg-blue-300 hover:text-white"
                                            title="Pinjam Buku">
                                            <i class="w-4 h-4" data-lucide="book-open"></i>
                                        </button>
                                    @endif



                                    @if (!in_array($item->id, $koleksiBukuIds))
                                        <button id="btn-tambah-koleksi" onclick="tambahKoleksi({{ $item->id }})"
                                            data-id="{{ $item->id }}"
                                            class="flex items-center justify-center w-8 h-8 text-purple-500 transition border border-purple-500 rounded-lg hover:bg-purple-300 hover:text-white"
                                            aria-label="Tambah ke Koleksi" title="Tambahkan ke Koleksi">
                                            <i data-lucide="bookmark" class="w-4 h-4"></i>
                                        </button>
                                    @else
                                        @foreach ($koleksi as $k)
                                            @if ($k->buku_id == $item->id)
                                                <button
                                                    class="flex items-center justify-center w-8 h-8 text-red-500 transition border border-red-500 rounded-lg hover:bg-red-300 hover:text-white"
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
                <div class="flex flex-col items-center justify-center w-full h-[50vh] text-gray-600 translate-x-96 ">
                    <i data-lucide="book-x" class="w-16 h-16 text-gray-400"></i>
                    <h1 class="mt-3 text-lg font-semibold">Tidak ada buku</h1>
                </div>
            @endforelse

        </div>
    </div>

    <div x-data="{ modalUpload: false, modalBuku: false }" x-init="$store.modal = { modalUpload: modalUpload, modalBuku: modalBuku }">
        <x-slot name="modals">

            <form id="modalBuku" action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <x-modal modal="$store.modal.modalBuku" dialog="modal-modalBuku-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Tambah Data Buku')" />
                            <div class="grid grid-cols-1 gap-4 my-2 lg:grid-cols-2">
                                <!-- Judul Buku -->
                                <div>
                                    <x-input-label for="judul" :text="__('Judul Buku')" />
                                    <x-text-input name="judul" id="judul" class="mt-1" :value="old('judul')"
                                        required />
                                    <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                                </div>

                                <!-- Kode Buku -->
                                <div>
                                    <x-input-label for="kode_buku" :text="__('Kode Buku')" />
                                    <x-text-input name="kode_buku" id="kode_buku" class="mt-1" :value="old('kode_buku')"
                                        required />
                                    <x-input-error :messages="$errors->get('kode_buku')" class="mt-2" />
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <x-input-label for="kategori" :text="__('Kategori')" />
                                    <select name="kategori_buku[]" id="multiselect" multiple
                                        class="w-full mt-1 rounded-md">
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                                </div>

                                <!-- Tahun Terbit -->
                                <div>
                                    <x-input-label for="tahun_terbit" :text="__('Tahun Terbit')" />
                                    <x-text-input name="tahun_terbit" id="tahun_terbit" class="mt-1"
                                        :value="old('tahun_terbit')" required />
                                    <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                                </div>

                                <!-- Pengarang -->
                                <div>
                                    <x-input-label for="pengarang" :text="__('Pengarang')" />
                                    <x-text-input name="pengarang" id="pengarang" class="mt-1" :value="old('pengarang')"
                                        required />
                                    <x-input-error :messages="$errors->get('pengarang')" class="mt-2" />
                                </div>

                                <!-- Penerbit -->
                                <div>
                                    <x-input-label for="penerbit" :text="__('Penerbit')" />
                                    <x-text-input name="penerbit" id="penerbit" class="mt-1" :value="old('penerbit')"
                                        required />
                                    <x-input-error :messages="$errors->get('penerbit')" class="mt-2" />
                                </div>

                                <!-- Stock -->
                                <div>
                                    <x-input-label for="stock" :text="__('Stock')" />
                                    <x-text-input type="number" name="stock" id="stock" class="mt-1"
                                        :value="old('stock')" required />
                                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                </div>

                                <!-- Tarif Denda -->
                                <div>
                                    <x-input-label for="tarif_denda" :text="__('Tarif Denda per Hari')" />
                                    <x-text-input type="number" name="tarif_denda" id="tarif_denda" class="mt-1"
                                        :value="old('tarif_denda')" required />
                                    <x-input-error :messages="$errors->get('tarif_denda')" class="mt-2" />
                                </div>

                                <!-- Gambar -->
                                <div class="lg:col-span-2">
                                    <x-input-label for="gambar" :text="__('Tambah Sampul Buku')" />
                                    <x-text-input type="file" name="gambar" id="gambar" class="mt-1"
                                        required />
                                    <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                                </div>

                                <!-- Deskripsi -->
                                <div class="lg:col-span-2">
                                    <x-input-label for="deskripsi" :text="__('Deskripsi')" />
                                    <textarea name="deskripsi" id="deskripsi" rows="3"
                                        class="block w-full px-4 py-3 mt-1 text-sm text-indigo-700 bg-white border border-gray-400 rounded-lg focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500">{{ old('deskripsi') }}</textarea>
                                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button type="submit"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Simpan') }}
                        </x-modal-button>
                        <x-modal-button x-on:click="$store.modal.modalBuku = false" type="button"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Batal') }}
                        </x-modal-button>
                    </div>
                </x-modal>
            </form>



            <form id="UploadBuku" action="{{ route('import-buku') }}" method="POST" class="space-y-4">
                @csrf
                <x-modal modal="$store.modal.modalUpload" dialog="modal-modalUpload-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Upload File Buku')" />
                            <div class="my-2 space-y-3">
                                <div>
                                    <span
                                        class="block px-3 py-2 text-sm font-medium text-red-700 bg-red-100 border border-red-400 rounded-lg">
                                        Pastikan sudah mengunduh file!
                                        <a href="{{ route('buku-export') }}" class="text-blue-700 underline">Unduh
                                            Template</a>
                                    </span>

                                    <input type="file" name="import" id="file" autocomplete="off"
                                        class="block w-full px-4 py-3 mt-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-500/30 focus:border-indigo-500 placeholder:text-gray-400"
                                        required />
                                    <p id="file-name" class="mt-2 text-sm text-gray-600"></p>

                                    <x-input-error :messages="$errors->get('import')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button type="submit"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Upload') }}
                        </x-modal-button>

                        <x-modal-button x-on:click="$store.modal.modalUpload = false" type="button"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Batal') }}
                        </x-modal-button>
                    </div>
                </x-modal>
            </form>

        </x-slot>
    </div>



    <div class="mx-2 my-5">
        {{ $buku->links('vendor.pagination.tailwind') }}
    </div>

    <!-- Buku Terpopuler -->
    <div class="p-5 bg-white rounded-lg">
        @if ($bukuTerpopuler->isNotEmpty())
            <h2 class="mb-5 text-2xl font-bold text-gray-700">📚 Buku Terpopuler</h2>
            <div class="grid grid-cols-1 gap-4">
                @foreach ($bukuTerpopuler as $populer)
                    <div class="flex items-start gap-4 p-4 bg-white border rounded-lg shadow-md">
                        <!-- Gambar Buku -->
                        <div class="w-40 h-full">
                            <img class="object-cover w-full h-full rounded-md"
                                src="{{ asset('/images/' . ($populer->gambar ?? 'noImage.jpg')) }}"
                                alt="{{ $populer->judul }}">
                        </div>

                        <!-- Informasi Buku -->
                        <div class="flex flex-col flex-1">
                            <h5 class="mb-2 text-lg font-bold text-indigo-600">
                                <a href="{{ route('buku.show', $populer->id) }}" class="hover:underline">
                                    {{ $populer->judul }}
                                </a>
                            </h5>
                            <p class="mb-3 text-sm text-gray-600 text-wrap"
                                style="text-indent: 0.75rem; letter-spacing: 0.05rem; word-spacing: 0.1rem;">
                                {{ $populer->deskripsi }}
                            </p>
                            <p class="text-sm text-gray-600">Pengarang:
                                <span class="text-indigo-500">{{ $populer->pengarang }}</span>
                            </p>

                            <!-- Menampilkan kategori -->
                            <div class="flex flex-wrap gap-2">
                                @foreach ($populer->kategori_buku as $kategori)
                                    <span class="px-2 py-1 text-xs text-indigo-500 border border-indigo-500 rounded">
                                        {{ $kategori->nama }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Tombol Detail & Pinjam -->
                            <div class="flex gap-2 mt-3">
                                <a href="{{ route('buku.show', $populer->id) }}"
                                    class="p-2 text-indigo-500 transition border border-indigo-500 rounded-full hover:bg-indigo-500 hover:text-white">
                                    <!-- Heroicon Eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M10 3C4 3 1 10 1 10s3 7 9 7 9-7 9-7-3-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                    </svg>
                                </a>
                                <button
                                    class="p-2 text-green-500 transition border border-green-500 rounded-full hover:bg-green-500 hover:text-white">
                                    <!-- Heroicon Bookmark -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M6 2a2 2 0 00-2 2v14l6-4 6 4V4a2 2 0 00-2-2H6z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="pl-5 mb-5 text-center text-gray-600">Belum ada buku terpopuler.</p>
        @endif
    </div>


    </div>






    <x-slot name="scripts">
        <script>
            lucide.createIcons();


            $('#multiselect').select2({
                allowClear: true,
            });

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
                                if (response.status === 'success') {
                                    window.Swal.fire({
                                        title: "Deleted!",
                                        text: response.message, // Pesan yang dikirimkan oleh server
                                        icon: "success",
                                        showConfirmButton: true,
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        // Setelah klik OK, refresh halaman
                                        location.reload(); // Refresh halaman setelah klik OK
                                    });
                                } else {
                                    window.Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi kesalahan saat menghapus data.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
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
                $.ajax({
                    url: "/dashboard/koleksi-buku/",
                    type: "POST",
                    data: {
                        buku_id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status === "success") {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Buku telah ditambahkan ke koleksi.",
                                icon: "success"
                            }).then(() => {
                                window.location.reload(); // Refresh halaman setelah user menutup alert
                            });
                        } else if (response.status === "exists") {
                            Swal.fire({
                                title: "Info",
                                text: "Buku sudah ada di koleksi Anda.",
                                icon: "info"
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Terjadi kesalahan.",
                            icon: "error"
                        });
                    }
                });
            }



            function importData() {
                $('#modal-modalUpload-dialog').removeClass("invisible");
                $('#modal-modalUpload-dialog').addClass("visible");

                window.Alpine.store('modal', {
                    modalUpload: true,
                });
            }
            $("#file").change(function() {
                let fileName = $(this).val().split("\\").pop();
                $("#file-name").text("File dipilih: " + fileName);
            });

            $("#UploadBuku").submit(function(e) {
                e.preventDefault(); // Mencegah form submit langsung

                let fileInput = $("#file")[0].files[0];
                let submitButton = $(this).find("[type='submit']");

                if (!fileInput) {
                    Swal.fire("Error!", "Silakan pilih file sebelum mengupload!", "error");
                    return;
                }

                let allowedExtensions = /(\.xlsx|\.xls)$/i;
                if (!allowedExtensions.exec(fileInput.name)) {
                    Swal.fire("Error!",
                        "Format file tidak valid! Hanya file .xlsx atau .xls yang diperbolehkan.",
                        "error");
                    return;
                }

                submitButton.prop("disabled", true).text("Uploading...");

                let formData = new FormData($("#UploadBuku")[0]);

                $.ajax({
                    url: $("#UploadBuku").attr("action"),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reset input file & form setelah klik OK
                                $("#file").val("");
                                $("#file-name").text("");
                                $("#UploadBuku")[0].reset();

                                // Aktifkan kembali tombol upload
                                submitButton.prop("disabled", false).text("Upload");

                                // Tutup modal
                                $('#modal-modalUpload-dialog').removeClass("visible");
                                $('#modal-modalUpload-dialog').addClass("invisible");

                                $('#userManage').DataTable().ajax.reload(null,
                                    false);
                            }
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = "Terjadi kesalahan saat mengupload data.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire("Error!", errorMessage, "error");

                        // Aktifkan kembali tombol upload
                        submitButton.prop("disabled", false).text("Upload");
                    }
                });
            });



            function AddBuku() {
                $('#modal-modalBuku-dialog').removeClass("invisible").addClass("visible");

                // Kosongkan semua input dalam modal
                $('#modal-modalBuku-dialog input').val('');
                $('#modal-modalBuku-dialog textarea').val('');
                $('#modal-modalBuku-dialog select').val(null).trigger('change'); // Untuk Select2

                // Pastikan Alpine menyimpan status modal
                window.Alpine.store('modal', {
                    modalBuku: true,
                });
            }


            $(document).ready(function() {
                $('#modalBuku').on('submit', function(e) {
                    e.preventDefault();

                    let form = $(this);
                    let formData = new FormData(this);
                    let submitButton = form.find('button[type="submit"]');

                    submitButton.prop('disabled', true).text('Processing...');

                    $.ajax({
                        url: form.attr('action'),
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (!response.success) {
                                Swal.fire({
                                    title: 'Warning!',
                                    text: response.message || 'Something went wrong.',
                                    icon: 'warning',
                                    confirmButtonText: 'OK',
                                    showConfirmButton: true
                                });
                                return;
                            }

                            Swal.fire({
                                title: 'Success!',
                                text: 'User berhasil ditambahkan!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            })
                            $('#modal-modalmodalBuku-dialog').removeClass("visible");
                            $('#modal-modalmodalBuku-dialog').addClass("invisible");

                            window.location.reload(); // Reset form setelah sukses
                        },
                        error: function(xhr) {
                            let errorText = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                            if (xhr.responseJSON?.errors) {
                                errorText = Object.values(xhr.responseJSON.errors).flat().join(
                                    '\n');
                            }
                            Swal.fire({
                                title: 'Error!',
                                text: errorText,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            });
                        },
                        complete: function() {
                            submitButton.prop('disabled', false).text('Submit');
                        }
                    });
                });


                // Event saat modal tertutup, reset form
                $('#modalBuku').on('hidden.bs.modal', function() {
                    $('#modalBuku')[0].reset(); // Reset form setelah modal ditutup
                });
            });


            $(document).ready(function() {
                $("[id^=pinjamSekarang-]").on("click", function(e) {
                    e.preventDefault();

                    let bukuId = $(this).data("buku-id");
                    let buttonEl = $(this);

                    // Cek stok buku sebelum meminjam
                    $.get(`/dashboard/cek-stok/${bukuId}`, function(data) {
                        if (data.stok > 0) {
                            // Jika stok tersedia, lakukan peminjaman
                            $.ajax({
                                url: `/dashboard/pinjam-buku/${bukuId}`,
                                type: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                                },
                                data: {
                                    buku_id: bukuId
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Berhasil!",
                                            text: "Buku berhasil dipinjam!",
                                        }).then(() => {
                                            location
                                                .reload(); // Reload halaman setelah peminjaman berhasil
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Gagal!",
                                            text: response.message,
                                        });
                                    }
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Terjadi Kesalahan!",
                                        text: "Coba lagi nanti.",
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: "Stok Habis!",
                                text: "Buku ini sedang tidak tersedia.",
                            });
                        }
                    });
                });
            });

            function toggleStatus(id) {
                fetch(`{{ route('buku-toggleStatus', ':id') }}`.replace(':id', id), {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        let message = data.status === "Aktif" ? "Buku berhasil diaktifkan!" :
                            "Buku berhasil dinonaktifkan!";

                        toastr.success(message); // Gunakan toastr.success, bukan toast.success
                        setTimeout(() => location.reload(), 2000);
                    })
                    .catch(error => {
                        toastr.error("Terjadi kesalahan saat mengubah status buku");
                        console.error("Error:", error);
                    });
            }

            setTimeout(() => {
                let flashMessage = document.getElementById("flash-message");
                if (flashMessage) {
                    flashMessage.style.opacity = "0";
                    setTimeout(() => flashMessage.remove(), 500);
                }
            }, 3000);
        </script>
    </x-slot>
</x-app-layout>
