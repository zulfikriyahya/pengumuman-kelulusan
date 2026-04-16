<div class="kop-surat">
    @if ($instansi?->logo_institusi)
        <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="">
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
