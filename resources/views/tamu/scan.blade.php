@extends('layouts.app')
@section('title', 'Scan QR Tamu')

@push('styles')
    <style>
        .scan-wrap {
            max-width: 440px;
            margin: 0 auto;
        }

        .scan-title {
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -.03em;
            margin-bottom: .35rem;
            font-family: var(--font-display);
        }

        .scan-sub {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 1.4rem;
        }

        .scanner-card {
            padding: 1.1rem;
            border-radius: var(--radius);
            margin-bottom: .9rem;
        }

        .qr-viewport {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 12px;
            overflow: hidden;
            background: #060f0d;
            border: 1px solid var(--border);
        }

        #qr-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            display: none;
        }

        /* Overlay scrim + aim box */
        .qr-scrim {
            position: absolute;
            inset: 0;
            pointer-events: none;
            display: none;
            background:
                linear-gradient(rgba(0, 0, 0, .4) 0 calc(50% - 110px), transparent calc(50% - 110px)),
                linear-gradient(transparent calc(50% + 110px), rgba(0, 0, 0, .4) calc(50% + 110px)),
                linear-gradient(90deg, rgba(0, 0, 0, .4) 0 calc(50% - 110px), transparent calc(50% - 110px)),
                linear-gradient(90deg, transparent calc(50% + 110px), rgba(0, 0, 0, .4) calc(50% + 110px));
        }

        .qr-aim-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 220px;
            height: 220px;
            border: 2px solid rgba(94, 234, 212, .7);
            border-radius: 14px;
            animation: aim-pulse 2s ease-in-out infinite;
            pointer-events: none;
        }

        .qr-aim-box::before,
        .qr-aim-box::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: var(--teal-xl);
            border-style: solid;
        }

        .qr-aim-box::before {
            top: -2px;
            left: -2px;
            border-width: 3px 0 0 3px;
            border-radius: 4px 0 0 0;
        }

        .qr-aim-box::after {
            bottom: -2px;
            right: -2px;
            border-width: 0 3px 3px 0;
            border-radius: 0 0 4px 0;
        }

        @keyframes aim-pulse {

            0%,
            100% {
                border-color: rgba(94, 234, 212, .5);
            }

            50% {
                border-color: rgba(94, 234, 212, 1);
                box-shadow: 0 0 18px rgba(94, 234, 212, .25);
            }
        }

        /* Placeholder */
        .qr-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .75rem;
        }

        .qr-spinner {
            width: 38px;
            height: 38px;
            border: 3px solid rgba(20, 184, 166, .15);
            border-top-color: var(--teal-xl);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .qr-ph-text {
            font-size: .72rem;
            color: var(--muted);
        }

        /* Status */
        .qr-status-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            margin-top: .8rem;
        }

        .qr-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--muted2);
            flex-shrink: 0;
            transition: background .3s;
        }

        .qr-text {
            font-size: .73rem;
            color: var(--muted);
        }

        /* Error */
        .cam-error {
            display: none;
            margin-top: .7rem;
            padding: .65rem .85rem;
            border-radius: 10px;
            background: rgba(220, 38, 38, .07);
            border: 1px solid rgba(220, 38, 38, .2);
            color: #f87171;
            font-size: .75rem;
            line-height: 1.6;
        }

        .cam-error.visible {
            display: block;
        }

        /* Start btn */
        .qr-start-btn {
            display: none;
            width: 100%;
            margin-top: .7rem;
            padding: .62rem;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            border: none;
            font-family: var(--font-body);
            font-size: .82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 0 18px rgba(13, 148, 136, .22);
        }

        .qr-start-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 22px rgba(13, 148, 136, .38);
        }

        .qr-start-btn.visible {
            display: block;
        }

        /* Manual */
        .manual-card {
            padding: 1.4rem;
            border-radius: var(--radius);
        }

        .manual-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: .8rem;
        }

        .manual-form {
            display: flex;
            gap: .55rem;
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
            color: var(--muted2);
        }

        .manual-input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
        }

        .manual-input.is-error {
            border-color: rgba(220, 38, 38, .4);
        }

        /* Redirect overlay */
        .scan-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(6, 13, 12, .92);
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
            backdrop-filter: blur(8px);
        }

        .scan-overlay.active {
            display: flex;
        }

        .scan-spinner2 {
            width: 44px;
            height: 44px;
            border: 3px solid rgba(20, 184, 166, .2);
            border-top-color: var(--teal-xl);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        .scan-overlay-text {
            font-size: .85rem;
            color: var(--teal-xl);
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="scan-overlay" id="scan-overlay">
        <div class="scan-spinner2"></div>
        <div class="scan-overlay-text">QR terdeteksi, memuat data…</div>
    </div>

    <div class="scan-wrap">
        <a href="{{ route('tamu.index') }}"
            style="margin-bottom:1.2rem;display:inline-flex;align-items:center;gap:.45rem;font-size:.8rem;color:var(--muted);text-decoration:none;">
            &larr; Kembali ke Daftar Tamu
        </a>

        <h1 class="scan-title">Scan QR Undangan</h1>
        <p class="scan-sub">Arahkan kamera ke QR Code pada surat undangan siswa.</p>

        <div class="card scanner-card">
            <div class="qr-viewport" id="qr-viewport">
                <video id="qr-video" playsinline muted autoplay></video>
                <canvas id="qr-canvas" style="display:none;"></canvas>
                <div class="qr-scrim" id="qr-scrim"></div>
                <div class="qr-aim-box" id="qr-aim" style="display:none;"></div>
                <div class="qr-placeholder" id="qr-placeholder">
                    <div class="qr-spinner"></div>
                    <span class="qr-ph-text" id="qr-ph-text">Meminta izin kamera…</span>
                </div>
            </div>

            <div class="qr-status-row">
                <span id="qr-dot" class="qr-dot"></span>
                <span id="qr-status" class="qr-text">Meminta izin kamera…</span>
            </div>

            <div class="cam-error" id="cam-error"></div>
            <button class="qr-start-btn" id="qr-start-btn" type="button">📷 Izinkan &amp; Mulai Kamera</button>
        </div>

        <div class="card manual-card">
            <div class="manual-label">Atau masukkan kode secara manual (ID Siswa / NISN):</div>
            <form action="{{ route('tamu.scan.post') }}" method="POST" class="manual-form">
                @csrf
                <input type="text" name="kode" placeholder="Contoh: 0012345678"
                    class="manual-input {{ $errors->has('kode') ? 'is-error' : '' }}">
                <button type="submit" class="btn btn-primary"
                    style="font-size:.8rem;padding:.58rem 1rem;flex-shrink:0;">Cari</button>
            </form>
            @error('kode')
                <p style="font-size:.72rem;color:#f87171;margin-top:.55rem;">&times; {{ $message }}</p>
            @enderror
        </div>
    </div>
@endsection

@push('scripts')
    {{-- BarcodeDetector polyfill untuk browser yang belum support (Firefox, older Safari) --}}
    <script src="https://cdn.jsdelivr.net/npm/barcode-detector@2/dist/es2015/barcode-detector.min.js"
        crossorigin="anonymous"></script>

    <script>
        (() => {
            const video = document.getElementById('qr-video');
            const canvas = document.getElementById('qr-canvas');
            const ctx = canvas.getContext('2d', {
                willReadFrequently: true
            });
            const statusEl = document.getElementById('qr-status');
            const phText = document.getElementById('qr-ph-text');
            const dotEl = document.getElementById('qr-dot');
            const overlay = document.getElementById('scan-overlay');
            const placeholder = document.getElementById('qr-placeholder');
            const scrim = document.getElementById('qr-scrim');
            const aimEl = document.getElementById('qr-aim');
            const errBox = document.getElementById('cam-error');
            const startBtn = document.getElementById('qr-start-btn');

            const konfirmasiBase = @json(url('/tamu/konfirmasi'));
            let stream = null;
            let rafId = null;
            let scanned = false;
            let detector = null;

            /* ── Status helpers ──────────────────────────────────── */
            function setStatus(msg, color) {
                statusEl.textContent = msg;
                if (phText) phText.textContent = msg;
                dotEl.style.background = color || 'var(--muted2)';
            }

            function showError(msg) {
                setStatus('Kamera tidak tersedia', '#f87171');
                errBox.textContent = msg;
                errBox.classList.add('visible');
                startBtn.classList.add('visible');
            }

            function humanizeErr(err) {
                const s = String(err.name || err).toLowerCase();
                if (s.includes('notallowed') || s.includes('permission'))
                    return 'Izin kamera ditolak. Buka pengaturan browser → izinkan kamera untuk situs ini, lalu muat ulang.';
                if (s.includes('notfound') || s.includes('devicenotfound'))
                    return 'Kamera tidak ditemukan pada perangkat ini.';
                if (s.includes('notreadable') || s.includes('trackstart'))
                    return 'Kamera sedang dipakai aplikasi lain. Tutup aplikasi tersebut lalu coba lagi.';
                if (s.includes('overconstrained'))
                    return 'Konfigurasi kamera tidak cocok dengan perangkat ini.';
                return 'Gagal mengakses kamera: ' + (err.message || err);
            }

            /* ── Camera start ────────────────────────────────────── */
            async function startCamera() {
                startBtn.classList.remove('visible');
                errBox.classList.remove('visible');
                setStatus('Meminta izin kamera…', 'var(--muted2)');

                // Constraints: utama belakang, fallback default
                const constraints = [{
                        video: {
                            facingMode: {
                                ideal: 'environment'
                            },
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        }
                    },
                    {
                        video: {
                            facingMode: 'environment'
                        }
                    },
                    {
                        video: true
                    },
                ];

                for (const c of constraints) {
                    try {
                        stream = await navigator.mediaDevices.getUserMedia(c);
                        break;
                    } catch (e) {
                        if (e.name === 'NotAllowedError' || e.name === 'PermissionDeniedError') {
                            showError(humanizeErr(e));
                            return;
                        }
                        // coba constraint berikutnya
                    }
                }

                if (!stream) {
                    showError('Tidak dapat membuka kamera. Coba izinkan secara manual.');
                    return;
                }

                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    video.play().then(() => {
                        video.style.display = 'block';
                        placeholder.style.display = 'none';
                        scrim.style.display = 'block';
                        aimEl.style.display = 'block';
                        setStatus('Kamera aktif — arahkan ke QR Code', 'var(--teal-xl)');
                        scheduleDetect();
                    }).catch(e => showError(humanizeErr(e)));
                };
            }

            /* ── QR Detection loop ───────────────────────────────── */
            async function initDetector() {
                // BarcodeDetector API (Chrome 83+, Edge 83+, Safari 17.4+, + polyfill)
                if ('BarcodeDetector' in window) {
                    const formats = await BarcodeDetector.getSupportedFormats();
                    if (formats.includes('qr_code')) {
                        detector = new BarcodeDetector({
                            formats: ['qr_code']
                        });
                        return;
                    }
                }
                // Fallback: ZXing-js (dinamis, hanya load jika perlu)
                detector = null;
            }

            function scheduleDetect() {
                rafId = requestAnimationFrame(detectFrame);
            }

            async function detectFrame() {
                if (scanned || !video.videoWidth) {
                    scheduleDetect();
                    return;
                }

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0);

                try {
                    if (detector) {
                        const results = await detector.detect(video);
                        if (results.length) {
                            handleResult(results[0].rawValue);
                            return;
                        }
                    } else {
                        // Fallback: jsQR (CDN dinamis)
                        if (!window.jsQR) {
                            scheduleDetect();
                            return;
                        }
                        const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        const result = jsQR(imgData.data, imgData.width, imgData.height, {
                            inversionAttempts: 'dontInvert'
                        });
                        if (result) {
                            handleResult(result.data);
                            return;
                        }
                    }
                } catch (_) {
                    /* skip frame */
                }

                scheduleDetect();
            }

            function handleResult(text) {
                if (scanned) return;
                scanned = true;
                cancelAnimationFrame(rafId);
                stream?.getTracks().forEach(t => t.stop());
                setStatus('QR terdeteksi!', 'var(--teal-xl)');
                overlay.classList.add('active');
                window.location.href = konfirmasiBase + '/' + encodeURIComponent(text.trim());
            }

            /* ── Load jsQR sebagai fallback jika BarcodeDetector tidak ada ── */
            async function loadFallbackLib() {
                if ('BarcodeDetector' in window) return; // tidak perlu
                return new Promise(res => {
                    const s = document.createElement('script');
                    s.src = 'https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js';
                    s.onload = res;
                    s.onerror = res;
                    document.head.appendChild(s);
                });
            }

            /* ── Init ────────────────────────────────────────────── */
            async function init() {
                await loadFallbackLib();
                await initDetector();
                await startCamera();
            }

            startBtn.addEventListener('click', () => {
                scanned = false;
                init();
            });

            // Pause/resume saat tab disembunyikan
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    cancelAnimationFrame(rafId);
                    stream?.getTracks().forEach(t => t.stop());
                    stream = null;
                } else if (!scanned) {
                    init();
                }
            });

            // Autostart setelah halaman selesai render
            if (document.readyState === 'complete') {
                init();
            } else {
                window.addEventListener('load', init);
            }
        })();
    </script>
@endpush
