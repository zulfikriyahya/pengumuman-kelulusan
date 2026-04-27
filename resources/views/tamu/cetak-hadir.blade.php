<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir Tamu Undangan</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            color: #1a1a1a;
            padding: 1.5cm 2cm;
            line-height: 1.6;
        }
        .kop {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 4px double #1a1a1a;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }
        .kop img { height: 70px; width: 70px; object-fit: contain; }
        .kop-text { flex: 1; text-align: center; }
        .kop-text h1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; letter-spacing: .4px; }
        .kop-text p { font-size: 10pt; color: #444; margin-top: 2px; }
        h2.judul {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 16px 0 4px;
        }
        .sub-judul { text-align: center; font-size: 10pt; color: #555; margin-bottom: 16px; }
        table.daftar {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        table.daftar th {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
        }
        table.daftar td {
            border: 1px solid #d1d5db;
            padding: 5px 8px;
            vertical-align: top;
        }
        table.daftar tr:nth-child(even) td { background: #fafafa; }
        .ttd-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
        }
        .ttd-box { text-align: center; width: 6.5cm; font-size: 10pt; }
        .ttd-box .ttd-space { height: 60px; }
        .ttd-box .nama { font-weight: bold; text-decoration: underline; }
        .ttd-box .nip { font-size: 9pt; color: #444; }
        .summary { margin: 0 0 14px; font-size: 10pt; color: #444; }
        .no-print { text-align: center; padding: 1rem; }
        .no-print button {
            padding: .5rem 1.5rem; background: #0d9488; color: #fff;
            border: none; border-radius: 6px; font-size: 1rem; cursor: pointer;
        }
        @media print {
            .no-print { display: none; }
            @page { margin: 0; }
            body { padding: 1.5cm 2cm; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="kop">
        @if ($instansi?->logo_institusi)
            <img src="{{ public_path('storage/' . $instansi->logo_institusi) }}" alt="Logo">
        @endif
        <div class="kop-text">
            <h1>{{ $instansi?->nama }}</h1>
            <p>NPSN: {{ $instansi?->npsn }}
                @if ($instansi?->akreditasi) &bull; Akreditasi: {{ $instansi->akreditasi }} @endif
            </p>
        </div>
    </div>

    <h2 class="judul">Daftar Hadir Tamu Undangan</h2>
    <p class="sub-judul">Acara Wisuda &amp; Pengambilan Ijazah &bull; Dicetak {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>

    <p class="summary">
        Total Siswa Hadir: <strong>{{ $tamus->count() }}</strong> &nbsp;&bull;&nbsp;
        Total Tamu (PAX): <strong>{{ $totalPax }}</strong>
    </p>

    <table class="daftar">
        <thead>
            <tr>
                <th style="width:2rem">No.</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Nama Orang Tua / Wali</th>
                <th style="text-align:center;width:3.5rem">PAX</th>
                <th style="width:4.5rem">Waktu</th>
                <th style="width:5rem">TTD</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tamus as $i => $t)
                <tr>
                    <td style="text-align:center">{{ $i + 1 }}</td>
                    <td>{{ $t->siswa?->nama ?? '-' }}</td>
                    <td style="font-family:monospace">{{ $t->siswa?->nisn ?? '-' }}</td>
                    <td>{{ $t->siswa?->nama_orangtua ?? '-' }}</td>
                    <td style="text-align:center">{{ $t->jumlah_tamu }}</td>
                    <td>{{ $t->created_at->format('H:i') }}</td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:1.5rem;color:#9ca3af;">
                        Belum ada tamu yang tercatat.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($tamus->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="4" style="font-weight:bold;text-align:right;padding:6px 8px;">Total</td>
                <td style="font-weight:bold;text-align:center">{{ $totalPax }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="ttd-section">
        <div class="ttd-box">
            <p>{{ $instansi?->nama }}, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Panitia Wisuda</p>
            @if ($instansi?->tte_pimpinan)
                <img src="{{ public_path('storage/' . $instansi->tte_pimpinan) }}" alt="TTD"
                    style="height:60px;margin:6px auto;display:block;object-fit:contain;">
            @else
                <div class="ttd-space"></div>
            @endif
            <p class="nama">{{ $instansi?->nama_pimpinan }}</p>
            @if ($instansi?->nip_pimpinan)
                <p class="nip">NIP. {{ $instansi->nip_pimpinan }}</p>
            @endif
        </div>
    </div>

</body>
</html>
