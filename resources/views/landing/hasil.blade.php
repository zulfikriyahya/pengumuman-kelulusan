@extends('layouts.app')
@section('title', $siswa ? 'Hasil — ' . $siswa->nama : 'Siswa Tidak Ditemukan')

@section('content')
    <div class="max-w-lg mx-auto">

        {{-- Kembali --}}
        <a href="{{ route('landing') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 mb-5 transition group">
            <span class="group-hover:-translate-x-0.5 transition-transform">←</span>
            Kembali ke Pencarian
        </a>

        {{-- ══ Tidak ditemukan ══ --}}
        @if (!$siswa)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-10 text-center">
                <p class="text-5xl mb-4">🔍</p>
                <h2 class="font-bold text-gray-700 text-lg mb-1">Data Tidak Ditemukan</h2>
                <p class="text-sm text-gray-400 mb-6">
                    Tidak ada siswa dengan NISN atau nomor telepon
                    <span class="font-mono font-semibold text-gray-600">"{{ $keyword }}"</span>.
                </p>
                <a href="{{ route('landing') }}"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700
                      text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition active:scale-[0.98]">
                    ← Coba Lagi
                </a>
            </div>

            {{-- ══ Ditemukan ══ --}}
        @else
            @php
                [$bgCard, $bgBadge, $textColor, $icon] = match ($siswa->status) {
                    \App\Enums\StatusSiswa::Lulus => ['from-green-50 to-white', 'bg-green-600', 'text-green-700', '🎓'],
                    \App\Enums\StatusSiswa::TidakLulus => ['from-red-50 to-white', 'bg-red-500', 'text-red-700', '📋'],
                    \App\Enums\StatusSiswa::LulusBersyarat => [
                        'from-yellow-50 to-white',
                        'bg-yellow-500',
                        'text-yellow-700',
                        '⚠️',
                    ],
                };
            @endphp

            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

                {{-- Header --}}
                <div class="bg-gradient-to-br {{ $bgCard }} px-6 py-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div
                            class="{{ $bgBadge }} text-white rounded-2xl h-14 w-14 flex items-center justify-center text-2xl shadow-md flex-shrink-0">
                            {{ $icon }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-widest mb-0.5">Status Kelulusan</p>
                            <p class="text-xl font-bold {{ $textColor }}">{{ $siswa->status->label() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Info Siswa --}}
                <div class="px-6 py-5 space-y-3 text-sm">
                    @foreach ([
            'Nama Siswa' => $siswa->nama,
            'NISN' => $siswa->nisn,
            'Nama Orang Tua' => $siswa->nama_orangtua,
        ] as $label => $val)
                        @if ($val)
                            <div class="flex justify-between items-baseline gap-4">
                                <span class="text-gray-400 flex-shrink-0">{{ $label }}</span>
                                <span
                                    class="font-medium text-right {{ $label === 'NISN' ? 'font-mono' : '' }}">{{ $val }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mx-6 border-t border-dashed border-gray-100"></div>

                {{-- Aksi --}}
                <div class="px-6 py-5 flex flex-col gap-2.5">

                    {{-- SKL --}}
                    @if ($siswa->berkas_skl)
                        <a href="{{ route('landing.skl', $siswa) }}" target="_blank"
                            class="flex items-center justify-center gap-2
                          bg-green-600 hover:bg-green-700 active:scale-[0.98]
                          text-white font-semibold py-3 rounded-xl text-sm transition-all
                          shadow-sm shadow-green-200">
                            <span>📄</span> Unduh Surat Keterangan Lulus
                        </a>
                    @else
                        <div
                            class="flex items-center gap-2 justify-center bg-gray-50 border border-dashed
                            border-gray-200 rounded-xl py-3 text-xs text-gray-400">
                            <span>🕐</span> Dokumen SKL belum tersedia — hubungi sekolah
                        </div>
                    @endif

                    {{-- Surat Undangan (Lulus & Lulus Bersyarat) --}}
                    @if ($siswa->isLulus())
                        <a href="{{ route('landing.undangan', $siswa) }}" target="_blank"
                            class="flex items-center justify-center gap-2
                          bg-white border border-green-300 text-green-700
                          hover:bg-green-50 active:scale-[0.98]
                          font-semibold py-3 rounded-xl text-sm transition-all">
                            <span>🎟️</span> Cetak Surat Undangan Kelulusan
                        </a>
                    @endif

                </div>
            </div>

            @if ($siswa->status === \App\Enums\StatusSiswa::Lulus)
                <p class="text-center text-xs text-gray-400 mt-4">
                    🎉 Selamat! Semoga sukses di jenjang berikutnya.
                </p>
            @elseif($siswa->status === \App\Enums\StatusSiswa::LulusBersyarat)
                <p class="text-center text-xs text-yellow-500 mt-4">
                    ⚠️ Segera hubungi sekolah untuk informasi lebih lanjut.
                </p>
            @endif
        @endif

    </div>
@endsection
