@foreach (['success', 'error', 'warning', 'info'] as $type)
    @if (session($type))
        <div class="flash-msg" data-type="{{ $type }}">
            <div class="flash-inner flash-{{ $type }}">
                <span>{{ session($type) }}</span>
                <button onclick="this.closest('.flash-msg').remove()" aria-label="Tutup">&times;</button>
            </div>
        </div>
    @endif
@endforeach
