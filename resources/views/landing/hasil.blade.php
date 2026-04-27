@extends('layouts.app')
@section('title', $siswa ? 'Hasil — ' . $siswa->nama : 'Siswa Tidak Ditemukan')

@push('styles')
    @include('partials._people-styles')
@endpush

@push('styles')
    <style>
        .hasil-wrap {
            max-width: 500px;
            margin: 0 auto
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            font-size: .8rem;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 1.5rem;
            transition: color .2s
        }

        .back-link:hover { color: var(--teal-xl) }
        .back-link span { transition: transform .2s }
        .back-link:hover span { transform: translateX(-2px) }

        /* Not found */
        .notfound-card { padding: 3rem 2rem; text-align: center }
        .notfound-title { font-size: 1.05rem; font-weight: 700; margin-bottom: .45rem; font-family: var(--font-display) }
        .notfound-sub { font-size: .82rem; color: var(--muted); line-height: 1.75; margin-bottom: 1.4rem }

        /* Result */
        .result-header { padding: 1.5rem 1.6rem; border-bottom: 1px solid var(--border2) }
        .status-row { display: flex; align-items: center; gap: .9rem }
        .status-icon-wrap {
            width: 50px; height: 50px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            font-size: .72rem; font-weight: 800; letter-spacing: .08em;
            text-transform: uppercase; font-family: var(--font-display)
        }
        .status-label-sm { font-size: .62rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; opacity: .7; margin-bottom: .18rem }
        .status-text { font-size: 1.2rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.1; font-family: var(--font-display) }
        .result-info { padding: 1.1rem 1.6rem; border-bottom: 1px solid var(--border2) }
        .info-row { display: flex; justify-content: space-between; align-items: baseline; gap: 1rem; padding: .5rem 0; border-bottom: 1px solid var(--border2) }
        .info-row:last-child { border-bottom: none }
        .info-label { font-size: .73rem; color: var(--muted); flex-shrink: 0; font-weight: 500 }
        .info-val { font-size: .83rem; font-weight: 600; text-align: right }
        .result-actions { padding: 1.1rem 1.6rem; display: flex; flex-direction: column; gap: .6rem }
        .doc-btn {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            padding: .8rem 1.1rem; border-radius: 11px; font-size: .82rem; font-weight: 700;
            font-family: var(--font-body); text-decoration: none; cursor: pointer; transition: all .22s; border: none
        }
        .doc-btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff; box-shadow: 0 0 24px rgba(13,148,136,.22)
        }
        .doc-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 28px rgba(13,148,136,.38) }
        .doc-btn-outline { background: transparent; border: 1px solid rgba(20,184,166,.28); color: var(--teal-xl) }
        .doc-btn-outline:hover { background: rgba(20,184,166,.07); border-color: rgba(20,184,166,.5) }
        .doc-btn-disabled {
            background: rgba(255,255,255,.02); border: 1px dashed var(--border);
            color: var(--muted2); cursor: default; pointer-events: none
        }
        .result-footer-note { text-align: center; font-size: .72rem; color: var(--muted2); margin-top: .85rem; letter-spacing: .01em }

        /* Themes */
        .theme-lulus .status-icon-wrap { background: rgba(20,184,166,.1); border: 1px solid rgba(20,184,166,.2); color: var(--teal-xl) }
        .theme-lulus .status-text { color: var(--teal-xl) }
        .theme-tidak .status-icon-wrap { background: rgba(220,38,38,.08); border: 1px solid rgba(220,38,38,.18); color: #f87171 }
        .theme-tidak .status-text { color: #f87171 }
        .theme-syarat .status-icon-wrap { background: rgba(245,158,11,.09); border: 1px solid rgba(245,158,11,.2); color: #fbbf24 }
        .theme-syarat .status-text { color: #fbbf24 }
    </style>
@endpush

@section('content')
    <div class="hasil-wrap reveal visible">
        <a href="{{ route('landing') }}" class="back-link"><span>&larr;</span> Kembali ke Pencarian</a>

        @if (!$siswa)
            <div class="card notfound-card">
                <div class="notfound-title">Data Tidak Ditemukan</div>
                <div class="notfound-sub">
                    Tidak ada siswa dengan NISN atau nomor telepon
                    <strong style="color:var(--text)">&ldquo;{{ $keyword }}&rdquo;</strong>.
                    Pastikan data yang dimasukkan sudah benar.
                </div>
                <a href="{{ route('landing') }}" class="btn btn-primary" style="margin:0 auto;">&larr; Coba Lagi</a>
            </div>
        @else
            @php
                $status      = $siswa->status;
                $adaSkl      = (bool) $siswa->berkas_skl;
                $bolehUndang = $siswa->isLulus();
            @endphp

            <div class="card {{ $status->theme() }}" style="overflow:hidden;">

                <div class="result-header">
                    <div class="eyebrow" style="margin-bottom:.9rem;">Hasil Seleksi Kelulusan</div>
                    <div class="status-row">
                        <div class="status-icon-wrap">{{ $status->iconLabel() }}</div>
                        <div>
                            <div class="status-label-sm">Status</div>
                            <div class="status-text">{{ $status->getLabel() }}</div>
                        </div>
                    </div>
                </div>

                <div class="result-info">
                    @foreach ([
                        'Nama Siswa'     => [$siswa->nama,           false],
                        'NISN'           => [$siswa->nisn,           true],
                        'Nama Orang Tua' => [$siswa->nama_orangtua,  false],
                    ] as $label => [$val, $mono])
                        @if ($val)
                            <div class="info-row">
                                <span class="info-label">{{ $label }}</span>
                                <span class="info-val" @if ($mono) style="font-family:monospace;" @endif>
                                    {{ $val }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="result-actions">
                    @if ($adaSkl)
                        <a href="{{ route('landing.skl', $siswa) }}" target="_blank" class="doc-btn doc-btn-primary">
                            Unduh Surat Keterangan Lulus
                        </a>
                    @else
                        <div class="doc-btn doc-btn-disabled">
                            Dokumen SKL belum tersedia &mdash; hubungi madrasah
                        </div>
                    @endif

                    @if ($bolehUndang)
                        <a href="{{ route('landing.undangan', $siswa) }}" target="_blank" class="doc-btn doc-btn-outline">
                            Cetak Surat Undangan Kelulusan
                        </a>
                    @endif
                </div>

            </div>

            @if ($status->footerNote())
                <p class="result-footer-note"
                   @if ($status->footerColor()) style="color:{{ $status->footerColor() }}" @endif>
                    {{ $status->footerNote() }}
                </p>
            @endif
        @endif
    </div>
@endsection
