<form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    {{-- Name --}}
    <div>
        <x-input-label for="name" :text="__('Name')" />
        <x-text-input name="name" id="name" class="mt-1" :value="old('name')" wire:model.live="name" required
            autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Email --}}
    <div>
        <x-input-label for="email" :text="__('Email')" />
        <x-text-input type="email" name="email" id="email" class="mt-1" :value="old('email')"
            wire:model.live="email" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    {{-- NIK --}}
    <div>
        <x-input-label for="nik" :text="__('NIK')" />
        <x-text-input type="text" name="nik" id="nik" class="mt-1" :value="old('nik')"
            wire:model.live="nik" required pattern="\d{16}" maxlength="16" placeholder="Masukkan 16 digit NIK" />
        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
    </div>

    {{-- Alamat --}}
    <div>
        <x-input-label for="alamat" :text="__('Alamat')" />
        <x-text-input type="text" name="alamat" id="alamat" class="w-full mt-1" :value="old('alamat')"
            wire:model.live="alamat" required placeholder="Masukkan alamat lengkap" />
        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
    </div>

    {{-- No. Telepon --}}
    <div>
        <x-input-label for="no_telp" :text="__('Nomor Telepon')" />
        <x-text-input type="text" name="no_telp" id="no_telp" class="mt-1" :value="old('no_telp')"
            wire:model.live="no_telp" required pattern="\d{10,15}" maxlength="15"
            placeholder="Masukkan nomor telepon" />
        <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
    </div>

    {{-- Password --}}
    <div>
        <x-input-label for="password" :text="__('Password')" />
        <x-text-input type="password" name="password" id="password" class="mt-1" wire:model.live="password"
            required />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- Confirm Password --}}
    <div>
        <x-input-label for="password_confirmation" :text="__('Confirm Password')" />
        <x-text-input type="password" name="password_confirmation" id="password_confirmation" class="mt-1"
            wire:model.live="password_confirmation" required />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="ktp" :text="__('Upload Foto Ktp')" />
        <x-text-input type="file" name="ktp" id="ktp" accept="image/*" class="block w-full mt-1"
            required />
        <x-input-error :messages="$errors->get('ktp')" class="mt-2" />
    </div>


    <x-button class="w-full bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
        {{ __('Register') }}
    </x-button>
</form>
