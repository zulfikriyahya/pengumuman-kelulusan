@if ($items->isEmpty())
    <div class="empty-state">
        <p class="empty-title">Tidak ada data{{ isset($keyword) ? ' untuk &ldquo;' . e($keyword) . '&rdquo;' : '' }}.</p>
        @if (isset($keyword))
            <a href="{{ url()->current() }}" class="empty-link">Lihat semua &rarr;</a>
        @endif
    </div>
@else
    <div class="people-grid">
        @foreach ($items as $p)
            @php $photo = $p->{$photoKey} ?? null; @endphp
            <div class="card card-hover person-card reveal">
                <div class="avatar-wrap">
                    @if ($photo)
                        <img src="{{ Storage::url($photo) }}" alt="{{ $p->nama }}" class="avatar-img">
                    @else
                        <div class="avatar-fallback">{{ strtoupper(mb_substr($p->nama, 0, 1)) }}</div>
                    @endif
                </div>

                <div class="person-name">{{ $p->nama }}</div>

                <div class="person-sub" @if (!empty($subColor)) style="color:{{ $subColor }}" @endif>
                    {{ $subPrefix ?? '' }}{{ $p->{$subKey} ?? '' }}
                </div>

                @if (!empty($monoKey) && $p->{$monoKey})
                    <div class="person-mono">{{ $p->{$monoKey} }}</div>
                @endif

                @if ($p->quote ?? null)
                    <div class="person-quote">&ldquo;{{ $p->quote }}&rdquo;</div>
                @endif

                @if ($p->sosial_media ?? null)
                    <a href="{{ $p->sosial_media }}" target="_blank" rel="noopener" class="person-link">Sosial
                        Media</a>
                @endif
            </div>
        @endforeach
    </div>

    @if (method_exists($items, 'links'))
        <div class="pagination-wrap">{{ $items->links() }}</div>
    @endif
@endif
