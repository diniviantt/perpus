<x-app-layout title="{{ __('Tambah Kategori') }}">
    <x-header value="{{ __('Tambah Kategori') }}" />
    <x-session-status />

    <div class="p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('kategori.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input name="nama" type="text"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    id="nama" placeholder="Masukkan nama kategori" required>
                @error('nama')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    name="deskripsi" id="deskripsi" rows="3" placeholder="Masukkan deskripsi"></textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('kategori.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Tambah
                </button>
            </div>
        </form>
    </div>


    <x-slot name = "scripts">
        <script>
            function confirmDelete(id) {
                window.Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.Swal.fire({
                            title: "Deleting...",
                            text: "Please wait while we delete the data.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                window.Swal.showLoading();
                            }
                        });

                        $.ajax({
                            type: "DELETE",
                            url: `${window.location.origin}/dashboard/delete-/${id}`,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content")
                            },
                            success: function(response) {
                                window.Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload(
                                        true); // Reload page without cache
                                });
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                                window.Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while deleting the record.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
