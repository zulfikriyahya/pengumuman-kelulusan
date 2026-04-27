@extends('layouts.app')
@section('title', 'Personil')

@push('styles')
    @include('partials._people-styles')
@endpush

@section('content')
    @include('partials._page-header', [
        'title' => 'Personil',
        'searchRoute' => 'personil.cari',
        'clearRoute' => 'personil.index',
        'placeholder' => 'Cari nama',
        'keyword' => $keyword ?? null,
        'totalFound' => $personils->count() ?? null,
    ])

    @include('partials._people-grid', [
        'items' => $personils,
        'photoKey' => 'foto',
        'subKey' => 'jabatan',
        'subPrefix' => '',
        'subColor' => 'var(--teal-xl)',
        // 'monoKey' => 'nip',
        'keyword' => $keyword ?? null,
    ])
@endsection
