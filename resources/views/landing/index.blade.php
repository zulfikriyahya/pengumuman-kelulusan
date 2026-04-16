@extends('layouts.app')
@section('title', 'Pengumuman Kelulusan')

@section('content')
    @php
        $tp = $tahunPelajaran ?? null;
        $now = now();
        $belumBuka = $tp && $now->lt($tp->jadwal_pengumuman_mulai);
        $sudahBuka = $tp && $now->gte($tp->jadwal_pengumuman_mulai);
        $sudahTutup = $tp && $now->gt($tp->jadwal_pengumuman_selesai);
    @endphp

    {{-- ── Hero ──────────────────────────────────────────────── --}}
    <section class="text-center py-10 px-4">
        @if ($instansi?->logo_institusi)
            <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="Logo"
                class="h-24 w-24 object-contain mx-auto mb-5 drop-shadow">
        @endif
        <h1 class="text-2xl md:text-3xl font-bold text-green-700 tracking-tight">
            Pengumuman Kelulusan
        </h1>
        <p class="text-gray-400 mt-2 text-sm">
            {{ $instansi?->nama }} &bull; Tahun Pelajaran {{ $tp?->name ?? '-' }}
        </p>
    </section>

    {{-- ══ STATE: Belum ada konfigurasi ══ --}}
    @if (!$tp)
        <section class="flex justify-center py-12 px-4">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl px-8 py-8 max-w-sm text-center shadow-sm">
                <p class="text-4xl mb-3">🏫</p>
                <p class="text-gray-600 font-semibold">Informasi belum tersedia.</p>
                <p class="text-sm text-gray-400 mt-1">Hubungi sekolah untuk informasi lebih lanjut.</p>
            </div>
        </section>

        {{-- ══ STATE 1: Belum buka → Countdown ══ --}}
    @elseif($belumBuka)
        <section class="text-center py-8 px-4">
            <div class="inline-block bg-white rounded-2xl shadow-md px-8 py-6 mb-8 border border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Pengumuman dibuka pada</p>
                <p class="font-semibold text-green-700 text-sm">
                    {{ $tp->jadwal_pengumuman_mulai->translatedFormat('l, d F Y · H:i') }} WIB
                </p>
            </div>

            <div class="flex justify-center gap-3">
                @foreach (['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $key => $label)
                    <div class="bg-white shadow-md rounded-2xl px-5 py-4 min-w-[72px] border border-gray-100">
                        <span id="cd-{{ $key }}" class="text-3xl font-bold text-green-700 tabular-nums">00</span>
                        <p class="text-xs text-gray-400 mt-1">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-gray-400 mt-6">
                Pastikan kamu kembali tepat waktu ya 😊
            </p>
        </section>

        {{-- ══ STATE 2: Sudah tutup ══ --}}
    @elseif($sudahTutup)
        <section class="flex justify-center py-12 px-4">
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl px-8 py-8 max-w-sm text-center shadow-sm">
                <p class="text-4xl mb-3">📋</p>
                <p class="text-yellow-700 font-semibold">Periode pengumuman telah berakhir.</p>
                <p class="text-sm text-gray-500 mt-1">Hubungi sekolah untuk informasi lebih lanjut.</p>
            </div>
        </section>

        {{-- ══ STATE 3: Sedang buka → Amplop + Pencarian ══ --}}
    @elseif($sudahBuka)
        {{-- Amplop --}}
        <section class="flex justify-center my-4 px-4" id="amplop-section">
            <div class="flex flex-col items-center">
                <button onclick="bukaAmplop()" id="amplop-btn" class="group focus:outline-none"
                    aria-label="Klik untuk membuka amplop">
                    <div id="amplop"
                        class="relative w-72 h-48 transition-all duration-500 group-hover:scale-105 group-hover:-translate-y-1 drop-shadow-xl">
                        <svg viewBox="0 0 288 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect width="288" height="192" rx="14" fill="#16a34a" />
                            <path d="M0 192 L144 112 L288 192Z" fill="#15803d" />
                            <path d="M288 20 L288 192 L144 112Z" fill="#14532d" fill-opacity="0.3" />
                            <path d="M0 20 L0 192 L144 112Z" fill="#14532d" fill-opacity="0.2" />
                            <path id="amplop-lid" d="M0 20 L144 108 L288 20 L288 0 L0 0 Z" fill="#166534"
                                style="transform-origin:50% 0%;transition:transform .5s ease,opacity .5s ease;" />
                            <path d="M0 20 L144 108 L288 20" stroke="#bbf7d0" stroke-width="1.5" fill="none"
                                opacity="0.5" />
                            <text x="144" y="158" text-anchor="middle" fill="white" font-size="12"
                                font-family="Inter,sans-serif" font-weight="600" opacity="0.9">
                                ✉ Klik untuk membuka
                            </text>
                        </svg>
                    </div>
                </button>
                <p class="text-xs text-gray-400 mt-3 animate-bounce">↑ ketuk amplop</p>
            </div>
        </section>

        {{-- Form Pencarian --}}
        <section id="cari-section" class="hidden px-4">
            <div class="bg-white rounded-2xl shadow-md p-6 max-w-lg mx-auto border border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div
                        class="h-10 w-10 rounded-xl bg-green-100 flex items-center justify-center text-green-700 text-lg flex-shrink-0">
                        🎓
                    </div>
                    <div>
                        <h2 class="font-semibold text-green-700 text-base leading-tight">Cek Status Kelulusan</h2>
                        <p class="text-xs text-gray-400">Masukkan NISN atau nomor telepon terdaftar</p>
                    </div>
                </div>

                <form action="{{ route('landing.cari') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none">🔎</span>
                        <input type="text" name="nisn" placeholder="NISN (10 digit) atau Nomor Telepon"
                            value="{{ old('nisn') }}"
                            class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                  transition placeholder:text-gray-300 @error('nisn') border-red-300 @enderror"
                            maxlength="15" autofocus>
                    </div>

                    @error('nisn')
                        <p class="text-red-500 text-xs flex items-center gap-1">
                            <span>⚠</span> {{ $message }}
                        </p>
                    @enderror
                    @error('telepon')
                        <p class="text-red-500 text-xs flex items-center gap-1">
                            <span>⚠</span> {{ $message }}
                        </p>
                    @enderror

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 active:scale-[0.98] text-white font-semibold
                               py-2.5 rounded-xl text-sm transition-all shadow-sm shadow-green-200">
                        Cari Kelulusan
                    </button>
                </form>
            </div>
        </section>

    @endif
@endsection

@push('styles')
    <style>
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-slide-up {
            animation: fadeSlideUp .4s ease forwards;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // ── Countdown ────────────────────────────────────────
        const cdTarget = new Date("{{ $tp?->jadwal_pengumuman_mulai?->toIso8601String() }}");
        const pad = n => String(n).padStart(2, '0');

        function tickCountdown() {
            const diff = cdTarget - Date.now();
            if (diff <= 0) {
                location.reload();
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            [
                ['days', d],
                ['hours', h],
                ['minutes', m],
                ['seconds', s]
            ].forEach(([k, v]) => {
                const el = document.getElementById('cd-' + k);
                if (el) el.textContent = pad(v);
            });
        }

        if (document.getElementById('cd-seconds')) {
            tickCountdown();
            setInterval(tickCountdown, 1000);
        }

        // ── Buka Amplop ──────────────────────────────────────
        function tampilkanForm() {
            document.getElementById('amplop-section')?.classList.add('hidden');
            const cari = document.getElementById('cari-section');
            if (!cari) return;
            cari.classList.remove('hidden');
            cari.classList.add('animate-fade-slide-up');
            setTimeout(() => cari.querySelector('input')?.focus(), 50);
        }

        function bukaAmplop() {
            const lid = document.getElementById('amplop-lid');
            const btn = document.getElementById('amplop-btn');
            if (!lid || btn.disabled) return;
            btn.disabled = true;

            lid.style.transform = 'rotateX(-180deg)';
            lid.style.opacity = '0';

            setTimeout(() => {
                const amplop = document.getElementById('amplop');
                if (amplop) {
                    amplop.style.transform = 'scale(0.8)';
                    amplop.style.opacity = '0';
                    amplop.style.transition = 'all .4s ease';
                }
            }, 400);

            setTimeout(tampilkanForm, 750);
            try {
                localStorage.setItem('amplop_dibuka', '1');
            } catch (e) {}
        }

        // Auto-buka jika sudah pernah
        try {
            if (localStorage.getItem('amplop_dibuka') === '1') tampilkanForm();
        } catch (e) {}

        // Auto-buka jika ada error validasi (form sudah disubmit)
        @if ($errors->any())
            tampilkanForm();
        @endif
    </script>
@endpush
