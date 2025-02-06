@if (session()->has('status'))
    <div
        {{ $attributes->merge(['class' => 'p-2 text-sm font-medium text-center text-indigo-600 border border-indigo-300 rounded-lg bg-indigo-50']) }}>
        {!! session('status') !!}
    </div>
@endif

@if (session()->has('err'))
    <div
        {{ $attributes->merge(['class' => 'p-2 text-sm font-medium text-center text-red-600 border border-red-300 rounded-lg bg-red-50']) }}>
        {!! session('err') !!}
    </div>
@endif
