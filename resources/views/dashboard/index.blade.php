@extends('dashboard.sidebar')

@section('title', 'Dashboard')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @vite('resources/js/dashboard.js')
@endsection

@section('content')
    <div id="dashboard-app">
    </div>
    
    <script>
        window.dailyData = @json($dailyData);
        window.todayAsupan = @json($todayAsupan ?? []);
        window.routeCreate = "{{ route('asupan.create') }}";
    </script>
@endsection
