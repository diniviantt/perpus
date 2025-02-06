@props(['to', 'icon', 'text', 'active'])

<li class="item {{ $active ?? '' }}">
    <a href="{{ $to ?? '#' }}" class="menu {{ $active ?? '' }}">
        <i class="{{ $icon ?? '' }} icon"></i>
        {{ $text ?? __('Menu') }}
    </a>
</li>
