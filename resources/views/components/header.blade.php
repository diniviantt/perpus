@props(['value'])

<header>
    <h1 {{ $attributes->merge(['class' => 'pt-3 text-2xl md:text-3xl font-semibold pb-9 first-letter:text-indigo-500 first-letter:font-bold']) }}>
        {{ $value ?? $slot }}
    </h1>
</header>
