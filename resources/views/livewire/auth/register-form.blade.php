<form action="{{ route('register') }}" method="POST" class="space-y-4">
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

    {{-- Confirm Password --}}
    <div>
        <x-input-label for="password_confirmation" :text="__('Confirm Password')" />
        <x-text-input type="password" name="password_confirmation" id="password_confirmation" class="mt-1"
            wire:model.live="password_confirmation" required />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <x-button class="w-full bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
        {{ __('Register') }}
    </x-button>
</form>
