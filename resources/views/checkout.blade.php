@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">💳 Konfirmasi Pesanan</h1>

        <form action="{{ route('payment.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($checkout['cart_by_canteen'] as $canteenId => $canteenData)
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            Kantin #{{ $canteenId }}
                        </h2>

                        <div class="space-y-2 border-b pb-4 mb-4">
                            @foreach($canteenData['items'] as $item)
                                <div class="flex justify-between">
                                    <span class="text-gray-700">{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                                    <span class="font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between font-bold text-lg">
                            <span>Subtotal:</span>
                            <span class="text-green-600">Rp {{ number_format($canteenData['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Payment Summary -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Pembayaran</h3>

                    <!-- Payment Method -->
                    <div class="mb-6 pb-6 border-b">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="midtrans" checked class="w-4 h-4">
                                <span class="ml-2 text-gray-700">💳 Midtrans (Coming Soon)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="space-y-3 mb-6 pb-6 border-b">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span class="font-semibold">Rp {{ number_format($checkout['grand_total'] + $checkout['discount'], 0, ',', '.') }}</span>
                        </div>
                        @if($checkout['discount'] > 0)
                            <div class="flex justify-between text-gray-700">
                                <span>Diskon:</span>
                                <span class="font-semibold text-red-600">-Rp {{ number_format($checkout['discount'], 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between mb-6 text-xl border-b pb-6">
                        <span class="font-bold text-gray-900">Total Pembayaran:</span>
                        <span class="font-bold text-green-600">Rp {{ number_format($checkout['grand_total'], 0, ',', '.') }}</span>
                    </div>

                    <!-- Pay Button -->
                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">
                        ✓ Proses Pembayaran
                    </button>

                    <!-- Back Button -->
                    <a href="/cart" class="block text-center mt-3 text-blue-600 hover:text-blue-700 font-semibold">
                        ← Kembali ke Keranjang
                    </a>

                    <!-- Info -->
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded p-3">
                        <p class="text-xs text-yellow-800">
                            <strong>⚠️ Note:</strong> Midtrans belum diintegrasikan. Implementasi sedang dalam tahap development.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
