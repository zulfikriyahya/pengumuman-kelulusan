@extends('layouts.app')
@section('title', 'Alumni')

@push('styles')
    @include('partials._people-styles')
@endpush

@section('content')
    @include('partials._page-header', [
        'title' => 'Alumni',
        'searchRoute' => 'alumni.cari',
        'clearRoute' => 'alumni.index',
        'placeholder' => 'Nama atau NISN',
        'keyword' => $keyword ?? null,
        'totalFound' => $alumnis->total() ?? null,
    ])

    @include('partials._people-grid', [
        'items' => $alumnis,
        'photoKey' => 'avatar',
        'subKey' => 'tahun_lulus',
        'subPrefix' => 'Lulus ',
        'subColor' => '',
        'monoKey' => 'nisn',
        'keyword' => $keyword ?? null,
    ])
@endsection
