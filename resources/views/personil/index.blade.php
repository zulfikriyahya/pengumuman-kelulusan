@extends('layouts.app')
@section('title', 'Personil')

@section('content')

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-green-700">Personil</h1>
            @if (isset($keyword))
                <p class="text-sm text-gray-400 mt-0.5">
                    Hasil pencarian untuk <span class="font-semibold text-gray-600">"{{ $keyword }}"</span>
                    &mdash; {{ $personils->count() }} data
                </p>
            @endif
        </div>

        <form action="{{ route('personil.cari') }}" method="GET" class="flex gap-2">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none">🔎</span>
                <input type="text" name="nama" value="{{ request('nama', $keyword ?? '') }}" placeholder="Cari nama…"
                    class="border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm w-52
                          focus:outline-none focus:ring-2 focus:ring-green-500 transition">
            </div>
            <button
                class="bg-green-600 hover:bg-green-700 active:scale-[0.98]
                       text-white px-4 py-2 rounded-xl text-sm transition">
                Cari
            </button>
            @if (isset($keyword))
                <a href="{{ route('personil.index') }}"
                    class="px-3 py-2 rounded-xl text-sm text-gray-400 hover:text-gray-600
                      border border-gray-200 hover:border-gray-300 transition">
                    ✕
                </a>
            @endif
        </form>
    </div>

    @if ($personils->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <p class="text-4xl mb-3">🔍</p>
            <p class="text-sm">
                Tidak ada data personil{{ isset($keyword) ? ' untuk "' . $keyword . '"' : '' }}.
            </p>
            @if (isset($keyword))
                <a href="{{ route('personil.index') }}" class="inline-block mt-3 text-xs text-green-600 hover:underline">
                    Lihat semua personil
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($personils as $p)
                <div
                    class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-100
                transition-all duration-200 hover:-translate-y-0.5 p-5 text-center group">
                    @if ($p->foto)
                        <img src="{{ Storage::url($p->foto) }}" alt="{{ $p->nama }}"
                            class="w-16 h-16 rounded-full object-cover mx-auto mb-3
                        ring-2 ring-green-100 group-hover:ring-green-300 transition">
                    @else
                        <div
                            class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center
                        mx-auto mb-3 ring-2 ring-green-100 group-hover:ring-green-300 transition">
                            <span class="text-green-700 font-bold text-xl">
                                {{ strtoupper(substr($p->nama, 0, 1)) }}
                            </span>
                        </div>
                    @endif

                    <p class="font-semibold text-sm leading-tight">{{ $p->nama }}</p>
                    <p class="text-xs text-green-600 font-medium mt-0.5">{{ $p->jabatan }}</p>

                    @if ($p->nip)
                        <p class="text-xs text-gray-300 font-mono mt-0.5">{{ $p->nip }}</p>
                    @endif

                    @if ($p->quote)
                        <p class="text-xs text-gray-400 italic mt-2 line-clamp-2 leading-relaxed">
                            "{{ $p->quote }}"
                        </p>
                    @endif

                    @if ($p->sosial_media)
                        <a href="{{ $p->sosial_media }}" target="_blank" rel="noopener"
                            class="inline-block mt-2 text-xs text-blue-400 hover:text-blue-600 transition">
                            🔗 Sosial Media
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($personils instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">{{ $personils->links() }}</div>
        @endif
    @endif

@endsection
