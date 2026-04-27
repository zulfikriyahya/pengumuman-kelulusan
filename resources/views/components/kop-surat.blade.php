@props(['forPdf' => false])
@php
    $logoSrc = $instansi?->logo_institusi
        ? ($forPdf
            ? public_path('storage/' . $instansi->logo_institusi)
            : Storage::url($instansi->logo_institusi))
        : null;
@endphp

<div class="kop-surat">
    @if ($logoSrc)
        <img src="{{ $logoSrc }}" alt="">
    @endif
    <div class="kop-text">
        <h1>{{ $instansi?->nama }}</h1>
        <p>
            NPSN: {{ $instansi?->npsn ?? '&mdash;' }}
            @if ($instansi?->akreditasi)
                &nbsp;&middot;&nbsp; Akreditasi: {{ $instansi->akreditasi }}
            @endif
        </p>
    </div>
</div>
