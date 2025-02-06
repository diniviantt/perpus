<div class="space-y-4">
    {{-- Password --}}
    <div>
        <x-input-label for="password" :text="__('Password')" />
        <x-text-input type="password" name="password" id="password" class="mt-1" wire:model.live="password" required autofocus />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- Confirm Password --}}
    <div>
        <x-input-label for="password_confirmation" :text="__('Confirm Password')" />
        <x-text-input type="password" name="password_confirmation" id="password_confirmation" class="mt-1" wire:model.live="password_confirmation" required />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
</div>
