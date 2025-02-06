<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h3>Laporan Peminjaman</h3>
    </center>

    <table class='table mt-3 table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Judul Buku</th>
                <th>Kode Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Wajib Pengembalian</th>
                <th>Tanggal Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat_peminjaman as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ $item->buku->kode_buku }}</td>
                    <td>{{ $item->tanggal_pinjam }}</td>
                    <td>{{ $item->tanggal_wajib_kembali }}</td>
                    <td>{{ $item->tanggal_pengembalian }}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>

</body>
