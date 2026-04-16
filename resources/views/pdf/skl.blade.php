{{-- ════════════════════════════════════════════════════
     resources/views/pdf/skl.blade.php
     Surat Keterangan Lulus (DomPDF)
     Render via: Pdf::loadView('pdf.skl', compact('siswa','instansi','tahunPelajaran'))
════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SKL - {{ $siswa->nama }}</title>
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
            line-height: 1.6;
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
            letter-spacing: 0.5px;
        }

        .kop-text p {
            font-size: 10pt;
            color: #444;
            margin-top: 2px;
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
            width: 5cm;
            color: #555;
        }

        table.nomor td.sep {
            width: 0.3cm;
        }

        /* DATA SISWA */
        table.data {
            width: 100%;
            margin-bottom: 16px;
            font-size: 11pt;
            border-collapse: collapse;
        }

        table.data td {
            padding: 3px 6px 3px 0;
            vertical-align: top;
        }

        table.data td.label {
            width: 5.5cm;
            color: #555;
        }

        table.data td.sep {
            width: 0.3cm;
        }

        table.data td.val {
            font-weight: bold;
        }

        /* PARAGRAF */
        .isi p {
            text-indent: 1.5cm;
            margin-bottom: 10px;
            text-align: justify;
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
            <td class="sep">:</td>
            <td>{{ $instansi->nomor_surat ?? '-' }}</td>
        </tr>
    </table>

    <h2 class="judul">Surat Keterangan Lulus</h2>

    <div class="isi">
        <p>
            Yang bertanda tangan di bawah ini, Kepala {{ $instansi->nama }},
            menerangkan bahwa siswa berikut:
        </p>
    </div>

    {{-- DATA SISWA --}}
    <table class="data">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nama }}</td>
        </tr>
        <tr>
            <td class="label">NISN</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nisn }}</td>
        </tr>
        @if ($siswa->nama_orangtua)
            <tr>
                <td class="label">Nama Orang Tua / Wali</td>
                <td class="sep">:</td>
                <td class="val">{{ $siswa->nama_orangtua }}</td>
            </tr>
        @endif
        <tr>
            <td class="label">Tahun Pelajaran</td>
            <td class="sep">:</td>
            <td class="val">{{ $tahunPelajaran->name }}</td>
        </tr>
    </table>

    @php
        use App\Enums\StatusSiswa;
        $statusText = match ($siswa->status) {
            StatusSiswa::Lulus => 'dinyatakan <b>LULUS</b> dari satuan pendidikan',
            StatusSiswa::LulusBersyarat => 'dinyatakan <b>LULUS BERSYARAT</b> dari satuan pendidikan',
            StatusSiswa::TidakLulus => 'dinyatakan <b>TIDAK LULUS</b> dari satuan pendidikan',
        };
    @endphp

    <div class="isi">
        <p>
            Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan
            {!! $statusText !!} {{ $instansi->nama }} Tahun Pelajaran {{ $tahunPelajaran->name }}.
        </p>
        <p>
            Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk
            dapat digunakan sebagaimana mestinya.
        </p>
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
            <p>Scan untuk verifikasi kehadiran</p>
        </div>
    @endif

</body>

</html>
