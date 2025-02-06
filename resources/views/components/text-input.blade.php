@props(['type'])

<input {{ $attributes->merge(['type' => $type ?? 'text', 'class' => 'w-full block py-3 px-4 rounded-lg text-sm text-indigo-700 shrink truncate transition-all duration-300 ease-in-out bg-white border border-gray-400 focus:outline-none focus:ring focus:ring-indigo-600/20 focus:border-indigo-500 placeholder:text-sm placeholder:text-slate-300']) }} />
