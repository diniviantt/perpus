<x-guest-layout title="{{ __('Forgot Password') }}">
    <h1 class="mb-5 text-xl font-medium text-center text-gray-800 sm:text-2xl">
        {{ __('Forgot Password') }}
    </h1>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-5" />

    <main>
        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label for="email" :text="__('Email')" />
                <x-text-input type="email" name="email" id="email" class="mt-1" :value="old('email')" required
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-button class="w-full bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                    {{ __('Email Password Reset Link') }}
                </x-button>

                <x-button-link :to="route('login')"
                    class="w-full bg-gray-500 hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-600">
                    {{ __('Back') }}
                </x-button-link>
            </div>
        </form>
    </main>
</x-guest-layout>
