<x-app-layout title="{{ __('Daftar Kategori') }}">
    <x-header value="{{ __('Daftar Kategori') }}" />
    <x-session-status />

    <x-slot name="styles">
        <style>
            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 11px;
                /* Menambahkan jarak di bawah elemen pencarian */
            }

            .dataTables_length select {
                width: 60px;
                /* Atur lebar sesuai kebutuhan */
            }
        </style>
    </x-slot>

    @role('admin')
        <a href="{{ route('kategori.create') }}"
            class="inline-flex items-center px-4 py-2 mb-3 text-white bg-blue-500 rounded-md hover:bg-blue-600">
            Tambah Kategori
        </a>
    @endrole

    <div class="col-lg-auto">
        <div class="mb-4 bg-white rounded-lg shadow-md">
            <div class="p-3 overflow-x-auto">
                <table id="dataTableHover" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">
                                No.</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">
                                Nama Kategori</th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">
                                Tombol Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($kategori as $key => $item)
                            <tr>
                                <th scope="row" class="px-6 py-4 whitespace-nowrap">{{ $key + 1 }}</th>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @role('peminjam')
                                        <div class="flex space-x-2">
                                            <a href="{{ route('kategori.show', $item->id) }}"
                                                class="inline-flex items-center px-3 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                        </div>
                                    @endrole
                                    @role('admin')
                                        <div class="flex space-x-2">
                                            <a href="{{ route('kategori.show', $item->id) }}"
                                                class="inline-flex items-center px-3 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <a href="{{ route('kategori.edit', $item->id) }}"
                                                class="inline-flex items-center px-3 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button
                                                class="inline-flex items-center px-3 py-2 text-white bg-red-500 rounded-md hover:bg-red-600"
                                                data-toggle="modal" data-target="#DeleteModal{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            new DataTable('#dataTableHover');

            function confirmDelete(id) {
                window.swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "delete",
                            url: `${window.location.origin}/kategori/capaian_pembelajaran/delete/${id}`,
                            success: function(response) {
                                if (response.status == 'success') {
                                    window.swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });
                                    window.location.reload();
                                }
                            }
                        })

                    }
                });
            }
        </script>
    </x-slot>

</x-app-layout>
