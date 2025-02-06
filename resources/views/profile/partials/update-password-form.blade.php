<x-card class="h-full">
    <header class="mb-4">
        <h2 class="text-lg font-bold">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
        @csrf
        @method('PATCH')
        
        {{-- Current Password --}}
        <div>
            <x-input-label for="update_password_current_password" :text="__('Current Password')" />
            <x-text-input type="password" name="current_password" id="update_password_current_password" class="mt-1" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div>
            <x-input-label for="update_password_password" :text="__('New Password')" />
            <x-text-input type="password" name="password" id="update_password_password" class="mt-1" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :text="__('Confirm Password')" />
            <x-text-input type="password" name="password_confirmation" id="update_password_password_confirmation" class="mt-1" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <x-button class="bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Save') }}
        </x-button>
    </form>
</x-card>
