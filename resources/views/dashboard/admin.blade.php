<x-app-layout title="{{ __('User Management') }}">
    <x-header value="{{ __('User Management') }}" />

    <x-slot name="styles">
        <style>
            /* .dataTables_wrapper .dataTables_filter {
                margin-bottom: 11px;
            }

            .dataTables_length select {
                width: 60px;
            } */
        </style>
    </x-slot>

    <x-card>
        <div class="relative inline-flex mb-3 border border-gray-500 rounded-md" role="group">
            <!-- Tombol Tambah Data -->
            <div class="relative w-full group">
                <a href="javascript:void(0);" onclick="addUser()"
                    class="flex items-center justify-center w-full h-full gap-2 px-4 py-2 text-sm font-normal text-gray-400 transition duration-300 ease-in-out bg-transparent border-r border-gray-600 ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                        <path
                            d="M21.5,2H12.118L8.118,0H2.5C1.122,0,0,1.122,0,2.5V22H10.298c-.2-.32-.381-.653-.538-1H1V7H23v4.026c.36,.306,.695,.641,1,1.003V4.5c0-1.378-1.121-2.5-2.5-2.5ZM1,6V2.5c0-.827,.673-1.5,1.5-1.5H7.882l4,2h9.618c.827,0,1.5,.673,1.5,1.5v1.5H1Zm16.5,5c-3.584,0-6.5,2.916-6.5,6.5s2.916,6.5,6.5,6.5,6.5-2.916,6.5-6.5-2.916-6.5-6.5-6.5Zm0,12c-3.032,0-5.5-2.468-5.5-5.5s2.468-5.5,5.5-5.5,5.5,2.468,5.5,5.5-2.468,5.5-5.5,5.5Zm.5-6h2.5v1h-2.5v2.5h-1v-2.5h-2.5v-1h2.5v-2.5h1v2.5Z" />
                    </svg>
                </a>
                <span
                    class="absolute top-0 px-3 py-2 text-xs text-white transition-opacity duration-300 -translate-x-1/2 -translate-y-full rounded-md opacity-0 pointer-events-none bg-gray-800/40 left-1/2 whitespace-nowrap group-hover:opacity-100">
                    Tambah Data
                </span>
            </div>

            <!-- Tombol Import Data -->
            <div class="relative w-full border-r border-gray-600 group">
                <a href="javascript:void(0);" onclick="importData()"
                    class="flex items-center justify-center w-full h-full gap-2 px-4 py-2 text-sm font-normal text-gray-400 transition duration-300 ease-in-out bg-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                        <path
                            d="M17.5,11c-3.58,0-6.5,2.92-6.5,6.5s2.92,6.5,6.5,6.5,6.5-2.92,6.5-6.5-2.92-6.5-6.5-6.5Zm0,12c-3.03,0-5.5-2.47-5.5-5.5s2.47-5.5,5.5-5.5,5.5,2.47,5.5,5.5-2.47,5.5-5.5,5.5Zm3.06-6.56c.58,.58,.58,1.54,0,2.12l-2.17,2.17-.71-.71,2.02-2.02h-5.71v-1h5.71l-1.94-1.94,.71-.71,2.09,2.09Zm-9.01-5.01c-.24,.24-.47,.49-.69,.76-.26-.12-.55-.19-.86-.19-1.1,0-2,.9-2,2,0,.81,.48,1.5,1.17,1.82-.07,.33-.11,.67-.14,1.02-1.18-.41-2.03-1.52-2.03-2.84,0-1.65,1.35-3,3-3,.57,0,1.1,.16,1.55,.43ZM1,20V3C1,1.9,1.9,1,3,1h1v7H15V1h.42l4.58,4.58v3.8c.34,.11,.68,.23,1,.38V5.16L15.83,0H3C1.35,0,0,1.35,0,3V21H9.75c-.15-.32-.27-.66-.38-1H1ZM14,7H5V1H14V7Z" />
                    </svg>
                </a>
                <span
                    class="absolute top-0 px-3 py-2 text-xs text-white transition-opacity duration-300 -translate-x-1/2 -translate-y-full rounded-md opacity-0 pointer-events-none bg-gray-800/40 left-1/2 whitespace-nowrap group-hover:opacity-100">
                    Import Data
                </span>
            </div>

            <!-- Tombol Unduh Data -->
            <div class="relative w-full rounded-md group">
                <a href="{{ route('tempt-export') }}"
                    class="flex items-center justify-center w-full h-full gap-2 px-4 py-2 text-sm font-normal text-gray-400 transition duration-300 ease-in-out bg-transparent rounded-r-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M14,2V11H19L12,18L5,11H10V2H14M2,20H22V22H2V20Z" />
                    </svg>
                </a>
                <span
                    class="absolute top-0 px-3 py-2 text-xs text-white transition-opacity duration-300 -translate-x-1/2 -translate-y-full rounded-md opacity-0 pointer-events-none bg-gray-800/40 left-1/2 whitespace-nowrap group-hover:opacity-100">
                    Unduh Template
                </span>
            </div>
        </div>

        <table id="userManage" class="min-w-full">
            <thead class="">
                <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                    <th class="px-6 py-3 border border-gray-300">No</th>
                    <th class="px-6 py-3 border border-gray-300">Name</th>
                    <th class="px-6 py-3 border border-gray-300">Email</th>
                    <th class="px-6 py-3 border border-gray-300">Role</th>
                    <th class="px-6 py-3 border border-gray-300">Option</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated by DataTables -->
            </tbody>
        </table>
    </x-card>

    <div x-data="{ modalUser: false, modalAddUser: false, modalUpload: false }" x-init="$store.modal = { modalUser: modalUser, modalAddUser: modalAddUser, modalUpload: modalUpload }">
        <x-slot name="modals">
            <!-- Modal Edit User -->
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
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button x-on:click="$store.modal.modalUser = false" type="button"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Batal') }}
                        </x-modal-button>
                        <x-modal-button x-on:click="$store.modal.modalUser = false" type="submit"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Simpan') }}
                        </x-modal-button>
                    </div>
                </x-modal>
            </form>

            <!-- Modal Tambah User -->
            <form id="AddUser" action="{{ route('add-user') }}" method="POST" class="space-y-4">
                @csrf
                <x-modal modal="$store.modal.modalAddUser" dialog="modal-modalAddUser-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Tambah Anggota')" />
                            <div class="my-2 space-y-3">
                                <!-- Form fields -->
                                <div>
                                    <x-input-label for="name" :text="__('Nama')" />
                                    <x-text-input name="name" id="name" class="mt-1" :value="old('name')"
                                        required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="email" :text="__('Email')" />
                                    <x-text-input type="email" name="email" id="email" class="mt-1"
                                        :value="old('email')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password" :text="__('Password')" />
                                    <x-text-input type="password" name="password" id="password" class="mt-1"
                                        required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :text="__('Konfirmasi Password')" />
                                    <x-text-input type="password" name="password_confirmation"
                                        id="password_confirmation" class="mt-1" required />
                                </div>

                                <div>
                                    <x-input-label for="role_id" :text="__('Role')" />
                                    <select
                                        class="block w-full px-4 py-3 mt-1 text-sm text-indigo-700 truncate transition-all duration-300 ease-in-out bg-white border border-gray-400 rounded-lg shrink focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500 placeholder:text-sm placeholder:text-slate-300"
                                        name="role_id" id="role_id">
                                        <option value="Pilih Role">Pilih Role</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button type="submit"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Simpan') }}
                        </x-modal-button>

                        <x-modal-button x-on:click="$store.modal.modalAddUser = false" type="button"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Batal') }}
                        </x-modal-button>
                    </div>
                </x-modal>
            </form>

            <form id="UploadUser" action="{{ route('import-user') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <x-modal modal="$store.modal.modalUpload" dialog="modal-modalUpload-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Upload Data User')" />
                            <div class="my-2 space-y-3">
                                <div>
                                    <span
                                        class="block px-3 py-2 text-sm font-medium text-red-700 bg-red-100 border border-red-400 rounded-lg">
                                        Pastikan sudah mengunduh file!
                                        <a href="{{ route('tempt-export') }}" class="text-blue-700 underline">Unduh
                                            Template</a>
                                    </span>

                                    <input type="file" name="import" id="file" autocomplete="off"
                                        class="block w-full px-4 py-3 mt-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-500/30 focus:border-indigo-500 placeholder:text-gray-400"
                                        required />
                                    <p id="file-name" class="mt-2 text-sm text-gray-600"></p>

                                    <x-input-error :messages="$errors->get('import')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button type="submit"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Upload') }}
                        </x-modal-button>

                        <x-modal-button x-on:click="$store.modal.modalUpload = false" type="button"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Batal') }}
                        </x-modal-button>
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
                    headerCallback: function(thead) {
                        $(thead).find('th').each(function() {
                            $(this).addClass('text-center');
                        });
                    },
                    columnDefs: [{
                            targets: [4],
                            className: 'relative',
                        },
                        {
                            targets: [0, 1, 2, 3, 4],
                            className: 'text-center',
                        }
                    ],
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


            function addUser() {
                $('#modal-modalAddUser-dialog').removeClass("invisible");
                $('#modal-modalAddUser-dialog').addClass("visible");

                $("input[name='name']").val('');
                $("input[name='email']").val('');
                $("input[name='password']").val('');
                $("input[name='password_confirmation']").val('');
                $("input[name='role_id']").val('');

                window.Alpine.store('modal', {
                    modalAddUser: true,
                });
            }


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

            $(document).ready(function() {
                $('#AddUser').on('submit', function(e) {
                    e.preventDefault();

                    let form = $(this);
                    let formData = new FormData(this);
                    let submitButton = form.find('button[type="submit"]');

                    submitButton.prop('disabled', true).text('Processing...');

                    $.ajax({
                        url: form.attr('action'),
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (!response.success) {
                                Swal.fire({
                                    title: 'Warning!',
                                    text: response.message || 'Something went wrong.',
                                    icon: 'warning',
                                    confirmButtonText: 'OK',
                                    showConfirmButton: true
                                });
                                return;
                            }

                            Swal.fire({
                                title: 'Success!',
                                text: 'User berhasil ditambahkan!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            })
                            $('#modal-modalAddUser-dialog').removeClass("visible");
                            $('#modal-modalAddUser-dialog').addClass("invisible");

                            $('#userManage').DataTable().ajax.reload(null,
                                false); // Refresh DataTable
                            form[0].reset(); // Reset form setelah sukses
                        },
                        error: function(xhr) {
                            let errorText = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                            if (xhr.responseJSON?.errors) {
                                errorText = Object.values(xhr.responseJSON.errors).flat().join(
                                    '\n');
                            }
                            Swal.fire({
                                title: 'Error!',
                                text: errorText,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            });
                        },
                        complete: function() {
                            submitButton.prop('disabled', false).text('Submit');
                        }
                    });
                });


                // Event saat modal tertutup, reset form
                $('#AddUser').on('hidden.bs.modal', function() {
                    $('#AddUser')[0].reset(); // Reset form setelah modal ditutup
                });
            });


            // Open modal for adding user
            function AddUser() {
                $('#modal-modalAddUser-dialog').removeClass("invisible");
                $('#modal-modalAddUser-dialog').addClass("visible");

                // Kosongkan input form sebelum ditampilkan
                $("input[name='name']").val('');
                $("input[name='email']").val('');
                $("input[name='password']").val('');
                $("input[name='password_confirmation']").val('');
                $("input[name='role_id']").val('');

                window.Alpine.store('modal', {
                    modalUser: true,
                });
            }

            $.get("{{ route('get-roles') }}", function(roles) {
                let roleSelect = $("#role_id");
                roles.forEach(role => {
                    roleSelect.append(`<option value="${role.id}">${role.name}</option>`);
                });
            });

            function importData() {
                $('#modal-modalUpload-dialog').removeClass("invisible");
                $('#modal-modalUpload-dialog').addClass("visible");

                window.Alpine.store('modal', {
                    modalUpload: true,
                });
            }
            $(document).ready(function() {
                $("#file").change(function() {
                    let fileName = $(this).val().split("\\").pop();
                    $("#file-name").text("File dipilih: " + fileName);
                });

                $("#UploadUser").submit(function(e) {
                    e.preventDefault(); // Mencegah form submit langsung

                    let fileInput = $("#file")[0].files[0];
                    let submitButton = $(this).find("[type='submit']");

                    if (!fileInput) {
                        Swal.fire("Error!", "Silakan pilih file sebelum mengupload!", "error");
                        return;
                    }

                    let allowedExtensions = /(\.xlsx|\.xls)$/i;
                    if (!allowedExtensions.exec(fileInput.name)) {
                        Swal.fire("Error!",
                            "Format file tidak valid! Hanya file .xlsx atau .xls yang diperbolehkan.",
                            "error");
                        return;
                    }

                    submitButton.prop("disabled", true).text("Uploading...");

                    let formData = new FormData($("#UploadUser")[0]);

                    $.ajax({
                        url: $("#UploadUser").attr("action"),
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reset input file & form setelah klik OK
                                    $("#file").val("");
                                    $("#file-name").text("");
                                    $("#UploadUser")[0].reset();

                                    // Aktifkan kembali tombol upload
                                    submitButton.prop("disabled", false).text("Upload");

                                    // Tutup modal
                                    $('#modal-modalUpload-dialog').removeClass("visible");
                                    $('#modal-modalUpload-dialog').addClass("invisible");

                                    $('#userManage').DataTable().ajax.reload(null,
                                        false);
                                }
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = "Terjadi kesalahan saat mengupload data.";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire("Error!", errorMessage, "error");

                            // Aktifkan kembali tombol upload
                            submitButton.prop("disabled", false).text("Upload");
                        }
                    });
                });
            });



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
