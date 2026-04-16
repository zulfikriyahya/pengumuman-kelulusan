@extends('layouts.app')
@section('title', 'Tamu Undangan')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 gap-3 flex-wrap">
        <h1 class="text-xl font-bold text-green-700">Tamu Undangan</h1>
        <div class="flex gap-2">
            <a href="{{ route('tamu.scan') }}"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 active:scale-[0.98]
                  text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm shadow-green-200">
                📷 Scan QR
            </a>
            <a href="{{ route('tamu.cetak-hadir') }}" target="_blank"
                class="flex items-center gap-2 bg-white border border-green-300 text-green-700
                  hover:bg-green-50 active:scale-[0.98]
                  text-sm font-semibold px-4 py-2 rounded-xl transition">
                🖨️ Cetak Hadir
            </a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 {{ isset($totalSiswa) ? 'sm:grid-cols-3' : 'sm:grid-cols-2' }} gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $tamuUndangans->total() }}</p>
            <p class="text-xs text-gray-400 mt-1">Siswa Hadir</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $tamuUndangans->sum('jumlah_tamu') }}</p>
            <p class="text-xs text-gray-400 mt-1">Total PAX</p>
        </div>
        @isset($totalSiswa)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                @php $pct = $totalSiswa > 0 ? round($tamuUndangans->total() / $totalSiswa * 100) : 0; @endphp
                <p class="text-3xl font-bold text-green-700">{{ $pct }}%</p>
                <p class="text-xs text-gray-400 mt-1">Kehadiran</p>
            </div>
        @endisset
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-4 py-3 text-left w-10">#</th>
                    <th class="px-4 py-3 text-left">Nama Siswa</th>
                    <th class="px-4 py-3 text-left hidden sm:table-cell">Nama Orang Tua</th>
                    <th class="px-4 py-3 text-center">PAX</th>
                    <th class="px-4 py-3 text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($tamuUndangans as $i => $t)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-4 py-3 text-gray-300 text-xs">{{ $tamuUndangans->firstItem() + $i }}</td>
                        <td class="px-4 py-3 font-medium">{{ $t->siswa?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-400 hidden sm:table-cell">{{ $t->siswa?->nama_orangtua ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span
                                class="inline-flex items-center justify-center bg-green-100 text-green-700
                                 font-semibold text-xs px-2.5 py-1 rounded-full min-w-[28px]">
                                {{ $t->jumlah_tamu }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs text-right tabular-nums">
                            {{ $t->created_at->format('H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-14 text-gray-400">
                            <p class="text-3xl mb-2">👥</p>
                            <p class="text-sm">Belum ada tamu yang hadir.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tamuUndangans->links() }}</div>

@endsection
