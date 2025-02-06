<x-card>
    <header class="mb-4">
        <h2 class="text-lg font-bold">
            {{ __('Delete Account') }}
        </h2>
    
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <form action="{{ route('profile.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        
        <x-button onclick="return confirm('Are you sure you want to delete your account?')" class="bg-red-600 hover:bg-red-500 focus:bg-red-500 active:bg-red-700">
            {{ __('Delete Account') }}
        </x-button>
    </form>
</x-card>
