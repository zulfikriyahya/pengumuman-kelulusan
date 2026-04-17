<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SKL - {{ $siswa->nama }}</title>
    @include('pdf._base-styles')
</head>

<body>
    @include('pdf._kop')

    <table class="nomor">
        <tr>
            <td class="lbl">Nomor</td>
            <td class="sep">:</td>
            <td>{{ $instansi->nomor_surat ?? '-' }}</td>
        </tr>
    </table>

    <h2 class="judul">Surat Keterangan Lulus</h2>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini, Kepala {{ $instansi->nama }}, menerangkan bahwa siswa berikut:</p>
    </div>

    <table class="data">
        <tr>
            <td class="lbl">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nama }}</td>
        </tr>
        <tr>
            <td class="lbl">NISN</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nisn }}</td>
        </tr>
        @if ($siswa->nama_orangtua)
            <tr>
                <td class="lbl">Nama Orang Tua / Wali</td>
                <td class="sep">:</td>
                <td class="val">{{ $siswa->nama_orangtua }}</td>
            </tr>
        @endif
        <tr>
            <td class="lbl">Tahun Pelajaran</td>
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
        <p>Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan {!! $statusText !!}
            {{ $instansi->nama }} Tahun Pelajaran {{ $tahunPelajaran->name }}.</p>
        <p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat digunakan sebagaimana mestinya.</p>
    </div>

    @include('pdf._ttd')

</body>

</html>
