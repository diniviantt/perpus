<x-card>
    <header class="mb-4">
        <h2 class="text-lg font-bold">
            {{ __('Data Pengguna') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Berikut adalah informasi akun yang telah diisikan.') }}
        </p>
    </header>

    <form action="{{ route('profile.updateDataPribadi') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 gap-4 md:grid-cols-2">
        @csrf
        @method('PATCH')

        {{-- Kolom Kiri: Data Pengguna --}}
        <div class="space-y-4">
            <div>
                <x-input-label for="name" :text="__('Nama')" />
                <x-text-input type="text" name="name" id="name" class="block w-full mt-1"
                    value="{{ old('name', Auth::user()->name) }}" disabled />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>


            {{-- NIK --}}
            <div>
                <x-input-label for="nik" :text="__('NIK')" />
                <x-text-input type="text" name="nik" id="nik" class="block w-full mt-1"
                    value="{{ old('nik', Auth::user()->nik) }}" required />
                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
            </div>

            {{-- Alamat --}}
            <div>
                <x-input-label for="alamat" :text="__('Alamat')" />
                <x-text-input type="text" name="alamat" id="alamat" class="block w-full mt-1"
                    value="{{ old('alamat', Auth::user()->data['alamat'] ?? '') }}" />
                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
            </div>

            {{-- No. Telepon --}}
            <div>
                <x-input-label for="no_telp" :text="__('Nomor Telepon')" />
                <x-text-input type="text" name="no_telp" id="no_telp" class="mt-1" :value="old('no_telp', Auth::user()->data['no_telp'])"
                    pattern="\d{10,15}" maxlength="15" />
                <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
            </div>
        </div>

        {{-- Kolom Kanan: Upload dan Tampilan Foto KTP --}}
        <div class="flex flex-col items-center space-y-4">
            <div class="w-full">
                <x-input-label for="ktp" :text="__('Upload Foto KTP')" />
                <x-text-input type="file" name="ktp" id="ktp" accept="image/*" class="block w-full mt-1" />
                <x-input-error :messages="$errors->get('ktp')" class="mt-2" />
            </div>

            @if (Auth::user()->ktp)
                <div class="flex flex-col items-center justify-center mt-4">
                    <img src="{{ asset('storage/photoKtp/' . Auth::user()->ktp) }}" alt="Foto KTP"
                        class="w-[330px] h-[200px] object-cover border rounded-lg shadow">
                    <p class="mt-2 text-sm text-center text-gray-600">Kartu Identitas Pengguna</p>
                </div>
            @endif
        </div>


        {{-- Tombol Simpan --}}
        <div class="flex justify-end md:col-span-2">
            <x-button class="bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                {{ __('Simpan Perubahan') }}
            </x-button>
        </div>
    </form>
</x-card>
