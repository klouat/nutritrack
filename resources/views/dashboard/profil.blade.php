@extends('dashboard.sidebar')

@section('title', 'Profil')

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

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Form Bagian Kiri -->
    <div class="md:col-span-2 bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-2">Info Personal</h2>
        <p class="text-sm text-gray-500 mb-6">Kamu bisa perbarui data pribadi kamu di sini</p>

        <form action="{{ route('profil') }}" method="POST" class="space-y-4 w-full">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                <label class="font-semibold text-[#003266] text-md">Nama</label>
                <input type="text" name="nama" value="{{ auth()->user()->name }}"
                    class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                <label class="font-semibold text-[#003266] text-md">Email Address</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}"
                    class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                <label class="font-semibold text-[#003266] text-md">No. Telp</label>
                <input type="text" name="telp" value="{{ auth()->user()->nomor_telepon }}"
                    class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                <label class="font-semibold text-[#003266] text-md">Umur</label>
                <input type="number" name="umur" value="{{ auth()->user()->umur }}"
                    class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                <label class="font-semibold text-[#003266] text-md">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ auth()->user()->pekerjaan }}"
                    class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                <label class="font-semibold text-[#003266] text-md">Riwayat Kesehatan</label>
                <input type="text" name="riwayat" value="{{ auth()->user()->riwayat_kesehatan }}"
                    class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                <label class="font-semibold text-[#003266] text-md">Alergi</label>
                <input type="text" name="alergi" value="{{ auth()->user()->alergi }}"
                    class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full" />
            </div>

            <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
                <a href="{{ url()->previous() }}"
                    class="px-6 py-2 rounded-xl border border-blue-300 text-blue-600 hover:bg-blue-50 transition w-full sm:w-auto">
                    Kembali
                </a>
                <button type="submit"
                    class="px-6 py-2 rounded-xl text-white bg-gradient-to-r from-blue-500 to-green-400 hover:opacity-90 transition w-full sm:w-auto">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Sidebar Kanan -->
<div>
    <h3 class="text-2xl text-[#003266] font-semibold mb-4">Profile Akun</h3>
    <ul class="space-y-2 text-[#003266]">
        <li>
            <a href="#" class="font-semibold border-b border-blue-500">Info Personal</a>
        </li>
        <li>
            <a href="{{ route('profil.password.update') }}">Password</a>
        </li>
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
                    <div class="flex justify-center gap-4 w-full">
                        <button type="button" onclick="submitDeleteForm()" class="w-1/2 px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">Ya</button>
                        <button type="button" onclick="closePopup()" class="w-1/2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Tidak</button>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>

@endsection

<style>
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
</style>

<script>
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
