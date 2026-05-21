<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Hulahup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-[#122C4F] text-white p-6 fixed left-0 top-0 h-screen flex flex-col">
        <div class="mb-10">
            <h1 class="text-2xl font-bold italic">Hulahup.</h1>
            <p class="text-xs opacity-60">KANTIN TEL-U PURWOKERTO</p>
        </div>
        <nav class="flex-1 space-y-2">
            <a href="/home" class="flex items-center gap-3 p-3 opacity-60 hover:opacity-100 hover:bg-[#5B88B2] rounded-xl transition">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="/canteens" class="flex items-center gap-3 p-3 opacity-60 hover:opacity-100 hover:bg-[#5B88B2] rounded-xl transition">
                <i class="fas fa-store"></i> Daftar Kantin
            </a>
            <a href="/orders/active" class="flex items-center gap-3 p-3 opacity-60 hover:opacity-100 hover:bg-[#5B88B2] rounded-xl transition">
                <i class="fas fa-clock"></i> Pesanan Aktif
            </a>
            <a href="/history" class="flex items-center gap-3 p-3 bg-[#5B88B2] rounded-xl">
                <i class="fas fa-history"></i> Riwayat Pesan
            </a>
            <a href="/topup" class="flex items-center gap-3 p-3 opacity-60 hover:opacity-100 hover:bg-[#5B88B2] rounded-xl transition">
                <i class="fas fa-wallet"></i> Saldo TyU-Pay
            </a>
        </nav>
        <div class="pt-4 border-t border-[#5B88B2]">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-900 hover:text-white rounded-xl transition w-full">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 p-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-2 mb-2">
                    <i class="fas fa-history text-orange-500"></i>
                    Riwayat Pesanan
                </h1>
                <p class="text-slate-600">Lihat semua pesanan yang sudah selesai</p>
            </div>

            @if($orders->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-inbox text-slate-300 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum Ada Riwayat Pesanan</h3>
                    <p class="text-slate-600 mb-6">Pesanan yang sudah selesai akan muncul di sini</p>
                    <a href="/canteens" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg inline-block transition">
                        Lihat Daftar Kantin
                    </a>
                </div>
            @else
                <!-- Orders List -->
                <div class="space-y-4">
                    @foreach($orders as $order)
                        @php
                            $items = is_array($order->items) ? $order->items : json_decode($order->items, true) ?? [];
                        @endphp
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6 border-l-4 border-green-500">
                            <!-- Header Row -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-slate-900">{{ $order->order_number }}</h3>
                                    <p class="text-sm text-slate-600">
                                        <i class="fas fa-store text-orange-500 mr-1"></i>
                                        {{ $order->canteen->name ?? 'N/A' }} • 
                                        <i class="fas fa-user text-blue-500 mr-1"></i>
                                        {{ $order->canteen->ibuKantin->name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>

                            <!-- Items -->
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-slate-700 mb-2">Item Pesanan:</h4>
                                <div class="space-y-2">
                                    @if(count($items) > 0)
                                        @foreach($items as $item)
                                            <div class="flex justify-between items-center text-sm bg-slate-50 p-2 rounded">
                                                <span class="text-slate-700">
                                                    {{ $item['name'] ?? 'Menu Item' }} 
                                                    <span class="text-slate-500">(x{{ $item['quantity'] ?? 1 }})</span>
                                                </span>
                                                <span class="font-semibold text-slate-900">
                                                    Rp {{ number_format($item['price'] * ($item['quantity'] ?? 1), 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-slate-500 italic">Tidak ada detail item</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </span>
                                </div>
                                @php
                                    $orderData = $order->toArray();
                                    $orderData['canteen'] = [
                                        'name' => $order->canteen->name ?? 'Kantin',
                                        'ibuKantin' => [
                                            'name' => $order->canteen->ibuKantin->name ?? 'Pemilik Kantin'
                                        ]
                                    ];
                                @endphp
                                <button onclick="showReceiptModal({{ json_encode($orderData) }})" class="text-blue-600 hover:text-blue-800 text-sm font-semibold transition">
                                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-h-[90vh] overflow-y-auto w-full max-w-md shadow-2xl">
            <!-- Receipt Content (A4/Thermal Printer Size) -->
            <div id="receiptContent" class="bg-white p-0 text-center font-mono text-sm" style="min-height: 600px; padding: 24px; padding-bottom: 40px; position: relative;">
                <!-- Decorative jagged top edge effect -->
                <div class="absolute top-0 left-0 right-0 h-3 bg-repeat-x" style="background-image: url('data:image/svg+xml;utf8,%3Csvg%20width%3D%2220%22%20height%3D%2212%22%20viewBox%3D%220%200%2020%2012%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M0%2C6%20L5%2C0%20L10%2C6%20L15%2C0%20L20%2C6%20L20%2C12%20L0%2C12%20Z%22%20fill%3D%22white%22%2F%3E%3C%2Fsvg%3E'); background-size: 20px 12px;"></div>

                <!-- Main receipt content -->
                <div style="margin-top: 16px;">
                    <!-- Header -->
                    <div class="mb-3">
                        <h1 class="text-2xl font-bold tracking-wider" style="letter-spacing: 2px;">HULAHUP</h1>
                        <p class="text-xs text-gray-600 mb-1">KANTIN TEL-U PURWOKERTO</p>
                        <p id="receiptCanteen" class="text-sm font-bold text-gray-800"></p>
                        <p id="receiptIbu" class="text-xs text-gray-700"></p>
                    </div>

                    <!-- Title -->
                    <div class="my-4">
                        <p class="text-lg font-bold tracking-widest" style="letter-spacing: 1px;">CASH RECEIPT</p>
                    </div>

                    <!-- Separator dots -->
                    <div class="my-2 text-gray-400 text-xs" style="letter-spacing: 2px;">.........................</div>

                    <!-- Order Info -->
                    <div class="text-left bg-gray-50 p-3 rounded mb-3 text-xs space-y-1">
                        <div class="flex justify-between">
                            <span>Date</span>
                            <span id="receiptDate" class="font-semibold"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Time</span>
                            <span id="receiptTime" class="font-semibold"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Order #</span>
                            <span id="receiptOrderNum" class="font-bold"></span>
                        </div>
                    </div>

                    <!-- Separator dots -->
                    <div class="my-2 text-gray-400 text-xs" style="letter-spacing: 2px;">.........................</div>

                    <!-- Items with better formatting -->
                    <div class="text-left mb-3">
                        <div id="receiptItems" class="space-y-1.5 text-xs">
                            <!-- Items akan di-generate via JS -->
                        </div>
                    </div>

                    <!-- Separator dots -->
                    <div class="my-2 text-gray-400 text-xs" style="letter-spacing: 2px;">.........................</div>

                    <!-- Total section -->
                    <div class="text-left mb-3 text-xs space-y-1.5">
                        <div class="flex justify-between font-bold text-sm">
                            <span>TOTAL</span>
                            <span id="receiptTotal" class="text-base"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Payment</span>
                            <span id="receiptPayment"></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Status</span>
                            <span class="text-green-600 font-bold">✓ PAID</span>
                        </div>
                    </div>

                    <!-- Separator dots -->
                    <div class="my-3 text-gray-400 text-xs" style="letter-spacing: 2px;">.........................</div>

                    <!-- Thank you -->
                    <div class="my-4">
                        <p class="text-lg font-bold mb-1">THANK YOU</p>
                        <p class="text-xs text-gray-600">Untuk Pesananmu</p>
                    </div>

                    <!-- Barcode simulation -->
                    <div class="my-3 flex justify-center">
                        <div style="font-family: 'Code128', 'Courier New', monospace; font-size: 28px; letter-spacing: 2px; font-weight: bold;">
                            |||||||||||||||||||
                        </div>
                    </div>
                    <p id="receiptOrderNum2" class="text-xs text-gray-600 font-semibold tracking-widest"></p>

                    <!-- Footer message -->
                    <div class="mt-4 text-xs text-gray-500">
                        <p>Kualitas adalah prioritas kami</p>
                        <p>Semoga Anda puas 😊</p>
                    </div>
                </div>

                <!-- Decorative jagged bottom edge effect -->
                <div class="absolute bottom-0 left-0 right-0 h-3 bg-repeat-x" style="background-image: url('data:image/svg+xml;utf8,%3Csvg%20width%3D%2220%22%20height%3D%2212%22%20viewBox%3D%220%200%2020%2012%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M0%2C0%20L5%2C6%20L10%2C0%20L15%2C6%20L20%2C0%20L20%2C12%20L0%2C12%20Z%22%20fill%3D%22white%22%2F%3E%3C%2Fsvg%3E'); background-size: 20px 12px;"></div>
            </div>

            <!-- Modal Buttons -->
            <div class="bg-gradient-to-r from-orange-50 to-blue-50 p-4 flex gap-3 justify-center border-t-2 border-gray-200">
                <button onclick="printReceipt()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition transform hover:scale-105 font-semibold shadow-md">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                <button onclick="closeReceiptModal()" class="bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white px-6 py-2.5 rounded-lg transition transform hover:scale-105 font-semibold shadow-md">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function showReceiptModal(orderJson) {
            try {
                // Handle both string and object
                const order = typeof orderJson === 'string' ? JSON.parse(orderJson) : orderJson;
                const items = Array.isArray(order.items) ? order.items : (typeof order.items === 'string' ? JSON.parse(order.items || '[]') : []);
                
                // Fill receipt data
                document.getElementById('receiptCanteen').textContent = order.canteen?.name || 'Kantin';
                const ibuName = order.canteen?.ibuKantin?.name || 'Kantin Kami';
                document.getElementById('receiptIbu').textContent = ibuName;
                document.getElementById('receiptOrderNum').textContent = order.order_number;
                document.getElementById('receiptOrderNum2').textContent = order.order_number;
                
                // Format tanggal dan waktu Indonesia
                const waktuObj = new Date(order.created_at);
                const dateFormatted = new Intl.DateTimeFormat('id-ID', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                }).format(waktuObj);
                
                const timeFormatted = new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }).format(waktuObj);
                
                document.getElementById('receiptDate').textContent = dateFormatted;
                document.getElementById('receiptTime').textContent = timeFormatted;
                
                // Fill items dengan format yang lebih rapi
                const itemsHtml = items.map(item => {
                    const itemName = (item.name || 'Item').substring(0, 30); // Limit length
                    const qty = item.qty || item.quantity || 1;
                    const subtotal = item.subtotal || (item.price * qty);
                    const priceStr = subtotal.toLocaleString('id-ID');
                    
                    return `
                        <div class="flex justify-between">
                            <div>
                                <div>${itemName}</div>
                                <div class="text-gray-500" style="font-size: 10px;">x${qty}</div>
                            </div>
                            <div class="font-semibold" style="text-align: right;">${priceStr}</div>
                        </div>
                    `;
                }).join('');
                document.getElementById('receiptItems').innerHTML = itemsHtml;
                
                // Fill total & payment method
                const totalAmount = parseFloat(order.total_amount);
                document.getElementById('receiptTotal').textContent = totalAmount.toLocaleString('id-ID');
                
                // Extract payment method from notes
                let paymentMethod = 'CASH';
                if (order.notes) {
                    if (order.notes.includes('QRIS')) paymentMethod = 'QRIS';
                    else if (order.notes.includes('TyU-Pay') || order.notes.includes('Saldo TyU-Pay')) paymentMethod = 'SALDO TyU-Pay';
                    else if (order.notes.includes('E-Wallet')) paymentMethod = 'E-WALLET';
                }
                document.getElementById('receiptPayment').textContent = paymentMethod;
                
                // Store order for print
                window.currentOrder = order;
                
                // Show modal
                document.getElementById('receiptModal').classList.remove('hidden');
            } catch (error) {
                console.error('Error showing receipt modal:', error, orderJson);
                alert('Error opening receipt modal');
            }
        }
        
        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.add('hidden');
        }
        
        function printReceipt() {
            const printContent = document.getElementById('receiptContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Receipt - ${window.currentOrder.order_number}</title>
                    <style>
                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }
                        body {
                            font-family: 'Courier New', monospace;
                            font-size: 12px;
                            width: 80mm;
                            background: white;
                            color: #333;
                        }
                        @media print {
                            body {
                                width: 80mm;
                                margin: 0;
                                padding: 0;
                                background: white;
                            }
                            @page {
                                size: 80mm auto;
                                margin: 0;
                            }
                        }
                        .receipt {
                            padding: 15mm;
                            width: 100%;
                            text-align: center;
                        }
                        h1 {
                            font-size: 18px;
                            font-weight: bold;
                            margin: 10px 0 5px 0;
                            letter-spacing: 2px;
                        }
                        .shop-info {
                            font-size: 10px;
                            margin-bottom: 5px;
                        }
                        .separator {
                            text-align: center;
                            color: #999;
                            font-size: 10px;
                            letter-spacing: 2px;
                            margin: 10px 0;
                        }
                        .title {
                            font-size: 14px;
                            font-weight: bold;
                            letter-spacing: 1px;
                            margin: 10px 0;
                        }
                        .item-section, .total-section {
                            text-align: left;
                            font-size: 10px;
                            margin: 10px 0;
                        }
                        .item-line {
                            display: flex;
                            justify-content: space-between;
                            margin: 4px 0;
                        }
                        .item-name {
                            flex: 1;
                        }
                        .item-price {
                            font-weight: bold;
                            text-align: right;
                        }
                        .barcode {
                            font-family: 'Code128', 'Courier New', monospace;
                            font-size: 24px;
                            font-weight: bold;
                            letter-spacing: 2px;
                            margin: 10px 0;
                        }
                        .footer {
                            font-size: 10px;
                            color: #666;
                            margin-top: 10px;
                        }
                    </style>
                </head>
                <body>
                    <div class="receipt">${printContent}</div>
                    <script>
                        setTimeout(() => {
                            window.print();
                            setTimeout(() => window.close(), 500);
                        }, 500);
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }
        
        // Close modal when clicking outside
        document.getElementById('receiptModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReceiptModal();
            }
        });
    </script>