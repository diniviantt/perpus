<x-app-layout title="{{ __('Daftar Kategori') }}">
    {{-- <x-header value="{{ __('Daftar Kategori') }}" /> --}}
    <x-session-status />

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

    @role('admin')
        <div class="flex mb-3">
            <a href="javascript:void(0)" onclick="AddKategori()" x-data="{ show: false }" @mouseover="show = true"
                @mouseleave="show = false"
                class="relative flex items-center justify-center p-3 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <i class="fa-solid fa-plus"></i>

                <!-- Tooltip -->
                <span x-show="show"
                    class="absolute px-3 py-1 text-xs text-white -translate-x-1/2 bg-gray-800 rounded-md shadow-lg -bottom-10 left-1/2 whitespace-nowrap">
                    Tambah Kategori
                </span>
            </a>
        </div>
    @endrole

    <div class="col-lg-auto">
        <div class="mb-4 bg-white rounded-lg shadow-md">
            <div class="px-4 py-3 border-b">
                <h2 class="text-lg font-semibold">{{ __('Daftar Kategori') }}</h2>
            </div>
            <div class="p-3 overflow-x-auto">
                <table id="TabelKategori" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function confirmDelete(id) {
                window.Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.Swal.fire({
                            title: "Menghapus...",
                            text: "Harap tunggu sebentar.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                window.Swal.showLoading();
                            }
                        });

                        $.ajax({
                            type: "DELETE",
                            url: `${window.location.origin}/dashboard/kategori/${id}`,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                console.log("Success Response:", response);

                                window.Swal.fire({
                                    title: "Berhasil!",
                                    text: response.message,
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload(true);
                                });
                            },
                            error: function(xhr) {
                                console.log("Error Response:", xhr.responseText);

                                window.Swal.fire({
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan saat menghapus data!",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            }


            function EditKategori(id) {
                $('#modal-modalUser-dialog').removeClass("invisible");
                $('#modal-modalUser-dialog').addClass("visible");

                $.ajax({
                    url: `/dashboard/kategori/${id}`,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (!response || !response.nama) {
                            Swal.fire('Error!', 'Kategori tidak ditemukan.', 'error');
                            return;
                        }

                        // Set ID kategori ke dalam input hidden
                        $("#kategori_id").val(id);
                        $("input[name='nama']").val(response.nama);
                        $("input[name='deskripsi']").val(response.deskripsi || "");

                        // Tampilkan modal
                        window.Alpine.store('modal', {
                            modalUser: true
                        });
                    },
                    error: function(xhr) {
                        console.error("Error mengambil data:", xhr.responseText);
                        Swal.fire('Error!', 'Gagal mengambil data kategori.', 'error');
                    }
                });
            }

            $('#editKategori').on('submit', function(event) {
                event.preventDefault();

                let id = $("input[name='id']").val(); // Pastikan ID diambil dengan benar
                if (!id) {
                    Swal.fire('Error', 'ID kategori tidak ditemukan.', 'error');
                    return;
                }

                let nama = $("input[name='nama']").val();
                let deskripsi = $("input[name='deskripsi']").val();
                let token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/dashboard/kategori/${id}`, // Pastikan ID dimasukkan ke URL
                    type: 'POST', // Ubah ke POST agar bisa override dengan _method
                    data: {
                        _method: 'PATCH', // Laravel akan membaca ini sebagai PATCH
                        nama: nama,
                        deskripsi: deskripsi,
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memperbarui kategori.',
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                });
            });


            function AddKategori() {
                $('#modal-modalAddUser-dialog').removeClass("invisible");
                $('#modal-modalAddUser-dialog').addClass("visible");

                $("input[name='nama']").val('');
                $("input[name='deskripsi']").val('');
                window.Alpine.store('modal', {
                    modalAddUser: true,
                });
            }


            $(document).ready(function() {
                $('#AddKategori').on('submit', function(e) {
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

                            window.location.reload();
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

            $(document).ready(function() {
                $('#TabelKategori').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('tabel-kategori') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'deskripsi',
                            name: 'deskripsi'
                        },
                        {
                            data: 'option',
                            name: 'option',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    </x-slot>

    <div x-data="{ modalUser: false }" x-init="$store.modal = { modalUser: modalUser }">
        <x-slot name="modals">
            <!-- Modal Edit User -->
            <form id="editKategori" method="POST">
                @method('PATCH')
                @csrf
                <x-modal modal="$store.modal.modalUser" dialog="modal-modalUser-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Edit Kategori')" />
                            <div class="my-2">
                                <div>
                                    <input type="hidden" name="id" id="kategori_id">
                                    <x-input-label for="nama" :text="__('Nama')" />
                                    <x-text-input name="nama" id="nama" class="mt-1" :value="old('nama')"
                                        required />
                                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="deskripsi" :text="__('Deskripsi')" />
                                    <x-text-input name="deskripsi" id="deskripsi" class="mt-1" :value="old('deskripsi')"
                                        required />
                                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                                </div>
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


            <form id="AddKategori" action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
                @csrf
                <x-modal modal="$store.modal.modalAddUser" dialog="modal-modalAddUser-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Tambah Kategori')" />
                            <div class="my-2 space-y-3">
                                <!-- Form fields -->
                                <div>
                                    <x-input-label for="nama" :text="__('Nama')" />
                                    <x-text-input name="nama" id="nama" class="mt-1" :value="old('nama')"
                                        required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="deskripsi" :text="__('Deskripsi')" />
                                    <x-text-input type="textarea" name="deskripsi" id="deskripsi" class="mt-1"
                                        :value="old('deskripsi')" required />
                                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
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

        </x-slot>
    </div>
</x-app-layout>
