<x-app-layout title="{{ __('Tambah Anggota') }}">
    <x-header value="{{ __('Tambah Anggota') }}" />
    <x-session-status />
    <form action="{{ route('add-user') }}" method="POST" class="space-y-4">
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

        {{-- Password --}}
        <div>
            <x-input-label for="password" :text="__('Password')" />
            <x-text-input type="password" name="password" id="password" class="mt-1" wire:model.live="password"
                required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Password Confirmation --}}
        <div>
            <x-input-label for="password_confirmation" :text="__('Password confirmation')" />
            <x-text-input type="password" name="password_confirmation" id="password_confirmation" class="mt-1"
                wire:model.live="password" required />
        </div>

        {{-- Nama Lengkap --}}
        <div>
            <x-input-label for="full_name" :text="__('Nama Lengkap')" />
            <x-text-input name="data[full_name]" id="full_name" class="mt-1" :value="old('data.full_name')" required />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        {{-- Alamat --}}
        <div>
            <x-input-label for="address" :text="__('Alamat')" />
            <x-text-input name="data[address]" id="address" class="mt-1" :value="old('data.address')" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        {{-- Provinsi --}}
        <div>
            <x-input-label for="province" :text="__('Provinsi')" />
            <x-text-input name="data[province]" id="province" class="mt-1" :value="old('data.province')" required />
            <x-input-error :messages="$errors->get('province')" class="mt-2" />
        </div>

        {{-- Kecamatan --}}
        <div>
            <x-input-label for="district" :text="__('Kecamatan')" />
            <x-text-input name="data[district]" id="district" class="mt-1" :value="old('data.district')" required />
            <x-input-error :messages="$errors->get('district')" class="mt-2" />
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <x-input-label for="phone" :text="__('Nomor Telepon')" />
            <x-text-input name="data[phone]" id="phone" class="mt-1" :value="old('data.phone')" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <x-button class="w-full bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Tambahkan') }}
        </x-button>
    </form>

</x-app-layout>
