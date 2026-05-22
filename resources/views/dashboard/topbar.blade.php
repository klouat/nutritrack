@php
    $topbarProfilePhoto = Auth::user()->foto_profil ? asset(Auth::user()->foto_profil) : null;
@endphp

<div class="flex items-center justify-between bg-white p-4 border-b border-gray-200 shadow-sm relative pb-5">
    <!-- Title centered responsively -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <h1 class="text-2xl sm:text-3xl font-semibold text-[#1B1C57] font-['Poppins']">
            @yield('title')
        </h1>
    </div>

    <!-- Right section: notification & user -->
    <div class="flex items-center space-x-4 ml-auto z-10">
        @if ($topbarProfilePhoto)
            <img
                src="{{ $topbarProfilePhoto }}"
                alt="Foto Profil"
                class="h-10 w-10 rounded-full object-cover shadow"
            />
        @else
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-[#003266]">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <span class="font-semibold text-sm text-black hidden sm:inline">{{ Auth::user()->name }}</span>
    </div>
</div>
