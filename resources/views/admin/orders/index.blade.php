@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">📋 Monitoring Pesanan</h1>
            <p class="text-gray-600 font-medium">Pantau semua pesanan dari seluruh kantin Tel-U</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status Pesanan</label>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="all" {{ $currentStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="processing" {{ $currentStatus === 'processing' ? 'selected' : '' }}>👨‍🍳 Diproses</option>
                        <option value="completed" {{ $currentStatus === 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kantin</label>
                    <select name="canteen_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="all" {{ $currentCanteen === 'all' ? 'selected' : '' }}>Semua Kantin</option>
                        @foreach($canteens as $canteen)
                            <option value="{{ $canteen->id }}" {{ $currentCanteen == $canteen->id ? 'selected' : '' }}>
                                {{ $canteen->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                    🔍 Filter
                </button>

                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 font-bold rounded-lg hover:bg-gray-400 transition">
                    ↻ Reset
                </a>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($orders->count() > 0)
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold">No. Pesanan</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Kantin</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Total</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Waktu Pesan</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 font-bold text-blue-600">{{ $order->order_number }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $order->canteen->name ?? '❌ N/A' }}
                                    </div>
                                    @if($order->canteen)
                                        <div class="text-xs text-gray-500">{{ $order->canteen->ibuKantin->name ?? 'Ibu Kantin' }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-green-600">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($order->status === 'pending')
                                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">⏳ Menunggu</span>
                                    @elseif($order->status === 'processing')
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">👨‍🍳 Diproses</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">✅ Selesai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="showOrderDetail('{{ $order->id }}', '{{ $order->order_number }}')" class="text-blue-600 hover:text-blue-800 font-bold">
                                        👁️ Lihat
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">Tidak ada pesanan untuk ditampilkan</p>
                </div>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 font-medium text-sm">⏳ Menunggu</p>
                        <p class="text-4xl font-black text-yellow-600">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
                    </div>
                    <i class="fas fa-hourglass-half text-5xl text-yellow-200 opacity-50"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 font-medium text-sm">👨‍🍳 Diproses</p>
                        <p class="text-4xl font-black text-blue-600">{{ \App\Models\Order::where('status', 'processing')->count() }}</p>
                    </div>
                    <i class="fas fa-fire text-5xl text-blue-200 opacity-50"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 font-medium text-sm">✅ Selesai</p>
                        <p class="text-4xl font-black text-green-600">{{ \App\Models\Order::where('status', 'completed')->count() }}</p>
                    </div>
                    <i class="fas fa-check-circle text-5xl text-green-200 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Detail Modal (Bisa di-expand di masa depan) -->
<script>
    function showOrderDetail(orderId, orderNumber) {
        alert(`Detail pesanan ${orderNumber} - ID: ${orderId}\n\n(Fitur detail pesanan akan dikembangkan lebih lanjut)`);
    }
</script>
@endsection
