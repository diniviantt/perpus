@props(['icon', 'text', 'active'])

<li class="item {{ $active ?? '' }}">
    <div class="submenu-item">
        <span class="menu">
            <i class="{{ $icon ?? '' }} icon"></i>
            {{ $text ?? __('Menu') }}
        </span>
        <i class="fa-solid fa-chevron-right"></i>
    </div>
    <ul class="menu-items submenu">
        <div class="menu-title">
            <i class="fa-solid fa-chevron-left"></i>
            {{ $text ?? __('Menu') }}
        </div>
        {{ $slot }}
    </ul>
</li>
