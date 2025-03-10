<x-app-layout title="{{ __('Riwayat Peminjaman') }}">
    <x-header value="{{ __('Riwayat Peminjaman') }}" />
    <x-session-status />

    @role('admin')
        <div class="container mx-auto">
            <div class="mb-3">
                <a href="{{ route('peminjaman.create') }}"
                    class="inline-flex items-center px-4 py-2 mb-3 text-white bg-blue-600 rounded hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i> tambah
                </a>
                <a href="/cetaklaporan"
                    class="inline-flex items-center px-4 py-2 mx-2 mb-3 text-white bg-blue-600 rounded hover:bg-blue-700">
                    <i class="fa-solid fa-print"></i> Cetak
                </a>
            </div>
            <div class="lg:col-auto">
                <div class="mb-4 bg-white rounded-lg shadow-md">
                    <div class="p-3 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="dataTableHover" style="font-size: .7rem">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">No.</th>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Judul Buku</th>
                                    <th class="px-4 py-2 text-left">Kode Buku</th>
                                    <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
                                    <th class="px-4 py-2 text-left">Tanggal Wajib Pengembalian</th>
                                    <th class="px-4 py-2 text-left">Tanggal Pengembalian</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($peminjam as $item)
                                    <tr class="hover:bg-gray-100">
                                        <th class="px-4 py-2">{{ $loop->iteration }}</th>
                                        <td class="px-4 py-2">{{ $item->user->name }}</td>
                                        <td class="px-4 py-2">{{ $item->buku->judul }}</td>
                                        <td class="px-4 py-2">{{ $item->buku->kode_buku }}</td>
                                        <td class="px-4 py-2">{{ $item->tanggal_pinjam }}</td>
                                        <td class="px-4 py-2">{{ $item->tanggal_wajib_kembali }}</td>
                                        <td class="px-4 py-2">{{ $item->tanggal_pengembalian }}</td>
                                        <td class="px-4 py-2">{{ $item->tanggal_pengembalian }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-2 text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @role('peminjam')
        <div class="lg:col-auto">
            <div class="mb-4 bg-white rounded-lg shadow-md">
                <div class="p-3 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="dataTableHover" style="font-size: .7rem">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">No.</th>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">Judul Buku</th>
                                <th class="px-4 py-2 text-left">Kode Buku</th>
                                <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
                                <th class="px-4 py-2 text-left">Tanggal Wajib Pengembalian</th>
                                <th class="px-4 py-2 text-left">Tanggal Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pinjamanUser  as $item)
                                <tr class="hover:bg-gray-100">
                                    <th class="px-4 py-2">{{ $loop->iteration }}</th>
                                    <td class="px-4 py-2">{{ $item->user->name }}</td>
                                    <td class="px-4 py-2">{{ $item->buku->judul }}</td>
                                    <td class="px-4 py-2">{{ $item->buku->kode_buku }}</td>
                                    <td class="px-4 py-2">{{ $item->tanggal_pinjam }}</td>
                                    <td class="px-4 py-2">{{ $item->tanggal_wajib_kembali }}</td>
                                    <td class="px-4 py-2">{{ $item->tanggal_pengembalian }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-2 text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endrole
</x-app-layout>
