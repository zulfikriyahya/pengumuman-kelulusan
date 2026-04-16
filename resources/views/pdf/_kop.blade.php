<div class="kop">
    @if ($instansi->logo_institusi)
        <img src="{{ public_path('storage/' . $instansi->logo_institusi) }}" alt="">
    @endif
    <div class="kop-text">
        <h1>{{ $instansi->nama }}</h1>
        <p>NPSN: {{ $instansi->npsn }}
            @if ($instansi->akreditasi) &bull; Akreditasi: {{ $instansi->akreditasi }} @endif
        </p>
    </div>
</div>
