@extends('dashboard.sidebar')

@section('title', 'Daftar Konsultasi')

@section('content')
<div class="bg-slate-50 min-h-full p-4 sm:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Daftar Konsultasi</h1>
            <p class="text-slate-500 mt-1">
                Daftar percakapan dari pengguna untuk {{ ucfirst(str_replace('_', ' ', $role)) }}.
            </p>
        </div>

        <div class="mb-6">
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="divide-y divide-slate-200" id="userList">
                @forelse($users as $user)
                    <a href="{{ route('konsultasi.chat.user', $user->id) }}"
                       class="user-item flex items-center gap-4 p-5 w-full text-left transition duration-300 ease-in-out hover:bg-blue-50 focus:outline-none focus:bg-blue-100"
                       data-name="{{ strtolower($user->name) }}">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-semibold text-lg text-slate-800 truncate">{{ $user->name }}</h3>
                            <p class="text-sm text-slate-500">Lihat percakapan</p>
                        </div>
                        <div class="flex-shrink-0 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="text-center p-12">
                        <svg class="mx-auto h-20 w-20 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-slate-800">Konsultasi Kosong</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Belum ada pesan yang diterima dari pengguna manapun.
                        </p>
                    </div>
                @endforelse

                <div id="noResultsMessage" class="text-center p-12" style="display: none;">
                    <svg class="mx-auto h-20 w-20 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-slate-800">Tidak Ditemukan</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Tidak ada pengguna yang cocok dengan pencarian Anda.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const userList = document.getElementById('userList');
        const userItems = userList.querySelectorAll('.user-item');
        const noResultsMessage = document.getElementById('noResultsMessage');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();
            let visibleCount = 0;

            userItems.forEach(function (item) {
                const userName = item.dataset.name; 

                if (userName.includes(searchTerm)) {
                    item.style.display = 'flex'; 
                    visibleCount++;
                } else {
                    item.style.display = 'none'; 
                }
            });

            if (visibleCount === 0) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
        });
    });
</script>
@endsection