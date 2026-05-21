@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🍽️ Manajemen Menu</h1>
            <a href="{{ route('canteen.menus.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                ➕ Tambah Menu
            </a>
        </div>

        @if($menus->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-lg text-gray-600 mb-4">Belum ada menu</p>
                <a href="{{ route('canteen.menus.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Tambah Menu Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($menus as $menu)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        @if($menu->image_url)
                            <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                <span class="text-4xl">🍴</span>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-900">{{ $menu->name }}</h3>
                            <p class="text-sm text-gray-600 capitalize">{{ $menu->category }}</p>
                            <p class="text-gray-700 text-sm mt-2">{{ $menu->description }}</p>
                            <p class="text-blue-600 font-bold text-lg mt-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                            
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('canteen.menus.edit', $menu->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded text-center font-semibold">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('canteen.menus.destroy', $menu->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus menu ini?')" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded font-semibold">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $menus->links() }}
            </div>
        @endif

        <a href="{{ route('canteen.dashboard') }}" class="mt-6 inline-block text-blue-600 hover:text-blue-700 font-semibold">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
