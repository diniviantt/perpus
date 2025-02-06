<x-guest-layout title="{{ __('Verification Email') }}">
    <h1 class="mb-5 text-xl font-medium text-center text-gray-800 sm:text-2xl">
        {{ __('Verification Email') }}
    </h1>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    {{-- Session Status --}}
    @if (session('status') == 'verification-link-sent')
        <div class="p-2 mb-5 text-sm font-medium text-center text-green-600 border border-green-300 rounded-lg bg-green-50">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif
    
    <main class="space-y-2">
        <form action="{{ route('verification.send') }}" method="POST">
            @csrf

            <x-button class="w-full bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                {{ __('Resend Verification Email') }}
            </x-button>
        </form>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <x-button class="w-full bg-red-600 hover:bg-red-500 focus:bg-red-500 active:bg-red-700">
                {{ __('Logout') }}
            </x-button>
        </form>
    </main>
</x-guest-layout>
