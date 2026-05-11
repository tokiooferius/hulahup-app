<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Food-TyU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-200 flex justify-center items-center min-h-screen p-4">

    <div class="w-[375px] h-[812px] bg-[#6A9AB0] shadow-2xl relative flex flex-col rounded-[45px] border-[8px] border-white overflow-hidden">
        
        <div class="px-8 pt-12 flex items-center justify-between">
            <a href="/home" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white transition hover:bg-white/30">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h1 class="text-xl font-extrabold text-[#EAD8B1] tracking-tight">Cart</h1>
            <div class="w-10"></div> </div>

        <div class="mx-8 mt-6 bg-white/10 backdrop-blur-sm rounded-[20px] p-1.5 flex shadow-inner">
            <button class="flex-1 bg-[#EAD8B1] text-[#3A6D8C] py-2.5 rounded-[15px] font-bold text-[11px] shadow-md transition">
                Pick Up At Canteen
            </button>
            <button class="flex-1 text-white/80 py-2.5 font-bold text-[11px] hover:text-white transition">
                Delivery
            </button>
        </div>

        <div class="flex-1 px-8 mt-8 space-y-5 overflow-y-auto no-scrollbar">
            
            <div class="bg-[#3A6D8C]/80 backdrop-blur-sm p-4 rounded-[30px] flex items-center gap-4 text-white shadow-lg border border-white/10">
                <div class="w-20 h-20 bg-white rounded-[22px] overflow-hidden shadow-md">
                    <img src="{{ asset('images/katsu.png') }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/150?text=Katsu'">
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-[13px] leading-tight">Rice Chicken Katsu Curry</h3>
                    <p class="text-[#EAD8B1] font-black text-[12px] mt-1">RP. 22.000</p>
                </div>
                <div class="flex flex-col items-center gap-1 bg-black/20 rounded-xl px-2 py-1.5 border border-white/5">
                    <button class="text-[14px] hover:text-[#EAD8B1]">+</button>
                    <span class="text-[12px] font-bold">1</span>
                    <button class="text-[14px] hover:text-[#EAD8B1]">-</button>
                </div>
            </div>

            <div class="bg-[#3A6D8C]/80 backdrop-blur-sm p-4 rounded-[30px] flex items-center gap-4 text-white shadow-lg border border-white/10">
                <div class="w-20 h-20 bg-white rounded-[22px] overflow-hidden shadow-md">
                    <img src="{{ asset('images/seblak.png') }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/150?text=Seblak'">
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-[13px] leading-tight">Seblak Special</h3>
                    <p class="text-[#EAD8B1] font-black text-[12px] mt-1">RP. 13.000</p>
                </div>
                <div class="flex flex-col items-center gap-1 bg-black/20 rounded-xl px-2 py-1.5 border border-white/5">
                    <button class="text-[14px] hover:text-[#EAD8B1]">+</button>
                    <span class="text-[12px] font-bold">1</span>
                    <button class="text-[14px] hover:text-[#EAD8B1]">-</button>
                </div>
            </div>

        </div>

        <div class="bg-[#333A44] rounded-t-[45px] p-9 shadow-[0_-10px_40px_rgba(0,0,0,0.3)] border-t border-white/5">
            <div class="space-y-3 mb-8">
                <div class="flex justify-between text-white/60 text-[13px] font-medium">
                    <span>Subtotal</span>
                    <span class="text-white">RP. 35.000</span>
                </div>
                <div class="flex justify-between text-white/60 text-[13px] font-medium">
                    <span>Delivery</span>
                    <span class="text-white">RP. 1.000</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-white/10">
                    <span class="text-white font-bold text-lg">Total</span>
                    <span class="text-[#EAD8B1] font-black text-2xl">RP. 36.000</span>
                </div>
            </div>
            
            <button class="w-full bg-[#EAD8B1] text-[#333A44] py-4.5 rounded-[22px] font-black text-[14px] shadow-[0_8px_20px_rgba(234,216,177,0.3)] uppercase tracking-widest active:scale-95 transition-all duration-150">
                Checkout
            </button>
        </div>

        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-32 h-1.5 bg-white/10 rounded-full"></div>
    </div>

</body>
</html>