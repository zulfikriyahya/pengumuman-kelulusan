@extends('layouts.app')
@section('title', 'Scan QR Tamu')

@push('styles')
    <style>
        #qr-region video {
            border-radius: 12px;
            width: 100% !important;
        }

        #qr-region {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-md mx-auto">

        <div class="mb-6">
            <h1 class="text-xl font-bold text-green-700 mb-1">Scan QR Undangan</h1>
            <p class="text-sm text-gray-400">Arahkan kamera ke QR Code pada surat undangan siswa.</p>
        </div>

        {{-- Scanner --}}
        <div class="bg-white rounded-2xl shadow-md p-4 border border-gray-100 mb-4">
            <div id="qr-region" class="w-full aspect-square bg-gray-100 rounded-xl overflow-hidden"></div>
            <div id="qr-status-wrap" class="flex items-center justify-center gap-2 mt-3">
                <span id="qr-dot" class="inline-block w-2 h-2 rounded-full bg-gray-300"></span>
                <p id="qr-status" class="text-xs text-gray-400">Menginisialisasi kamera…</p>
            </div>
        </div>

        {{-- Manual --}}
        <div class="bg-white rounded-2xl shadow-md p-5 border border-gray-100">
            <p class="text-sm font-medium text-gray-600 mb-3">Atau masukkan kode secara manual:</p>
            <form action="{{ route('tamu.scan.post') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="kode" placeholder="ID Siswa / NISN"
                    class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-500 transition
                          @error('kode') border-red-300 @enderror">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5
                           rounded-xl text-sm transition active:scale-[0.98]">
                    Cari
                </button>
            </form>
            @error('kode')
                <p class="text-red-500 text-xs mt-2 flex items-center gap-1"><span>⚠</span> {{ $message }}</p>
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

        function setStatus(msg, color = 'gray') {
            statusEl.textContent = msg;
            dotEl.className = `inline-block w-2 h-2 rounded-full bg-${color}-400`;
        }

        const html5Qr = new Html5Qrcode('qr-region');

        Html5Qrcode.getCameras()
            .then(cameras => {
                if (!cameras.length) {
                    setStatus('Tidak ada kamera ditemukan.', 'red');
                    return;
                }

                // Prefer kamera belakang
                const cam = cameras.find(c => /back|rear|environment/i.test(c.label)) ?? cameras[cameras.length - 1];
                setStatus('Kamera aktif — arahkan ke QR Code…', 'green');

                html5Qr.start(
                    cam.id, {
                        fps: 10,
                        qrbox: {
                            width: 240,
                            height: 240
                        }
                    },
                    decodedText => {
                        if (scanned) return;
                        scanned = true;
                        setStatus('✅ QR terdeteksi, mengalihkan…', 'green');
                        html5Qr.stop().catch(() => {});
                        window.location.href = '{{ route('tamu.konfirmasi', ['siswa' => ':id']) }}'
                            .replace(':id', encodeURIComponent(decodedText));
                    }
                ).catch(() => {
                    setStatus('Gagal memulai kamera.', 'red');
                });
            })
            .catch(() => {
                setStatus('Akses kamera ditolak. Gunakan input manual.', 'red');
            });
    </script>
@endpush
