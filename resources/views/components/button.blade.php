@props(['type'])

<button {{ $attributes->merge(['type' => $type ?? 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-3.5 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out border border-transparent rounded-lg focus:ring-indigo-600/20 focus:ring-opacity-80 focus:outline-none focus:ring focus:ring-offset-2', 'role' => 'button']) }}>
    {{ $slot }}
</button>
