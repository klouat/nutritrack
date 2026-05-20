@extends('auth.layouts') 

@section('title', 'Login - NutriTrack')

@section('content')
    <div id="login-app"></div>
    @vite('resources/js/login.js')
@endsection
