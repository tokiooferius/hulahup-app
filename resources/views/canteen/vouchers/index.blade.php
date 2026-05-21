@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🎟️ Manajemen Voucher</h1>
            <a href="{{ route('canteen.vouchers.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold">
                ➕ Buat Voucher
            </a>
        </div>

        @if($vouchers->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-lg text-gray-600 mb-4">Belum ada voucher</p>
                <a href="{{ route('canteen.vouchers.create') }}" class="inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                    Buat Voucher Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($vouchers as $voucher)
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-600">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900 font-mono">{{ $voucher->code }}</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if(now() >= $voucher->valid_from && now() <= $voucher->valid_to) bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">
                                @if(now() >= $voucher->valid_from && now() <= $voucher->valid_to)
                                    ✓ Aktif
                                @else
                                    ✗ Tidak Aktif
                                @endif
                            </span>
                        </div>

                        <p class="text-gray-600 mb-4">{{ $voucher->description }}</p>

                        <div class="grid grid-cols-2 gap-4 mb-4 pb-4 border-b">
                            <div>
                                <p class="text-sm text-gray-600">Diskon</p>
                                <p class="font-bold text-lg text-purple-600">
                                    @if($voucher->discount_percentage)
                                        {{ $voucher->discount_percentage }}%
                                    @else
                                        Rp {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Terpakai</p>
                                <p class="font-bold text-lg">{{ $voucher->times_used }}/{{ $voucher->max_uses }}</p>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 mb-4">
                            Berlaku: {{ $voucher->valid_from->format('d/m/Y H:i') }} - {{ $voucher->valid_to->format('d/m/Y H:i') }}
                        </p>

                        <div class="flex gap-2">
                            <a href="{{ route('canteen.vouchers.edit', $voucher->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded text-center font-semibold text-sm">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('canteen.vouchers.destroy', $voucher->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus voucher ini?')" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded font-semibold text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $vouchers->links() }}
            </div>
        @endif

        <a href="{{ route('canteen.dashboard') }}" class="mt-6 inline-block text-blue-600 hover:text-blue-700 font-semibold">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
