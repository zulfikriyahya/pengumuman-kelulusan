@extends('layouts.app')
@section('title', 'Surat Undangan — ' . $siswa->nama)

@push('styles')
    @include('partials._doc-styles')
@endpush

@section('content')
    <div class="doc-wrap">
        <div class="doc-toolbar print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}" class="doc-back">
                <span>&larr;</span> Kembali
            </a>
            <a href="{{ route('landing.undangan.pdf', $siswa) }}" target="_blank" class="btn btn-primary"
                style="font-size:.82rem;padding:.55rem 1.1rem;">
                Unduh PDF
            </a>
        </div>

        <div class="doc-card">
            <x-kop-surat />

            <div class="doc-body">
                <table class="doc-meta">
                    <tr>
                        <td class="lbl">Nomor</td>
                        <td class="sep">:</td>
                        <td>{{ $instansi?->nomor_surat ?? '&mdash;' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Hal</td>
                        <td class="sep">:</td>
                        <td>Undangan Wisuda &amp; Pengambilan Ijazah</td>
                    </tr>
                </table>

                <h2 class="doc-title">Surat Undangan</h2>

                <p class="doc-para">Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh.</p>

                <p class="doc-para">
                    Dengan hormat, kami mengundang Bapak/Ibu
                    <strong>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</strong>
                    beserta putra/putri atas nama <strong>{{ $siswa->nama }}</strong>
                    (NISN: {{ $siswa->nisn }}) untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah
                    yang akan dilaksanakan pada:
                </p>

                @php
                    $tp        = $tahunPelajaran;
                    $adaJadwal = $tp?->jadwal_kelulusan_mulai
                              && $tp?->jadwal_kelulusan_selesai
                              && $tp?->jadwal_kelulusan_tempat;
                @endphp

                @if ($adaJadwal)
                    <table class="doc-jadwal">
                        <tr>
                            <td class="lbl">Hari / Tanggal</td>
                            <td>:</td>
                            <td>{{ $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Waktu</td>
                            <td>:</td>
                            <td>{{ $tp->jadwal_kelulusan_mulai->format('H:i') }} &ndash;
                                {{ $tp->jadwal_kelulusan_selesai->format('H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="lbl">Tempat</td>
                            <td>:</td>
                            <td>{{ $tp->jadwal_kelulusan_tempat }}</td>
                        </tr>
                    </table>
                @else
                    <div class="doc-alert">Jadwal acara belum ditentukan. Pantau informasi dari madrasah.</div>
                @endif

                <p class="doc-para">Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
                <p class="doc-para">Wassalamu&rsquo;alaikum Warahmatullahi Wabarakatuh.</p>

                <x-ttd />

                <div class="qr-block">
                    {!! QrCode::size(100)->format('svg')->generate($siswa->id) !!}
                    <p>Scan QR ini saat registrasi kehadiran &bull; {{ $siswa->nisn }}</p>
                </div>
            </div>
        </div>

        <p class="doc-note print:hidden">
            Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
        </p>
    </div>
@endsection
