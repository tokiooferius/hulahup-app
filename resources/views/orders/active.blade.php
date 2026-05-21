@extends('layouts.app')

@section('title', 'Pesanan Aktif')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-2">
                    <i class="fas fa-clock text-orange-500"></i>
                    Pesanan Aktif
                </h1>
                <p class="text-slate-600 mt-2">Pantau status pesanan kamu yang sedang diproses</p>
            </div>
            <div class="flex gap-3">
                <button onclick="location.reload()" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-sync"></i> Refresh
                </button>
                <a href="/home" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-home"></i> Kembali ke Home
                </a>
            </div>
        </div>

        @if($orders->isEmpty())
            <!-- Auto Refresh Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 flex items-center gap-3">
                <i class="fas fa-info-circle text-blue-600"></i>
                <span class="text-blue-800">Halaman akan auto-refresh setiap 3 detik untuk status terbaru</span>
            </div>

            <!-- Orders Grid -->
            <div class="space-y-6">
                @foreach($orders as $order)
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'badge' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fas fa-hourglass-start text-yellow-600'],
                            'processing' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'badge' => 'bg-blue-100 text-blue-800', 'icon' => 'fas fa-fire text-blue-600'],
                            'completed' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'badge' => 'bg-green-100 text-green-800', 'icon' => 'fas fa-check-circle text-green-600'],
                        ];
                        $colors = $statusColors[$order->status] ?? $statusColors['pending'];
                    @endphp
                    
                    <div class="{{$colors['bg']}} border-l-4 {{$colors['border']}} rounded-lg shadow-md p-6 hover:shadow-lg transition">
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-opacity-30 border-slate-300">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">{{ $order->order_number }}</h3>
                                <p class="text-sm text-slate-600">{{ $order->canteen->name ?? 'N/A' }} • {{ $order->canteen->ibuKantin->name ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="{{$colors['badge']}} px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1 justify-end">
                                    <i class="{{$colors['icon']}} mr-1"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                                <p class="text-sm text-slate-600 mt-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="mb-4">
                            <h4 class="font-semibold text-slate-900 mb-2">
                                <i class="fas fa-box text-orange-500"></i> Pesanan Kamu:
                            </h4>
                            <div class="bg-white bg-opacity-50 rounded-lg p-3 space-y-2">
                                @php
                                    $items = is_array($order->items) ? $order->items : json_decode($order->items, true) ?? [];
                                @endphp
                                @foreach($items as $item)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-700">
                                            <span class="font-medium">{{ $item['name'] ?? 'Unknown' }}</span>
                                            <span class="text-slate-600">x{{ $item['qty'] ?? 1 }}</span>
                                        </span>
                                        <span class="text-slate-900 font-semibold">Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Status Progress -->
                        <div class="mb-4">
                            <h4 class="font-semibold text-slate-900 mb-2">
                                <i class="fas fa-tasks text-purple-500"></i> Progres Pesanan:
                            </h4>
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex-1">
                                    <div class="bg-white bg-opacity-50 rounded-full h-2 overflow-hidden">
                                        @php
                                            $progress = ['pending' => 33, 'processing' => 66, 'completed' => 100][$order->status] ?? 0;
                                        @endphp
                                        <div class="h-full bg-gradient-to-r from-orange-400 to-orange-600 transition-all duration-300" style="width: {{$progress}}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-slate-600">{{$progress}}%</span>
                            </div>
                            <div class="flex justify-between text-xs text-slate-600 mt-2">
                                <span class="{{$order->status != 'pending' ? 'text-green-600 font-semibold' : ''}}">✓ Dipesan</span>
                                <span class="{{$order->status == 'processing' ? 'text-blue-600 font-semibold' : ($order->status != 'pending' ? 'text-green-600 font-semibold' : '')}}">⟳ Diproses</span>
                                <span class="{{$order->status == 'completed' ? 'text-green-600 font-semibold' : ''}}">✓ Selesai</span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="flex items-center justify-between text-xs text-slate-600">
                            <span>
                                <i class="fas fa-calendar"></i> 
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                            @if($order->status == 'processing')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-spinner fa-spin"></i> Sedang Disiapkan
                                </span>
                            @elseif($order->status == 'completed')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-check"></i> Siap Diambil
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-hourglass-end"></i> Menunggu Konfirmasi
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Auto Refresh Script -->
<script>
    // Auto refresh setiap 3 detik untuk update status real-time
    setInterval(() => {
        // Check if there are any non-completed orders
        const hasActiveOrders = document.querySelectorAll('[class*="pending"], [class*="processing"]').length > 0;
        if (hasActiveOrders) {
            // Silently refresh without showing loader
            location.reload();
        }
    }, 3000);
</script>
@endsection
