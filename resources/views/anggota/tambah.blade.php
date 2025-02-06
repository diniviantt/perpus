<x-app-layout title="{{ __('Tambah Anggota') }}">
    <x-header value="{{ __('Tambah Anggota') }}" />
    <x-session-status />
    <form action="{{ route('anggota.store') }}" method="post">
        @csrf

        <div class="bg-white shadow-md rounded-lg p-6 mb-5">
            <div class="mb-4">
                <label for="name" class="text-md text-indigo-600 font-bold">Nama Lengkap</label>
                <input type="text" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                    name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="npm" class="text-md text-indigo-600 font-bold">Nomor Induk Mahasiswa</label>
                <input type="text" id="npm"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('npm') border-red-500 @enderror"
                    name="npm" value="{{ old('npm') }}">
                @error('npm')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="prodi" class="text-md text-indigo-600 font-bold">Program Studi</label>
                <input type="text" id="prodi"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('prodi') border-red-500 @enderror"
                    name="prodi" value="{{ old('prodi') }}">
                @error('prodi')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="alamat" class="text-md text-indigo-600 font-bold">Alamat</label>
                <input type="text" id="alamat"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('alamat') border-red-500 @enderror"
                    name="alamat" value="{{ old('alamat') }}">
                @error('alamat')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="noTelp" class="text-md text-indigo-600 font-bold">Nomor Telepon</label>
                <input type="text" id="noTelp"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('noTelp') border-red-500 @enderror"
                    name="noTelp" value="{{ old('noTelp') }}">
                @error('noTelp')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="text-md text-indigo-600 font-bold">Email</label>
                <input id="email" type="email"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email')  border-red-500 @enderror"
                    name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="text-md text-indigo-600 font-bold">Password</label>
                <input id="password" type="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password')  border-red-500 @enderror"
                    name="password">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                    Simpan
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
