<x-app-layout title="{{ __('User Management') }}">
    <x-header value="{{ __('User Management') }}" />

    <x-slot name="styles">
        <style>
            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 11px;
            }

            .dataTables_length select {
                width: 60px;
            }
        </style>
    </x-slot>

    <x-card>
        <div class="">
            <a href="">Tambah</a>
        </div>
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
                <!-- Data will be populated by DataTables -->
            </tbody>
        </table>
    </x-card>

    <div x-data="{ modalUser: false }" x-init="$store.modal = { modalUser: modalUser }">
        <x-slot name="modals">
            <form id="editUser">
                <x-modal modal="$store.modal.modalUser" dialog="modal-modalUser-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Edit Role User')" />
                            <div class="my-2">
                                <input type="hidden" name="id">
                                <input type="text" class="w-full p-2 mb-2 border border-black rounded" disabled
                                    name="name" value="{{ old('name') }}" placeholder="Enter Name" />
                                <select name="role_id" class="w-full p-2 border border-black rounded">
                                    @foreach ($roles as $r)
                                        <option value="{{ $r->id }}">
                                            {{ $r->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button x-on:click="$store.modal.modalUser = false" type="button"
                            id="button-modalUser-close"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500"
                            :label="__('Batal')">{{ __('Batal') }}</x-modal-button>
                        <x-modal-button x-on:click="$store.modal.modalUser = false" type="submit"
                            id="button-modalUser-close"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500"
                            :label="__('Simpan')">{{ __('Simpan') }}</x-modal-button>
                    </div>
                </x-modal>
            </form>
        </x-slot>
    </div>

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
                    columnDefs: [{
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
                });
            });

            // Edit User function
            $('#editUser').on('submit', function(event) {
                event.preventDefault();

                let id = $("input[name='id']").val();
                let name = $("input[name='name']").val();
                let role_id = $("select[name='role_id']").val();

                $.ajax({
                    url: `${window.location.origin}/dashboard/rolesupdate/${id}`,
                    type: 'PATCH',
                    data: {
                        id: id,
                        name: name,
                        role_id: role_id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === true) {
                            // Show SweetAlert notification
                            Swal.fire({
                                title: 'Success!',
                                text: 'User role has been updated.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload the table after the success message
                                    window.location.reload(); // Reload table data
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error updating the user role.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                });
            });


            // Open modal for editing user
            function editUser(id) {
                $('#modal-modalUser-dialog').removeClass("invisible");
                $('#modal-modalUser-dialog').addClass("visible");

                $.ajax({
                    url: `/dashboard/get-user/${id}`,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.data) {
                            $("input[name='name']").val(response.data.name);
                            $("input[name='id']").val(response.data.id);
                            $("select[name='role_id']").val(response.data.roles[0].id);
                        }
                    }
                });

                window.Alpine.store('modal', {
                    modalUser: true,
                });
            }

            // Confirm delete user
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
                            url: `${window.location.origin}/dashboard/delete-user/${id}`,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                window.Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload(true); // Reload page without cache
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
