@props(['forPdf' => false])
@php
    $ttdSrc = $instansi?->tte_pimpinan
        ? ($forPdf
            ? public_path('storage/' . $instansi->tte_pimpinan)
            : Storage::url($instansi->tte_pimpinan))
        : null;
@endphp

<div class="ttd-block">
    <div class="ttd-inner">
        <p>{{ $instansi?->nama }}, {{ now()->translatedFormat('d F Y') }}</p>
        @if ($ttdSrc)
            <img src="{{ $ttdSrc }}" alt="Tanda Tangan">
        @else
            <div class="ttd-space"></div>
        @endif
        <p class="ttd-nama">{{ $instansi?->nama_pimpinan }}</p>
        @if ($instansi?->nip_pimpinan)
            <p class="ttd-nip">NIP. {{ $instansi->nip_pimpinan }}</p>
        @endif
    </div>
</div>
