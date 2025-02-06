@props(['to', 'text', 'active'])

<li class="item {{ $active ?? '' }}">
    <a href="{{ $to ?? '#' }}" class="{{ $active ?? '' }}">{{ $text ?? __('Submenu') }}</a>
</li>
