@if (flash()->message)
<figure class="notification">
    <div class="notification_body">
        @if (!flash()->class || flash()->class == 'success')
            <i class="fa-solid fa-check notification_icon"></i>
        @endif

        @if (flash()->class == 'err')
            <i class="fa-solid fa-triangle-exclamation notification_icon"></i>
        @endif
        
        {!! flash()->message !!}
    </div>
    <div class="notification_progress"></div>
</figure>
@endif
