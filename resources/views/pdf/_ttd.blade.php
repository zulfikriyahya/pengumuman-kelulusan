<div class="ttd">
    <div class="ttd-box">
        <p>{{ $instansi->nama }},<br>{{ now()->translatedFormat('d F Y') }}</p>
        @if ($instansi->tte_pimpinan)
            <img src="{{ public_path('storage/' . $instansi->tte_pimpinan) }}" alt="TTD">
        @else
            <div style="height:72px;"></div>
        @endif
        <p class="nama">{{ $instansi->nama_pimpinan }}</p>
        @if ($instansi->nip_pimpinan)
            <p class="nip">NIP. {{ $instansi->nip_pimpinan }}</p>
        @endif
    </div>
</div>
