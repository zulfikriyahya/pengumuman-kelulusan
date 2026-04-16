@extends('layouts.app')
@section('title', 'SKL — ' . $siswa->nama)

@section('content')
    <div class="max-w-2xl mx-auto">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between mb-5 gap-3 flex-wrap print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}"
                class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 transition group">
                <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Kembali
            </a>
            <a href="{{ route('landing.skl.pdf', $siswa) }}" target="_blank"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 active:scale-[0.98]
                  text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm shadow-green-200">
                ⬇ Unduh PDF
            </a>
        </div>

        {{-- Preview Card --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            {{-- Kop Surat --}}
            <div class="flex items-center gap-4 px-8 pt-8 pb-5 border-b-4 border-double border-gray-800">
                @if ($instansi?->logo_institusi)
                    <img src="{{ Storage::url($instansi->logo_institusi) }}" alt=""
                        class="h-20 w-20 object-contain flex-shrink-0">
                @endif
                <div class="flex-1 text-center">
                    <h1 class="text-xl font-bold uppercase tracking-wide">{{ $instansi?->nama }}</h1>
                    <p class="text-xs text-gray-500 mt-0.5">
                        NPSN: {{ $instansi?->npsn ?? '-' }}
                        @if ($instansi?->akreditasi)
                            &nbsp;·&nbsp; Akreditasi: {{ $instansi->akreditasi }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Isi SKL --}}
            <div class="px-8 py-6 font-serif text-[13px] leading-relaxed">

                <h2 class="text-center text-base font-bold uppercase underline underline-offset-4 tracking-wider mb-6">
                    Surat Keterangan Lulus
                </h2>

                {{-- Nomor --}}
                <table class="mb-4 text-sm">
                    <tr>
                        <td class="pr-2 text-gray-500 w-24 align-top">Nomor</td>
                        <td class="pr-1 align-top">:</td>
                        <td>{{ $instansi?->nomor_surat ?? '-' }}</td>
                    </tr>
                </table>

                <p class="mb-4 text-justify indent-8">
                    Yang bertanda tangan di bawah ini, Kepala {{ $instansi?->nama }},
                    menerangkan bahwa siswa berikut:
                </p>

                {{-- Data Siswa --}}
                <table class="mb-4 w-full text-sm">
                    @php
                        $rows = [
                            'Nama Lengkap' => $siswa->nama,
                            'NISN' => $siswa->nisn,
                            'Tahun Pelajaran' => $tahunPelajaran?->name ?? '-',
                        ];
                    @endphp
                    @foreach ($rows as $lbl => $val)
                        <tr>
                            <td class="py-0.5 text-gray-500 w-44 align-top">{{ $lbl }}</td>
                            <td class="py-0.5 w-3 align-top">:</td>
                            <td class="py-0.5 font-medium">{{ $val }}</td>
                        </tr>
                    @endforeach
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

                <p class="mb-4 text-justify indent-8">
                    Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan
                    {!! $statusText !!} {{ $instansi?->nama }} Tahun Pelajaran {{ $tahunPelajaran?->name ?? '-' }}.
                </p>

                <p class="mb-6 text-justify indent-8">
                    Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk
                    dapat digunakan sebagaimana mestinya.
                </p>

                {{-- TTD --}}
                <div class="flex justify-end mt-6">
                    <div class="text-center w-56">
                        <p>{{ $instansi?->nama }},
                            {{ now()->translatedFormat('d F Y') }}</p>
                        @if ($instansi?->tte_pimpinan)
                            <img src="{{ Storage::url($instansi->tte_pimpinan) }}" alt="TTD"
                                class="h-16 mx-auto my-2 object-contain">
                        @else
                            <div class="h-16"></div>
                        @endif
                        <p class="font-bold underline">{{ $instansi?->nama_pimpinan }}</p>
                        @if ($instansi?->nip_pimpinan)
                            <p class="text-xs text-gray-500">NIP. {{ $instansi->nip_pimpinan }}</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4 print:hidden">
            Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
        </p>
    </div>
@endsection
