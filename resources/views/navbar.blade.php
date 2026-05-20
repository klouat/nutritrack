<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>@yield('title', 'NutriTrack')</title>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   @vite('resources/css/app.css')
   <style>
       body {
           font-family: 'Poppins', sans-serif;
       }

       /* Scroller */
       .scroller__inner {
           display: flex;
           gap: 1rem;
           flex-wrap: nowrap;
           width: max-content;
           animation: scroll 40s linear infinite;
       }

       .scroller:hover .scroller__inner {
           animation-play-state: paused;
       }

       @keyframes scroll {
           to {
               transform: translateX(calc(-50% - 0.5rem));
           }
       }

       /* Mobile Menu */
       #menu {
           transition: max-height 0.3s ease-in-out;
       }
   </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4 px-6">
        <div class="container mx-auto flex justify-between items-center relative">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="NutriTrack Logo" class="h-10">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-[#007AFF] to-[#00D26A] bg-clip-text text-transparent">
                    NutriTrack
                </h1>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex space-x-6 text-white bg-gradient-to-r from-[#007AFF] to-[#00D26A] px-6 py-2 rounded-full items-center justify-center">
                <a href="#" class="px-4 py-2 hover:opacity-80">Program</a>
                <a href="#" class="px-4 py-2 hover:opacity-80">FAQ</a>
                <a href="#" class="px-4 py-2 hover:opacity-80">Tentang Kami</a>
                <a href="#" class="px-4 py-2 hover:opacity-80">Testimoni</a>
            </div>

            <div class="hidden lg:flex space-x-6 text-white bg-gradient-to-r from-[#007AFF] to-[#00D26A] px-6 py-2 rounded-full items-center justify-center">
                <a href="{{ route('login') }}" class="px-4 py-2 hover:opacity-80">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 hover:opacity-80">Register</a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="lg:hidden focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="menu" class="hidden flex flex-col items-center bg-white shadow-md py-4 space-y-4 lg:hidden">
            <a href="#" class="px-4 py-2 text-gray-800">Program</a>
            <a href="#" class="px-4 py-2 text-gray-800">FAQ</a>
            <a href="#" class="px-4 py-2 text-gray-800">Tentang Kami</a>
            <a href="#" class="px-4 py-2 text-gray-800">Testimoni</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

</body>
</html>
