<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open"
        class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md">
        <!-- Icon Dropdown -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-7">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
        </svg>
    </button>


    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false" x-transition
        class="absolute z-[1000] mt-1 bg-white border border-gray-200 rounded-md shadow-xl min-w-32 -left-20">
        <div class="py-1">

            <a href="javascript:void(0)" onclick="updateStatus('batalkan', '{{ $model->id }}')"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="w-4 h-4 text-red-500 fas fa-times"></i> <!-- Ikon X untuk batalkan -->
                Batalkan
            </a>

            <!-- Status: Menunggu Pengambilan (Admin konfirmasi peminjaman) -->
            <a href="javascript:void(0)" onclick="updateStatus('konfirmasi', '{{ $model->id }}')"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                </svg>
                Konfirmasi
            </a>

            <!-- Status: Dipinjam (User mengambil buku) -->
            <a href="javascript:void(0)" onclick="updateStatus('ambil', '{{ $model->id }}')"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 6h14M5 12h14M5 18h14" />
                </svg>
                Buku Diambil
            </a>

            <!-- Status: Dikembalikan (User mengembalikan buku) -->
            <a href="javascript:void(0)" onclick="updateStatus('dikembalikan', '{{ $model->id }}')"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Dikembalikan
            </a>
        </div>
    </div>
</div>
