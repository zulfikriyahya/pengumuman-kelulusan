@extends('layouts.app')
@section('title', 'Surat Undangan — ' . $siswa->nama)

@section('content')
    <div class="max-w-2xl mx-auto">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between mb-5 gap-3 flex-wrap print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}"
                class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 transition group">
                <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Kembali
            </a>
            <a href="{{ route('landing.undangan.pdf', $siswa) }}" target="_blank"
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

            {{-- Isi --}}
            <div class="px-8 py-6 font-serif text-[13px] leading-relaxed">

                {{-- Nomor & Hal --}}
                <table class="mb-5 text-sm">
                    <tr>
                        <td class="pr-2 text-gray-500 w-24 align-top">Nomor</td>
                        <td class="pr-1 align-top">:</td>
                        <td>{{ $instansi?->nomor_surat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-2 text-gray-500 align-top">Hal</td>
                        <td class="pr-1 align-top">:</td>
                        <td>Undangan Wisuda &amp; Pengambilan Ijazah</td>
                    </tr>
                </table>

                <h2 class="text-center text-base font-bold uppercase underline underline-offset-4 tracking-wider mb-6">
                    Surat Undangan
                </h2>

                <p class="mb-4 text-justify indent-8">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh.
                </p>

                <p class="mb-4 text-justify indent-8">
                    Dengan hormat, kami mengundang Bapak/Ibu
                    <strong>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</strong>
                    beserta putra/putri atas nama
                    <strong>{{ $siswa->nama }}</strong> (NISN: {{ $siswa->nisn }})
                    untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah yang akan dilaksanakan pada:
                </p>

                @php
                    $tp = $tahunPelajaran;
                    $adaJadwal =
                        $tp?->jadwal_kelulusan_mulai && $tp?->jadwal_kelulusan_selesai && $tp?->jadwal_kelulusan_tempat;
                @endphp

                @if ($adaJadwal)
                    <table class="mb-5 text-sm ml-8">
                        <tr>
                            <td class="pr-2 text-gray-500 w-36 align-top">Hari / Tanggal</td>
                            <td class="pr-1 align-top">:</td>
                            <td>{{ $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="pr-2 text-gray-500 align-top">Waktu</td>
                            <td class="pr-1 align-top">:</td>
                            <td>
                                {{ $tp->jadwal_kelulusan_mulai->format('H:i') }} –
                                {{ $tp->jadwal_kelulusan_selesai->format('H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <td class="pr-2 text-gray-500 align-top">Tempat</td>
                            <td class="pr-1 align-top">:</td>
                            <td>{{ $tp->jadwal_kelulusan_tempat }}</td>
                        </tr>
                    </table>
                @else
                    <div class="mb-5 ml-8 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-xs text-yellow-700">
                        Jadwal acara belum ditentukan. Pantau informasi dari sekolah.
                    </div>
                @endif

                <p class="mb-4 text-justify indent-8">
                    Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.
                </p>
                <p class="mb-6 text-justify">
                    Wassalamu'alaikum Warahmatullahi Wabarakatuh.
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

                {{-- QR Code --}}
                @if ($siswa->barcode_url)
                    <div class="mt-8 pt-6 border-t border-dashed border-gray-200 flex flex-col items-center gap-2">
                        <img src="{{ $siswa->barcode_url }}" alt="QR Code" class="w-24 h-24 object-contain">
                        <p class="text-xs text-gray-400">Scan QR untuk verifikasi kehadiran di lokasi</p>
                    </div>
                @endif

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4 print:hidden">
            Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
        </p>
    </div>
@endsection
