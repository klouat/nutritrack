@extends('dashboard.sidebar')

@section('title', 'Pilih Dokter')

@section('content')
<div class="p-6 md:p-10 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Pilih Jenis Konsultasi</h2>
            <p class="text-gray-600 mt-2">Pilih dokter yang sesuai dengan kebutuhan Anda.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            

            <a href="{{ route('konsultasi.chat.role', 'dokter_pencegahan') }}" class="group block transform hover:-translate-y-2 transition-transform duration-300">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 p-8 text-center h-full">
                    <div class="flex justify-center items-center mx-auto bg-green-100 rounded-full w-24 h-24 mb-6">
                        <svg class="w-12 h-12 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Dokter Pencegahan</h3>
                    <p class="text-gray-500">Fokus pada upaya preventif, gaya hidup sehat, dan deteksi dini untuk menjaga kesehatan Anda secara optimal.</p>
                </div>
            </a>

            {{-- Kartu Dokter Pengobatan --}}
            <a href="{{ route('konsultasi.chat.role', 'dokter_pengobatan') }}" class="group block transform hover:-translate-y-2 transition-transform duration-300">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 p-8 text-center h-full">
                    <div class="flex justify-center items-center mx-auto bg-blue-100 rounded-full w-24 h-24 mb-6">
                        <svg class="w-12 h-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h12M3.75 3h16.5M3.75 3v16.5M19.5 3v11.25A2.25 2.25 0 0117.25 16.5H6.75" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Dokter Pengobatan</h3>
                    <p class="text-gray-500">Untuk diagnosis, penanganan, dan pengobatan keluhan atau penyakit yang sedang Anda alami.</p>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection