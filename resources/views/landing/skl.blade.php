@extends('layouts.app')
@section('title', 'SKL — ' . $siswa->nama)

@push('styles')
    @include('partials._doc-styles')
@endpush

@section('content')
    <div class="doc-wrap">
        <div class="doc-toolbar print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}" class="doc-back">
                <span>&larr;</span> Kembali
            </a>
            <a href="{{ route('landing.skl.pdf', $siswa) }}" target="_blank" class="btn btn-primary"
                style="font-size:.82rem;padding:.55rem 1.1rem;">
                Unduh PDF
            </a>
        </div>

        <div class="doc-card">
            <div class="kop-surat">
                @include('partials._kop-surat')
            </div>

            <div class="doc-body">
                <table class="doc-meta">
                    <tr>
                        <td class="lbl">Nomor</td>
                        <td class="sep">:</td>
                        <td>{{ $instansi?->nomor_surat ?? '&mdash;' }}</td>
                    </tr>
                </table>

                <h2 class="doc-title">Surat Keterangan Lulus</h2>

                <p class="doc-para">Yang bertanda tangan di bawah ini, Kepala {{ $instansi?->nama }}, menerangkan bahwa
                    siswa berikut:</p>

                <table class="doc-data">
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
                            <td class="lbl">Nama Orang Tua</td>
                            <td class="sep">:</td>
                            <td class="val">{{ $siswa->nama_orangtua }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="lbl">Tahun Pelajaran</td>
                        <td class="sep">:</td>
                        <td class="val">{{ $tahunPelajaran?->name ?? '&mdash;' }}</td>
                    </tr>
                </table>

                @php
                    use App\Enums\StatusSiswa;
                    $statusText = match ($siswa->status) {
                        StatusSiswa::Lulus => 'dinyatakan <strong>LULUS</strong> dari satuan pendidikan',
                        StatusSiswa::LulusBersyarat
                            => 'dinyatakan <strong>LULUS BERSYARAT</strong> dari satuan pendidikan',
                        StatusSiswa::TidakLulus => 'dinyatakan <strong>TIDAK LULUS</strong> dari satuan pendidikan',
                    };
                @endphp

                <p class="doc-para">
                    Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan {!! $statusText !!}
                    {{ $instansi?->nama }} Tahun Pelajaran {{ $tahunPelajaran?->name ?? '&mdash;' }}.
                </p>

                <p class="doc-para">Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat digunakan
                    sebagaimana mestinya.</p>

                @include('partials._ttd')
            </div>
        </div>

        <p class="doc-note print:hidden">Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
        </p>
    </div>
@endsection
