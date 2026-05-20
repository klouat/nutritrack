@extends('dashboard.sidebar')

@section('title', 'Pilihan Sehat')

@section('content')
    <div id="TambahPilihanSehat-app"></div>
    @vite('resources/js/createpilihansehat.js')
@endsection
