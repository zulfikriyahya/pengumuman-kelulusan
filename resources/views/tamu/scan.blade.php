@extends('layouts.app')
@section('title', 'Scan QR Tamu')

@push('styles')
    <style>
        .scan-wrap {
            max-width: 440px;
            margin: 0 auto
        }

        .scan-title {
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -.03em;
            margin-bottom: .35rem;
            font-family: var(--font-display)
        }

        .scan-sub {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 1.4rem
        }

        .scanner-card {
            padding: 1.1rem;
            border-radius: var(--radius);
            margin-bottom: .9rem
        }

        #qr-region {
            border-radius: 11px;
            overflow: hidden;
            background: rgba(13, 148, 136, .04);
            aspect-ratio: 1
        }

        #qr-region video {
            border-radius: 11px;
            width: 100% !important
        }

        .qr-status-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            margin-top: .8rem
        }

        .qr-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--muted2);
            transition: background .3s
        }

        .qr-text {
            font-size: .73rem;
            color: var(--muted)
        }

        .manual-card {
            padding: 1.4rem;
            border-radius: var(--radius)
        }

        .manual-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: .8rem
        }

        .manual-form {
            display: flex;
            gap: .55rem
        }

        .manual-input {
            flex: 1;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: .58rem .88rem;
            font-size: .83rem;
            font-family: var(--font-body);
            color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .manual-input::placeholder {
            color: var(--muted2)
        }

        .manual-input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1)
        }

        .manual-input.is-error {
            border-color: rgba(220, 38, 38, .4)
        }
    </style>
@endpush

@section('content')
    <div class="scan-wrap">
        <h1 class="scan-title">Scan QR Undangan</h1>
        <p class="scan-sub">Arahkan kamera ke QR Code pada surat undangan siswa.</p>

        <div class="card scanner-card">
            <div id="qr-region"></div>
            <div class="qr-status-row">
                <span id="qr-dot" class="qr-dot"></span>
                <span id="qr-status" class="qr-text">Menginisialisasi kamera</span>
            </div>
        </div>

        <div class="card manual-card">
            <div class="manual-label">Atau masukkan kode secara manual:</div>
            <form action="{{ route('tamu.scan.post') }}" method="POST" class="manual-form">
                @csrf
                <input type="text" name="kode" placeholder="ID Siswa / NISN"
                    class="manual-input {{ $errors->has('kode') ? 'is-error' : '' }}">
                <button type="submit" class="btn btn-primary"
                    style="font-size:.8rem;padding:.58rem 1rem;flex-shrink:0">Cari</button>
            </form>
            @error('kode')
                <p style="font-size:.72rem;color:#f87171;margin-top:.55rem;">&times; {{ $message }}</p>
            @enderror
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S09FkAP0l+F+VxQJr6B29Y5xMRCYAkELf2jNOGa+7kBvPKB4OIDHPx/8FBGqW2Y6UiRjg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const statusEl = document.getElementById('qr-status');
        const dotEl = document.getElementById('qr-dot');
        let scanned = false;

        function setStatus(msg, color = 'var(--muted2)') {
            statusEl.textContent = msg;
            dotEl.style.background = color;
        }

        const html5Qr = new Html5Qrcode('qr-region');
        Html5Qrcode.getCameras()
            .then(cameras => {
                if (!cameras.length) {
                    setStatus('Tidak ada kamera ditemukan.', '#f87171');
                    return;
                }
                const cam = cameras.find(c => /back|rear|environment/i.test(c.label)) ?? cameras[cameras.length - 1];
                setStatus('Kamera aktif — arahkan ke QR Code', 'var(--teal-xl)');
                html5Qr.start(cam.id, {
                    fps: 10,
                    qrbox: {
                        width: 230,
                        height: 230
                    }
                }, text => {
                    if (scanned) return;
                    scanned = true;
                    setStatus('QR terdeteksi, mengalihkan\u2026', 'var(--teal-xl)');
                    html5Qr.stop().catch(() => {});
                    window.location.href = '{{ route('tamu.konfirmasi', ['siswa' => ':id']) }}'.replace(':id',
                        encodeURIComponent(text));
                }).catch(() => setStatus('Gagal memulai kamera.', '#f87171'));
            })
            .catch(() => setStatus('Akses kamera ditolak. Gunakan input manual.', '#fbbf24'));
    </script>
@endpush
