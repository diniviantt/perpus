<x-app-layout title="{{ __('Riwayat Peminjaman') }}">
    <div class="lg:col-auto h-min">
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
                            <th>Nominal</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Option</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#dendaTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('peminjaman-riwayat') }}", // URL untuk mengambil data dari server
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
            });

            function konfirmasiBayarDenda(id) {
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
                        // Kirim permintaan AJAX ke server
                        $.ajax({
                            url: "/dashboard/peminjaman-bayar-denda/" + id, // Route pembayaran denda
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire("Berhasil!", "Denda telah dibayar.", "success");
                                $('#dendaTable').DataTable().ajax.reload(); // Reload tabel DataTables
                            },
                            error: function(error) {
                                Swal.fire("Gagal!", "Terjadi kesalahan, coba lagi.", "error");
                            }
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
