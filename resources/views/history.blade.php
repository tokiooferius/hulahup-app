<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Hulahup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#FBF9E4] min-h-screen flex"> <aside class="w-64 bg-[#122C4F] text-white p-6 flex flex-col"> <div class="mb-10">
            <h1 class="text-2xl font-bold italic">Hulahup.</h1>
            <p class="text-xs opacity-60">KANTIN TEL-U PURWOKERTO</p>
        </div>
        <nav class="flex-1 space-y-4">
            <a href="/home" class="flex items-center gap-3 p-3 opacity-60 hover:opacity-100 transition">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="/history" class="flex items-center gap-3 p-3 bg-[#5B88B2] rounded-xl">
                <i class="fas fa-history"></i> Riwayat Pesan
            </a>
            <a href="/topup" class="flex items-center gap-3 p-3 opacity-60 hover:opacity-100 transition">
                <i class="fas fa-wallet"></i> Saldo TyU-Pay
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-10">
        <h2 class="text-3xl font-bold text-[#122C4F] mb-6">Riwayat Pesanan</h2>

        <div id="order-history-list" class="space-y-4">
            <div class="bg-white p-6 rounded-3xl shadow-sm text-slate-500 border border-slate-100">
                <p class="font-medium">Riwayat pesanan akan tampil di sini setelah kamu melakukan pembayaran.</p>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const historyContainer = document.getElementById('order-history-list');
            const orders = JSON.parse(localStorage.getItem('hulahup_orders')) || [];

            if (orders.length > 0 && historyContainer) {
                historyContainer.innerHTML = orders.map(order => `
                    <div class="bg-white p-6 rounded-[30px] shadow-sm flex justify-between items-center border border-slate-50 mb-4 animate-in fade-in slide-in-from-bottom-4 duration-500">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 text-[#5B88B2] rounded-2xl flex items-center justify-center">
                                <i class="fa-solid fa-receipt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#122C4F]">${order.order_id}</h4>
                                <p class="text-[10px] text-slate-400 font-medium">${order.date}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-[#122C4F] mb-1">${order.total}</p>
                            <span class="px-3 py-1 bg-green-100 text-green-600 text-[10px] rounded-full font-bold uppercase tracking-widest">${order.status}</span>
                        </div>
                    </div>
                `).join('');
            }
        });
    </script>
</body>
</html>