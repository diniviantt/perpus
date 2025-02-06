<x-app-layout title="{{ __('Dashboard') }}">
    <x-header value="{{ __('Dashboard') }}" />

    {{-- Session Status --}}
    <x-session-status />

    <x-slot name="styles">
        <style>
            /* Container grid adjustments for responsiveness */
            .grid-cols-4 {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            /* Card hover effects for a smooth interaction */
            .rounded-lg {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s;
            }

            .rounded-lg:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12), 0 6px 6px rgba(0, 0, 0, 0.10);
            }

            /* Card icon container styling */
            .card-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 3rem;
                width: 3rem;
                border-radius: 50%;
            }

            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 11px;
                /* Menambahkan jarak di bawah elemen pencarian */
            }

            .dataTables_length select {
                width: 60px;
                /* Atur lebar sesuai kebutuhan */
            }

            /* Table styling for better readability */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                text-align: left;
                padding: 12px;
                border-bottom: 1px solid #e2e8f0;
            }

            th {
                background-color: #f9fafb;
                font-weight: bold;
                text-transform: uppercase;
                color: #4b5563;
            }

            tbody tr:hover {
                background-color: #f1f5f9;
            }

            /* Responsive table adjustments */
            @media (max-width: 768px) {
                thead {
                    display: none;
                }

                tbody tr {
                    display: block;
                    margin-bottom: 1rem;
                    border-bottom: 2px solid #e2e8f0;
                }

                tbody td {
                    display: flex;
                    justify-content: space-between;
                    padding: 10px;
                    border-bottom: 1px solid #e2e8f0;
                }

                tbody td:before {
                    content: attr(data-label);
                    font-weight: bold;
                    color: #6b7280;
                }
            }
        </style>
    </x-slot>

    <x-card>
        {{ __("You're logged in!") }}
    </x-card>

    @role('admin')
        <div class="grid justify-between w-full grid-cols-1 my-5 md:grid-cols-4 gap-x-5">

            <!-- Card for Jumlah Buku -->
            <a href="#"
                class="max-w-xs p-5 bg-white border-r-4 border-[#d01818] rounded-lg shadow hover:shadow-lg transition-all duration-100">
                <div class="flex w-full gap-4">
                    <div class="card-icon bg-[#d01818] text-white">
                        <i class="fa-solid fa-user-group py-3 p-3.5 text-sm"></i>
                    </div>
                    <div class="grid -space-y-1">
                        <p class="text-base font-bold">{{ $buku }}</p>
                        <p class="text-sm font-normal">Jumlah Buku</p>
                    </div>
                </div>
            </a>

            <!-- Card for Kategori -->
            <a href="#"
                class="max-w-xs p-5 bg-[#ffffff] border-r-4 border-[#f3d842] rounded-lg shadow hover:shadow-lg transition-all duration-100">
                <div class="flex w-full gap-4">
                    <div class="card-icon bg-[#f3d842] text-white">
                        <i class="px-4 py-3 text-sm fa-solid fa-pencil"></i>
                    </div>
                    <div class="grid -space-y-1">
                        <p class="text-base font-bold">{{ $kategori }}</p>
                        <p class="text-sm font-normal">Kategori</p>
                    </div>
                </div>
            </a>

            <!-- Card for Anggota -->
            <a href="#"
                class="max-w-xs p-5 bg-[#ffffff] border-r-4 border-[#4dd658] rounded-lg shadow hover:shadow-lg transition-all duration-100">
                <div class="flex w-full gap-4">
                    <div class="card-icon bg-[#4dd658] text-white">
                        <i class="px-4 py-3 text-sm fa-solid fa-user-group"></i>
                    </div>
                    <div class="grid -space-y-1">
                        <p class="text-base font-bold">{{ $user }}</p>
                        <p class="text-sm font-normal">Anggota</p>
                    </div>
                </div>
            </a>

            <!-- Card for Riwayat Peminjaman -->
            <a href="#"
                class="max-w-xs p-5 bg-[#ffffff] border-r-4 border-[#39859f] rounded-lg shadow hover:shadow-lg transition-all duration-100">
                <div class="flex w-full gap-4">
                    <div class="card-icon bg-[#39859f] text-white">
                        <i class="px-4 py-3 text-sm fa-solid fa-chart-line"></i>
                    </div>
                    <div class="grid -space-y-1">
                        <p class="text-base font-bold">{{ $jumlah_riwayat }}</p>
                        <p class="text-sm font-normal">Riwayat Peminjaman</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Riwayat Peminjaman Section -->
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
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($riwayat_pinjam as $item)
                            <tr class="hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4">{{ $loop->iteration }}</th>
                                <td class="px-6 py-4">{{ $item->user->name }}</td>
                                <td class="px-6 py-4">{{ $item->buku->judul }}</td>
                                <td class="px-6 py-4">{{ $item->buku->kode_buku }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pinjam }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_wajib_kembali }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pengembalian }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pengembalian }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center">Belum ada riwayat peminjaman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    @endrole

    @role('user')
        {{-- Add content for the user role here or remove the block if unnecessary --}}
    @endrole

    <x-slot name="scripts">
        <script>
            new DataTable('#dataTableHover');
        </script>
    </x-slot>
</x-app-layout>
