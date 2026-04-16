{{-- ════════════════════════════════════════════════════
     resources/views/pdf/undangan.blade.php
     Surat Undangan Kelulusan (DomPDF)
     Render via: Pdf::loadView('pdf.undangan', compact('siswa','instansi','tahunPelajaran'))
════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Undangan - {{ $siswa->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #1a1a1a;
            padding: 1.5cm 2cm 2cm;
            line-height: 1.7;
        }

        /* KOP */
        .kop {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 4px double #1a1a1a;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .kop img {
            height: 80px;
            width: 80px;
            object-fit: contain;
        }

        .kop-text {
            flex: 1;
            text-align: center;
        }

        .kop-text h1 {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text p {
            font-size: 10pt;
            color: #444;
            margin-top: 2px;
        }

        /* NOMOR */
        table.nomor {
            margin-bottom: 16px;
            font-size: 11pt;
        }

        table.nomor td {
            padding: 2px 6px 2px 0;
            vertical-align: top;
        }

        table.nomor td.label {
            width: 2cm;
            color: #555;
        }

        /* JUDUL */
        h2.judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 18px 0 20px;
        }

        /* ISI */
        .isi p {
            text-indent: 1.5cm;
            margin-bottom: 10px;
            text-align: justify;
        }

        /* JADWAL */
        table.jadwal {
            margin: 4px 0 16px 1.5cm;
            font-size: 11pt;
        }

        table.jadwal td {
            padding: 3px 6px 3px 0;
            vertical-align: top;
        }

        table.jadwal td.label {
            width: 4.5cm;
            color: #555;
        }

        /* TTD */
        .ttd {
            display: flex;
            justify-content: flex-end;
            margin-top: 32px;
        }

        .ttd-box {
            text-align: center;
            width: 7cm;
            font-size: 11pt;
        }

        .ttd-box img {
            height: 72px;
            margin: 6px auto;
            display: block;
            object-fit: contain;
        }

        .ttd-box .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-box .nip {
            font-size: 10pt;
            color: #444;
        }

        /* QR */
        .qr-box {
            margin-top: 28px;
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 14px;
        }

        .qr-box img {
            width: 90px;
            height: 90px;
        }

        .qr-box p {
            font-size: 9pt;
            color: #666;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    {{-- KOP --}}
    <div class="kop">
        @if ($instansi->logo_institusi)
            <img src="{{ public_path('storage/' . $instansi->logo_institusi) }}" alt="">
        @endif
        <div class="kop-text">
            <h1>{{ $instansi->nama }}</h1>
            <p>NPSN: {{ $instansi->npsn }}
                @if ($instansi->akreditasi)
                    &nbsp;&bull;&nbsp; Akreditasi: {{ $instansi->akreditasi }}
                @endif
            </p>
        </div>
    </div>

    {{-- NOMOR --}}
    <table class="nomor">
        <tr>
            <td class="label">Nomor</td>
            <td>:</td>
            <td>{{ $instansi->nomor_surat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Hal</td>
            <td>:</td>
            <td>Undangan Wisuda &amp; Pengambilan Ijazah</td>
        </tr>
    </table>

    <h2 class="judul">Surat Undangan</h2>

    <div class="isi">
        <p>Assalamu'alaikum Warahmatullahi Wabarakatuh.</p>
        <p>
            Dengan hormat, kami mengundang Bapak/Ibu
            <b>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</b>
            beserta putra/putri atas nama
            <b>{{ $siswa->nama }}</b> (NISN: {{ $siswa->nisn }})
            untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah yang akan dilaksanakan pada:
        </p>
    </div>

    @php
        $tp = $tahunPelajaran;
        $adaJadwal = $tp->jadwal_kelulusan_mulai && $tp->jadwal_kelulusan_selesai && $tp->jadwal_kelulusan_tempat;
    @endphp

    @if ($adaJadwal)
        <table class="jadwal">
            <tr>
                <td class="label">Hari / Tanggal</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_mulai->format('H:i') }} –
                    {{ $tp->jadwal_kelulusan_selesai->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_tempat }}</td>
            </tr>
        </table>
    @endif

    <div class="isi">
        <p>Demikian undangan ini kami sampaikan. Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
        <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
    </div>

    {{-- TTD --}}
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

    {{-- QR --}}
    @if ($siswa->barcode_url)
        <div class="qr-box">
            <img src="{{ $siswa->barcode_url }}" alt="QR Code">
            <p>Scan untuk verifikasi kehadiran di lokasi acara</p>
        </div>
    @endif

</body>

</html>
