@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">➕ Tambah Menu Baru</h1>

        <form action="{{ route('canteen.menus.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-8">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Nasi Kuning">
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="category" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="heavy">🍚 Makanan Berat</option>
                    <option value="beverage">🥤 Minuman</option>
                    <option value="snack">🍪 Snack</option>
                </select>
                @error('category') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                <input type="number" name="price" required min="0" step="1000" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="15000">
                @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Deskripsi menu..."></textarea>
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">📸 Upload Foto Menu</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG (Maks 2MB)</p>
                @error('image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">
                    ✓ Simpan Menu
                </button>
                <a href="{{ route('canteen.menus.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-3 rounded-lg text-center transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
