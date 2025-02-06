<x-guest-layout title="{{ __('Register') }}">
    <h1 class="mb-5 text-xl font-medium text-center text-gray-800 sm:text-2xl">
        {{ __('Register') }}
    </h1>

    <main>
        <livewire:auth.register-form />

        <div class="pt-4 text-sm text-center text-gray-700">
            {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="text-indigo-700 underline transition hover:text-indigo-500 decoration-2 decoration-indigo-500/30">{{ __('Login') }}</a>
        </div>
    </main>

    <x-slot name="styles">
        @livewireStyles
    </x-slot>

    <x-slot name="scripts">
        @livewireScripts
    </x-slot>
</x-guest-layout>
