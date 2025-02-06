<x-app-layout title="{{ __('Daftar Anggota') }}">
    <x-header value="{{ __('Daftar Anggota') }}" />
    <x-session-status />

    <a href="{{ route('anggota.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-3">Tambah Anggota</a>

    <div class="w-full mt-5">
        <div class="bg-white shadow-md rounded-lg mb-4">
            <div class="py-3 px-4 border-b">
                <h2 class="text-lg font-semibold">{{ __('Daftar Anggota') }}</h2>
            </div>
            <div class="overflow-x-auto p-3">
                <table class="min-w-full divide-y divide-gray-200" id="dataTableHover">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No.</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Anggota</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                                class="bg-blue-500 text-white px-3 py-1 rounded">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <a href="{{ route('anggota.edit', $item->id) }}"
                                                class="bg-yellow-500 text-white px-3 py-1 rounded">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button class="bg-red-500 text-white px-3 py-1 rounded" data-toggle="modal"
                                                data-target="#DeleteModal{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </div>
                                    @endrole

                                    @role('user')
                                        <a href="{{ route('kategori.show', $item->id) }}"
                                            class="bg-blue-500 text-white px-3 py-1 rounded">Detail</a>
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
