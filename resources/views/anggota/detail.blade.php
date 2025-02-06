<x-app-layout title="{{ __('Detail Anggota') }}">
    <x-header value="{{ __('Detail Anggota') }}" />
    <x-session-status />

    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between py-3">
            <h4 class="m-0 font-bold text-blue-500">Profile</h4>
        </div>
        <div class="flex gap-12">
            <div class="my-4 ml-5">
                @if ($user->photoProfile != null)
                    <img src="{{ asset('/images/photoProfile/' . $user->photoProfile) }}" class="rounded-full w-36 h-36">
                @else
                    <img src="{{ asset('template/img/boy.png') }}" class="w-24 h-24 rounded-full">
                @endif
            </div>
            <div class="flex-1">
                <div class="mb-3">
                    <label for="nama" class="text-lg font-bold text-blue-500">Nama Lengkap</label>
                    <h4>{{ $user->name }}</h4>
                </div>

                <div class="mb-3">
                    <label for="npm" class="text-lg font-bold text-blue-500">Email</label>
                    <h4>{{ $user->email }}</h4>
                </div>

                {{-- <div class="mb-3">
                    <label for="prodi" class="text-lg font-bold text-blue-500">Program Studi</label>
                    <h4>{{ $user->prodi }}</h4>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="text-lg font-bold text-blue-500">Alamat</label>
                    <h4>{{ $user->alamat }}</h4>
                </div>

                <div class="mb-3">
                    <label for="noTelp" class="text-lg font-bold text-blue-500">Nomor Telephone</label>
                    <h4>{{ $user->noTelp }}</h4>
                </div> --}}
            </div>
        </div>
        <div class="flex justify-end mx-4 my-4">
            <a href="{{ route('anggota.index') }}" class="px-5 py-2 text-white bg-blue-500 rounded">Kembali</a>
        </div>
    </div>
    <h2 class="my-4 text-blue-500">Daftar Riwayat Pinjaman Anggota</h2>
    <div class="lg:col-auto">
        <div class="mb-4 bg-white rounded-lg shadow-md">
            <div class="p-3 overflow-x-auto">
                <table class="min-w-full text-sm table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Judul Buku</th>
                            <th class="px-4 py-2">Kode Buku</th>
                            <th class="px-4 py-2">Tanggal Pinjam</th>
                            <th class="px-4 py-2">Tanggal Wajib Pengembalian</th>
                            <th class="px-4 py-2">Tanggal Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody>
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

</x-app-layout>
