@extends('layouts.app')
@section('title', 'Pengumuman Kelulusan')

@push('styles')
    <style>
        /* ── HERO ─────────────────────────────────────────────────────── */
        .hero-section {
            min-height: calc(100svh - var(--nav-h));
            display: flex;
            align-items: center;
            padding: 5rem 2rem 4rem;
            position: relative;
        }

        .hero-inner {
            max-width: 1120px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 440px;
            gap: 3.5rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        /* ── LEFT ─────────────────────────────────────────────────────── */
        .hero-left {
            display: flex;
            flex-direction: column;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: rgba(20, 184, 166, .1);
            border: 1px solid rgba(20, 184, 166, .2);
            color: var(--teal-xl);
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .11em;
            text-transform: uppercase;
            padding: .3rem .9rem;
            border-radius: 999px;
            width: fit-content;
            margin-bottom: 1.25rem;
            animation: fu .5s ease both .05s;
        }

        .hero-title {
            font-size: clamp(2.6rem, 5.5vw, 4rem);
            font-weight: 900;
            letter-spacing: -.045em;
            line-height: 1.02;
            font-family: var(--font-display);
            animation: fu .55s ease both .12s;
            margin-bottom: 1.15rem;
            color: #fff;
        }

        .hero-title .grad {
            background: linear-gradient(135deg, var(--teal-xl) 0%, var(--gold-l) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: .88rem;
            color: var(--muted);
            line-height: 1.78;
            max-width: 500px;
            animation: fu .55s ease both .2s;
            margin-bottom: 1.8rem;
        }

        .hero-desc strong {
            color: var(--text);
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            column-gap: 1.6rem;
            row-gap: .4rem;
            font-size: .77rem;
            color: var(--muted);
            animation: fu .55s ease both .28s;
            padding-top: .1rem;
        }

        .hero-meta span {
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .hero-meta strong {
            color: var(--text);
            font-weight: 600;
        }

        /* ── STATS ROW ────────────────────────────────────────────────── */
        .hero-stats {
            display: flex;
            gap: 2.4rem;
            margin-top: 2.2rem;
            animation: fu .55s ease both .36s;
            flex-wrap: wrap;
        }

        .stat-item {}

        .stat-item-val {
            font-size: 1.9rem;
            font-weight: 900;
            font-family: var(--font-display);
            color: var(--teal-xl);
            line-height: 1;
            letter-spacing: -.03em;
        }

        .stat-item-val.gold {
            color: var(--gold-l);
        }

        .stat-item-lbl {
            font-size: .68rem;
            color: var(--muted);
            margin-top: .28rem;
            font-weight: 500;
            letter-spacing: .01em;
        }

        /* ── RIGHT CARD ───────────────────────────────────────────────── */
        .hero-card {
            background: rgba(10, 22, 20, .72);
            border: 1px solid rgba(20, 184, 166, .2);
            border-radius: 24px;
            backdrop-filter: blur(20px);
            overflow: hidden;
            animation: fu .65s ease both .18s;
            box-shadow: 0 0 0 1px rgba(20, 184, 166, .06), 0 32px 80px rgba(0, 0, 0, .45);
        }

        .hcard-top {
            padding: 1.5rem 1.7rem 1.2rem;
            border-bottom: 1px solid rgba(20, 184, 166, .11);
            text-align: center;
        }

        .hcard-eyebrow {
            font-size: .62rem;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--gold-l);
            margin-bottom: .75rem;
        }

        /* Countdown */
        .cd-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .5rem;
        }

        .cd-box {
            background: rgba(13, 148, 136, .1);
            border: 1px solid rgba(20, 184, 166, .15);
            border-radius: 12px;
            padding: .95rem .25rem .75rem;
            text-align: center;
        }

        .cd-n {
            font-size: 2.1rem;
            font-weight: 900;
            font-variant-numeric: tabular-nums;
            background: linear-gradient(160deg, var(--teal-xl), var(--gold-l));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            letter-spacing: -.02em;
        }

        .cd-l {
            font-size: .54rem;
            color: var(--muted2);
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-top: .3rem;
            font-weight: 700;
        }

        .cd-note {
            font-size: .7rem;
            color: var(--muted2);
            text-align: center;
            margin-top: .75rem;
        }

        /* Schedule rows */
        .hcard-sched {
            padding: .8rem 1.7rem 1rem;
            display: flex;
            flex-direction: column;
        }

        .sched-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            font-size: .77rem;
            gap: 1rem;
        }

        .sched-row:last-child {
            border-bottom: none;
        }

        .sched-label {
            color: var(--muted);
        }

        .sched-val {
            font-weight: 700;
            color: var(--teal-xl);
            text-align: right;
        }

        /* Search */
        .hcard-search {
            padding: 1.25rem 1.7rem 1.6rem;
            border-top: 1px solid rgba(20, 184, 166, .1);
        }

        .hcard-search-lbl {
            font-size: .76rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .8rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .hcard-search-lbl::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--teal-xl);
            flex-shrink: 0;
        }

        .search-row {
            display: flex;
            gap: .5rem;
        }

        .search-row input {
            flex: 1;
            min-width: 0;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(20, 184, 166, .18);
            border-radius: 10px;
            padding: .7rem .95rem;
            font-size: .85rem;
            font-family: var(--font-body);
            color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .search-row input::placeholder {
            color: var(--muted2);
        }

        .search-row input:focus {
            border-color: rgba(20, 184, 166, .48);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .12);
        }

        .search-row input.is-error {
            border-color: rgba(220, 38, 38, .45);
        }

        .search-row .btn-s {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .7rem 1.15rem;
            font-size: .82rem;
            font-weight: 700;
            font-family: var(--font-body);
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all .2s;
            box-shadow: 0 0 18px rgba(13, 148, 136, .22);
        }

        .search-row .btn-s:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 22px rgba(13, 148, 136, .4);
        }

        .search-err {
            font-size: .72rem;
            color: #f87171;
            margin-top: .5rem;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        /* State (no TP / tutup) */
        .hcard-state {
            padding: 2.4rem 1.7rem;
            text-align: center;
        }

        .hcard-state-title {
            font-size: 1rem;
            font-weight: 800;
            font-family: var(--font-display);
            margin-bottom: .45rem;
        }

        .hcard-state-sub {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.7;
        }

        /* ── ANIMATIONS ───────────────────────────────────────────────── */
        @keyframes fu {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* ── RESPONSIVE ───────────────────────────────────────────────── */
        @media (max-width: 900px) {
            .hero-inner {
                grid-template-columns: 1fr;
                gap: 2.2rem;
                text-align: center;
            }

            .hero-eyebrow,
            .hero-desc {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-meta,
            .hero-stats {
                justify-content: center;
            }

            .hero-card {
                max-width: 460px;
                margin: 0 auto;
                width: 100%;
            }
        }

        @media (max-width: 500px) {
            .hero-section {
                padding: 3rem 1rem 2.5rem;
            }

            .hcard-top,
            .hcard-sched,
            .hcard-search {
                padding-left: 1.2rem;
                padding-right: 1.2rem;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $tp = $tahunPelajaran ?? null;
        $now = now();
        $belumBuka = $tp && $now->lt($tp->jadwal_pengumuman_mulai);
        $sudahTutup = $tp && $now->gt($tp->jadwal_pengumuman_selesai);
        $sudahBuka = $tp && $now->between($tp->jadwal_pengumuman_mulai, $tp->jadwal_pengumuman_selesai);
    @endphp

    <div style="margin-top:-2.5rem">
        <section class="hero-section">
            <div class="hero-inner">

                {{-- ══ LEFT ══════════════════════════════════════════════ --}}
                <div class="hero-left">

                    <div class="hero-eyebrow">
                        Pengumuman Kelulusan Madrasah
                        @if ($tp)
                            &middot; TP {{ $tp->name }}
                        @endif
                    </div>

                    <h1 class="hero-title">
                        Selamat &amp;<br>
                        <span class="grad">Berprestasi</span><br>
                        di MTs Negeri 1 Pandeglang
                    </h1>

                    <p class="hero-desc">
                        {{ $instansi?->nama }} mengumumkan kelulusan peserta didik
                        melalui sistem digital yang cepat, transparan, dan resmi.
                        @if ($tp && $sudahBuka)
                            Pengumuman resmi <strong>telah dibuka</strong> untuk TP <strong>{{ $tp->name }}</strong>.
                        @elseif ($tp && $belumBuka)
                            Dibuka pada <strong>{{ $tp->jadwal_pengumuman_mulai->translatedFormat('d F Y') }}</strong>.
                        @endif
                    </p>

                    <div class="hero-meta">
                        @if ($instansi?->nama_pimpinan)
                            <span>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Kepala Madrasah: <strong>{{ $instansi->nama_pimpinan }}</strong>
                            </span>
                        @endif
                        @if ($instansi?->npsn)
                            <span>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <path d="M3 9h18M9 21V9" />
                                </svg>
                                NPSN: <strong>{{ $instansi->npsn }}</strong>
                            </span>
                        @endif
                    </div>

                    {{-- Stats row --}}
                    @php $statsVisible = $tp && ($sudahBuka || $belumBuka || $sudahTutup); @endphp
                    @if ($statsVisible)
                        <div class="hero-stats">
                            @if ($instansi?->jumlah_siswa ?? null)
                                <div class="stat-item">
                                    <div class="stat-item-val">{{ $instansi->jumlah_siswa }}</div>
                                    <div class="stat-item-lbl">Peserta Didik</div>
                                </div>
                            @endif
                            @if ($instansi?->akreditasi ?? null)
                                <div class="stat-item">
                                    <div class="stat-item-val gold">{{ $instansi->akreditasi }}</div>
                                    <div class="stat-item-lbl">Akreditasi</div>
                                </div>
                            @endif
                            <div class="stat-item">
                                <div class="stat-item-val">3</div>
                                <div class="stat-item-lbl">Status Kelulusan</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-item-val">Gratis</div>
                                <div class="stat-item-lbl">Biaya Akses</div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- ══ RIGHT CARD ═════════════════════════════════════════ --}}
                <div class="hero-card">

                    @if (!$tp)
                        <div class="hcard-state">
                            <div class="hcard-state-title">Informasi Belum Tersedia</div>
                            <div class="hcard-state-sub">Hubungi pihak madrasah untuk informasi lebih lanjut mengenai
                                pengumuman kelulusan.</div>
                        </div>
                    @elseif ($belumBuka)
                        <div class="hcard-top">
                            <div class="hcard-eyebrow">Hitung Mundur Pembukaan</div>
                            <div class="cd-grid">
                                @foreach (['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $k => $l)
                                    <div class="cd-box">
                                        <div class="cd-n" id="cd-{{ $k }}">00</div>
                                        <div class="cd-l">{{ $l }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="cd-note">Pastikan kamu kembali tepat waktu.</div>
                        </div>
                        <div class="hcard-sched">
                            <div class="sched-row">
                                <span class="sched-label">Pengumuman Dibuka</span>
                                <span
                                    class="sched-val">{{ $tp->jadwal_pengumuman_mulai->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="sched-row">
                                <span class="sched-label">Pengumuman Ditutup</span>
                                <span
                                    class="sched-val">{{ $tp->jadwal_pengumuman_selesai->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="sched-row">
                                <span class="sched-label">Jam Buka</span>
                                <span class="sched-val">{{ $tp->jadwal_pengumuman_mulai->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    @elseif ($sudahTutup)
                        <div class="hcard-state">
                            <div class="hcard-state-title" style="color:#fbbf24;">Periode Berakhir</div>
                            <div class="hcard-state-sub">Periode pengumuman kelulusan telah selesai. Hubungi madrasah untuk
                                informasi lebih lanjut.</div>
                        </div>
                    @elseif ($sudahBuka)
                        <div class="hcard-top">
                            <div class="hcard-eyebrow">Pengumuman Kelulusan Reguler</div>
                            <div class="cd-grid">
                                @foreach (['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $k => $l)
                                    <div class="cd-box">
                                        <div class="cd-n" id="cd-{{ $k }}">00</div>
                                        <div class="cd-l">{{ $l }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="hcard-sched">
                            <div class="sched-row">
                                <span class="sched-label">Pengumuman</span>
                                <span
                                    class="sched-val">{{ $tp->jadwal_pengumuman_mulai->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="sched-row">
                                <span class="sched-label">Ditutup</span>
                                <span
                                    class="sched-val">{{ $tp->jadwal_pengumuman_selesai->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="hcard-search">
                            <div class="hcard-search-lbl">Cek Status Kelulusan</div>
                            <form action="{{ route('landing.cari') }}" method="POST">
                                @csrf
                                <div class="search-row">
                                    <input type="text" name="nisn" placeholder="Cth. 0000971291"
                                        value="{{ old('nisn') }}"
                                        class="{{ $errors->hasAny(['nisn', 'telepon']) ? 'is-error' : '' }}" maxlength="15"
                                        autofocus>
                                    <button type="submit" class="btn-s">Cari →</button>
                                </div>
                                @error('nisn')
                                    <div class="search-err"><span>&times;</span> {{ $message }}</div>
                                @enderror
                                @error('telepon')
                                    <div class="search-err"><span>&times;</span> {{ $message }}</div>
                                @enderror
                            </form>
                        </div>
                    @endif

                </div>{{-- /hero-card --}}

            </div>{{-- /hero-inner --}}
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const cdEl = document.getElementById('cd-seconds');
        if (cdEl) {
            @if ($belumBuka)
                const cdTarget = new Date("{{ $tp?->jadwal_pengumuman_mulai?->toIso8601String() }}");
            @elseif ($sudahBuka)
                const cdTarget = new Date("{{ $tp?->jadwal_pengumuman_selesai?->toIso8601String() }}");
            @endif
            const pad = n => String(n).padStart(2, '0');

            function tick() {
                const d = cdTarget - Date.now();
                if (d <= 0) {
                    location.reload();
                    return;
                }
                [
                    ['days', Math.floor(d / 86400000)],
                    ['hours', Math.floor((d % 86400000) / 3600000)],
                    ['minutes', Math.floor((d % 3600000) / 60000)],
                    ['seconds', Math.floor((d % 60000) / 1000)]
                ]
                .forEach(([k, v]) => {
                    const e = document.getElementById('cd-' + k);
                    if (e) e.textContent = pad(v);
                });
            }
            tick();
            setInterval(tick, 1000);
        }
    </script>
@endpush
