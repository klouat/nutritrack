@extends('dashboard.sidebar')

@section('title', 'Catatan Asupan')

@section('content')
    <div id="asupan-app"></div>
    @vite('resources/js/asupan.js')
@endsection
