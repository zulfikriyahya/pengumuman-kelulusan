@php
    $isEmpty = method_exists($items, 'isEmpty') ? $items->isEmpty() : $items->count() === 0;
@endphp

@if ($isEmpty)
    <div class="empty-state">
        <p class="empty-title">
            Tidak ada data{{ isset($keyword) ? ' untuk &ldquo;' . e($keyword) . '&rdquo;' : '' }}.
        </p>
        @isset($keyword)
            <a href="{{ url()->current() }}" class="empty-link">Lihat semua &rarr;</a>
        @endisset
    </div>
@else
    <div class="people-grid">
        @foreach ($items as $p)
            @php
                $photo = $p->{$photoKey} ?? null;
                $photoUrl = $photo ? Storage::url($photo) : null;

                /*
                 * Tentukan badge & baris data berdasarkan konteks:
                 *  - alumni  : subKey = tahun_lulus, monoKey = nisn
                 *  - personil: subKey = jabatan
                 */
                $isAlumni = isset($monoKey) && $monoKey === 'nisn';
                $badgeLabel = $isAlumni ? ($subPrefix ?? '') . ($p->{$subKey} ?? '') : $p->{$subKey} ?? '';

                $rows = [];
                if (!$isAlumni && ($p->{$subKey} ?? null)) {
                    $rows[] = ['Jabatan', $p->{$subKey}, false];
                }
                if (!empty($monoKey) && ($p->{$monoKey} ?? null)) {
                    $rows[] = [$isAlumni ? 'NISN' : 'ID', $p->{$monoKey}, true];
                }
                if ($isAlumni && ($p->nama_orangtua ?? null)) {
                    $rows[] = ['Nama Orang Tua', $p->nama_orangtua, false];
                }

                $personData = json_encode(
                    [
                        'nama' => $p->nama,
                        'photo' => $photoUrl,
                        'badge' => $badgeLabel,
                        'badgeGold' => $isAlumni,
                        'quote' => $p->quote ?? null,
                        'sosial' => $p->sosial_media ?? null,
                        'rows' => $rows,
                    ],
                    JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT,
                );
            @endphp

            <div class="card card-hover person-card reveal" data-person="{{ $personData }}"
                title="Lihat detail {{ $p->nama }}">

                <div class="avatar-wrap">
                    @if ($photoUrl)
                        <img src="{{ $photoUrl }}" alt="{{ $p->nama }}" class="avatar-img">
                    @else
                        <div class="avatar-fallback">{{ strtoupper(mb_substr($p->nama, 0, 1)) }}</div>
                    @endif
                </div>

                <div class="person-name">{{ $p->nama }}</div>

                <div class="person-sub" @isset($subColor) style="color:{{ $subColor }}" @endisset>
                    {{ $subPrefix ?? '' }}{{ $p->{$subKey} ?? '' }}
                </div>

                @if (!empty($monoKey) && ($p->{$monoKey} ?? null))
                    <div class="person-mono">{{ $p->{$monoKey} }}</div>
                @endif

                @if ($p->quote ?? null)
                    <div class="person-quote">&ldquo;{{ $p->quote }}&rdquo;</div>
                @endif

                {{-- Tanda klik --}}
                <div class="person-hint">Lihat detail &rsaquo;</div>

            </div>
        @endforeach
    </div>

    @if (method_exists($items, 'links'))
        <div class="pagination-wrap">{{ $items->links() }}</div>
    @endif
@endif
