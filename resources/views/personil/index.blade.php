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
        'totalFound' => $items->count() ?? null,
    ])

    @include('partials._people-grid', [
        'items' => $items,
        'photoKey' => 'foto',
        'subKey' => 'jabatan',
        'subColor' => 'var(--teal-xl)',
        'keyword' => $keyword ?? null,
    ])
@endsection
