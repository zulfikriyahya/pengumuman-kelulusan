@extends('layouts.app')
@section('title', 'Konfirmasi Tamu')

@section('content')
    <div class="max-w-md mx-auto">

        <a href="{{ route('tamu.scan') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 mb-5 transition group">
            <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Kembali ke Scanner
        </a>

        <h1 class="text-xl font-bold text-green-700 mb-4">Konfirmasi Kehadiran</h1>

        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            {{-- Info siswa --}}
            <div class="px-6 py-5 space-y-3 text-sm border-b border-gray-100">
                @foreach ([
            'Nama Siswa' => $siswa->nama,
            'NISN' => $siswa->nisn,
            'Nama Orang Tua' => $siswa->nama_orangtua ?? '-',
            'Status' => $siswa->status->label(),
        ] as $label => $val)
                    <div class="flex justify-between items-baseline gap-4">
                        <span class="text-gray-400 flex-shrink-0">{{ $label }}</span>
                        <span
                            class="font-medium text-right {{ $label === 'NISN' ? 'font-mono' : '' }}
                             {{ $label === 'Status' ? 'text-green-700' : '' }}">
                            {{ $val }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Form --}}
            <div class="px-6 py-5">
                @if (isset($sudahHadir) && $sudahHadir)
                    <div
                        class="mb-4 flex items-center gap-2 bg-yellow-50 border border-yellow-200
                            text-yellow-700 text-xs px-4 py-3 rounded-xl">
                        <span>⚠️</span>
                        <span>Siswa ini sudah tercatat hadir. Data akan diperbarui.</span>
                    </div>
                @endif

                <form action="{{ route('tamu.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Jumlah Tamu <span class="text-gray-400 font-normal">(termasuk orang tua/wali)</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="adj(-1)"
                                class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-50
                                       hover:bg-gray-100 text-lg font-bold text-gray-600 transition
                                       flex items-center justify-center flex-shrink-0">
                                −
                            </button>
                            <input id="pax" type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                min="1" max="10" readonly
                                class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      text-center font-bold text-lg focus:outline-none focus:ring-2
                                      focus:ring-green-500 @error('jumlah_tamu') border-red-300 @enderror">
                            <button type="button" onclick="adj(1)"
                                class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-50
                                       hover:bg-gray-100 text-lg font-bold text-gray-600 transition
                                       flex items-center justify-center flex-shrink-0">
                                +
                            </button>
                        </div>
                        @error('jumlah_tamu')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <span>⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 active:scale-[0.98]
                               text-white font-semibold py-3 rounded-xl text-sm transition
                               shadow-sm shadow-green-200 mt-1">
                        ✅ Simpan Kehadiran
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function adj(delta) {
            const el = document.getElementById('pax');
            const val = parseInt(el.value) + delta;
            el.value = Math.min(10, Math.max(1, val));
        }
    </script>
@endpush
