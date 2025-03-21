<x-app-layout title="{{ __('Daftar User') }}">
    {{-- <x-header value="{{ __('Daftar User') }}" /> --}}
    <x-session-status />

    <div class="w-full mt-2">
        <div class="mb-4 bg-white rounded-lg shadow-md">
            <div class="px-4 py-3 border-b">
                <h2 class="text-lg font-semibold">{{ __('Daftar User') }}</h2>
            </div>

            <!-- Dropdown Menu -->
            <div class="flex items-center gap-3 p-3">
                <label for="dataType" class="text-sm font-normal text-gray-500 ">Pilih Data:</label>
                <select id="dataType"
                    class="px-3 py-2 text-sm transition-all bg-white border border-gray-300 rounded-lg shadow-sm appearance-none pr-9 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option class="text-sm" value="peminjam">Peminjam</option>
                    <option class="text-sm" value="petugas">Petugas</option>
                    <option class="text-sm" value="admin">Admin</option>
                </select>

            </div>



            <div class="p-3 overflow-x-auto">
                <div id="datatable-peminjam" class="table-responsive">
                    <table id="TabelPeminjam"></table>
                </div>
                <div id="datatable-petugas" class="hidden table-responsive">
                    <table id="TabelPetugas"></table>
                </div>
                <div id="datatable-admin" class="hidden table-responsive">
                    <table id="TabelAdmin"></table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(function() {
                let tabelPeminjam = $('#TabelPeminjam').DataTable({
                    ordering: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        'url': '{{ route('tabel-peminjam') }}',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'No',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            title: 'Nama Peminjam'
                        },
                        {
                            data: 'email',
                            name: 'email',
                            title: 'Email'
                        },
                        {
                            data: 'alamat',
                            name: 'alamat',
                            title: 'Alamat'
                        },
                        {
                            data: 'telepon',
                            name: 'telepon',
                            title: 'No Telepon'
                        },
                        {
                            data: 'option',
                            name: 'option',
                            title: 'Aksi',
                            orderable: false,
                            searchable: false
                        }
                    ],
                });

                let tabelPetugas = $('#TabelPetugas').DataTable({
                    ordering: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        'url': '{{ route('tabel-petugas') }}',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'No',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            title: 'Nama Petugas'
                        },
                        {
                            data: 'email',
                            name: 'email',
                            title: 'Email'
                        },
                        {
                            data: 'option',
                            name: 'option',
                            title: 'Aksi',
                            orderable: false,
                            searchable: false
                        }
                    ],
                });

                let tabelAdmin = $('#TabelAdmin').DataTable({
                    ordering: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        'url': '{{ route('tabel-admin') }}',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            title: 'No',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            title: 'Nama Admin'
                        },
                        {
                            data: 'email',
                            name: 'email',
                            title: 'Email'
                        },
                        {
                            data: 'option',
                            name: 'option',
                            title: 'Aksi',
                            orderable: false,
                            searchable: false
                        }
                    ],
                });

                $('#dataType').on('change', function() {
                    let selected = $(this).val();
                    let titleText = selected === 'peminjam' ? 'Daftar Peminjam' :
                        selected === 'petugas' ? 'Daftar Petugas' :
                        'Daftar Admin';

                    document.title = titleText; // Mengubah title halaman
                    $('h2').text(titleText); // Mengubah judul di halaman

                    $('#datatable-peminjam, #datatable-petugas, #datatable-admin').addClass('hidden');
                    if (selected === 'peminjam') {
                        $('#datatable-peminjam').removeClass('hidden');
                    } else if (selected === 'petugas') {
                        $('#datatable-petugas').removeClass('hidden');
                    } else {
                        $('#datatable-admin').removeClass('hidden');
                    }
                });
            });

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
                            url: `${window.location.origin}/dashboard/anggota/${id}`,
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


            function editAnggota(id) {
                console.log("Mengambil data anggota dengan ID:", id);

                // Tampilkan modal sebelum AJAX dipanggil agar lebih responsif
                $('#modal-modalUser-dialog').removeClass("invisible").addClass("visible");

                $.ajax({
                    url: `/dashboard/anggota/${id}`,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log("Response dari server:", response);

                        if (!response || !response.name) {
                            Swal.fire('Error!', 'Anggota tidak ditemukan.', 'error');
                            return;
                        }

                        // Set data ke form modal
                        $("#anggota_id").val(id); // Perbaiki ID yang digunakan
                        $("input[name='name']").val(response.name);
                        $("input[name='email']").val(response.email || "");

                        // Pastikan Alpine store di-set dengan benar
                        window.Alpine.store('modal', {
                            modalUser: true
                        });
                    },
                    error: function(xhr) {
                        console.error("Error mengambil data:", xhr.responseText);
                        Swal.fire('Error!', 'Gagal mengambil data anggota.', 'error');
                    }
                });
            }

            // Form Update Anggota
            $('#editAnggota').on('submit', function(event) {
                event.preventDefault();

                let id = $("#anggota_id").val(); // Ambil ID dari input hidden
                if (!id) {
                    Swal.fire('Error', 'ID anggota tidak ditemukan.', 'error');
                    return;
                }

                let name = $("input[name='name']").val();
                let email = $("input[name='email']").val();
                let token = $('meta[name="csrf-token"]').attr('content');

                console.log("Mengirim data update:", {
                    id,
                    name,
                    email
                });

                $.ajax({
                    url: `/dashboard/anggota/${id}`,
                    type: 'PATCH',
                    data: {
                        name: name,
                        email: email,
                        _token: token
                    },
                    success: function(response) {
                        console.log("Response dari update:", response);

                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        }).then(() => {
                            $('#modal-modalUser-dialog').removeClass("visible").addClass(
                                "invisible");
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memperbarui anggota.',
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                });
            });
        </script>
    </x-slot>


    <div x-data="{ modalUser: false }" x-init="$store.modal = { modalUser: modalUser }">
        <x-slot name="modals">
            <!-- Modal Edit User -->
            <form id="editAnggota" method="POST">
                @method('PATCH')
                @csrf
                <x-modal modal="$store.modal.modalUser" dialog="modal-modalUser-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Edit User')" />
                            <div class="my-2">
                                <div>
                                    <input type="hidden" name="id" id="anggota_id">
                                    <x-input-label for="name" :text="__('Nama')" />
                                    <x-text-input name="name" id="name" class="mt-1" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="email" :text="__('Email')" />
                                    <x-text-input type="email" name="email" id="email" class="mt-1"
                                        required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button x-on:click="$store.modal.modalUser = false" type="button"
                            class="px-4 py-2 text-sm text-white bg-[#213555] rounded-lg hover:bg-gray-500 ">
                            {{ __('Batal') }}
                        </x-modal-button>
                        <x-modal-button type="submit"
                            class="px-4 py-2 text-sm text-white bg-[#213555] rounded-lg hover:bg-gray-500 ">
                            {{ __('Simpan') }}
                        </x-modal-button>
                    </div>
                </x-modal>
            </form>
        </x-slot>
    </div>

</x-app-layout>
