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

        <div class="space-y-4">
            <div class="bg-white p-6 rounded-3xl shadow-sm flex justify-between items-center">
                <div class="flex gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-utensils text-[#5B88B2]"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Mie Ayam Bakso & Ice Americano</h3>
                        <p class="text-sm text-gray-500">11 Mei 2026 • 13:45 WIB</p>
                        <span class="mt-2 inline-block px-3 py-1 bg-green-100 text-green-600 text-xs rounded-full font-semibold">Selesai</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-[#122C4F]">RP 30.000</p>
                    <button class="text-[#5B88B2] text-sm font-semibold hover:underline mt-2">Lihat Detail</button>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm flex justify-between items-center opacity-80">
                <div class="flex gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-hamburger text-[#5B88B2]"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Chicken Katsu Curry</h3>
                        <p class="text-sm text-gray-500">10 Mei 2026 • 12:10 WIB</p>
                        <span class="mt-2 inline-block px-3 py-1 bg-blue-100 text-blue-600 text-xs rounded-full font-semibold">Diproses</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-[#122C4F]">RP 22.000</p>
                    <button class="text-[#5B88B2] text-sm font-semibold hover:underline mt-2">Lihat Detail</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>