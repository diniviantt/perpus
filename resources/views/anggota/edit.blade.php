<x-app-layout title="{{ __('Edit Anggota') }}">
    <x-header title="{{ __('Edit Anggota') }}" />
    <x-session-status />

    <form action="{{ route('anggota.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
    @method('put')

        <div class="p-6 mb-5 bg-white rounded-lg shadow-md">
            <div class="mb-4">
                <label for="name" class="font-bold text-indigo-600 text-md">Nama Lengkap</label>
                <input type="text" name="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="font-bold text-indigo-600 text-md">Email</label>
                <input type="email" name="email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="avatar" class="font-bold text-indigo-600 text-md">Tambah Photo Profile</label>
                <input type="file" name="avatar"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('avatar') border-red-500 @enderror">
                @error('avatar')
                    <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end mt-4">
                <a href="{{ route('anggota.index') }}"
                    class="px-4 py-2 font-semibold text-white transition duration-200 bg-red-600 rounded hover:bg-red-700">Batal</a>
                <button type="submit"
                    class="px-4 py-2 mx-2 font-semibold text-white transition duration-200 bg-indigo-600 rounded hover:bg-indigo-700">Simpan</button>
            </div>
        </div>
    </form>
</x-app-layout>
