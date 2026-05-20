@extends('dashboard.sidebar')

@section('title', 'Pilihan Sehat')

@section('content')
<h1 class="text-3xl sm:text-4xl text-center font-bold bg-gradient-to-r from-[#007AFF] to-[#00D26A] bg-clip-text text-transparent mb-6 font-['Poppins']">
    @if(request()->segment(2))
        {{ ucfirst(request()->segment(2)) }} Sehat
    @elseif($items->first())
        {{ $items->first()->judul }}
    @else
        Pilihan Sehat
    @endif
</h1>

<div class="space-y-6">
    @forelse($items as $item)
        <div class="bg-blue-100 p-6 rounded-xl shadow-md flex flex-col md:flex-row gap-4 md:gap-6 items-center">
            @if($item->gambar_path)
                <img src="{{ asset($item->gambar_path) }}" alt="{{ $item->nama }}"
                     class="rounded-lg object-cover w-full h-48 md:w-40 md:h-32 flex-shrink-0" />
            @else
                <div class="rounded-lg w-full h-48 md:w-40 md:h-32 flex-shrink-0 bg-white/70 text-gray-400 flex items-center justify-center font-medium">
                    Tidak ada gambar
                </div>
            @endif
            
            <div class="text-center md:text-left">
                <h3 class="font-semibold text-xl sm:text-2xl font-['Poppins']">{{ $item->nama }}</h3>
                <p class="text-base sm:text-lg text-gray-700 mt-2">
                    {{ $item->deskripsi }}
                </p>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500">Tidak ada pilihan sehat yang tersedia untuk kategori ini.</p>
    @endforelse
</div>
@endsection
