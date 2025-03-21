<x-app-layout title="{{ __('Profile') }}">
    <x-header value="{{ __('Profile') }}" />

    {{-- Session Status --}}
    <x-session-status />

    <div class="grid w-full grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
        <div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <div>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="mb-7">
        @include('profile.partials.data-user')
    </div>
    <div>
        @include('profile.partials.delete-user-form')
    </div>

    <x-slot name="scripts">
        <script>
            function previewImage() {
                const image = document.querySelector('#image');
                const imagePreview = document.querySelector('.image-preview');
                const oFReader = new FileReader();

                oFReader.readAsDataURL(image.files[0]);
                oFReader.onload = function(oFREvent) {
                    imagePreview.src = oFREvent.target.result;
                }
            }
        </script>
    </x-slot>
</x-app-layout>
