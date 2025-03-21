<x-app-layout title="{{ __('Riwayat Peminjaman') }}">
    <div class="lg:col-auto h-min">
        <div class="flex mb-3">
            <a href="javascript:void(0)" onclick="openDendaModal()" x-data="{ show: false }" @mouseover="show = true"
                @mouseleave="show = false"
                class="relative flex items-center justify-center p-3 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <i class="fa-solid fa-plus"></i>

                <!-- Tooltip -->
                <span x-show="show"
                    class="absolute px-3 py-1 text-xs text-white -translate-x-1/2 bg-gray-800 rounded-md shadow-lg -bottom-10 left-1/2 whitespace-nowrap">
                    Tambah Denda
                </span>
            </a>
        </div>
        <div class="mb-4 bg-white rounded-lg shadow-md min-h-80">
            <div class="px-4 py-3 border-b">
                <h2 class="text-lg font-semibold">{{ __('Pembayaran Denda') }}</h2>
            </div>
            <div class="w-full p-3 overflow-x-auto min-h-80">

                <table id="dendaTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Buku</th>
                            <th>Kode Buku</th>
                            <th>Tarif Denda</th>
                            <th>Nominal</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="lg:col-auto h-min">
        <div class="mb-4 bg-white rounded-lg shadow-md min-h-80">
            <div class="px-4 py-3 border-b">
                <h2 class="text-lg font-semibold">{{ __('Riwayat Pembayaran Denda') }}</h2>
            </div>
            <div class="w-full p-3 overflow-x-auto min-h-80">

                <table id="TableRiwayat" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Buku</th>
                            <th>Kode Buku</th>
                            <th>Tarif Denda</th>
                            <th>Nominal</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Modal Tambah Denda -->
    <div id="dendaModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-semibold">Tambah Denda</h2>

            <form id="AddDendaForm" action="" method="POST">
                @csrf

                <!-- ID Peminjaman -->
                <div class="mb-3">
                    <label for="id_peminjaman" class="block text-sm font-medium text-gray-700">ID Peminjaman</label>
                    <select name="id_peminjaman" id="id_peminjaman" class="w-full p-2 mt-1 border rounded">
                        <option value="" disabled selected>Pilih Peminjaman</option>
                    </select>
                </div>

                <!-- Email Peminjam -->
                <div class="mb-3">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Peminjam</label>
                    <input type="text" name="email" id="email" class="w-full p-2 mt-1 border rounded" readonly>
                </div>

                <!-- Judul Buku -->
                <div class="mb-3">
                    <label for="judul_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                    <input type="text" name="judul_buku" id="judul_buku" class="w-full p-2 mt-1 border rounded"
                        readonly>
                </div>

                <!-- Keterangan -->
                <div class="mb-3">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <select name="keterangan" id="keterangan" class="w-full p-2 mt-1 border rounded">
                        <option value="" disabled selected>Pilih Keterangan</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="hilang">Hilang</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>

                <!-- Tarif Denda -->
                <div class="mb-3">
                    <label for="denda" class="block text-sm font-medium text-gray-700">Tarif Denda</label>
                    <input type="text" name="denda" id="denda" class="w-full p-2 mt-1 border rounded" readonly>
                </div>

                <!-- Metode Bayar -->
                <div class="mb-3">
                    <label for="metode_bayar" class="block text-sm font-medium text-gray-700">Metode Bayar</label>
                    <select name="metode_bayar" id="metode_bayar" class="w-full p-2 mt-1 border rounded">
                        <option value="" disabled selected>Pilih Metode</option>
                        <option value="tunai">Tunai</option>
                        <option value="ganti_buku">Ganti Buku</option>
                    </select>
                </div>

                <!-- Harga Buku -->
                <div class="mb-3">
                    <label for="harga_buku" class="block text-sm font-medium text-gray-700">Harga Buku</label>
                    <input type="text" name="harga_buku" id="harga_buku" class="w-full p-2 mt-1 border rounded"
                        readonly>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeDendaModal()"
                        class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                // Inisialisasi DataTables untuk tabel denda
                let tableDenda = $('#dendaTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('peminjaman-riwayat') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'user',
                            name: 'user'
                        },
                        {
                            data: 'buku',
                            name: 'buku'
                        },
                        {
                            data: 'kode',
                            name: 'kode'
                        },
                        {
                            data: 'tarif_denda',
                            name: 'tarif_denda'
                        },
                        {
                            data: 'nominal',
                            name: 'nominal'
                        },
                        {
                            data: 'tanggal_bayar',
                            name: 'tanggal_bayar'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Inisialisasi DataTables untuk tabel riwayat
                let tableRiwayat = $('#TableRiwayat').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('riwayat-lunas') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'user',
                            name: 'user'
                        },
                        {
                            data: 'buku',
                            name: 'buku'
                        },
                        {
                            data: 'kode',
                            name: 'kode'
                        },
                        {
                            data: 'tarif_denda',
                            name: 'tarif_denda'
                        },
                        {
                            data: 'nominal',
                            name: 'nominal'
                        },
                        {
                            data: 'tanggal_bayar',
                            name: 'tanggal_bayar'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan'
                        }
                    ]
                });

                // Fungsi konfirmasi pembayaran denda
                window.konfirmasiBayarDenda = function(id) {
                    Swal.fire({
                        title: "Bayar Denda?",
                        text: "Apakah Anda yakin ingin membayar denda sekarang?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Bayar!",
                        cancelButtonText: "Batal",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/dashboard/peminjaman-bayar-denda/" + id,
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    Swal.fire("Berhasil!", "Denda telah dibayar.", "success");
                                    tableDenda.ajax.reload();
                                    tableRiwayat.ajax.reload();
                                },
                                error: function(error) {
                                    Swal.fire("Gagal!", "Terjadi kesalahan, coba lagi.",
                                        "error");
                                }
                            });
                        }
                    });
                };
            });

            function openDendaModal() {
                document.getElementById("dendaModal").classList.remove("hidden");

                // Mengosongkan input sebelum menampilkan modal
                document.getElementById("id_peminjaman").value = '';
                document.getElementById("email").value = '';
                document.getElementById("judul_buku").value = '';
                document.getElementById("keterangan").value = '';
                document.getElementById("denda").value = '';
                document.getElementById("metode_bayar").value = '';
                document.getElementById("harga_buku").value = '';
            }

            function closeDendaModal() {
                document.getElementById("dendaModal").classList.add("hidden");
            }
        </script>

    </x-slot>

</x-app-layout>
