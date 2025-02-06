<div class="relative inline-block text-left dropdown-container">
    <button id="dropdownButton-{{ $model->model_id }}" onclick="onClickDD({{ $model->model_id }})"
        class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md">
        <!-- Icon untuk dropdown -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
        </svg>
    </button>

    <div id="dropdownMenu-{{ $model->model_id }}"
        class="absolute min-w-10 z-10 top-[26px] hidden bg-white shadow-xl dropdown-p">
        <div class="py-1" role="menu" aria-orientation="vertical">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                Edit
            </a>
            <a href="javascript:void(0)" onclick="confirmDelete('{{ $model->model_id }}')"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                Hapus
            </a>
        </div>
    </div>
</div>
