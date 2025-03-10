<x-app-layout title="{{ __('Tambah Peminjaman') }}">
    <x-header value="{{ __('Tambah Peminjaman') }}" />
    <x-session-status />

    <style>
        body {
            background-color: #f8f9fa;
            /* Warna latar belakang halaman */
        }

        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin: 0.1.3rem auto;
            /* Margin untuk membuat card berada di tengah */
            max-width: 100%;
            /* Lebar maksimum card */
        }

        .form-group {
            margin-bottom: 1.5rem;
            /* Jarak bawah untuk setiap grup form */
        }

        .form-control {
            width: 100%;
            /* Lebar penuh untuk kontrol form */
            padding: 0.75rem;
            /* Padding di dalam kontrol */
            border: 1px solid #ccc;
            /* Border abu-abu */
            border-radius: 0.25rem;
            /* Sudut membulat */
            transition: border-color 0.2s;
            /* Transisi untuk perubahan border */
        }

        .form-control:focus {
            border-color: #007bff;
            /* Warna border saat fokus */
            outline: none;
            /* Menghilangkan outline default */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Efek bayangan saat fokus */
        }

        .btn {
            padding: 0.5rem 1rem;
            /* Padding untuk tombol */
            border: none;
            /* Menghilangkan border default */
            border-radius: 0.25rem;
            /* Sudut membulat untuk tombol */
            cursor: pointer;
            /* Menunjukkan bahwa tombol dapat diklik */
            transition: background-color 0.2s;
            /* Transisi untuk perubahan warna latar belakang */
        }

        .btn-danger {
            background-color: #dc3545;
            /* Warna latar belakang merah untuk tombol kembali */
            color: white;
            /* Warna teks putih */
        }

        .btn-danger:hover {
            background-color: #c82333;
            /* Warna latar belakang saat hover */
        }

        .btn-primary {
            background-color: #007bff;
            /* Warna latar belakang biru untuk tombol submit */
            color: white;
            /* Warna teks putih */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Warna latar belakang saat hover */
        }

        .alert-danger {
            color: #dc3545;
            /* Warna teks merah untuk pesan kesalahan */
            margin-top: 0.5rem;
            /* Jarak atas untuk pesan kesalahan */
        }
    </style>

    <div class="card">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama" class="text-primary font-weight-bold">Nama Peminjam</label>
                @role('admin')
                    <select name="users_id" class="form-control">
                        <option value="">Pilih Peminjam</option>
                        @forelse ($peminjam as $item)
                            @if (isset($item->user))
                                <option value="{{ $item->user->id }}">
                                    {{ $item->user->name }} ({{ $item->user->email }})
                                </option>
                            @endif
                        @empty
                            <option disabled>Tidak ada peminjam</option>
                        @endforelse
                    </select>
                @endrole


                @role('peminjam')
                    <select name="users_id" class="form-control">
                        <option value="{{ $peminjam->user->id }}">{{ $peminjam->user->name }} ({{ $peminjam->user->email }})
                        </option>
                    </select>
                @endrole

                @error('users_id')
                    <div class="alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="buku" class="text-primary font-weight-bold">Buku yang akan dipinjam</label>
                <select name="buku_id" class="form-control">
                    <option value="">Pilih Buku</option>
                    @forelse ($buku as $item)
                        <option value="{{ $item->id }}">{{ $item->judul }} ({{ $item->kode_buku }}) |
                            {{ $item->stock }} Tersedia</option>
                    @empty
                        <option value="" disabled>Tidak ada buku yang tersedia</option>
                    @endforelse
                </select>
            </div>

            @error('buku_id')
                <div class="alert-danger">{{ $message }}</div>
            @enderror

            <div class="mt-5 d-flex justify-content-end">
                <a href="{{ route('peminjaman.index') }}" class="mr-2 btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</x-app-layout>
