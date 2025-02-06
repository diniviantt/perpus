<x-app-layout title="{{ __('User  Management') }}">
    <x-header value="{{ __('User  Management') }}" />

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
    <x-card>
        <table id="userManage" class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                    <th class="px-6 py-3 text-left border border-gray-300">No</th>
                    <th class="px-6 py-3 text-left border border-gray-300">Name</th>
                    <th class="px-6 py-3 text-left border border-gray-300">Email</th>
                    <th class="px-6 py-3 text-left border border-gray-300">Role</th>
                    <th class="px-6 py-3 text-left border border-gray-300">Option</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </x-card>

    <x-slot name="scripts">
        <script>
            $(function() {
                let tableUser = $('#userManage').DataTable({
                    ordering: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        'url': '{{ route('dashboard.table') }}',
                    },
                    columDefs: [{
                        targets: [4],
                        className: 'relative',
                    }],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'No',
                            width: '10px',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'role',
                            name: 'role',
                        },
                        {
                            data: 'option',
                            name: 'option',
                            orderable: false,
                            searchable: false

                        }
                    ],

                })
            })



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
                            type: "DELETE", // Pastikan metode adalah DELETE
                            url: `${window.location.origin}/delete-user/${id}`, // Perbarui URL
                            success: function(response) {
                                if (response.status == 'success') {
                                    window.swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });
                                    window.location.reload();
                                }
                            },
                            error: function(xhr) {
                                // Tangani kesalahan jika diperlukan
                                window.swal.fire({
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
