<x-guest-layout title="{{ __('Login') }}">
    <h1 class="mb-5 text-xl font-medium text-center text-gray-800 sm:text-2xl">
        {{ __('Perpustakaan') }}
    </h1>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-5" />

    <main>
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label for="email" :text="__('Email')" />
                <x-text-input type="email" name="email" id="email" class="mt-1" :value="old('email')" required
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :text="__('Password')" />
                <x-text-input type="password" name="password" id="password" class="mt-1" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between w-full text-sm">
                {{-- Remember Me --}}
                <div class="inline-flex items-center gap-x-2">
                    <input
                        class="text-indigo-600 transition-all duration-300 ease-in-out bg-white border-gray-400 rounded shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-600/20 focus:ring-opacity-80"
                        type="checkbox" name="remember" id="remember">
                    <label class="text-sm font-medium text-gray-700 select-none" for="remember">
                        {{ __('Remember me') }}
                    </label>
                </div>

                {{-- Lupa Password --}}
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-right text-indigo-700 underline transition hover:text-indigo-500 decoration-2 decoration-indigo-500/30">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <x-button class="w-full bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                {{ __('Login') }}
            </x-button>
        </form>

        @if (env('GITHUB_CLIENT_ID') != null || env('GOOGLE_CLIENT_ID') != null)
            <div class="py-4 text-xs text-center text-gray-400 select-none">OR</div>

            <div class="space-y-2">
                @if (env('GITHUB_CLIENT_ID') != null)
                    <x-button-link to="{{ route('login.provider', 'github') }}"
                        class="w-full bg-black hover:bg-slate-800 focus:bg-slate-800 active:bg-black">
                        <span class="flex items-center gap-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12.026 2c-5.509 0-9.974 4.465-9.974 9.974 0 4.406 2.857 8.145 6.821 9.465.499.09.679-.217.679-.481 0-.237-.008-.865-.011-1.696-2.775.602-3.361-1.338-3.361-1.338-.452-1.152-1.107-1.459-1.107-1.459-.905-.619.069-.605.069-.605 1.002.07 1.527 1.028 1.527 1.028.89 1.524 2.336 1.084 2.902.829.091-.645.351-1.085.635-1.334-2.214-.251-4.542-1.107-4.542-4.93 0-1.087.389-1.979 1.024-2.675-.101-.253-.446-1.268.099-2.64 0 0 .837-.269 2.742 1.021a9.582 9.582 0 0 1 2.496-.336 9.554 9.554 0 0 1 2.496.336c1.906-1.291 2.742-1.021 2.742-1.021.545 1.372.203 2.387.099 2.64.64.696 1.024 1.587 1.024 2.675 0 3.833-2.33 4.675-4.552 4.922.355.308.675.916.675 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.178.577.687.479C19.146 20.115 22 16.379 22 11.974 22 6.465 17.535 2 12.026 2z">
                                </path>
                            </svg>
                            {{ __('Login with GitHub') }}
                        </span>
                    </x-button-link>
                @endif

                @if (env('GOOGLE_CLIENT_ID') != null)
                    <x-button-link to="{{ route('login.provider', 'google') }}"
                        class="w-full bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-700">
                        <span class="flex items-center gap-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current">
                                <path
                                    d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934 0-.528-.081-1.097-.202-1.625z">
                                </path>
                            </svg>
                            {{ __('Login with Google') }}
                        </span>
                    </x-button-link>
                @endif
            </div>
        @endif

        <div class="pt-4 text-sm text-center text-gray-700">
            {{ __('Don\'t have an account?') }} <a href="{{ route('register') }}"
                class="text-indigo-700 underline transition hover:text-indigo-500 decoration-2 decoration-indigo-500/30">{{ __('Register') }}</a>
        </div>
    </main>
</x-guest-layout>
