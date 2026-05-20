<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication')</title>
    
    @vite('resources/css/app.css')

    <!-- Google Font (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-[#007AFF] via-[#00E1FF] to-[#00D26A] px-4">

    <div class="relative flex flex-col md:flex-row bg-white shadow-lg rounded-3xl overflow-hidden max-w-5xl w-full">
        
        <!-- Left Side -->
        <div class="relative w-full md:w-2/5 flex flex-col justify-between p-8 text-white">
            <div class="absolute inset-0 bg-gradient-to-b from-[#007AFF] to-[#00D26A] rounded-t-3xl md:rounded-l-3xl md:rounded-tr-none"></div>
            
            <div class="relative z-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14 mb-6">
                <h2 class="text-2xl font-bold leading-tight">
                    Makanan sehat adalah kunci energi dan kebugaran sepanjang hari.
                </h2>
            </div>

            <img src="{{ asset('images/healthy-food.png') }}" alt="Healthy Food" 
                 class="absolute bottom-0 left-[18%] w-full md:w-auto md:max-w-xs lg:max-w-sm">
        </div>

        <!-- Right Side (Dynamic Content) -->
        <div class="w-full md:w-3/5 px-8 py-12">
            @yield('content')
        </div>

    </div>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>
</html>
