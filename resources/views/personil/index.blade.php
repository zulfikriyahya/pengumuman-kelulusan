@extends('layouts.app')
@section('title', 'Personil')

@push('styles')
    @include('partials._people-styles')
    <style>
        .group-section {
            margin-bottom: 2.5rem;
        }

        .group-heading {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.1rem;
        }

        .group-heading-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--teal-xl);
            white-space: nowrap;
        }

        .group-heading-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .group-heading-count {
            font-size: .62rem;
            font-weight: 600;
            color: var(--muted2);
            white-space: nowrap;
        }

        /* Desktop: center dengan auto-fit */
        .group-section .people-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(160px, 100%), 175px));
            justify-content: center;
            gap: 1rem;
        }

        /* Tablet portrait */
        @media (max-width: 899px) and (min-width: 600px) {
            .group-section .people-grid {
                grid-template-columns: repeat(3, 1fr);
                justify-content: normal;
            }
        }

        /* Mobile: 2 kolom simetris — spesifisitas dinaikkan untuk override _people-styles */
        @media (max-width: 599px) {
            .group-section .people-grid.people-grid {
                grid-template-columns: repeat(2, 1fr);
                justify-content: normal;
                gap: .65rem;
            }
        }
    </style>
@endpush

@section('content')
    @include('partials._page-header', [
        'title' => 'Personil',
        'searchRoute' => 'personil.cari',
        'clearRoute' => 'personil.index',
        'placeholder' => 'Cari nama',
        'keyword' => $keyword ?? null,
        'totalFound' => $items->count() ?? null,
    ])

    @php
        $groupOrder = [
            'Kepala Madrasah',
            'Wakil Kepala Madrasah',
            'Guru',
            'Kepala Tata Usaha',
            'Bendahara',
            'Staf Tata Usaha',
            'Outsourcing',
            'Komite Madrasah',
        ];

        $grouped = $items->groupBy('jabatan');

        $ordered = collect();
        foreach ($groupOrder as $jabatan) {
            if ($grouped->has($jabatan) && $grouped[$jabatan]->isNotEmpty()) {
                $ordered->put($jabatan, $grouped[$jabatan]);
            }
        }

        $lainnya = collect();
        foreach ($grouped as $jabatan => $anggota) {
            if (!in_array($jabatan, $groupOrder)) {
                $lainnya = $lainnya->merge($anggota);
            }
        }
        if ($lainnya->isNotEmpty()) {
            $ordered->put('Lainnya', $lainnya);
        }
    @endphp

    @if ($items->isEmpty())
        @include('partials._people-grid', [
            'items' => $items,
            'photoKey' => 'foto',
            'subKey' => 'jabatan',
            'subColor' => 'var(--teal-xl)',
            'keyword' => $keyword ?? null,
        ])
    @else
        @foreach ($ordered as $jabatan => $anggota)
            @if ($anggota->isEmpty())
                @continue
            @endif

            <div class="group-section">
                <div class="group-heading">
                    <span class="group-heading-label">{{ $jabatan }}</span>
                    <span class="group-heading-line"></span>
                    <span class="group-heading-count">{{ $anggota->count() }} orang</span>
                </div>

                @include('partials._people-grid', [
                    'items' => $anggota,
                    'photoKey' => 'foto',
                    'subKey' => 'jabatan',
                    'subColor' => 'var(--teal-xl)',
                    'keyword' => $keyword ?? null,
                ])
            </div>
        @endforeach
    @endif
@endsection
