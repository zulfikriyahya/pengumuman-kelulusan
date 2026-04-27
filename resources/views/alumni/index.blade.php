@extends('layouts.app')
@section('title', 'Alumni')

@push('styles')
    @include('partials._people-styles')
@endpush

@section('content')
    @include('partials._page-header', [
        'title'       => 'Alumni',
        'searchRoute' => 'alumni.cari',
        'clearRoute'  => 'alumni.index',
        'placeholder' => 'Nama atau NISN',
        'keyword'     => $keyword ?? null,
        'totalFound'  => $items->total() ?? null,
    ])

    @include('partials._people-grid', [
        'items'     => $items,
        'photoKey'  => 'foto',
        'subKey'    => 'tahun_lulus',
        'subPrefix' => 'Lulus ',
        'monoKey'   => 'nisn',
        'keyword'   => $keyword ?? null,
    ])
@endsection
