@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">📊 Penjualan & Pesanan</h1>
            <div class="text-right">
                <p class="text-gray-600">Total Pendapatan</p>
                <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-lg text-gray-600 mb-4">Belum ada pesanan</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">No. Pesanan</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Pembeli</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Total</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-mono font-semibold">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif

        <a href="{{ route('canteen.dashboard') }}" class="mt-6 inline-block text-blue-600 hover:text-blue-700 font-semibold">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
