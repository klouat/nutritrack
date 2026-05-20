@extends('auth.layouts') 

@section('title', 'Register - NutriTrack')

@section('content')
    <div id="register-app"></div>
    @vite('resources/js/register.js')
@endsection
