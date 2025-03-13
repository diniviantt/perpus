<x-app-layout title="{{ __('Form Pengembalian Buku') }}">
    <x-header value="{{ __('Form Pengembalian Buku') }}" />
    <x-session-status />
    <div class="p-6 mx-auto mt-2 bg-white rounded-lg shadow-md max-full">
        <form action="{{ route('pengembalian.create') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-lg font-semibold text-blue-600">Nama Peminjam</label>
                <select onchange="GetBuku()" name="users_id" id="users_id"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value=""></option>
                    @forelse ($peminjam as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->email }})</option>
                    @empty
                        <option value="" disabled>Tidak ada user</option>
                    @endforelse
                </select>
            </div>

            <div class="mb-4">
                <label for="buku" class="block text-lg font-semibold text-blue-600">Buku yang Dipinjam</label>
                <select name="buku_id" id="buku_id"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value=""></option>
                    @forelse ($bukuDipinjam as $item)
                        <option value="{{ $item->id }}">{{ $item->buku->judul }} ({{ $item->buku->kode_buku }}) -
                            Stok: {{ $item->buku->stock }}</option>
                    @empty
                        <option value="" disabled>Tidak ada buku yang sedang dipinjam</option>
                    @endforelse
                </select>
            </div>


            @error('buku_id')
                <div class="mt-2 text-red-600">{{ $message }}</div>
            @enderror

            <div class="flex justify-end mt-5">
                <a href="{{ route('peminjaman.index') }}"
                    class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Kembali</a>
                <button type="submit"
                    class="px-4 py-2 mx-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Submit</button>
            </div>
        </form>
    </div>

    <x-slot name='scripts'>
        <script>
            function GetBuku() {
                var users_id = document.getElementById('users_id').value;
                var url = "/dashboard/get-buku/" + users_id
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        var buku_id = document.getElementById('buku_id');
                        buku_id.innerHTML = '';
                        data.forEach(function(item) {
                            var option = document.createElement('option');
                            option.value = item.buku.id;
                            option.text = item.buku.judul + ' (' + item.buku.kode_buku + ') - Stok: ' + item.buku
                                .stock;
                            buku_id.add(option);
                        });
                    });
            }
        </script>
    </x-slot>
</x-app-layout>
