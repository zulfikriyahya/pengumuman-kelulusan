@extends('layouts.app')
@section('title', 'Konfirmasi Tamu')

@push('styles')
    <style>
        .konfirmasi-wrap {
            max-width: 420px;
            margin: 0 auto
        }

        .pax-control {
            display: flex;
            align-items: center;
            gap: .8rem
        }

        .pax-btn {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: var(--card2);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .2s;
            font-family: var(--font-body);
        }

        .pax-btn:hover {
            border-color: rgba(20, 184, 166, .42);
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .07)
        }

        .pax-input {
            flex: 1;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: .6rem;
            font-size: 1.2rem;
            font-weight: 800;
            font-family: var(--font-display);
            color: var(--text);
            text-align: center;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .pax-input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1)
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 1rem;
            padding: .48rem 0;
            border-bottom: 1px solid var(--border2)
        }

        .info-row:last-child {
            border-bottom: none
        }
    </style>
@endpush

@section('content')
    <div class="konfirmasi-wrap">
        <a href="{{ route('tamu.scan') }}"
            style="margin-bottom:1.4rem;display:inline-flex;align-items:center;gap:.45rem;font-size:.8rem;color:var(--muted);text-decoration:none;">
            &larr; Kembali ke Scanner
        </a>

        <h1
            style="font-size:1.3rem;font-weight:800;letter-spacing:-.03em;margin-bottom:1.35rem;font-family:var(--font-display)">
            Konfirmasi Kehadiran</h1>

        <div class="card" style="overflow:hidden;">
            <div style="padding:1.4rem 1.6rem;border-bottom:1px solid var(--border2);">
                @if (isset($sudahHadir) && $sudahHadir)
                    <div
                        style="display:flex;align-items:center;gap:.55rem;background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.18);color:#fbbf24;border-radius:9px;padding:.7rem .9rem;font-size:.76rem;font-weight:600;margin-bottom:.9rem;">
                        Siswa ini sudah tercatat hadir. Data akan diperbarui.
                    </div>
                @endif

                @foreach ([
            'Nama Siswa' => [$siswa->nama, false, false],
            'NISN' => [$siswa->nisn, true, false],
            'Nama Ortu' => [$siswa->nama_orangtua ?? '—', false, false],
            'Status' => [$siswa->status->label(), false, true],
        ] as $lbl => [$val, $mono, $accent])
                    <div class="info-row">
                        <span style="font-size:.73rem;color:var(--muted)">{{ $lbl }}</span>
                        <span
                            style="font-size:.82rem;font-weight:600;{{ $mono ? 'font-family:monospace;' : '' }}{{ $accent ? 'color:var(--teal-xl);' : '' }}">{{ $val }}</span>
                    </div>
                @endforeach
            </div>

            <div style="padding:1.4rem 1.6rem;">
                <form action="{{ route('tamu.store') }}" method="POST"
                    style="display:flex;flex-direction:column;gap:1rem;">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                    <div>
                        <label
                            style="font-size:.76rem;font-weight:600;color:var(--muted);display:block;margin-bottom:.7rem;">
                            Jumlah Tamu <span style="font-weight:400;color:var(--muted2)">(termasuk orang tua/wali)</span>
                        </label>
                        <div class="pax-control">
                            <button type="button" onclick="adj(-1)" class="pax-btn">&minus;</button>
                            <input id="pax" type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                min="1" max="10" readonly class="pax-input">
                            <button type="button" onclick="adj(1)" class="pax-btn">+</button>
                        </div>
                        @error('jumlah_tamu')
                            <p style="font-size:.72rem;color:#f87171;margin-top:.45rem;">&times; {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="justify-content:center;">Simpan Kehadiran</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function adj(d) {
            const el = document.getElementById('pax');
            el.value = Math.min(10, Math.max(1, parseInt(el.value) + d));
        }
    </script>
@endpush
