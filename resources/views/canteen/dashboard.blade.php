@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">🍴 Dashboard Kantin</h1>
                <p class="text-gray-600">{{ $canteen->name }}</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Saldo: <span class="font-bold text-lg text-green-600">Rp {{ number_format($canteen->balance, 0, ',', '.') }}</span></span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Menu</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalMenus }}</p>
                    </div>
                    <span class="text-4xl">🍽️</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Voucher Aktif</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalVouchers }}</p>
                    </div>
                    <span class="text-4xl">🎟️</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
                    </div>
                    <span class="text-4xl">📦</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Pendapatan</p>
                        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <span class="text-4xl">💰</span>
                </div>
            </div>
        </div>

        <!-- Order Status Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-700 text-sm font-semibold">Pending</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $pendingOrders }}</p>
                    </div>
                    <span class="text-4xl">⏳</span>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-700 text-sm font-semibold">Diproses</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $processingOrders }}</p>
                    </div>
                    <span class="text-4xl">🔄</span>
                </div>
            </div>

            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-700 text-sm font-semibold">Selesai</p>
                        <p class="text-3xl font-bold text-green-600">{{ $completedOrders }}</p>
                    </div>
                    <span class="text-4xl">✅</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('canteen.menus.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md p-6 text-center transition">
                <p class="text-3xl mb-2">➕</p>
                <p class="font-bold">Tambah Menu</p>
                <p class="text-sm text-blue-100">Tambah item makanan baru</p>
            </a>

            <a href="{{ route('canteen.vouchers.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow-md p-6 text-center transition">
                <p class="text-3xl mb-2">🎟️</p>
                <p class="font-bold">Buat Voucher</p>
                <p class="text-sm text-purple-100">Buat promo/diskon baru</p>
            </a>

            <a href="{{ route('canteen.sales') }}" class="bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md p-6 text-center transition">
                <p class="text-3xl mb-2">📊</p>
                <p class="font-bold">Lihat Penjualan</p>
                <p class="text-sm text-green-100">Detail pesanan & pendapatan</p>
            </a>

            <a href="{{ route('canteen.orders.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white rounded-lg shadow-md p-6 text-center transition">
                <p class="text-3xl mb-2">📋</p>
                <p class="font-bold">Kelola Pesanan</p>
                <p class="text-sm text-orange-100">Update status pesanan real-time</p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">📋 Pesanan Terbaru</h2>
                @if($recentOrders->isEmpty())
                    <p class="text-gray-500 text-center py-8">Belum ada pesanan</p>
                @else
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                            <div class="border rounded-lg p-3 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-900 font-bold mt-2">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                <a href="{{ route('canteen.sales') }}" class="mt-4 block text-center text-blue-600 hover:text-blue-700 font-semibold">
                    Lihat Semua Pesanan →
                </a>
            </div>

            <!-- Pending Payments -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">💳 Pembayaran Pending</h2>
                @if($pendingPayments->isEmpty())
                    <p class="text-gray-500 text-center py-8">Tidak ada pembayaran pending</p>
                @else
                    <div class="space-y-3">
                        @foreach($pendingPayments as $payment)
                            <div class="border rounded-lg p-3 bg-yellow-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $payment->payment->transaction_code }}</p>
                                        <p class="text-sm text-gray-600">{{ $payment->payment->user->name }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        Menunggu
                                    </span>
                                </div>
                                <p class="text-gray-900 font-bold mt-2">Rp {{ number_format($payment->amount_for_canteen, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                <a href="{{ route('canteen.payments') }}" class="mt-4 block text-center text-blue-600 hover:text-blue-700 font-semibold">
                    Lihat Semua Pembayaran →
                </a>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('canteen.menus.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg p-4 font-semibold transition">
                🍽️ Kelola Menu
            </a>
            <a href="{{ route('canteen.vouchers.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg p-4 font-semibold transition">
                🎟️ Kelola Voucher
            </a>
        </div>
    </div>
</div>
@endsection
