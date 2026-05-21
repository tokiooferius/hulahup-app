@extends('layouts.app')

@section('title', 'Daftar Kantin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-slate-900 flex items-center justify-center gap-2 mb-2">
                <i class="fas fa-store text-orange-500 text-5xl"></i>
                Daftar Kantin
            </h1>
            <p class="text-slate-600 text-lg">Jelajahi semua kantin yang tersedia dan lihat menu mereka</p>
            <div class="flex justify-center mt-4">
                <a href="/home" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
                    <i class="fas fa-home"></i>
                    Kembali ke Home
                </a>
            </div>
        </div>

        @if($canteens->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum Ada Kantin</h3>
                <p class="text-slate-600">Kantin sedang siap dibuka. Nantikan segera! 🏪</p>
            </div>
        @else
            <!-- Canteens Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($canteens as $canteen)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden group cursor-pointer"
                         onclick="location.href='/canteens/{{ $canteen->id }}'">
                        
                        <!-- Cover Image -->
                        <div class="relative h-40 bg-gradient-to-br from-orange-400 to-orange-500 overflow-hidden">
                            <img src="{{ $canteen->logo_url ?? 'https://via.placeholder.com/400x200?text=' . urlencode($canteen->name) }}" 
                                 alt="{{ $canteen->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <!-- Name & Owner -->
                            <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $canteen->name }}</h3>
                            <p class="text-sm text-slate-600 mb-3">
                                <i class="fas fa-user-tie text-orange-500"></i>
                                {{ $canteen->ibuKantin->name ?? 'Admin' }}
                            </p>

                            <!-- Description -->
                            @if($canteen->description)
                                <p class="text-sm text-slate-600 mb-3 line-clamp-2">{{ $canteen->description }}</p>
                            @endif

                            <!-- Stats Row -->
                            <div class="grid grid-cols-3 gap-3 mb-4 py-3 border-y border-slate-200">
                                <div class="text-center">
                                    <p class="text-lg font-bold text-orange-500">{{ $canteen->menus->count() }}</p>
                                    <p class="text-xs text-slate-600">Menu</p>
                                </div>
                                <div class="text-center border-l border-r border-slate-200">
                                    <p class="text-lg font-bold text-blue-500">{{ $canteen->completed_orders }}</p>
                                    <p class="text-xs text-slate-600">Selesai</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-lg font-bold text-yellow-500">{{ number_format($canteen->rating, 1) }}</p>
                                    <p class="text-xs text-slate-600">Rating</p>
                                </div>
                            </div>

                            <!-- Rating Stars -->
                            <div class="flex items-center gap-1 mb-4">
                                @php
                                    $rating = floor($canteen->rating);
                                    $hasHalf = ($canteen->rating - $rating) >= 0.5;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @elseif($i == $rating + 1 && $hasHalf)
                                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                                    @else
                                        <i class="far fa-star text-slate-300"></i>
                                    @endif
                                @endfor
                                <span class="text-xs text-slate-600 ml-1">({{ $canteen->completed_orders }} orders)</span>
                            </div>

                            <!-- CTA Button -->
                            <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-right"></i>
                                Lihat Menu
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
