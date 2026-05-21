@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-black text-gray-900 mb-2">🏪 Kelola Kantin</h1>
                <p class="text-gray-600 font-medium">Manajemen semua kantin Tel-U dan ibu kantin</p>
            </div>
            <button onclick="alert('Fitur tambah kantin akan dikembangkan')" class="px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Kantin
            </button>
        </div>

        <!-- Canteens Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($canteens as $canteen)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden border-t-4 border-blue-600">
                    <!-- Canteen Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                        <h2 class="text-2xl font-bold mb-1">{{ $canteen->name }}</h2>
                        <p class="text-blue-100 text-sm">🏢 Kantin Telkom University</p>
                    </div>

                    <!-- Canteen Info -->
                    <div class="p-6 space-y-4">
                        <!-- Ibu Kantin Info -->
                        <div class="flex items-center gap-3 pb-4 border-b">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($canteen->ibuKantin->name ?? 'IK', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">IBU KANTIN</p>
                                <p class="text-sm font-bold text-gray-900">{{ $canteen->ibuKantin->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $canteen->ibuKantin->email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-black text-blue-600">{{ $canteen->orders_count }}</div>
                                <div class="text-xs font-bold text-gray-600 uppercase tracking-wider">Pesanan</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-black text-green-600">{{ $canteen->menus_count }}</div>
                                <div class="text-xs font-bold text-gray-600 uppercase tracking-wider">Menu</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-black text-purple-600">{{ $canteen->vouchers_count }}</div>
                                <div class="text-xs font-bold text-gray-600 uppercase tracking-wider">Voucher</div>
                            </div>
                        </div>

                        <!-- Address -->
                        @if($canteen->address)
                            <div class="text-sm text-gray-700 p-3 bg-gray-50 rounded-lg">
                                <p class="font-bold mb-1">📍 Lokasi:</p>
                                <p>{{ $canteen->address }}</p>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                ✅ Aktif
                            </span>
                            <div class="flex gap-2">
                                <button onclick="alert('Fitur edit kantin akan dikembangkan')" class="text-blue-600 hover:text-blue-800 font-bold text-sm">
                                    ✏️ Edit
                                </button>
                                <button onclick="alert('Fitur lihat detail kantin akan dikembangkan')" class="text-gray-600 hover:text-gray-800 font-bold text-sm">
                                    👁️ Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-lg shadow-sm">
                    <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">Belum ada kantin terdaftar</p>
                </div>
            @endforelse
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-12">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 font-medium text-sm">Total Kantin</p>
                        <p class="text-4xl font-black text-blue-600">{{ $canteens->count() }}</p>
                    </div>
                    <i class="fas fa-store text-5xl text-blue-200 opacity-50"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 font-medium text-sm">Total Menu</p>
                        <p class="text-4xl font-black text-green-600">{{ $canteens->sum('menus_count') }}</p>
                    </div>
                    <i class="fas fa-utensils text-5xl text-green-200 opacity-50"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 font-medium text-sm">Total Voucher</p>
                        <p class="text-4xl font-black text-purple-600">{{ $canteens->sum('vouchers_count') }}</p>
                    </div>
                    <i class="fas fa-ticket-alt text-5xl text-purple-200 opacity-50"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 font-medium text-sm">Total Pesanan</p>
                        <p class="text-4xl font-black text-orange-600">{{ $canteens->sum('orders_count') }}</p>
                    </div>
                    <i class="fas fa-list-check text-5xl text-orange-200 opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Table View for Details -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mt-12">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Kantin</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Ibu Kantin</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Pesanan</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Menu</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Voucher</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($canteens as $canteen)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 font-bold text-blue-600">{{ $canteen->name }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $canteen->ibuKantin->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $canteen->ibuKantin->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                                    {{ $canteen->orders_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">
                                    {{ $canteen->menus_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-bold">
                                    {{ $canteen->vouchers_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">✅ Aktif</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
