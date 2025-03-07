<x-app-layout title="{{ __('Daftar Anggota') }}">
    <x-header value="{{ __('Daftar Anggota') }}" />
    <x-session-status />

    <a href="{{ route('anggota.create') }}" class="px-4 py-2 mb-3 text-white bg-blue-500 rounded">Tambah Anggota</a>

    <div class="w-full mt-5">
        <div class="mb-4 bg-white rounded-lg shadow-md">
            <div class="px-4 py-3 border-b">
                <h2 class="text-lg font-semibold">{{ __('Daftar Anggota') }}</h2>
            </div>
            <div class="p-3 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="dataTableHover">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                No.</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Nama Anggota</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Email</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tombol Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($user as $key => $item)
                            <tr>
                                <th scope="row" class="px-6 py-4 whitespace-nowrap">{{ $key + 1 }}</th>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @role('admin')
                                        <div class="flex space-x-2">
                                            <a href="{{ route('anggota.show', $item->id) }}"
                                                class="px-3 py-1 text-white bg-blue-500 rounded">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <a href="{{ route('anggota.edit', $item->id) }}"
                                                class="px-3 py-1 text-white bg-yellow-500 rounded">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button class="px-3 py-1 text-white bg-red-500 rounded" data-toggle="modal"
                                                data-target="#DeleteModal{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </div>
                                    @endrole

                                    @role('peminjam')
                                        <a href="{{ route('kategori.show', $item->id) }}"
                                            class="px-3 py-1 text-white bg-blue-500 rounded">Detail</a>
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada anggota
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
