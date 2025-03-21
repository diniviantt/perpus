<x-app-layout title="{{ __('Dashboard') }}">
    <x-header value="{{ __('Dashboard') }}" />

    <x-session-status />

    <x-slot name="styles">
        <link href="https://cdn.datatables.net/2.1.2/css/dataTables.tailwindcss.min.css" rel="stylesheet" />
        <style>
            .grid-cols-4 {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .rounded-lg {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s;
            }

            .rounded-lg:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12), 0 6px 6px rgba(0, 0, 0, 0.10);
            }

            .card-container {
                display: grid;
                gap: 1rem;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }

            .card {
                padding: 1.5rem;
                background: white;
                border-radius: 0.75rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .card-icon {
                height: 3rem;
                width: 3rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                color: white;
            }
        </style>
    </x-slot>

    <x-card>
        {{ __("You're logged in!") }}
    </x-card>


    @role('peminjam')
        <div class="my-5 card-container">
            <div class="border-l-4 border-red-500 card">
                <div class="bg-red-500 card-icon">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">{{ $koleksi }}</p>
                    <p class="text-sm text-gray-600">Koleksi Buku</p>
                </div>
            </div>

            <div class="border-l-4 border-blue-500 card">
                <div class="bg-blue-500 card-icon">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">{{ $jumlah_dipinjam }}</p>
                    <p class="text-sm text-gray-600">Buku Dipinjam</p>
                </div>
            </div>

            <div class="border-l-4 border-blue-500 card">
                <div class="bg-blue-500 card-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">{{ $jumlah_peminjaman }}</p>
                    <p class="text-sm text-gray-600">Riwayat Peminjaman</p>
                </div>
            </div>
        </div>

        @if (!empty($notifikasi))
            <!-- Header Pemberitahuan -->
            <div class="w-full p-4 bg-white border border-gray-300 rounded-lg shadow-md">
                <div class="flex items-center gap-2">
                    <div class="text-xl animate-bounce">🔔</div>
                    <h2 class="text-2xl font-bold t">Pemberitahuan</h2>
                </div>
                <hr class="mt-2 border-gray-300">

                <!-- Bubble Chat Notifikasi -->
                <div class="flex flex-col w-full gap-3 mt-3">
                    @foreach ($notifikasi as $notif)
                        @php
                            // Menentukan warna latar belakang & panah
                            if (str_contains($notif['pesan'], '❗')) {
                                $bgColor = 'bg-red-100';
                                $arrowColor = 'border-r-red-100';
                            } elseif (str_contains($notif['pesan'], '⏳') || str_contains($notif['pesan'], '⚠️')) {
                                $bgColor = 'bg-yellow-100';
                                $arrowColor = 'border-r-yellow-100';
                            } else {
                                $bgColor = 'bg-green-100';
                                $arrowColor = 'border-r-green-100';
                            }
                        @endphp

                        <div class="relative flex flex-col items-start p-3 shadow-md rounded-xl {{ $bgColor }}">
                            <div
                                class="absolute -left-2 -top-1 w-0 h-0 border-t-[14px] border-t-transparent border-r-[18px] {{ $arrowColor }} border-b-[14px] border-b-transparent rotate-[26deg]">
                            </div>

                            <!-- Pesan Notifikasi -->
                            <p class="text-sm text-gray-800">{!! $notif['pesan'] !!}</p>


                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <x-card class="p-6 mt-10 bg-white rounded-lg shadow-md">
            <h1 class="mb-4 text-2xl font-extrabold">Riwayat Peminjaman</h1>
            <div class="p-3 overflow-x-auto">
                <table id="dataTableHover" class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">No.</th>
                            <th scope="col" class="px-6 py-3">Judul Buku</th>
                            <th scope="col" class="px-6 py-3">Kode Buku</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-3">Tanggal Wajib Pengembalian</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pengembalian</th>
                            <th scope="col" class="px-6 py-3">Denda</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($riwayat_pinjam as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $item->buku->judul }}</td>
                                <td class="px-6 py-4">{{ $item->buku->kode_buku }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pinjam }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_wajib_kembali }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pengembalian }}</td>
                                <td class="px-6 py-4">{{ $item->denda }}</td>
                                <td class="px-6 py-4">
                                    @if ($item->status == 'Dipinjam')
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-yellow-500 rounded-lg">
                                            <i class="fa-solid fa-clock"></i> Dipinjam
                                        </span>
                                    @elseif ($item->status == 'Dikembalikan')
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-green-500 rounded-lg">
                                            <i class="fa-solid fa-check-circle"></i> Dikembalikan
                                        </span>
                                    @elseif ($item->status == 'Menunggu Pengambilan')
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-red-500 rounded-lg">
                                            <i class="fa-solid fa-hourglass-half"></i> Menunggu Pengambilan
                                        </span>
                                    @else
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-gray-500 rounded-lg">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Menunggu Konfirmasi
                                        </span>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    @endrole



    @role('admin')
        <div class="grid grid-cols-1 gap-4 my-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
            <div class="flex items-center p-4 space-x-4 bg-white border-l-4 border-red-500 rounded-lg shadow-md">
                <div class="p-3 text-white bg-red-500 rounded-full">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">{{ $buku }}</p>
                    <p class="text-sm text-gray-600">Jumlah Buku</p>
                </div>
            </div>

            <div class="flex items-center p-4 space-x-4 bg-white border-l-4 border-yellow-400 rounded-lg shadow-md">
                <div class="p-3 text-white bg-yellow-400 rounded-full">
                    <i class="fa-solid fa-list"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">{{ $kategori }}</p>
                    <p class="text-sm text-gray-600">Kategori</p>
                </div>
            </div>

            <div class="flex items-center p-4 space-x-4 bg-white border-l-4 border-green-500 rounded-lg shadow-md">
                <div class="p-3 text-white bg-green-500 rounded-full">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">{{ $user }}</p>
                    <p class="text-sm text-gray-600">Peminjam</p>
                </div>
            </div>

            <div class="flex items-center p-4 space-x-4 bg-white border-l-4 border-blue-500 rounded-lg shadow-md">
                <div class="p-3 text-white bg-blue-500 rounded-full">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">{{ $jumlah_riwayat }}</p>
                    <p class="text-sm text-gray-600">Riwayat Peminjaman</p>
                </div>
            </div>

            <div class="flex items-center p-4 space-x-4 bg-white border-l-4 border-purple-500 rounded-lg shadow-md">
                <div class="p-3 text-white bg-purple-500 rounded-full">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <p class="text-lg font-bold">Rp {{ number_format($total_denda, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">Total Uang Denda</p>
                </div>
            </div>
        </div>


        <x-card class="p-6 bg-white rounded-lg shadow-md">
            <h1 class="mb-4 text-2xl font-extrabold">Riwayat Peminjaman</h1>
            <div class="p-3 overflow-x-auto">
                <table id="dataTableHover" class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">No.</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Judul Buku</th>
                            <th scope="col" class="px-6 py-3">Kode Buku</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-3">Tanggal Wajib Pengembalian</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pengembalian</th>
                            <th scope="col" class="px-6 py-3">Denda</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($riwayat_pinjam as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $item->user->name }}</td>
                                <td class="px-6 py-4">{{ $item->buku->judul }}</td>
                                <td class="px-6 py-4">{{ $item->buku->kode_buku }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pinjam }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_wajib_kembali }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pengembalian }}</td>
                                <td class="px-6 py-4">{{ $item->denda }}</td>
                                <td class="px-6 py-4">
                                    @if ($item->status == 'Dipinjam')
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-yellow-500 rounded-lg">
                                            <i class="fa-solid fa-clock"></i> Dipinjam
                                        </span>
                                    @elseif ($item->status == 'Dikembalikan')
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-green-500 rounded-lg">
                                            <i class="fa-solid fa-check-circle"></i> Dikembalikan
                                        </span>
                                    @elseif ($item->status == 'Menunggu Pengambilan')
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-red-500 rounded-lg">
                                            <i class="fa-solid fa-hourglass-half"></i> Menunggu Pengambilan
                                        </span>
                                    @else
                                        <span
                                            class="flex items-center gap-1 px-2 py-1 text-xs text-white bg-gray-500 rounded-lg">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Menunggu Konfirmasi
                                        </span>
                                    @endif

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    @endrole

    <x-slot name="scripts">
        <script>
            new DataTable('#dataTableHover');
        </script>
    </x-slot>

    <x-slot name="scripts">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let table = new DataTable("#dataTableHover", {
                    responsive: true,
                    autoWidth: false,
                    columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6, 7],
                        className: "text-center", // Semua kolom di tengah
                    }],
                    rowCallback: function(row, data, index) {
                        $(row).addClass("hover:bg-gray-50"); // Efek hover untuk baris
                    },
                    language: {
                        emptyTable: `<div class="text-center text-gray-500">Belum ada riwayat peminjaman</div>`
                    }
                });
            });
        </script>

    </x-slot>

</x-app-layout>
