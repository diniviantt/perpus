<x-app-layout title="{{ __('Riwayat Peminjaman') }}">
    {{-- <x-header value="{{ __('Riwayat Peminjaman') }}" /> --}}
    <x-session-status />


    @role('admin')
        <div class="">
            <div class="flex gap-4 mb-4">
                <!-- Tombol Tambah Peminjaman -->
                <a href="javascript:void(0)" onclick="AddPeminjaman()" x-data="{ show: false }" @mouseover="show = true"
                    @mouseleave="show = false"
                    class="relative flex items-center justify-center p-3 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <i class="fa-solid fa-plus"></i>

                    <!-- Tooltip -->
                    <span x-show="show"
                        class="absolute px-3 py-1 text-xs text-white -translate-x-1/2 bg-gray-800 rounded-md shadow-lg -bottom-10 left-1/2 whitespace-nowrap">
                        Tambah Peminjaman
                    </span>
                </a>

                <a href="#" x-data="{ show: false }" @mouseover="show = true" @mouseleave="show = false"
                    id="printReport" onclick="printReport()"
                    class="relative flex items-center justify-center p-3 text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-green-400 focus:outline-none">
                    <i class="fa-solid fa-print"></i>

                    <!-- Tooltip -->
                    <span x-show="show"
                        class="absolute px-3 py-1 text-xs text-white -translate-x-1/2 bg-gray-800 rounded-md shadow-lg -bottom-10 left-1/2 whitespace-nowrap">
                        Cetak Laporan Peminjaman
                    </span>
                </a>
            </div>

            <div class="lg:col-auto h-min">
                <div class="mb-4 bg-white rounded-lg shadow-md min-h-80">
                    <div class="px-4 py-3 border-b">
                        <h2 class="text-lg font-semibold">{{ __('Peminjaman') }}</h2>
                    </div>
                    <div class="w-full p-3 overflow-x-auto min-h-80">
                        <table id="Tablepeminjaman" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Judul Buku</th>
                                    <th>Kode Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Wajib Kembali</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Denda</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-auto h-min">
                <div class="mb-4 bg-white rounded-lg shadow-md min-h-80">
                    <div class="px-4 py-3 border-b">
                        <h2 class="text-lg font-semibold">{{ __('Riwayat Peminjaman') }}</h2>
                    </div>
                    <div class="w-full p-3 overflow-x-auto min-h-80">
                        <table id="TableRiwayatpeminjaman" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Judul Buku</th>
                                    <th>Kode Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Wajib Kembali</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Denda</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @role('peminjam')

        @if (!empty($notifikasi))
            <!-- Header Pemberitahuan -->
            <div class="w-full p-4 mb-4 bg-white border border-gray-300 rounded-lg shadow-md">
                <div class="flex items-center gap-2">
                    <div class="text-xl animate-bounce">🔔</div>
                    <h2 class="text-2xl font-bold t">Pemberitahuan</h2>
                </div>
                <hr class="mt-2 border-gray-300">

                <!-- Bubble Chat Notifikasi -->
                <div class="flex flex-col w-full gap-3 mt-3">
                    @foreach ($notifikasi as $notif)
                        @php
                            // Menentukan warna latar belakang & panah
                            if (str_contains($notif['pesan'], '❗')) {
                                $bgColor = 'bg-red-100';
                                $arrowColor = 'border-r-red-100';
                            } elseif (str_contains($notif['pesan'], '⏳') || str_contains($notif['pesan'], '⚠️')) {
                                $bgColor = 'bg-yellow-100';
                                $arrowColor = 'border-r-yellow-100';
                            } else {
                                $bgColor = 'bg-green-100';
                                $arrowColor = 'border-r-green-100';
                            }
                        @endphp

                        <div class="relative flex flex-col items-start p-3 shadow-md rounded-xl {{ $bgColor }}">
                            <div
                                class="absolute -left-2 -top-1 w-0 h-0 border-t-[14px] border-t-transparent border-r-[18px] {{ $arrowColor }} border-b-[14px] border-b-transparent rotate-[26deg]">
                            </div>

                            <!-- Pesan Notifikasi -->
                            <p class="text-sm text-gray-800">{!! $notif['pesan'] !!}</p>


                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="">
            <div class="lg:col-auto">
                <div class="mb-4 bg-white rounded-lg shadow-md">
                    <div class="px-4 py-3 border-b">
                        <h2 class="text-lg font-semibold">{{ __('Daftar Peminjaman') }}</h2>
                    </div>
                    <div class="p-3 overflow-x-auto">
                        <table class="min-w-full m-2 divide-y divide-gray-200" id="Tablepeminjam" style="font-size: .7rem">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">No.</th>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Judul Buku</th>
                                    <th class="px-4 py-2 text-left">Kode Buku</th>
                                    <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
                                    <th class="px-4 py-2 text-left">Tanggal Wajib Pengembalian</th>
                                    <th class="px-4 py-2 text-left">Tanggal Pengembalian</th>
                                    <th class="px-4 py-2 text-left">Denda</th>
                                    <th class="px-4 py-2 text-left">Status</th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    <div x-data="{ modalPeminjaman: false, modalPerpanjangan: false }" x-init="$store.modal = { modalPeminjaman: modalPeminjaman, modalPerpanjangan: modalPerpanjangan }">
        <x-slot name="modals">
            <form id="AddPeminjaman" aria-autocomplete="off">
                @csrf
                <x-modal modal="$store.modal.modalPeminjaman" dialog="modal-modalPeminjaman-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Tambah Peminjaman')" />
                            <div class="my-2 space-y-3">

                                <!-- Nama Peminjam -->
                                <div>
                                    <x-input-label for="users_id" :text="__('Nama Peminjam')" />
                                    @role('admin')
                                        <select onchange="GetBuku()" name="users_id" id="users_id"
                                            class="block w-full px-4 py-3 mt-1 text-sm text-indigo-700 transition-all duration-300 ease-in-out bg-white border border-gray-400 rounded-lg focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500">
                                            <option value="">Pilih Peminjam</option>
                                            @forelse ($peminjam as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }} ({{ $item->email }})
                                                </option>
                                            @empty
                                                <option disabled>Tidak ada peminjam</option>
                                            @endforelse
                                        </select>
                                    @endrole

                                    @role('peminjam')
                                        <select name="users_id"
                                            class="block w-full px-4 py-3 mt-1 text-sm text-indigo-700 transition-all duration-300 ease-in-out bg-white border border-gray-400 rounded-lg focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500">
                                            <option value="{{ auth()->id() }}">{{ auth()->user()->name }}
                                                ({{ auth()->user()->email }})</option>
                                        </select>
                                    @endrole


                                    <x-input-error :messages="$errors->get('users_id')" class="mt-2" />
                                </div>

                                <!-- Buku yang akan dipinjam -->
                                <div>
                                    <x-input-label for="buku_id" :text="__('Buku yang akan dipinjam')" />
                                    <select name="buku_id" id="buku_id"
                                        class="block w-full px-4 py-4 mt-1 text-xs text-indigo-700 transition-all duration-300 ease-in-out bg-white border border-gray-400 rounded-lg focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500 select2"
                                        disabled>
                                        <option class="text-xs" value="">Pilih Buku</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('buku_id')" class="mt-2" />
                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button x-on:click="$store.modal.modalPeminjaman = false" type="button"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-gray-500 rounded-lg hover:bg-gray-600">
                            {{ __('Batal') }}
                        </x-modal-button>
                        <x-modal-button type="submit"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-[#213555] rounded-lg hover:bg-gray-500">
                            {{ __('Simpan') }}
                        </x-modal-button>
                    </div>
                </x-modal>
            </form>


            <form id="PerpanjanganPeminjaman" aria-autocomplete="off">
                @csrf
                <x-modal modal="$store.modal.modalPerpanjangan" dialog="modal-modalPerpanjangan-dialog">
                    <div class="px-5 bg-white sm:p-7 sm:pb-0">
                        <div class="mt-5 sm:mt-0">
                            <x-modal-title :label="__('Perpanjang Peminjaman')" />
                            <div class="my-2 space-y-3">

                                <!-- Input Hidden untuk ID Peminjaman -->
                                <input type="hidden" name="peminjaman_id" id="peminjamanId">

                                <!-- Durasi Perpanjangan -->
                                <div>
                                    <x-input-label for="durasiPerpanjangan" :text="__('Silakan pilih durasi perpanjangan')" />
                                    <select name="durasiPerpanjangan" id="durasiPerpanjangan"
                                        class="block w-full p-5 px-4 py-3 mt-1 text-sm text-indigo-700 transition-all duration-300 ease-in-out bg-white border border-gray-400 rounded-lg focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500">
                                        <option value="">Pilih Durasi Perpanjangan</option>
                                        <option value="1">1 Hari</option>
                                        <option value="2">2 Hari</option>
                                        <option value="3">3 Hari</option>
                                        <option value="4">4 Hari</option>
                                        <option value="5">5 Hari</option>
                                        <option value="6">6 Hari</option>
                                        <option value="7">7 Hari</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('durasiPerpanjangan')" class="mt-2" />
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
                        <x-modal-button x-on:click="$store.modal.modalPerpanjangan = false" type="button"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-indigo-500 rounded-lg hover:bg-indigo-600">
                            {{ __('Batal') }}
                        </x-modal-button>
                        <x-modal-button type="submit"
                            class="px-4 py-2 text-sm text-white transition-all duration-200 ease-in-out bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            {{ __('Perpanjang') }}
                        </x-modal-button>

                    </div>
                </x-modal>
            </form>

        </x-slot>
    </div>


    <x-slot name="scripts">
        <script>
            $('#buku_id').select2({
                allowClear: true,
                placeholder: "Pilih Buku",
            });

            // Menyesuaikan tampilan Select2 agar mirip dengan Tailwind CSS
            $(".select2-selection").addClass(
                "block w-full px-4 py-3 mt-1 text-sm text-indigo-700 transition-all duration-300 ease-in-out bg-white border border-gray-400 rounded-xl focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500"
            );

            // Menyesuaikan dropdown Select2 agar tampilan tidak berubah
            $(".select2-container--default .select2-selection--single").css({
                "height": "42px", // Sesuaikan dengan tinggi input lain
                "display": "flex",
                "align-items": "center",
            });

            $(".select2-container--default .select2-selection--multiple .select2-selection__arrow").css({
                "top": "50%",
                "right": "20px", // Pastikan posisinya pas
                "transform": "translateY(-50%)",
                "position": "absolute" // Pastikan posisinya mutlak
            });

            $(document).ready(function() {
                $('#Tablepeminjaman').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('table-peminjaman') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'user.name'
                        },
                        {
                            data: 'judul_buku',
                            name: 'buku.judul'
                        },
                        {
                            data: 'kode_buku',
                            name: 'buku.kode_buku'
                        },
                        {
                            data: 'tanggal_pinjam',
                            name: 'tanggal_pinjam'
                        },
                        {
                            data: 'tanggal_wajib_kembali',
                            name: 'tanggal_wajib_kembali'
                        },
                        {
                            data: 'tanggal_pengembalian',
                            name: 'tanggal_pengembalian'
                        },
                        {
                            data: 'denda',
                            name: 'denda'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'option',
                            name: 'option',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    columnDefs: [{
                        targets: [0, 8, 9],
                        className: "text-center"
                    }, ],
                });
            });

            $(document).ready(function() {
                $('#TableRiwayatpeminjaman').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('table-riwayat') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'user.name'
                        },
                        {
                            data: 'judul_buku',
                            name: 'buku.judul'
                        },
                        {
                            data: 'kode_buku',
                            name: 'buku.kode_buku'
                        },
                        {
                            data: 'tanggal_pinjam',
                            name: 'tanggal_pinjam'
                        },
                        {
                            data: 'tanggal_wajib_kembali',
                            name: 'tanggal_wajib_kembali'
                        },
                        {
                            data: 'tanggal_pengembalian',
                            name: 'tanggal_pengembalian'
                        },
                        {
                            data: 'denda',
                            name: 'denda'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    columnDefs: [{
                        targets: [0, 8],
                        className: "text-center"
                    }, ],
                });
            });

            $(document).ready(function() {
                $('#Tablepeminjam').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('table-peminjam') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'user.name'
                        },
                        {
                            data: 'judul_buku',
                            name: 'buku.judul'
                        },
                        {
                            data: 'kode_buku',
                            name: 'buku.kode_buku'
                        },
                        {
                            data: 'tanggal_pinjam',
                            name: 'tanggal_pinjam'
                        },
                        {
                            data: 'tanggal_wajib_kembali',
                            name: 'tanggal_wajib_kembali'
                        },
                        {
                            data: 'tanggal_pengembalian',
                            name: 'tanggal_pengembalian'
                        },
                        {
                            data: 'denda',
                            name: 'denda'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    columnDefs: [{
                        targets: [0, 8],
                        className: "text-center"
                    }, ],
                });
            });

            function updateStatus(action, id) {
                let url = '';
                let message = '';
                let confirmText = '';

                if (action === 'konfirmasi') {
                    url = `/dashboard/pinjam/${id}/konfirmasi`;
                    message = 'Konfirmasi peminjaman ini?';
                    confirmText = 'Ya, Konfirmasi!';
                } else if (action === 'ambil') {
                    url = `/dashboard/pinjam/${id}/ambil`;
                    message = 'Tandai buku sebagai telah diambil?';
                    confirmText = 'Ya, Sudah Diambil!';
                } else if (action === 'dikembalikan') {
                    url = `/dashboard/pinjam/${id}/kembalikan`;
                    message = 'Tandai buku sebagai telah dikembalikan?';
                    confirmText = 'Ya, Dikembalikan!';
                } else if (action === 'batalkan') { // Aksi batalkan menggunakan DELETE
                    url = `/dashboard/pinjam/${id}/batalkan`;
                    message = 'Batalkan peminjaman ini dan hapus riwayat?';
                    confirmText = 'Ya, Batalkan!';
                }

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: message,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: confirmText,
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                                method: action === 'batalkan' ? "DELETE" : "PUT", // Menentukan method sesuai aksi
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message ===
                                    'Peminjaman tidak dapat dibatalkan jika sudah dikonfirmasi') {
                                    Swal.fire({
                                        title: "Gagal!",
                                        text: data.message,
                                        icon: "error",
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: data.message,
                                        icon: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(() => location.reload(), 2000);
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan, coba lagi.",
                                    icon: "error",
                                });
                            });
                    }
                });
            }


            function batalkanPeminjaman(id) {
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Batalkan peminjaman ini dan hapus riwayat?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Batalkan!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/dashboard/pinjam/${id}/batalkan`, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: data.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                setTimeout(() => location.reload(), 2000);
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan, coba lagi.",
                                    icon: "error",
                                });
                            });
                    }
                });
            }



            function AddPeminjaman() {
                console.log('Add Peminjaman');
                // Reset inputan dalam modal
                $("#AddPeminjaman")[0].reset();

                // Tampilkan modal menggunakan Alpine.js
                $('#modal-modalPeminjaman-dialog').removeClass("invisible");
                $('#modal-modalPeminjaman-dialog').addClass("visible");
                window.Alpine.store('modal', {
                    modalPeminjaman: true,
                });
            }


            $(document).ready(function() {
                $("#AddPeminjaman").on("submit", function(e) {
                    e.preventDefault(); // Mencegah reload halaman

                    let form = $(this);
                    let formData = form.serialize(); // Ambil semua data dari form
                    let csrfToken = $('meta[name="csrf-token"]').attr("content");

                    $.ajax({
                        url: "{{ route('peminjaman.store') }}", // Sesuaikan dengan rute penyimpanan
                        type: "POST",
                        data: formData + "&_token=" + csrfToken, // Pastikan CSRF dikirim
                        beforeSend: function() {
                            $("button[type=submit]").prop("disabled", true).text("Menyimpan...");
                        },
                        success: function(response) {
                            // Jika sukses, tampilkan SweetAlert
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Peminjaman berhasil diajukan.",
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "OK",
                            }).then(() => {
                                // Tutup modal dengan benar
                                $('#modal-modalPeminjaman-dialog').removeClass("visible")
                                    .addClass("invisible");

                                // Jika menggunakan Bootstrap Modal
                                // $('#modal-modalPeminjaman-dialog').modal('hide');

                                // Jika menggunakan Alpine.js
                                // let modal = document.getElementById("modal-modalPeminjaman-dialog");
                                // modal.__x.$data.open = false;

                                // Reset form setelah modal tertutup
                                form[0].reset();

                                // Refresh DataTable
                                $('#Tablepeminjaman').DataTable().ajax.reload(null, false);
                            });
                        },
                        error: function(xhr) {
                            $("button[type=submit]").prop("disabled", false).text("Simpan");

                            let errors = xhr.responseJSON.errors;
                            $(".alert-danger").remove(); // Hapus error sebelumnya

                            if (errors) {
                                $.each(errors, function(key, value) {
                                    $("#" + key)
                                        .after('<div class="mt-2 text-sm alert-danger">' +
                                            value[0] + "</div>");
                                });

                                // SweetAlert untuk error
                                Swal.fire({
                                    title: "Gagal!",
                                    text: "Harap periksa kembali inputan Anda.",
                                    icon: "error",
                                    confirmButtonColor: "#d33",
                                    confirmButtonText: "OK",
                                });
                            }
                        },
                    });
                });
            });


            document.addEventListener("DOMContentLoaded", function() {
                let users_id = document.getElementById("users_id");
                let buku_id = document.getElementById("buku_id");

                function updateBukuStatus() {
                    if (users_id.value) {
                        buku_id.disabled = false;
                        GetBuku();
                    } else {
                        buku_id.innerHTML = '<option class="text-xs" value="">Pilih Buku</option>';
                        buku_id.disabled = true;
                    }
                }

                // Event listener untuk perubahan pada users_id
                users_id.addEventListener("change", updateBukuStatus);

                // Jalankan updateBukuStatus saat halaman dimuat untuk memastikan kondisi awal
                updateBukuStatus();
            });

            function GetBuku() {
                fetch("/dashboard/get-buku-pinjam")
                    .then(res => res.json())
                    .then(data => {
                        let buku_id = document.getElementById('buku_id');
                        buku_id.innerHTML = `<option class="text-xs" value="">Pilih Buku</option>` +
                            (data.length ? data.map(item => `
                    <option class="text-xs" value="${item.id}" ${item.stock === 0 ? 'disabled' : ''}>
                        ${item.judul} (${item.kode_buku}) - Stok: ${item.stock} ${item.stock === 0 ? '(HABIS)' : ''}
                    </option>
                `).join('') : '<option disabled>⚠️ Semua buku habis</option>');

                        buku_id.disabled = data.length === 0;
                    })
                    .catch(() => {
                        buku_id.innerHTML = '<option selected>⚠️ Gagal mengambil data</option>';
                        buku_id.disabled = true;
                    });
            }

            @role('peminjam')
                document.addEventListener("DOMContentLoaded", function() {
                    GetBuku();
                });
            @endrole

            function printReport() {
                $.ajax({
                    url: "/dashboard/laporan-peminjaman", // Menggunakan route utama
                    method: "GET",
                    dataType: "json",
                    success: function(dataPeminjaman) {
                        // Membuat elemen HTML untuk laporan
                        let laporan = `
                <html>
                <head>
                    <title>Laporan Peminjaman Buku</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            padding: 0;
                            color: #333;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .header h1 {
                            margin: 0;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
                        th, td {
                            border: 1px solid #000;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                        .footer {
                            margin-top: 20px;
                            text-align: center;
                        }
                        .footer p {
                            margin: 5px 0;
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Laporan Peminjaman Buku</h1>
                    </div>
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Judul Buku</th>
                            <th>Kode Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Wajib Kembali</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Denda</th>
                            <th>Status</th>
                        </tr>`;

                        $.each(dataPeminjaman, function(index, item) {
                            laporan += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.user.name}</td>
                        <td>${item.buku.judul}</td>
                        <td>${item.buku.kode_buku}</td>
                        <td>${item.tanggal_pinjam}</td>
                        <td>${item.tanggal_wajib_kembali}</td>
                        <td>${item.tanggal_pengembalian || '-'}</td>
                        <td>${item.denda}</td>
                        <td>${item.status}</td>
                    </tr>`;
                        });

                        laporan += `
                    </table>
                    <div class="footer">
                        <p>Dicetak pada: ${new Date().toLocaleString()}</p>
                        <p>Terima kasih!</p>
                    </div>
                </body>
                </html>`;

                        // Membuka laporan dalam jendela baru untuk dicetak
                        const win = window.open('', '', 'width=800,height=600');
                        win.document.write(laporan);
                        win.document.close();
                        win.print();
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                        alert("Gagal mengambil data peminjaman.");
                    }
                });
            }

            // Buat fungsi global agar bisa dipanggil di tombol
            window.bukaModalPerpanjangan = function(id) {
                if (!id) {
                    alert("ID peminjaman tidak valid.");
                    return;
                }

                // Setel ID peminjaman ke input hidden dalam form modal
                $("#peminjamanId").val(id);

                // Tampilkan modal
                $('#modal-modalPerpanjangan-dialog').removeClass("invisible").addClass("visible");

                // Gunakan Alpine.js jika ada
                try {
                    window.Alpine.store('modal', {
                        modalPerpanjangan: true
                    });
                } catch (error) {
                    console.error("Gagal menampilkan modal perpanjangan:", error);
                }
            };


            $(document).ready(function() {
                // Event listener untuk menangani submit form
                $("#PerpanjanganPeminjaman").on("submit", function(e) {
                    e.preventDefault(); // Mencegah submit default

                    // Ambil data dari form
                    let peminjamanId = $("#peminjamanId").val(); // Ambil ID peminjaman
                    let durasiPerpanjangan = $("#durasiPerpanjangan").val(); // Ambil durasi perpanjangan

                    if (!peminjamanId) {
                        Swal.fire({
                            icon: "error",
                            title: "ID peminjaman tidak valid!",
                            text: "Harap pilih peminjaman yang benar sebelum memperpanjang.",
                            width: "400px",
                            confirmButtonColor: "#4F46E5"
                        });
                        return;
                    }

                    if (!durasiPerpanjangan) {
                        Swal.fire({
                            icon: "error",
                            title: "Durasi perpanjangan belum dipilih!",
                            text: "Harap pilih durasi perpanjangan.",
                            width: "400px",
                            confirmButtonColor: "#4F46E5"
                        });
                        return;
                    }

                    // Kirim data ke server melalui AJAX
                    $.ajax({
                        url: '/dashboard/pinjam/perpanjang/' +
                            peminjamanId, // Ganti dengan URL yang sesuai
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            durasi: durasiPerpanjangan
                        },
                        success: function(response) {
                            // Jika peminjaman sudah diperpanjang, beri notifikasi
                            if (response.already_extended) {
                                Swal.fire({
                                    icon: "info",
                                    title: "Peminjaman Sudah Diperpanjang!",
                                    text: "Peminjaman buku ini sudah diperpanjang sebelumnya.",
                                    width: "450px",
                                    confirmButtonColor: "#4F46E5"
                                });
                            } else {
                                Swal.fire({
                                    icon: response.success ? "success" : "error",
                                    title: response.success ? "Perpanjangan Berhasil!" :
                                        "Gagal Memperpanjang",
                                    text: response.message,
                                    width: "450px",
                                    confirmButtonColor: "#4F46E5"
                                }).then(() => {
                                    if (response.success) {
                                        location.reload(); // Refresh halaman setelah sukses
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Terjadi Kesalahan!",
                                text: "Gagal memperpanjang peminjaman. Silakan coba lagi.",
                                width: "450px",
                                confirmButtonColor: "#4F46E5"
                            });
                        }
                    });
                });
            });
        </script>
    </x-slot>


</x-app-layout>
