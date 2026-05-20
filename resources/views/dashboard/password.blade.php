@extends('dashboard.sidebar')

@section('title', 'Ganti Password')

@section('content')
@if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        class="fixed top-5 right-5 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 transition-all"
        x-transition
    >
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $isGoogleUser = auth()->user()->google_id ? true : false;
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="md:col-span-2 bg-white rounded-2xl shadow p-6">
    <h2 class="text-xl font-semibold mb-2">Password</h2>
    <p class="text-sm text-gray-500 mb-6">Ganti Password Anda Disini</p>

<form action="{{ route('profil.password.update') }}" method="POST" class="space-y-4">
    @csrf

    <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
        <label class="font-semibold text-[#003266] text-md">Password Lama</label>
        <div class="relative sm:col-span-2 w-full">
            <input
                type="password"
                id="old_password"
                name="old_password"
                class="border border-blue-400 rounded-xl px-4 py-2 w-full pr-10"
                @if($isGoogleUser) readonly @endif
            />
            @if(!$isGoogleUser)
            <i class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500"
                onclick="togglePassword('old_password', this)"></i>
            @endif
        </div>
        @if($isGoogleUser)
            <p class="text-sm text-yellow-600 mt-1">Tidak bisa ganti password karena login menggunakan Google.</p>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
        <label class="font-semibold text-[#003266] text-md">Password Baru</label>
        <div class="relative sm:col-span-2 w-full">
            <input
                type="password"
                id="new_password"
                name="new_password"
                class="border border-blue-400 rounded-xl px-4 py-2 w-full pr-10"
                @if($isGoogleUser) readonly @endif
            />
            @if(!$isGoogleUser)
            <i class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500"
                onclick="togglePassword('new_password', this)"></i>
            @endif
        </div>
        @if($isGoogleUser)
            <p class="text-sm text-yellow-600 mt-1">Tidak bisa ganti password karena login menggunakan Google.</p>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
        <label class="font-semibold text-[#003266] text-md">Konfirmasi Password Baru</label>
        <div class="relative sm:col-span-2 w-full">
            <input
                type="password"
                id="new_password_confirmation"
                name="new_password_confirmation"
                class="border border-blue-400 rounded-xl px-4 py-2 w-full pr-10"
                @if($isGoogleUser) readonly @endif
            />
            @if(!$isGoogleUser)
            <i class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500"
                onclick="togglePassword('new_password_confirmation', this)"></i>
            @endif
        </div>
        @if($isGoogleUser)
            <p class="text-sm text-yellow-600 mt-1">Tidak bisa ganti password karena login menggunakan Google.</p>
        @endif
    </div>

    <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
        <a href="{{ url()->previous() }}"
            class="px-6 py-2 rounded-xl border border-blue-300 text-blue-600 hover:bg-blue-50 transition w-full sm:w-auto">
            Kembali
        </a>

        <button
            type="submit"
            class="px-6 py-2 rounded-xl text-white bg-gradient-to-r from-blue-500 to-green-400 hover:opacity-90 transition w-full sm:w-auto"
            @if($isGoogleUser) disabled title="Tidak bisa ganti password karena login Google" @endif
        >
            Simpan
        </button>
    </div>
</form>
</div>

<!-- Sidebar Kanan -->
<div>
    <h3 class="text-2xl text-[#003266] font-semibold mb-4">Profile Akun</h3>
    <ul class="space-y-2 text-[#003266]">
        <li><a href="{{ route('profil') }}">Info Personal</a></li>
        <li><a href="{{ route('profil.password.update') }}" class="font-semibold border-b border-blue-500">Password</a></li>
        <li>
            <form method="POST" action="{{ route('profil.destroy') }}" id="delete-account-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDeletion()">
                    Hapus Akun
                </button>
            </form>
            <!-- Popup Konfirmasi Hapus Akun -->
            <div id="popup-blur" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center">
                    <h2 class="text-xl font-semibold mb-4">Konfirmasi Hapus Akun</h2>
                    <p class="mb-6">Apakah Anda yakin ingin menghapus akun?</p>
                    <div class="flex justify-center gap-4">
                        <button type="button" onclick="submitDeleteForm()" class="w-1/2 px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">Ya</button>
                        <button type="button" onclick="closePopup()" class="w-1/2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Tidak</button>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
</div>

<style>
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
</style>

<script>
    function togglePassword(id, el) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            el.classList.remove('fa-eye');
            el.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            el.classList.remove('fa-eye-slash');
            el.classList.add('fa-eye');
        }
    }
    function confirmDeletion() {
        document.getElementById('popup-blur').classList.remove('hidden');
    }
    function closePopup() {
        document.getElementById('popup-blur').classList.add('hidden');
    }
    function submitDeleteForm() {
        document.getElementById('delete-account-form').submit();
    }
</script>
@endsection
