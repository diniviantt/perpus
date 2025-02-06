<x-card class="h-full">
    <header class="mb-4">
        <h2 class="text-lg font-bold">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" action="{{ route('verification.send') }}" method="POST">
        @csrf
    </form>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

        {{-- Avatar --}}
        <div>
            <div class="flex items-center space-x-4">
                <div class="shrink-0">
                    @isset($user->avatar)
                        <img class="object-cover w-16 h-16 rounded-full image-preview" src="{{ $user->avatar }}" alt="{{ $user->name }}" />
                    @else
                        <img class="object-cover w-16 h-16 rounded-full image-preview" src="{{ asset('assets/img/profile.webp') }}" alt="{{ $user->name }}" />
                    @endisset
                </div>
                <label class="block">
                    <span class="sr-only">{{ __('Choose File') }}</span>
                    <input type="file" name="avatar" id="image" accept="image/*" class="block w-full text-sm text-[#697a8d] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-200 file:text-indigo-700 hover:file:bg-indigo-300 focus:outline-none file:transition-all file:!cursor-pointer" onchange="previewImage()" />
                </label>
            </div>
            <div class="mt-2">
                @error('avatar')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" :text="__('Name')" />
            <x-text-input name="name" id="name" class="mt-1" :value="old('name', $user->name)" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :text="__('Email')" />
            <x-text-input type="email" name="email" id="email" class="mt-1" :value="old('email', $user->email)" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="text-sm text-gray-600 underline hover:text-gray-900">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <x-button class="bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
            {{ __('Save') }}
        </x-button>
    </form>
</x-card>
